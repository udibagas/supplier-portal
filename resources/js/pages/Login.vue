<template>
    <el-container>
        <el-main>
            <div style="text-align:center;margin:60px 0 40px 0;">
                <img src="images/logo.jpeg" alt="" style="width:70px">
                <h1>{{appName}}</h1>
            </div>
            <el-form id="login-form" style="width:300px;margin: 30px auto 0;text-align:center;">
            <el-divider><h3>LOGIN</h3></el-divider>
            <el-form-item>
                <el-input v-model="email" placeholder="Email/Username"></el-input>
            </el-form-item>
            <el-form-item>
                <el-input type="password" v-model="password" placeholder="Password"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="login" style="width:100%">LOGIN</el-button>
            </el-form-item>
            <el-divider>&copy; {{year}}</el-divider>
        </el-form>
        </el-main>
    </el-container>
</template>

<script>
import moment from 'moment'

export default {
    props: ['visible'],
    data() {
        return {
            appName: APP_NAME,
            email: '',
            password: '',
            year: moment().format('YYYY')
        }
    },
    methods: {
        login() {
            if (!this.email || !this.password) {
                return
            }

            let data = {
                email: this.email,
                password: this.password
            }

            axios.post('login', data).then(r => {
                window.localStorage.setItem('user', JSON.stringify(r.data.user))
                window.localStorage.setItem('token', r.data.token)
                window.axios.defaults.headers.common['Authorization'] = 'bearer ' + r.data.token;
                this.$store.state.user = r.data.user
                this.$store.state.token = r.data.token
                this.$store.state.is_logged_in = true
                this.email = ''
                this.password = ''
                if (r.data.user.role == 31) {
                    this.$router.push('vendor-profile')
                } else {
                    this.$router.push('home')
                }
            }).catch(e => {
                this.$message({
                    message: e.response.data.message || e.response.message,
                    type: 'error',
                    showClose: true
                })
            })
        }
    },
    mounted() {
        document.getElementById('login-form').onkeypress = (e) => {
            if (e.key == 'Enter') {
                this.login()
            }
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
