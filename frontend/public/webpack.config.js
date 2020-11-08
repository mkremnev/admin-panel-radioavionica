const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');

module.exports = {
	entry: './src/index.tsx',
	mode: 'development',
	devtool: 'source-map',
	resolve: {
		extensions: ['.js', '.jsx', '.ts', '.tsx', '.json'],
		alias: {
			types: path.resolve(__dirname, 'src/types'),
			screens: path.resolve(__dirname, 'src/screens'),
			common: path.resolve(__dirname, 'src/common'),
			containers: path.resolve(__dirname, 'src/containers'),
			views: path.resolve(__dirname, 'src/views'),
			rdx: path.resolve(__dirname, 'src/rdx'),
			api: path.resolve(__dirname, 'src/api'),
			components: path.resolve(__dirname, 'src/components'),
			'@': path.resolve(__dirname, 'src'),
		},
	},
	output: {
		path: path.join(__dirname, '/dist'),
		filename: './index.js',
		publicPath: '/',
	},
	module: {
		rules: [
			{
				test: /\.(js|ts)x?$/,
				exclude: /node_modules/,
				use: [
					{
						loader: 'babel-loader',
						options: {
							presets: ['@babel/env'],
						},
					},
				],
			},
			{
				test: /\.css$/,
				use: ['css-loader'],
			},
			{
				test: /\.s[ac]ss$/i,
				use: [
					// Creates `style` nodes from JS strings
					'style-loader',
					// Translates CSS into CommonJS
					'css-loader',
					// Compiles Sass to CSS
					{
						loader: 'sass-loader',
						options: {
							// Prefer `dart-sass`
							implementation: require('node-sass'),
						},
					},
				],
			},
		],
	},
	devServer: {
		historyApiFallback: true,
		inline: true,
		contentBase: [
			path.join(__dirname, '/public'),
			path.join(__dirname, '/dist'),
			path.join(__dirname, '/public/avatars'),
		],
		port: 5000,
	},
	plugins: [
		new CleanWebpackPlugin(),
		new HtmlWebpackPlugin({
			template: './public/index.html',
			favicon: './public/favicon.ico',
		}),
		new ManifestPlugin({
			writeToFileEmit: true,
			seed: {
				// eslint-disable-next-line @typescript-eslint/camelcase
				short_name: 'CoreUI-React Admin panel for Radioavionica',
				name: 'CoreUI-React sample',
				icons: [
					{
						src: './public/favicon.ico',
						sizes: '100x100',
						type: 'image/ico',
					},
				],
				// eslint-disable-next-line @typescript-eslint/camelcase
				start_url: '.',
				display: 'standalone',
				// eslint-disable-next-line @typescript-eslint/camelcase
				theme_color: '#000000',
				// eslint-disable-next-line @typescript-eslint/camelcase
				background_color: '#ffffff',
			},
		}),
	],
};
