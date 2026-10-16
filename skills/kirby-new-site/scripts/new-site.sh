#!/usr/bin/env bash
# Sets up a new Kirby project from the starters in Coding-Design-Guidelines.
#
# Usage: new-site.sh <target-dir> <domain> [--local-dev-server] [--ref <git-ref>]
#
#   --local-dev-server  adds the local-dev-server package (private GitHub repo, needs SSH access)
#   --ref               commit of the guidelines repo to copy the starters from (default: HEAD)
#
# The project is always a git repository. Kirby and staticache are submodules;
# content/ is a local submodule of its own (no remote).

set -euo pipefail

usage() {
	echo "Usage: $(basename "$0") <target-dir> <domain> [--local-dev-server] [--ref <git-ref>]" >&2
	exit 1
}

[ $# -ge 2 ] || usage
target=$1
domain=$2
shift 2

local_dev_server=false
ref=HEAD

while [ $# -gt 0 ]; do
	case $1 in
		--local-dev-server) local_dev_server=true ;;
		--ref) ref=${2:?--ref needs a value}; shift ;;
		*) usage ;;
	esac
	shift
done

case $domain in
	*.*) ;;
	*) echo "The domain needs a TLD, e.g. example.com" >&2; exit 1 ;;
esac

# stadtverwicklung.de → stadtverwicklung.test (local host and config.<host>.php)
testhost="${domain%.*}.test"

guidelines=$(git -C "$(dirname "$(realpath "$0")")" rev-parse --show-toplevel)

if [ -e "$target" ] && [ -n "$(ls -A "$target")" ]; then
	echo "$target exists and is not empty." >&2
	exit 1
fi

mkdir -p "$target"
target=$(cd "$target" && pwd)

echo "→ Copying the starters ($ref) to $target"

# Only committed files. Submodules (Kirby, staticache) are added fresh below.
git -C "$guidelines" archive "$ref:blueprint-kirby" | tar -x -C "$target"

# In the guidelines repo, develop/ is a symlink to ../blueprint/develop
rm -f "$target/develop"
mkdir -p "$target/develop"
git -C "$guidelines" archive "$ref:blueprint/develop" | tar -x -C "$target/develop"

# Files that don't belong in a new project
rm -f "$target/.php-cs-fixer.cache" "$target/.htpasswd" "$target/.gitmodules"
rm -rf "$target/public/media"
rmdir "$target/public/site/plugins/staticache" 2>/dev/null || true

for dir in public/media public/site/accounts public/site/cache public/site/sessions public/site/logs; do
	mkdir -p "$target/$dir"
	touch "$target/$dir/.gitkeep"
done

cat >> "$target/.gitignore" <<'EOF'

# Basic auth for preview hosts, created on the server
/.htpasswd
EOF

echo "→ Replacing placeholders"

perl -pi -e "s/example\.test/$testhost/g; s/example\.com/$domain/g" \
	"$target/README.md" "$target/AGENTS.md" "$target/public/.htaccess"
mv "$target/public/site/config/config.example.test.php" "$target/public/site/config/config.$testhost.php"

node -e '
const fs = require("fs");
const [file, testhost, localDevServer] = process.argv.slice(1);
const pkg = JSON.parse(fs.readFileSync(file, "utf8"));
pkg.config = { ...pkg.config, localDevServer: { domain: testhost, php: "8.5", docroot: "public" } };
if (localDevServer === "true") {
	pkg.scripts = {
		...pkg.scripts,
		"start-local-dev-server": "local-dev-server up",
		"stop-local-dev-server": "local-dev-server down",
		"logs-local-dev-server": "local-dev-server logs",
	};
	pkg.devDependencies = {
		...pkg.devDependencies,
		"local-dev-server": "git+ssh://git@github.com/tobiasfabian/local-dev-server.git",
	};
}
fs.writeFileSync(file, JSON.stringify(pkg, null, "\t") + "\n");
' "$target/package.json" "$testhost" "$local_dev_server"

if [ "$local_dev_server" = true ]; then
	# npm 12 refuses git dependencies by default; allow them for direct dependencies only
	cat > "$target/.npmrc" <<'EOF'
; local-dev-server is installed from its git repository
allow-git=root
EOF
fi

echo "→ Writing env.php with new secrets"

salt=$(php -r 'echo bin2hex(random_bytes(32));')
key=$(php -r 'echo bin2hex(random_bytes(32));')

cat > "$target/public/site/config/env.php" <<EOF
<?php

// Not in git. Each server gets its own env.php with its own values.
return [
	'content.salt' => '$salt',
	'cookie.key' => '$key',
];
EOF

echo "→ Setting up git and submodules"

cd "$target"
git init -q -b main

kirby_tag=$(git ls-remote --tags --refs https://github.com/getkirby/kirby.git \
	| awk -F/ '{print $3}' \
	| grep -E '^[0-9]+\.[0-9]+\.[0-9]+$' \
	| sort -V \
	| tail -1)

git submodule add -q --depth 1 https://github.com/getkirby/kirby.git public/kirby
git -C public/kirby fetch -q --depth 1 origin tag "$kirby_tag"
git -C public/kirby checkout -q "$kirby_tag"
git config -f .gitmodules submodule.public/kirby.shallow true

git submodule add -q --depth 1 https://github.com/getkirby/staticache.git public/site/plugins/staticache
git config -f .gitmodules submodule.public/site/plugins/staticache.shallow true

# Stage the release tag and the shallow settings
git add .gitmodules public/kirby

# content/ is its own local repository without a remote, registered as a submodule
content_note=""
git -C public/content init -q -b main
git -C public/content add -A

# A submodule needs a commit. If committing fails (e.g. commit signing), carry on and say so.
if git -C public/content commit -q -m "Initial content"; then
	git submodule add -q ./public/content public/content
else
	content_note="- public/content is its own repo, but its first commit failed. Commit it there, then run: git submodule add ./public/content public/content"
fi

echo "→ Installing npm packages and building assets"

npm install --silent
npm run build --silent

cat <<EOF

Done: $target (Kirby $kirby_tag). Nothing is committed yet.

Still to do by hand:
- README.md: describe the site
- public/content/site.txt: the site title
- public/.htaccess: server path of the .htpasswd for preview.$domain
- .connect-to-server: user, server and path
- On the server: its own env.php (with its own content.salt and cookie.key) and the .htpasswd
- Kirby license, first Panel account (/panel)
- Fonts (develop/css/foundation/FONT_NAME.css), logo, favicon, apple-touch-icon
EOF

if [ -n "$content_note" ]; then
	echo "$content_note"
fi
