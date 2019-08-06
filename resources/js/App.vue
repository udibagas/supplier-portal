<template>
    <el-container>
        <Login :visible.sync="!this.$store.state.is_logged_in" />
        <Profile v-if="$store.state.is_logged_in" :show="showProfile" @close="showProfile = false" />
        <el-header>
            <el-row>
                <el-col :span="12">
                    <el-button type="text" class="btn-big text-white" @click.prevent="collapse = !collapse" :icon="collapse ? 'el-icon-s-unfold' : 'el-icon-s-fold'"></el-button>
                    <span class="brand"> {{appName}} </span>
                </el-col>
                <el-col :span="12" class="text-right">
                    <el-dropdown @command="handleCommand">
                        <span class="el-dropdown-link" style="cursor:pointer">Welcome, {{$store.state.user.name}}!</span>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item command="profile">My Profile</el-dropdown-item>
                            <el-dropdown-item command="logout">Logout</el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>
                </el-col>
            </el-row>
        </el-header>

        <el-container>
            <el-aside width="auto">
                <el-menu
                :router="true"
                :collapse="collapse"
                default-active="1"
                background-color="#060446"
                text-color="#fff"
                class="sidebar"
                active-text-color="#cc0000">
                    <el-menu-item v-for="(m, i) in menus" :index="m.path" :key="i">
                        <i :class="m.icon"></i><span slot="title">{{m.label}}</span>
                    </el-menu-item>
                </el-menu>
            </el-aside>
            <el-main>
                <el-collapse-transition>
                    <router-view @back="goBack"></router-view>
                </el-collapse-transition>
            </el-main>
        </el-container>
    </el-container>
</template>

<script>
import Login from './pages/Login'
import Profile from './pages/Profile'

export default {
    components: { Login, Profile },
    computed: {
        menus() {
            return [
                {label: 'Dashboard', icon: 'el-icon-menu', path: '/' },
                {label: 'Vendor Invitation', icon: 'el-icon-message', path: 'vendor-invitation' },
                {label: 'Vendor Registration Review', icon: 'el-icon-folder-checked', path: 'vendor-registration-review' },
                {label: 'Invoice Submission', icon: 'el-icon-folder-add', path: 'invoice-submission' },
                {label: 'Invoice Submission Review', icon: 'el-icon-document-checked', path: 'invoice-submission-review' },
                {label: 'Quotation Request', icon: 'el-icon-document-copy', path: 'quotation-request' },
                {label: 'Quotation Request Assignment', icon: 'el-icon-share', path: 'quotation-request-assignment' },
                {label: 'Vendor Quotation', icon: 'el-icon-notebook-2', path: 'vendor-quotation' },
                {label: 'Master Data', icon: 'el-icon-coin', path: 'master-data' },
                // {label: 'Account Group', icon: 'el-icon-user', path: 'account-group' },
                // {label: 'Bank', icon: 'el-icon-user', path: 'bank' },
                // {label: 'Department', icon: 'el-icon-user', path: 'department' },
                // {label: 'Industry Type', icon: 'el-icon-user', path: 'industry-type' },
                // {label: 'Partnership Type', icon: 'el-icon-user', path: 'partnership-type' },
                // {label: 'Product Type', icon: 'el-icon-user', path: 'product-type' },
                // {label: 'User', icon: 'el-icon-user', path: 'user' },
                // {label: 'Vendor', icon: 'el-icon-user', path: 'vendor' },
            ]
        }
    },
    data() {
        return {
            collapse: false,
            appName: APP_NAME,
            showProfile: false,
            loginForm: !this.$store.state.is_logged_in
        }
    },
    methods: {
        goBack() {
            window.history.back();
        },
        handleCommand(command) {
            if (command === 'logout') {
                axios.get('/logout').then(r => {
                    window.localStorage.removeItem('user')
                    window.localStorage.removeItem('token')
                    this.$store.state.user = {}
                    this.$store.state.token = ''
                    this.$store.state.is_logged_in = false
                })
            }

            if(command === 'profile') {
                this.showProfile = true
            }
        },
    }
}
</script>

<style lang="css" scoped>
.brand {
    font-size: 22px;
    margin-left: 20px;
}

.btn-big {
    font-size: 22px;
}

.el-header {
    background-color: #3688e6;
    color: #fff;
    line-height: 60px;
}

.sidebar {
    background-color: #463404;
    border-color: #060446;
    height: calc(100vh - 60px);
}

.sidebar:not(.el-menu--collapse) {
    width: 270px;
}

.el-aside {
    height: calc(100vh - 60px);
}

.el-dropdown-link {
    color: #fff;
}
</style>
