require('./bootstrap');

window.Vue = require('vue');

import Articles from './components/Articles';

const app = new Vue({
    el: '#app',
    components: { Articles },
    methods: {
        printPol(request) {
            console.log(request);
        },
    }
});
