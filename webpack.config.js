// Import plugins
const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const ExtractCssChunks = require('extract-css-chunks-webpack-plugin');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');

// Set building direction
const buildDir = 'C:/Users/Lenophie/Utilitaires/WAMP/www/MoniCAG/';

// Set environment boolean
const dev = process.env.NODE_ENV === 'development';

const filesToCopy = [
  './readme.md',
  './changelog.md',
  'LICENSE'
];

// List of browser icons to copy to destination
const iconsToCopy = [
  'monicag.png'
].map(file => ({
  from: `./src/FRONT-END/favicons/${file}`,
  to: file
}));

filesToCopy.push(...iconsToCopy);

// List of PHP files to copy to destination
const PHPFilesToCopy = [

].map(file => ({
  from: `./src/BACK-END/${file}`,
  to: file
}));

filesToCopy.push(...PHPFilesToCopy);

// Prepares the HTML pages bundles
const htmlWebpackPluginConfig = [
  {
    name: 'index',
    favicon: 'monicag.png'
  }
].map(page => (
  new HtmlWebpackPlugin({
    filename: `${page.name}.html`, // the output name for the html page
    favicon: `./src/FRONT-END/favicons/${page.favicon}`, // the favicon to bundle
    template: `./src/FRONT-END/html/${page.name}.html`, // the html page to bundle
    chunks: ['common', page.name] // the js files to bundle with the html page
  })
));

let prodPlugins = [];
let cssLoaders = [
  { loader: 'style-loader' },
  { loader: 'css-loader' }
];

// Sets the the prod plugins.
if (!dev) {
  prodPlugins.push(new ExtractCssChunks({
    filename: '[name].[contenthash:8].css',
    chunkFilename: '[id].[contenthash:8].css'
  }));
  prodPlugins.push(new CleanWebpackPlugin(
    [buildDir],
    { allowExternal: true }
  ));
  prodPlugins.push(new UglifyJsPlugin({
    sourceMap: true
  }));
  prodPlugins.push(new OptimizeCSSAssetsPlugin({}));
  cssLoaders.shift();
  cssLoaders.unshift({ loader: ExtractCssChunks.loader });
}

// Set the webpack config
let config = {
  // Entry points, webpack will read them and will bundle them with their local dependencies.
  entry: {
    'common': './src/FRONT-END/js/common.js',
    'index': './src/FRONT-END/js/index.js'
  },
  // Output files, hashed in production mode to allow cache-busting.
  output: {
    filename: dev ? '[name].js' : '[name].[chunkhash:8].js',
    path: path.resolve(__dirname, buildDir)
  },
  mode: dev ? 'development' : 'production',
  // Change the source map used for debugging depending on the mode
  devtool: dev ? 'cheap-module-eval-source-map' : 'source-map',
  // Copy the copy files set previously, bundles the html files, applies the set prod plugins (empty list in dev mode)
  plugins: [
    new CopyWebpackPlugin([...filesToCopy]),
    ...htmlWebpackPluginConfig,
    ...prodPlugins
  ],
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: ['babel-loader']
      },
      {
        test: /\.css$/,
        use: cssLoaders
      },
      {
        test: /\.scss$/,
        use: [...cssLoaders, 'sass-loader']
      },
      {
        test: /.(ttf|otf|eot|svg|woff(2)?)(\?[a-z0-9]+)?$/,
        use: ['file-loader']
      },
      {
        test: /\.(png|jpg|gif)$/,
        use: [
          {
            loader: 'url-loader',
            options: {
              name: '[name].[hash:8].[ext]',
              limit: 8192
            }
          }
        ]
      }
    ]
  },
  resolve: {
    extensions: ['.js', '.json', '.jsx', '.css']
  },
  watch: dev,
  watchOptions: {
    ignored: /node_modules/
  }
};

module.exports = config;
