module.exports = {
	plugins: {
		'postcss-import': {}
		, 'postcss-cssnext': {
			browsers: ['last 2 versions', '> 5%']
			, warnForDuplicates: false
		}
		, 'css-mqpacker': {
			sort: true
		}
		, 'cssnano': {}
	},
};