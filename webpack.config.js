const path = require( 'path' );
module.exports = {
    entry: './src/index.js',
    output: {
        path: path.resolve( __dirname ),
        filename: './dist/bundle.js'
    },
    mode: 'development',
    module: {
        rules: [
            {
                test: /\.js$/,
                loader: 'babel-loader',
                exclude: /node_modules/,
                options: {
                    presets: ['@babel/preset-env','@babel/preset-react'],
                    plugins: ['@babel/transform-class-properties']
                }
            }
        ]
    }
  };