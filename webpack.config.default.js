const path = require('path');
const ExtractCssChunks = require('extract-css-chunks-webpack-plugin');
const PurgecssPlugin = require('purgecss-webpack-plugin');
const glob = require('glob-all');
const Dotenv = require('dotenv-webpack');
const PATHS = {
  root: path.join(__dirname, 'views'),
  admin: path.join(__dirname, 'modules/admin/views'),
};
function recursiveIssuer(m) {
  if (m.issuer) {
    return recursiveIssuer(m.issuer);
  } else if (m.name) {
    return m.name;
  } else {
    return false;
  }
}
module.exports = {
  entry: {
    'admin/main': './resources/admin/custom/styles.scss',
    'app/app': './resources/app/js/main.js',
    'app/bootstrap': './resources/app/js/bootstrap.js',
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, './web/dist/'),
    publicPath: '/dist/'
  },
  plugins: [
    new Dotenv(),
  ],
  optimization: {
    splitChunks: {
      cacheGroups: {
        appStyles: {
          name: 'app',
          test: (m, c, entry = 'app') =>
            m.constructor.name === 'CssModule' && recursiveIssuer(m) === entry,
          chunks: 'all',
          enforce: true,
        },
      },
    },
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        loader: 'babel-loader',
        exclude: '/node_modules/'
      },
      {
        test: /\.css$/,
        use: [
          ExtractCssChunks.loader,
          {
            loader: 'css-loader'
          },
          {
            loader: 'file-loader'
          }
        ]
      },
      {
        test: /\.scss$/,
        use: [
          'style-loader',
          ExtractCssChunks.loader,
          {
            loader: 'css-loader'
          },
          {
            loader: 'sass-loader'
          }
        ]
      },
      {
        test: /\.(png|svg|jpg|gif)$/,
        use: [
          'file-loader'
        ]
      },
      {
        test: /\.(woff|woff2|eot|ttf|otf)$/,
        loader: 'url-loader?limit=100000'
      }
    ]
  }
};
