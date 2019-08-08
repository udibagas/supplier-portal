<template>
    <el-card :body-style="{ padding: '0px' }">
        <div slot="header">LOGIN INFORMATION</div>
        <el-form label-width="170px" style="height:calc(100vh - 500px);overflow-y:auto;padding:20px;">
            <el-form-item label="Name" :class="formErrors.name ? 'is-error' : ''">
                <el-input placeholder="Name" v-model="formModel.name"></el-input>
                <div class="el-form-item__error" v-if="formErrors.name">{{formErrors.name[0]}}</div>
            </el-form-item>

            <el-form-item label="Email" :class="formErrors.email ? 'is-error' : ''">
                <el-input placeholder="Email" v-model="formModel.email"></el-input>
                <div class="el-form-item__error" v-if="formErrors.email">{{formErrors.email[0]}}</div>
            </el-form-item>

            <el-form-item label="Phone" :class="formErrors.phone ? 'is-error' : ''">
                <el-input placeholder="Phone" v-model="formModel.phone"></el-input>
                <div class="el-form-item__error" v-if="formErrors.phone">{{formErrors.phone[0]}}</div>
            </el-form-item>

            <el-form-item label="Password" :class="formErrors.password ? 'is-error' : ''">
                <el-input type="password" placeholder="Password" v-model="formModel.password"></el-input>
                <div class="el-form-item__error" v-if="formErrors.password">{{formErrors.password[0]}}</div>
            </el-form-item>

            <el-form-item label="Password Confirmation" :class="formErrors.password ? 'is-error' : ''">
                <el-input type="password" placeholder="Password Confirmation" v-model="formModel.password_confirmation"></el-input>
            </el-form-item>
        </el-form>

        <div style="text-align:right;border-top:1px solid #EBEEF5;line-height:60px;padding: 0 20px;">
            <el-button icon="el-icon-d-arrow-right" type="primary" @click="() => !!formModel.id ? update() : store()">NEXT</el-button>
        </div>

    </el-card>
</template>

<script>
export default {
    data() {
        return {
            formModel: {},
            formErrors: []
        }
    },
    methods: {
        store() {
            // this.$emit('next', 1)
            // return;
            axios.post('/register', this.formModel).then(r => {
                this.$message({
                    message: 'Data has been saved!',
                    type: 'success',
                    showClose: true
                })
                window.localStorage.setItem('user', JSON.stringify(r.data.user))
                window.localStorage.setItem('token', r.data.token)
                window.axios.defaults.headers.common['Authorization'] = 'bearer ' + r.data.token;
                this.$store.state.user = r.data.user
                this.$store.state.token = r.data.token
                this.$store.state.is_logged_in = true
                this.formModel = r.data.user
                this.$emit('next', 1)
            }).catch(e => {
                if (e.response.status == 422) {
                    this.formErrors = e.response.data.errors;
                }

                if (e.response.status == 500) {
                    this.$message({
                        message: e.response.data.message,
                        type: 'error',
                        showClose: true
                    })
                }
            })
        },
        update() {
            axios.put('/user/' + this.formModel.id, this.formModel).then(r => {
                this.$message({
                    message: 'Data has been saved!',
                    type: 'success',
                    showClose: true
                })
                this.formModel = r.data
                this.$emit('next', 1)
            }).catch(e => {
                if (e.response.status == 422) {
                    this.formErrors = e.response.data.errors;
                }

                if (e.response.status == 500) {
                    this.$message({
                        message: e.response.data.message,
                        type: 'error',
                        showClose: true
                    })
                }
            })
        }
    }

}
</script>
