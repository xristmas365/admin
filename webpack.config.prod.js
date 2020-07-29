const merge = require('webpack-merge');
const defaultConfig = require('./webpack.config.default.js');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const ExtractCssChunks = require('extract-css-chunks-webpack-plugin');

module.exports = merge(defaultConfig, {
  mode: 'production',
  plugins: [
    new ExtractCssChunks({
      filename: '[name].css',
      chunkFilename: '[id].css',
    }),
  ],
});
