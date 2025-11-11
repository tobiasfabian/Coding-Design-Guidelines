module.exports = {
	presets: [
		[
			'@babel/preset-env',
			{
				targets: {
					esmodules: true, // Use ES modules
				},
				useBuiltIns: 'usage',
				corejs: '3.46',
			},
		],
	],
};
