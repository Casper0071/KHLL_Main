import { createRouter, createWebHistory } from 'vue-router'
import Dashboard from '../pages/Dashboard.vue'
import Components from '../Pages/Components.vue'

const routes = [
    { path: '/', component: Dashboard },
    { path: '/components', component: Components },
]

export default createRouter({
    history: createWebHistory(),
    routes,
})

