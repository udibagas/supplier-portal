<template>
    <div>
        <Login v-if="!$store.state.is_logged_in" />
        <el-container v-else>
            <Profile :show="showProfile" @close="showProfile = false" />

            <el-aside width="auto">
                <div class="brand-box">
                    <img :src="baseUrl + '/images/logo.png'" :style="collapse ? 'width:50px;margin:25px 0' : 'width:100px;margin:25px 0'" alt="">

                    <div v-show="!collapse">
                        <el-avatar :size="50" icon="el-icon-user"></el-avatar>
                        <br>
                        <strong>{{$store.state.user.name}}</strong><br>
                        <small>{{$store.state.user.email}}</small>
                        <br><br>
                    </div>
                </div>
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
            <el-container>
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
                <el-main>
                    <el-collapse-transition>
                        <router-view @back="goBack"></router-view>
                    </el-collapse-transition>
                </el-main>
            </el-container>
        </el-container>
    </div>
</template>

<script>
import Login from './pages/Login'
import Profile from './pages/Profile'

export default {
    components: { Login, Profile },
    computed: {
        menus() {
            // admin
            if (this.$store.state.user.role == 11) {
                return [
                    {label: 'Dashboard', icon: 'el-icon-menu', path: '/' },
                    {label: 'Vendor Management', icon: 'el-icon-s-check', path: 'vendor' },
                    {label: 'Invoice Submission', icon: 'el-icon-folder-add', path: 'invoice-submission' },
                    {label: 'Invoice Monitoring', icon: 'el-icon-zoom-in', path: 'invoice-monitoring' },
                    {label: 'Quotation Request', icon: 'el-icon-document-copy', path: 'quotation-request' },
                    {label: 'Master Data', icon: 'el-icon-coin', path: 'master-data' },
                ]
            }

            // user
            if (this.$store.state.user.role == 21) {
                return [
                    {label: 'Quotation Request', icon: 'el-icon-document-copy', path: 'quotation-request' }
                ]
            }

            // requester
            if (this.$store.state.user.role == 22) {
                return [
                    {label: 'Quotation Request', icon: 'el-icon-document-copy', path: 'quotation-request' },
                    // untuk review
                    {label: 'Invoice Submission', icon: 'el-icon-money', path: 'invoice-submission' },
                    {label: 'Invoice Monitoring', icon: 'el-icon-zoom-in', path: 'invoice-monitoring' },
                ]
            }

            // tax
            if (this.$store.state.user.role == 23) {
                return [
                    {label: 'Quotation Request', icon: 'el-icon-document-copy', path: 'quotation-request' },
                    // untuk review
                    {label: 'Invoice Submission', icon: 'el-icon-money', path: 'invoice-submission' },
                    {label: 'Invoice Monitoring', icon: 'el-icon-zoom-in', path: 'invoice-monitoring' },
                ]
            }

            // treasury
            if (this.$store.state.user.role == 24) {
                return [
                    {label: 'Invoice Submission', icon: 'el-icon-money', path: 'invoice-submission' },
                    {label: 'Invoice Monitoring', icon: 'el-icon-zoom-in', path: 'invoice-monitoring' },
                ]
            }

            // procurement
            if (this.$store.state.user.role == 25) {
                return [
                    {label: 'Vendor Management', icon: 'el-icon-s-check', path: 'vendor' },
                    {label: 'Quotation Request', icon: 'el-icon-document-copy', path: 'quotation-request' },
                ]
            }

            // Vendor
            if (this.$store.state.user.role == 31) {
                return [
                    {label: 'Vendor Profile', icon: 'el-icon-menu', path: '/vendor-profile' },
                    {label: 'Quotation Request', icon: 'el-icon-document-copy', path: 'quotation-request' },
                    {label: 'Billable PO', icon: 'el-icon-money', path: 'billable-po' },
                    {label: 'Invoice Submission', icon: 'el-icon-folder-add', path: 'invoice-submission' },
                    {label: 'Invoice Monitoring', icon: 'el-icon-zoom-in', path: 'invoice-monitoring' },
                ]
            }
        }
    },
    data() {
        return {
            collapse: false,
            baseUrl: BASE_URL,
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

.brand-box {
    max-height: 220px;
    background-color: #060446;
    text-align: center;
    color: #fff;
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
    background-color: #060446;
    border-color: #060446;
    height: calc(100vh - 220px);
    overflow: auto;
}

.sidebar:not(.el-menu--collapse) {
    width: 220px;
}

.el-aside {
    height: 100vh;
    background-color: #060446;
}

.el-dropdown-link {
    color: #fff;
}
</style>
