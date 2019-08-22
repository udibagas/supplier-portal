<template>
    <el-container>
        <el-header class="title">{{appName}} - Vendor Registration</el-header>
        <div class="step">
            <el-steps :active="step" align-center finish-status="success" style="margin:30px 0;">
                <el-step title="Login Information" description="Complete login information"></el-step>
                <el-step title="Company Information" description="Complete company information"></el-step>
                <el-step title="Documents" description="Upload documents"></el-step>
                <el-step title="Company Managements" description="Add company managements data"></el-step>
                <el-step title="Bank Accounts" description="Add bank accounts"></el-step>
                <el-step title="Finish" description="Waiting for review"></el-step>
            </el-steps>
        </div>
        <el-main>
            <keep-alive>
                <component @next="next" @back="back" :is="activeStep"></component>
            </keep-alive>
        </el-main>
        <!-- <el-footer>
            <small>&copy; 2019 - PT Lamjaya Global Solusi</small>
        </el-footer> -->
    </el-container>
</template>

<script>
import UserForm from './vendor-registration/UserForm'
import VendorForm from './vendor-registration/VendorForm'
import CompanyDocumentForm from './vendor-registration/CompanyDocumentForm'
import CompanyManagementForm from './vendor-registration/CompanyManagementForm'
import CompanyBankForm from './vendor-registration/CompanyBankForm'
import Finish from './vendor-registration/Finish'

export default {
    components: { UserForm, VendorForm, CompanyDocumentForm, CompanyManagementForm, CompanyBankForm, Finish },
    data() {
        return {
            step: 0,
            steps: [UserForm, VendorForm, CompanyDocumentForm, CompanyManagementForm, CompanyBankForm, Finish],
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
        }
    }
}
</script>

<style lang="scss" scoped>
.el-header.title {
    background-color: #3688e6;
    color: #fff;
    line-height: 60px;
    font-size: 22px;
}

div.step {
    background-color: #eee;
    height: 150px;
}

.el-main {
    height: calc(100vh - 210px);
    padding: 20px 200px;
    // width: 1000px;
    // margin: 0 auto;
}
</style>
