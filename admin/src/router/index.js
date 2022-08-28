import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            redirect: "/home",
        },
        {
            path: "/login",
            name: "login",
            component: () => import("../views/Login.vue"),
        },
        {
            path: "/home",
            name: "home",
            component: () => import("../views/Home.vue"),
        },
        {
            path: "/analytics",
            name: "analytics",
            component: () => import("../views/Analytics.vue"),
        },
        {
            path: "/pairs/create",
            name: "paires - création",
            component: () => import("../views/CreatePair.vue"),
        },
        {
            path: "/pairs/update/:id",
            name: "pairs/update",
            component: () => import("../views/UpdatePair.vue"),
        },
        {
            path: "/currencies/create",
            name: "devises - création",
            component: () => import("../views/CreateCurrency.vue"),
        },
    ],
});

export default router;
