const mix = require('laravel-mix');
const path = require('path');
const webpack = require('webpack');

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

mix
    .webpackConfig({
       resolve: {
          extensions: ['.ts', '.tsx']
       },
       module: {
          rules: [
             {
                test: /\.tsx?$/,
                loader: 'ts-loader',
                exclude: /node_modules/
             }
          ]
       },
       plugins: [
          new webpack.ContextReplacementPlugin(
              /\@angular(\\|\/)core(\\|\/)fesm5/,
              path.join(__dirname, './src')
          )
       ]
    })
    .js('resources/ts/vendor.ts', 'public/js/vendor.js')
    .js('resources/ts/main.ts', 'public/js/app-component.js');
   