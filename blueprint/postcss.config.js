module.exports = (ctx) => ({
	map: ctx.options.map,
	plugins: {
		'postcss-import': { root: ctx.file.dirname },
		'postcss-nesting': true,
		'@csstools/postcss-oklab-function': true,
		'@csstools/postcss-color-mix-function': true,
		autoprefixer: true,
		cssnano: ctx.env === 'production' ? {
			preset: ['default', {
				cssDeclarationSorter: false,
			}],
		} : false,
	},
});
