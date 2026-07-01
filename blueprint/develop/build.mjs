import esbuild from "esbuild";
import CssModulesPlugin from "esbuild-css-modules-plugin";

const dev = process.argv.includes("--dev");

const options = {
	entryPoints: [
		{
			in: "develop/js/index.js",
			out: "js/index",
		},
		{
			in: "develop/css/index.css",
			out: "css/index",
		},
	],
	outdir: "public/assets",
	bundle: true,
	minify: !dev,
	sourcemap: true,
	format: "esm",
	plugins: [CssModulesPlugin()],
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
