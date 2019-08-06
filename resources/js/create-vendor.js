require('./bootstrap');

window.Vue = require('vue');

import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/en'
import store from './store'

Vue.use(ElementUI, { locale });

Vue.filter('readableDateTime', function(v) {
    return v ? moment(v).format('DD-MMM-YYYY HH:mm') : ''
})

Vue.filter('readableDate', function(v) {
    return v ? moment(v).format('DD-MMM-YYYY') : ''
})

Vue.component('VendorRegistration', require('./components/VendorRegistration').default)

const app = new Vue({
    el: '#app',
    store,
    render: function(createElement) {
        return createElement('VendorRegistration')
    }
});
