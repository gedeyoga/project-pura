import Vue from "vue";

import SideBar from "./components/core/SideBar";
import Navbar from "./components/core/Navbar";

Vue.component("SideBar", SideBar);
Vue.component("Navbar", Navbar);
Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);