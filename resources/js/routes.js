import Vue from "vue";
import VueRouter from "vue-router";

import UserRoutes from "./modules/User/UserRoutes";
import RoleRoutes from "./modules/Role/RoleRoutes";
import PuraRoutes from "./modules/Pura/PuraRoutes";
import DashboardRoutes from "./modules/Dashboard/DashboardRoutes";
import JenisPuraRoutes from "./modules/JenisPura/JenisPuraRoutes";
import SensorPintuRoutes from "./modules/SensorPintu/SensorPintuRoutes";
import SensorCctvRoutes from "./modules/SensorCctv/SensorCctvRoutes";

Vue.use(VueRouter);

const routes = [
    ...UserRoutes,
    ...RoleRoutes,
    ...DashboardRoutes,
    ...JenisPuraRoutes,
    ...PuraRoutes,
    ...SensorPintuRoutes,
    ...SensorCctvRoutes
];

const router = new VueRouter({
    mode: "history",
    routes: routes,
});

export default router;