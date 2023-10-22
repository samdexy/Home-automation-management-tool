const mix = require('laravel-mix');
require('dotenv').config()
let webpack = require('webpack')

let dotenvplugin = new webpack.DefinePlugin({
    'process.env': {
        APP_NAME: JSON.stringify(process.env.APP_NAME || 'Default app name'),
        TP_LINK_EMAIL: JSON.stringify(process.env.TP_LINK_EMAIL),
        TP_LINK_PASS: JSON.stringify(process.env.TP_LINK_PASS || 'tp-link pass'),

       
    }
})

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css')

    .version()
    
    .options({
        processCssUrls: false,
        postCss: [require('postcss-easy-import')(), require('tailwindcss')('./tailwind.js'), ],
    })
    .webpackConfig(
        {
            node: {
                fs: "empty"
            },
            plugins: [
                dotenvplugin
            ]
            
        }); 
    
