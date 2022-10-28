window.axios = require("axios");

import Vue from "vue";
import router from "./appweb/router/router";
import vuetify from "./appweb/vuetify/vuetify";
import App from "./appweb/pages/App";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
Vue.use(VueSweetalert2);

require("./bootstrap");

export const bus = new Vue();

const app = new Vue({
    el: "#root",
    router,
    vuetify,
    render: (h) => h(App),
});
