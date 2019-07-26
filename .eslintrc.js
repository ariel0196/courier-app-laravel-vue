module.exports = {
	root: true,
	env: {
		browser: true,
		node: true
	},
  parserOptions: {
  	parser: 'babel-eslint'
  },
	extends: [
		'plugin:vue/strongly-recommended',
		'eslint:recommended'
	],
	rules: {
		// allow debugger during development
		'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',
		'no-console': 'off',
		'semi': ['error', 'always'],
		'indent': ['warn', 'tab'],
		'vue/require-v-for-key': 'off',
		'vue/valid-v-for': 'off',
		'vue/html-indent': ['warn', 'tab']
	}
}
