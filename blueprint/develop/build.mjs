import esbuild from "esbuild";

const dev = process.argv.includes("--dev");

const options = {
	entryPoints: [
		"develop/css/*.css",
		"develop/js/*.js",
	],
	outdir: "public/assets",
	outbase: "develop",
	bundle: true,
	minify: !dev,
	sourcemap: true,
	format: "esm",
	target: ["chrome109", "firefox140", "safari16.6"],
	external: [
		"fonts/*.woff",
		"fonts/*.woff2",
		"./polyfills/*.js",
	],
};


if (dev) {
	const ctx = await esbuild.context(options);
	await ctx.watch();
} else {
	await esbuild.build(options);
}
