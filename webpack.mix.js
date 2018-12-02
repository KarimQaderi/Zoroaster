const mix = require('laravel-mix');
const exec = require('child_process').exec;
const rtlcss = require('rtlcss');


// mix.sass('resources/sass/app.scss', 'public/css/back_2.css')
//     .then(() => {
//         exec('rtlcss public/css/back_2.css public/css/back_2.css');
//     }).version(['public/css/back_2.css']);

// mix.options({
//     processCssUrls: false
// }).styles(['packages/KarimQaderi/Zoroaster/resources/css/back_2.css', 'resources/css/trix.css',], 'packages/KarimQaderi/Zoroaster/publishable/assets/ZoroasterCss.css')
//     .scripts(['packages/KarimQaderi/Zoroaster/resources/js/jquery.js', 'resources/js/trix.js', 'resources/js/uikit.js', 'resources/js/uikit-icons.js'],
//         'packages/KarimQaderi/Zoroaster/publishable/assets/ZoroasterJs.js');

mix.options({
    processCssUrls: false
}).styles(['packages/KarimQaderi/Zoroaster/resources/css/back_2.css', 'packages/KarimQaderi/Zoroaster/resources/css/trix.css',], 'public/css/ZoroasterCss.css')

    .scripts(['packages/KarimQaderi/Zoroaster/resources/js/jquery.js',
        'packages/KarimQaderi/Zoroaster/resources/js/trix.js',
        'packages/KarimQaderi/Zoroaster/resources/js/uikit.js',
        'packages/KarimQaderi/Zoroaster/resources/js/uikit-icons.js'
    ], 'public/js/ZoroasterJs.js');

mix.copyDirectory('public/js', 'packages/KarimQaderi/Zoroaster/publishable/assets/js');
mix.copyDirectory('public/css', 'packages/KarimQaderi/Zoroaster/publishable/assets/css');

// .scripts(['packages/KarimQaderi/Zoroaster/resources/js/jquery.js'],
// 'public/js/jquery.js')


