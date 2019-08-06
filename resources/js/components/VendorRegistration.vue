<template>
    <el-container>
        <el-header>{{appName}} - Vendor Registration</el-header>
        <el-main>

            <el-steps :active="step" align-center finish-status="success" style="margin:30px 0;">
                <el-step title="Login Information" description="Complete login information"></el-step>
                <el-step title="Company Information" description="Complete company information"></el-step>
                <el-step title="Documents" description="Upload documents"></el-step>
                <el-step title="Company Managements" description="Add company managements data"></el-step>
                <el-step title="Bank Accounts" description="Add bank accounts"></el-step>
            </el-steps>

            <keep-alive>
                <component @next="next" @back="back" :is="activeStep"></component>
            </keep-alive>

        </el-main>
        <el-footer>
            <small>&copy; 2019 - PT Lamjaya Global Solusi</small>
        </el-footer>
    </el-container>
</template>

<script>
import UserForm from './vendor-registration/UserForm'
import VendorForm from './vendor-registration/VendorForm'
import CompanyDocumentForm from './vendor-registration/CompanyDocumentForm'
import CompanyManagementForm from './vendor-registration/CompanyManagementForm'
import CompanyBankForm from './vendor-registration/CompanyBankForm'

export default {
    components: { UserForm, VendorForm, CompanyDocumentForm, CompanyManagementForm, CompanyBankForm },
    data() {
        return {
            step: 0,
            steps: [UserForm, VendorForm, CompanyDocumentForm, CompanyManagementForm, CompanyBankForm],
            activeStep: UserForm,
            appName: APP_NAME
        }
    },
    methods: {
        next(step) {
            this.step = step
            this.activeStep = this.steps[step]
        },
        back(step) {
            this.step = step
            this.activeStep = this.steps[step]
        },
        submit() {

        },
        getData() {

        },
        save() {

        }
    }
}
</script>

<style lang="scss" scoped>
.el-header {
    background-color: #3688e6;
    color: #fff;
    line-height: 60px;
    font-size: 22px;
}

.el-footer {
    background-color: #3688e6;
    color: #fff;
    line-height: 60px;
}

.el-main {
    height: calc(100vh - 120px);
    width: 1000px;
    margin: 0 auto;
}
</style>
