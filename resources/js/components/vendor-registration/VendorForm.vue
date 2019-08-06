<template>
     <el-card :body-style="{ padding: '0px' }">
        <div slot="header">COMPANY INFORMATION</div>

        <el-form label-width="170px" style="height:calc(100vh - 500px);overflow-y:auto;padding:20px;">
            <el-row :gutter="15">
                <el-col :span="12">
                    <el-form-item label="Company Name" :class="formErrors.name ? 'is-error' : ''">
                        <el-input placeholder="Company Name" v-model="formModel.name"></el-input>
                        <div class="el-form-item__error" v-if="formErrors.name">{{formErrors.name[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Established Date" :class="formErrors.established_date ? 'is-error' : ''">
                        <el-date-picker
                        style="width:100%"
                        format="yyyy-MM-dd"
                        placeholder="Established Date"
                        v-model="formModel.established_date">
                        </el-date-picker>
                        <div class="el-form-item__error" v-if="formErrors.established_date">{{formErrors.established_date[0]}}</div>
                    </el-form-item>

                    <el-form-item label="NPWP" :class="formErrors.npwp ? 'is-error' : ''">
                        <el-input placeholder="NPWP" v-model="formModel.npwp"></el-input>
                        <div class="el-form-item__error" v-if="formErrors.npwp">{{formErrors.npwp[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Account Group" :class="formErrors.account_group_id ? 'is-error' : ''">
                        <el-select v-model="formModel.account_group_id" placeholder="Account Group" style="width:100%">
                            <el-option v-for="(t, i) in $store.state.accountGroupList"
                            :value="t.id"
                            :label="t.name"
                            :key="i">
                            </el-option>
                        </el-select>
                        <div class="el-form-item__error" v-if="formErrors.account_group_id">{{formErrors.account_group_id[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Business Entity Form" :class="formErrors.business_entity_form ? 'is-error' : ''">
                        <el-select v-model="formModel.business_entity_form" placeholder="Business Entity Form" style="width:100%">
                            <el-option v-for="(t, i) in $store.state.businessEntityFormList"
                            :value="t"
                            :label="t"
                            :key="i">
                            </el-option>
                        </el-select>
                        <div class="el-form-item__error" v-if="formErrors.business_entity_form">{{formErrors.business_entity_form[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Company Status" :class="formErrors.company_status ? 'is-error' : ''">
                        <el-select v-model="formModel.company_status" placeholder="Company Status" style="width:100%">
                            <el-option v-for="(t, i) in $store.state.companyStatusList"
                            :value="t"
                            :label="t"
                            :key="i">
                            </el-option>
                        </el-select>
                        <div class="el-form-item__error" v-if="formErrors.company_status">{{formErrors.company_status[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Partnership Type" :class="formErrors.partnership_type_id ? 'is-error' : ''">
                        <el-select v-model="formModel.partnership_type_id" placeholder="Partnership Type" style="width:100%">
                            <el-option v-for="(t, i) in $store.state.partnershipTypeList"
                            :value="t.id"
                            :label="t.name"
                            :key="i">
                            </el-option>
                        </el-select>
                        <div class="el-form-item__error" v-if="formErrors.partnership_type_id">{{formErrors.partnership_type_id[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Industry Type" :class="formErrors.industry_type ? 'is-error' : ''">
                        <el-select
                        multiple
                        clearable
                        filterable
                        default-first-option
                        v-model="formModel.industry_type"
                        placeholder="Industry Type"
                        style="width:100%">
                            <el-option v-for="(t, i) in $store.state.industryTypeList"
                            :value="t.id"
                            :label="t.name"
                            :key="i">
                            </el-option>
                        </el-select>
                        <div class="el-form-item__error" v-if="formErrors.industry_type">{{formErrors.industry_type[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Product Type" :class="formErrors.product_type ? 'is-error' : ''">
                        <el-select
                        multiple
                        clearable
                        filterable
                        default-first-option
                        v-model="formModel.product_type"
                        placeholder="Product Type"
                        style="width:100%">
                            <el-option v-for="(t, i) in $store.state.productTypeList"
                            :value="t.id"
                            :label="t.name"
                            :key="i">
                            </el-option>
                        </el-select>
                        <div class="el-form-item__error" v-if="formErrors.product_type">{{formErrors.product_type[0]}}</div>
                    </el-form-item>
                </el-col>

                <el-col :span="12">
                    <el-form-item label="Address" :class="formErrors.address ? 'is-error' : ''">
                        <el-input type="textarea" rows="4" placeholder="Address" v-model="formModel.address"></el-input>
                        <div class="el-form-item__error" v-if="formErrors.address">{{formErrors.address[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Postcode" :class="formErrors.postcode ? 'is-error' : ''">
                        <el-input placeholder="Postcode" v-model="formModel.postcode"></el-input>
                        <div class="el-form-item__error" v-if="formErrors.postcode">{{formErrors.postcode[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Phone" :class="formErrors.phone ? 'is-error' : ''">
                        <el-input placeholder="Phone" v-model="formModel.phone"></el-input>
                        <div class="el-form-item__error" v-if="formErrors.phone">{{formErrors.phone[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Fax" :class="formErrors.fax ? 'is-error' : ''">
                        <el-input placeholder="Fax" v-model="formModel.fax"></el-input>
                        <div class="el-form-item__error" v-if="formErrors.fax">{{formErrors.fax[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Email" :class="formErrors.email ? 'is-error' : ''">
                        <el-input placeholder="Email" v-model="formModel.email"></el-input>
                        <div class="el-form-item__error" v-if="formErrors.email">{{formErrors.email[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Website" :class="formErrors.website ? 'is-error' : ''">
                        <el-input placeholder="Website" v-model="formModel.website"></el-input>
                        <div class="el-form-item__error" v-if="formErrors.website">{{formErrors.website[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Contact Person" :class="formErrors.contact_person_name ? 'is-error' : ''">
                        <el-input placeholder="Contact Person" v-model="formModel.contact_person_name"></el-input>
                        <div class="el-form-item__error" v-if="formErrors.contact_person_name">{{formErrors.contact_person_name[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Contact Person Phone" :class="formErrors.contact_person_phone ? 'is-error' : ''">
                        <el-input placeholder="Contact Person Phone" v-model="formModel.contact_person_phone"></el-input>
                        <div class="el-form-item__error" v-if="formErrors.contact_person_phone">{{formErrors.contact_person_phone[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Contact Person Email" :class="formErrors.contact_person_email ? 'is-error' : ''">
                        <el-input placeholder="Contact Person Email" v-model="formModel.contact_person_email"></el-input>
                        <div class="el-form-item__error" v-if="formErrors.contact_person_email">{{formErrors.contact_person_email[0]}}</div>
                    </el-form-item>
                </el-col>
            </el-row>
        </el-form>
        <div style="text-align:right;border-top:1px solid #EBEEF5;line-height:60px;padding: 0 20px;">
            <el-button plain icon="el-icon-d-arrow-left" type="primary" @click="$emit('back', 0)">BACK</el-button>
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
            this.$emit('next', 2)
            return;
            axios.post('/vendor', this.formModel).then(r => {
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
            axios.put('/vendor/' + this.formModel.id, this.formModel).then(r => {
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
    },
    mounted() {
        this.$store.commit('getAccountGroupList')
        this.$store.commit('getIndustryTypeList')
        this.$store.commit('getPartnershipTypeList')
        this.$store.commit('getProductTypeList')
    }
}
</script>

<style lang="scss" scoped>

</style>
