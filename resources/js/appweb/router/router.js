import Vue from "vue";
import VueRouter from "vue-router";
import IndexHome from "../pages/home/IndexHome";
import IndexReservation from "../pages/reservation/IndexReservation";
import IndexActivities from "../pages/activities/IndexActivities";
import IndexCategories from "../pages/categories/IndexCategories";

Vue.use(VueRouter);

const prefix = "/tech/";

let routes = [
    {
        path: prefix + "home",
        component: IndexHome,
        name: "home",
    },
    {
        path: prefix + "/admin-activities",
        component: IndexActivities,
        name: "activities",
    },
    {
        path: prefix + "/admin-reservations",
        component: IndexReservation,
        name: "reservations",
    },
    {
        path: prefix + "/admin-categories",
        component: IndexCategories,
        name: "categories",
    },
];

export default new VueRouter({
    mode: "history",
    routes: routes,
});
