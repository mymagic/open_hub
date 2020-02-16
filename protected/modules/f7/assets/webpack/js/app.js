require('./bootstrap');

const files = require.context('./components/', true, /\.vue$/i)
files.keys().forEach(filename => {
    const name = filename.split('.')[1].split('/')[1]
    const Comp = files(filename).default
    Vue.component(name, Comp)
})

const app = new Vue({
    el: '#main-content'
})