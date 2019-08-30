import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

let currentUser = JSON.parse(window.localStorage.getItem('user'))

export default new Vuex.Store({
    state: {
        vendor_id: null, // untuk nyimpen sementara
        base_url: BASE_URL,
        user: currentUser || {},
        token: window.localStorage.getItem('token'),
        is_logged_in: !!currentUser,
        accountGroupList: [],
        bankList: [],
        departmentList: [],
        industryTypeList: [],
        partnershipTypeList: [],
        paymentTermList: [],
        vendorDocumentTypeList: [],
        productTypeList: [],
        vendorList: [],
        roleList: [],
        businessEntityFormList: ['PT', 'CV', 'Mr.', 'Mrs.'],
        companyStatusList: ['Pusat', 'Cabang'],
        whtTypeList: [],
        whtCodeList: [],
    },
    mutations: {
        getAccountGroupList(state) {
            axios.get('/accountGroup/getList').then(r => state.accountGroupList = r.data)
                .catch(e => console.log(e))
        },
        getBankList(state) {
            axios.get('/bank/getList').then(r => state.bankList = r.data)
                .catch(e => console.log(e))
        },
        getDepartmentList(state) {
            axios.get('/department/getList').then(r => state.departmentList = r.data)
                .catch(e => console.log(e))
        },
        getIndustryTypeList(state) {
            axios.get('/industryType/getList').then(r => state.industryTypeList = r.data)
                .catch(e => console.log(e))
        },
        getPartnershipTypeList(state) {
            axios.get('/partnershipType/getList').then(r => state.partnershipTypeList = r.data)
                .catch(e => console.log(e))
        },
        getPaymentTermList(state) {
            axios.get('/paymentTerm/getList').then(r => state.paymentTermList = r.data)
                .catch(e => console.log(e))
        },
        getProductTypeList(state) {
            axios.get('/productType/getList').then(r => state.productTypeList = r.data)
                .catch(e => console.log(e))
        },
        getVendorDocumentTypeList(state) {
            axios.get('/vendorDocumentType/getList').then(r => state.vendorDocumentTypeList = r.data)
                .catch(e => console.log(e))
        },
        getVendorList(state) {
            axios.get('/vendor/getList').then(r => state.vendorList = r.data)
                .catch(e => console.log(e))
        },
        getRoleList(state) {
            axios.get('user/getRoleList').then(r => state.roleList = r.data)
                .catch(e => console.log(e))
        },
        getWhtTypeList(state) {
            axios.get('wht/getWhtTypeList').then(r => state.whtTypeList = r.data)
                .catch(e => console.log(e))
        },
        getWhtCodeList(state) {
            axios.get('wht/getWhtCodeList').then(r => state.whtCodeList = r.data)
                .catch(e => console.log(e))
        },
    }
})
