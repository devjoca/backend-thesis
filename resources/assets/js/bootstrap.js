import Vue from 'vue';
import * as VueGoogleMaps from 'vue2-google-maps';
import 'babel-polyfill';

window._ = require('lodash');

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap-sass');
} catch (e) {}

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');
let gmaps_key = document.head.querySelector('meta[name="gmaps-key"]').content;
window.mapbox_key = document.head.querySelector('meta[name="mapbox-key"]').content;

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

Vue.use(VueGoogleMaps, {
  load: {
    key: gmaps_key,
    libraries: ['visualization', 'geometry']
  }
});