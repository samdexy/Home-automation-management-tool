import Vue from 'vue'
import VueRouter from 'vue-router'
import indexHome from '../components/Index';
import editOutlet from '../components/crud/Home/Edit';
import indexUsers from '../components/crud/Admin/Index';
import createUser from '../components/crud/Admin/Create';
import editUser from '../components/crud/Admin/Edit';
import stats from '../components/crud/Stats/Index';
import actions from '../components/crud/Actions/Index';


Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        component: indexHome,
        name: 'home',
        meta: {
            authUser: true,
        }
    },
    {
        path: '/outlet/:id/edit',
        component: editOutlet,
        name: 'home.edit',
        meta: {
            authUser: true,

        }
    },
    {
        path: '/admin/users',
        component: indexUsers,
        name: 'admin.users',
        meta: {
            authUser: false,

        }
    },
    { 
        path: '/admin/users/create', 
        component: createUser, 
        name: 'admin.users.create',
        meta: {
            authUser: false,

        }
    },
    { 
        path: '/admin/users/edit/:id', 
        component: editUser, 
        name: 'admin.users.edit',
        meta: {
            authUser: false,

        }
    },
    { 
        path: '/admin/stats', 
        component: stats, 
        name: 'stats',
        meta: {
            authUser: false,
        }
    },
    { 
        path: '/actions', 
        component: actions, 
        name: 'actions',
        meta: {
            authUser: true,
        }
    }
]

export default new VueRouter({
    mode: 'history',
    routes
})
