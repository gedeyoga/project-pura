/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import { initializeApp } from "firebase/app";
import { getMessaging, getToken } from "firebase/messaging";

const firebaseConfig = {
    apiKey: process.env.MIX_FIREBASE_KEY,
    authDomain: process.env.MIX_FIREBASE_AUTH_DOMAIN,
    projectId: process.env.MIX_FIREBASE_PROJECT_ID,
    storageBucket: process.env.MIX_FIREBASE_STORAGE_BUCKET,
    messagingSenderId: process.env.MIX_FIREBASE_MESSAGING_SENDER_ID,
    appId: process.env.MIX_FIREBASE_APP_ID,
    measurementId: process.env.MIX_FIREBASE_MEASUREMENT_ID,
};

// Initialize Firebase
const firebase_app = initializeApp(firebaseConfig);
const messaging = getMessaging(firebase_app);

    getToken(messaging).then((currentToken) => {
        console.log(currentToken);
    });

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
