const mix = require('laravel-mix');
const path = require('path');
const CleanWebpackPlugin = require('clean-webpack-plugin'); //installed via npm
/*
|--------------------------------------------------------------------------
| Mix Asset Management
|--------------------------------------------------------------------------
|
| Mix provides a clean, fluent API for defining some Webpack build steps
| for your Laravel application. By default, we are compiling the Sass
| file for the application as well as bundling up all the JS files.
|
*/

function resolve(dir) {
	return path.join(__dirname, dir);
}

if (mix.config.hmr) {
	mix.setResourceRoot('//localhost:8080/');
}

mix
	// .setPublicPath('public/dist')
	.js('resources/js/main.js', 'public/js')
	// .js('resources/js/main.js', 'public/dist/js')
	// .copy('public/dist/hot', 'public/hot')
	// .sass('resources/sass/app.scss', 'public/dist/css')
	// .extract();
	// .options({
	// 	vue: {
	// 		transformAssetUrls: {
	// 			'img': 'src',
	// 			'image': 'xlink:href',
	// 			'b-img': 'src',
	// 			'b-img-lazy': ['src', 'blank-src'],
	// 			'b-card': 'img-src',
	// 			'b-card-img': 'img-src',
	// 			'b-carousel-slide': 'img-src',
	// 			'b-embed': 'src'
	// 		}
	// 	}
	// })
	.webpackConfig({
		stats: 'minimal',
		output: {
			// publicPath: 'http://localhost:8080/'
			// filename: 'js/[name].js',
			chunkFilename: 'js/[id].js',
		},
		resolve: {
			alias: {
				'vue$': 'vue/dist/vue.esm.js',
				'@': resolve('resources/js'),
				'static': resolve('resources/static')
			}
		},
		devServer: {
			proxy: {
				'/api': 'http://localhost:8000'
			},
			quiet: true
		},
		plugins: [
			new CleanWebpackPlugin(
				[
					'images',
					'fonts',
					'js'
				], {
					root: resolve('public')
				}
			),
		]
	});


// eslint-disable-next-line no-undef
Mix.listen('configReady', webpackConfig => {
	// eslint-disable-next-line no-undef
	if (Mix.isUsing('hmr')) {
		// Remove leading '/' from entry keys
		webpackConfig.entry = Object.keys(webpackConfig.entry).reduce((entries, entry) => {
			entries[entry.replace(/^\//, '')] = webpackConfig.entry[entry];
			return entries;
		}, {});
		// Remove leading '/' from ExtractTextPlugin instances
		webpackConfig.plugins.forEach(plugin => {
			if (plugin.constructor.name === 'ExtractTextPlugin') {
				plugin.filename = plugin.filename.replace(/^\//, '');
			}
		});
	}
});
