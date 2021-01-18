const path = require('path');
const fs = require('fs');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');
const getPublicUrlOrPath = require('react-dev-utils/getPublicUrlOrPath');

const appDirectory = fs.realpathSync(process.cwd());
const resolveApp = (relativePath) => path.resolve(appDirectory, relativePath);

const publicUrlOrPath = getPublicUrlOrPath(
	process.env.NODE_ENV === 'development',
	require(resolveApp('package.json')).homepage,
	process.env.PUBLIC_URL,
);

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
		hot: true,
		contentBase: [
			path.join(__dirname, '/public'),
			path.join(__dirname, '/dist'),
			path.join(__dirname, '/public/avatars'),
		],
		port: 5000,
		host: process.env.HOST || '0.0.0.0',
		transportMode: 'ws',
		// sockHost: '0.0.0.0',
		// sockPath: '/sockjs-node',
		// sockPort: '5000',
		watchContentBase: true,
		injectClient: false,
		// contentBasePublicPath: publicUrlOrPath,
		// publicPath: publicUrlOrPath.slice(0, -1),
		disableHostCheck: true,
		public: '0.0.0.0:5000',
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
