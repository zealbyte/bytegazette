'use strict';

const path = require( 'path' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const CleanWebpackPlugin = require( 'clean-webpack-plugin' );
const CopyWebpackPlugin = require( 'copy-webpack-plugin' );
const OptimizeCSSAssetsPlugin = require( 'optimize-css-assets-webpack-plugin' );
const ManifestPlugin = require( 'webpack-manifest-plugin' );

// These are the paths where different types of resources should end up.
const paths = {
	css: 'assets/css/',
	img: 'assets/img/',
	font: 'assets/font/',
	js: 'assets/js/',
	lang: 'languages/',
};

const uikitConfig = {
	entry: {
		'bytegazette-uikit': './src/bytegazette-uikit.js',
	},
}

const themeConfig = {
	entry: {
		'bytegazette-site': './src/bytegazette-site.js',
		'bytegazette-admin': './src/bytegazette-admin.js',
		'admin-customize-background': './src/plugins/admin-customize-background.js',
		'admin-customizer': './src/plugins/admin-customizer.js',
	},
	externals: {
		'@wordpress/a11y': 'wp.a11y',
		'@wordpress/components': 'wp.components',
		'@wordpress/customize': 'wp.customize',
		'@wordpress/blocks': 'wp.blocks',
		'@wordpress/data': 'wp.data',
		'@wordpress/date': 'wp.date',
		'@wordpress/element': 'wp.element',
		'@wordpress/hooks': 'wp.hooks',
		'@wordpress/i18n': 'wp.i18n',
		'@wordpress/utils': 'wp.utils',
		'backbone': 'Backbone',
		'jquery': 'jQuery',
		'lodash': 'lodash',
		'moment': 'moment',
		'react': 'React',
		'react-dom': 'ReactDOM',
		'tinymce': 'tinymce',
		'uikit': 'UIkit',
	},
};

const webpackConfig = ( env, srcPath, buildPath ) => {
	const config = {
		devtool: 'source-map',
		optimization: {
			minimize: false,
		},
		output: {
			filename: paths.js + ( env.development ? '[name].bundle.js' : '[name].[hash].bundle.js' ),
			chunkFilename: paths.js + ( env.development ? '[name].chunk.js' : '[name].[hash].chunk.js' ),
			path: buildPath,
			publicPath: '/',
		},
		resolve: {
			extensions: ['*', '.js', '.scss'],
		},
		plugins: [
			new ManifestPlugin( {
				fileName: 'manifest.json',
			} ),
			new MiniCssExtractPlugin( {
				filename: paths.css + ( env.development ? '[name].bundle.css' : '[name].[hash].bundle.css' ),
				chunkFilename: paths.css + ( env.development ? '[id].chunk.css' : '[id].[hash].chunk.css' ),
			} ),
		],
		module: {
			rules: [
				{
					enforce: 'pre',
					test: /\.js|.jsx/,
					exclude: /(node_modules)/,
					loader: 'import-glob',
				},
				{
					test: /\.s?css$/,
					exclude: /node_modules/,
					use: [
						//env.development ? 'style-loader' : MiniCssExtractPlugin.loader,
						MiniCssExtractPlugin.loader,
						'css-loader',
						'postcss-loader',
						'sass-loader',
					],
				},
				{
					test: /\.html$/,
					loader: 'raw-loader',
					exclude: /node_modules/,
				},
				{
					test: /\.(png|svg|jpg|gif)$/,
					exclude: /node_modules/,
					use: [
						{
							loader: 'file-loader',
							options: {
								name: '[name].[ext]',
								context: '',
								outputPath: paths.img,
								publicPath: '../img/',
							},
						},
					],
				},
			],
		},
	};

	if ( env.production ) {
		config.devtool = false;
		config.optimization.minimize = true;

		config.plugins.push( new OptimizeCSSAssetsPlugin( {} ) );

		config.plugins.push(
			new CleanWebpackPlugin( [buildPath] )
		);

		config.plugins.push(
			new CopyWebpackPlugin( [
				{
					from: path.resolve( srcPath, 'inc' ) + '/**',
					to: buildPath,
				},
				{
					from: path.resolve( srcPath, 'languages' ) + '/**',
					to: buildPath,
				},
				{
					from: path.resolve( srcPath, 'layouts' ) + '/**',
					to: buildPath,
				},
				{
					from: path.resolve( srcPath, 'template-parts' ) + '/**',
					to: buildPath,
				},
				{
					from: path.resolve( srcPath, '*.css' ),
					to: buildPath,
				},
				{
					from: path.resolve( srcPath, '*.md' ),
					to: buildPath,
				},
				{
					from: path.resolve( srcPath, '*.php' ),
					to: buildPath,
				},
				{
					from: path.resolve( srcPath, '*.txt' ),
					to: buildPath,
				},
			], {
				copyUnmodified: true,
			} )
		);
	}

	return config;
};

module.exports = ( env ) => {
	const srcPath = __dirname;
	let buildPath = path.resolve( srcPath, '.' );

	if ( env.production ) {
		buildPath = path.resolve( srcPath, 'build' );
	}

	console.log( 'development: ', env.development ? 'yes' : 'no' );
	console.log( 'production: ', env.production ? 'yes' : 'no' );

	return [
		Object.assign( {}, webpackConfig( env, srcPath, buildPath ), uikitConfig ),
		Object.assign( {}, webpackConfig( env, srcPath, buildPath ), themeConfig ),
	];
};
