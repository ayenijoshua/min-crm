require('./bootstrap');

//require('alpinejs');

window.Vue = require('vue').default; 

window.toastr = require('toastr');

const files = require.context('./', true, /\.vue$/i)
 files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

 const app = new Vue({ 
    el: '#app',
});