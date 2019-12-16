import Vue from 'vue'
import VueRouter from 'vue-router'

import store from './store.js'

//Login:
import Login from './components/Login';
import Register from './components/Register';
import PasswordForgot from './components/PasswordForgot';
import PasswordReset from './components/PasswordReset';
import Home from "./components/Home";
import Contact from "./components/Contact";
import About from "./components/About";
import Courses from "./components/Courses";
import courseDetails from "./components/courseDetails";
import Dashboard from "./components/Dashboard";
import Reports from "./components/Reports";
import Settings from "./components/Settings";
import Category from './components/Category';
import CategoryItems from './components/CategoryItems';
import Donors from './components/Donors';
import DonorView from './components/DonorView';
import Users from './components/Users';
import Users2 from './components/Users2';
import UserView from './components/UserView';


Vue.use(VueRouter)

const router = new VueRouter({
    mode  : 'history',
    routes: [
        {
            path     : '/',
            name     : 'main',
            component: Login,
            meta     : {
                guest: true
            }
        },
        {
            path     : '/login',
            name     : 'login',
            component: Login,
            meta     : {
                guest: true
            }
        },
        {
            path     : '/register',
            name     : 'register',
            component: Register,
            meta     : {
                guest: true
            }
        },
        {
            path     : '/password-forgot',
            name     : 'password.forgot',
            component: PasswordForgot,
            meta     : {
                guest: true
            }
        },
        {
            path     : '/password-reset',
            name     : 'password.reset',
            component: PasswordReset,
            meta     : {
                guest: true
            }
        },
        {
            path     : '/student',
            name     : 'student',
            component: Home,
            meta     : {
                requiresAuth: true,
                is_user     : true,
            }
        },
        {
            path     : '/courses',
            name     : 'courses',
            component: Courses,
            meta     : {
                requiresAuth: true,
                is_user     : true,
            }
        },
        {
            path     : '/course-details',
            name     : 'course-details',
            component: courseDetails,
            meta     : {
                requiresAuth: true,
                is_user     : true,
            }
        },
        {
            path     : '/contact',
            name     : 'contact',
            component: Contact,
            meta     : {
                requiresAuth: true,
                is_user     : true,
            }
        },
        {
            path     : '/about',
            name     : 'about',
            component: About,
            meta     : {
                requiresAuth: true,
                is_user     : true,
            }
        },
        {
            path     : '/dashboard',
            name     : 'dashboard',
            component: Dashboard,
            meta     : {
                requiresAuth: true,
                is_admin    : true,
            }
        },
        {
            path     : '/dashboard/courses',
            name     : 'dashboard.courses',
            component: Category,
            meta     : {
                requiresAuth: true,
                is_admin    : true,
            }
        },
        /*{
            path     : '/dashboard/categories',
            name     : 'dashboard.categories',
            component: Category,
            meta     : {
                requiresAuth: true,
                is_admin    : true,
            }
        },*/
        {
            path     : '/dashboard/enrolments',
            name     : 'dashboard.enrolments',
            component: CategoryItems,
            meta     : {
                requiresAuth: true,
                is_admin    : true,
            }
        },
        {
            path     : '/dashboard/students',
            name     : 'dashboard.students',
            component: Users2,
            meta     : {
                requiresAuth: true,
                is_admin    : true,
            }
        },
        {
            path     : '/dashboard/student/:id',
            name     : 'dashboard.student.id',
            component: UserView,
            props    : true,
            meta     : {
                requiresAuth: true,
                is_admin    : true,
            },
        },
        {
            path     : '/dashboard/parents',
            name     : 'dashboard.parents',
            component: Donors,
            meta     : {
                requiresAuth: true,
                is_admin    : true,
            }
        },
        {
            path     : '/dashboard/parent/:id',
            name     : 'dashboard.parent.id',
            component: DonorView,
            props    : true,
            meta     : {
                requiresAuth: true,
                is_admin    : true,
            },
        },
        {
            path     : '/dashboard/users',
            name     : 'dashboard.users',
            component: Users,
            meta     : {
                requiresAuth: true,
                is_admin    : true,
            }
        },
        {
            path     : '/dashboard/settings',
            name     : 'dashboard.settings',
            component: Settings,
            meta     : {
                requiresAuth: true,
                // is_super_admin: true,
            },
            /*props     : {
                title  : "This is the SPA Second Page",
                author : {
                    name : "Fisayo Afolayan",
                    role : "Software Engineer",
                    code : "Always keep it clean"
                }
            }*/
        },
    ],
})

// Check local storage to handle refreshes
try {
    if (window.localStorage) {
        console.log('window.localStorage: ');

        var user = store.state.user;
        if (user && user.id && user.id > 0) {
            console.log('Refresh No Needed: ');
        } else {
            var localUser = JSON.parse(window.localStorage.getItem('user'));
            var token = window.localStorage.getItem('token');

            if (localUser && localUser['id'] && localUser['id'] > 0) {
                console.log('Refresh Needed: ');
                store.commit('UPDATE_USER', localUser);
                // store.commit('UPDATE_USER', localUser);
            } else {
                console.log('Refresh: Not Logged In.');
            }
        }
    }
} catch (e) {
    console.log('window.localStorage: ', e);
}


// CALL FUNCTION: return (new LoginController())->login($request);
router.beforeEach((to, from, next) => {
    try {
        var token = localStorage.getItem('token');
        console.log('router.beforeEach: ', to, from);
        if (to.matched.some(record => record.meta.requiresAuth)) {
            if (token === null) {
                setLayout('layout-login');
                next({
                    path  : '/login',
                    params: {nextUrl: to.fullPath}
                });
            } else {
                let user = JSON.parse(window.localStorage.getItem('user'));
                let user_role = user && user['role'] && user['role']['name'] ? user['role']['name'] : null;
                console.log('router.beforeEach: user_role: ', user_role);
                if (to.matched.some(record => record.meta.is_admin)) {
                    if (user_role === 'Admin' || user_role === 'Parent') {
                        /*let notifyData = {
                            'group': 'edited',
                            'type' : 'warn',
                            'title': 'Access Denied!',
                            'text' : 'You do no have access to this.'
                        };
                        this.notify(notifyData);*/
                        setLayout('layout-dashboard');
                        next();
                    } else if (user_role === 'User') {
                        setLayout('layout-home');
                        next({name: 'student'});
                    } else {
                        setLayout('layout-dashboard');
                        next({name: 'dashboard'});
                    }
                } else if (to.matched.some(record => record.meta.is_user)) {
                    if (user_role === 'User') {
                        setLayout('layout-home');
                        next();
                    } else {
                        setLayout('layout-layout');
                        next({name: 'student'});
                    }
                } else {
                    // setLayout('layout-dashboard'); // FIX
                    next();
                }
            }
        } else if (to.matched.some(record => record.meta.guest)) {
            if (token === null) {
                setLayout('layout-login');
                next();
            } else {
                setLayout('layout-dashboard');
                next({name: 'dashboard'});
            }
        } else {
            // setLayout('layout-dashboard');
            next();
        }
    } catch (e) {
        console.error('router.beforeEach: catch: ', e);
        setLayout('layout-login');
        next({
            path  : '/404',
            params: {nextUrl: to.fullPath}
        })
    }
})

function setLayout(layout) {
    let currentLayout = store.state.layout;
    console.log('setLayout: ', layout, currentLayout);
    if (layout !== currentLayout) {
        console.log('setLayout: SET_LAYOUT: ', layout);
        store.commit('SET_LAYOUT', layout);
    }
}

//
export default router

