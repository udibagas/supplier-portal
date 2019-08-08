import Vue from 'vue'
import VueRouter from 'vue-router'
import { Message } from 'element-ui';
import Home from './pages/Home'
import User from './pages/User'
import Login from './pages/Login'
import MasterData from './pages/MasterData'
import VendorInvitation from './pages/VendorInvitation'
import InvoiceSubmission from './pages/InvoiceSubmission'
import QuotationRequest from './pages/QuotationRequest'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [
        { path: '/', component: Home, name: 'home' },
        { path: '/vendor-invitation', component: VendorInvitation, name: 'vendor-invitation' },
        { path: '/invoice-submission', component: InvoiceSubmission, name: 'invoice-submission' },
        { path: '/quotation-request', component: QuotationRequest, name: 'quotation-request' },
        { path: 'login', component: Login, name: 'login' },
        { path: '/user', component: User, name: 'user' },
        { path: '/master-data', component: MasterData, name: 'master-data' },
        { path: '*', component: Home },
    ]
})

// router.beforeEach((to, from, next) => {
//     if (to.path == 'login') {
//         next()
//     } else {
//         let params = { route: to.path }
//         axios.get('/checkAuth', { params: params }).then(r => {
//             next()
//         }).catch(e => {
//             next('login')
//         })
//     }
// });

export default router
