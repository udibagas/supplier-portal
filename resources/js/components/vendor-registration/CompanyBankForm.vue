<template>
    <el-card :body-style="{ padding: '0px' }">
        <div slot="header" class="clearfix">
            COMPANY BANK
            <el-button icon="el-icon-plus" style="float: right; padding: 3px 0" type="text" @click="showForm = true">ADD DATA</el-button>
        </div>

        <el-table :data="tableData.data" stripe>
            <el-table-column prop="bank.name" label="Bank" show-overflow-tooltip></el-table-column>
            <el-table-column prop="branch" label="Branch" show-overflow-tooltip></el-table-column>
            <el-table-column prop="account_number" label="Account Number" show-overflow-tooltip></el-table-column>
            <el-table-column prop="account_holder" label="Account Holder" show-overflow-tooltip></el-table-column>
            <el-table-column prop="currency" label="Currency" show-overflow-tooltip></el-table-column>
            <el-table-column width="40px">
                <template slot-scope="scope">
                    <el-dropdown>
                        <span class="el-dropdown-link">
                            <i class="el-icon-more"></i>
                        </span>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item @click.native.prevent="openForm(scope.row)"><i class="el-icon-edit-outline"></i> Edit</el-dropdown-item>
                            <el-dropdown-item @click.native.prevent="deleteData(scope.row.id)"><i class="el-icon-delete"></i> Delete</el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>
                </template>
            </el-table-column>
        </el-table>

        <el-dialog :visible.sync="showForm" :title="!!formModel.id ? 'EDIT BANK' : 'ADD BANK'" width="500px">
            <el-form label-width="150px">
                <el-form-item label="Bank" :class="formErrors.bank_id ? 'is-error' : ''">
                    <el-select filterable default-first-option clearable v-model="formModel.bank_id" placeholder="Bank" style="width:100%">
                        <el-option v-for="(t, i) in $store.state.bankList"
                        :value="t.id"
                        :label="t.code + ' - ' + t.name"
                        :key="i">
                        </el-option>
                    </el-select>
                    <div class="el-form-item__error" v-if="formErrors.bank_id">{{formErrors.bank_id[0]}}</div>
                </el-form-item>

                <el-form-item label="Branch" :class="formErrors.branch ? 'is-error' : ''">
                    <el-input placeholder="Branch" v-model="formModel.branch"></el-input>
                    <div class="el-form-item__error" v-if="formErrors.branch">{{formErrors.branch[0]}}</div>
                </el-form-item>

                <el-form-item label="Account Number" :class="formErrors.account_number ? 'is-error' : ''">
                    <el-input placeholder="Account Number" v-model="formModel.account_number"></el-input>
                    <div class="el-form-item__error" v-if="formErrors.account_number">{{formErrors.account_number[0]}}</div>
                </el-form-item>

                <el-form-item label="Account Holder" :class="formErrors.account_holder ? 'is-error' : ''">
                    <el-input placeholder="Account Holder" v-model="formModel.account_holder"></el-input>
                    <div class="el-form-item__error" v-if="formErrors.account_holder">{{formErrors.account_holder[0]}}</div>
                </el-form-item>

                <el-form-item label="Currency" :class="formErrors.currency ? 'is-error' : ''">
                    <el-select filterable default-first-option clearable v-model="formModel.currency" placeholder="Currency" style="width:100%">
                        <el-option v-for="(value, code) in currencies"
                        :value="code"
                        :label="code + ' - ' + value.name"
                        :key="code">
                        <span style="float: left">{{ code }}</span>
                        <span style="float: right; color: #8492a6; font-size: 13px">{{ value.name }}</span>
                        </el-option>
                    </el-select>
                    <div class="el-form-item__error" v-if="formErrors.currency">{{formErrors.currency[0]}}</div>
                </el-form-item>
            </el-form>

            <span slot="footer">
                <el-button type="primary" @click="() => !!formModel.id ? update() : store()"><i class="el-icon-success"></i> SAVE</el-button>
                <el-button type="info" @click="showForm = false"><i class="el-icon-error"></i> CANCEL</el-button>
            </span>
        </el-dialog>

        <div style="text-align:right;border-top:1px solid #EBEEF5;line-height:60px;padding: 0 20px;">
            <el-button plain icon="el-icon-d-arrow-left" type="primary" @click="$emit('back', 3)">BACK</el-button>
            <el-button icon="el-icon-finished" type="primary" @click="finish">FINISH</el-button>
        </div>

    </el-card>
</template>

<script>
import currencies from '../currencies'
export default {
    data() {
        return {
            tableData: {},
            formModel: {},
            formErrors: [],
            showForm: false,
            currencies: currencies[0]
        }
    },
    methods: {
        finish() {
            if (this.tableData.data.length == 0) {
                this.$message({
                    message: 'Please add at least 1 bank',
                    type: 'error',
                    showClose: true
                })
            } else {
                // notify user procurement, update status vendor
                this.$emit('next', 5)
            }
        },
        requestData() {
            let params = {
                vendor_id: this.$store.state.vendor_id,
                sort: 'bank_id',
                order: 'ascending'
            }
            axios.get('/vendorBank', { params: params }).then(r => {
                this.tableData = r.data
            }).catch(e => {
                this.$message({
                    message: e.response.data.message,
                    type: 'error',
                    showClose: true
                })
            })
        },
        update() {
            axios.put('/vendorBank/' + this.formModel.id, this.formModel).then(r => {
                this.$message({
                    message: 'Data has been saved!',
                    type: 'success',
                    showClose: true
                })
                this.formModel = {}
                this.showForm = false
                this.requestData()
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
        store() {
            this.formModel.vendor_id = this.$store.state.vendor_id;
            axios.post('/vendorBank', this.formModel).then(r => {
                this.$message({
                    message: 'Data has been saved!',
                    type: 'success',
                    showClose: true
                })
                this.formModel = {}
                this.showForm = false
                this.requestData()
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
        deleteData(id) {
            this.$confirm('Are you sure?', 'Confirm', { type: 'warning'}).then(() => {
                axios.delete('/vendorBank/' + id).then(r => {
                    this.$message({
                        message: 'Data has been deleted!',
                        type: 'success',
                        showClose: true
                    })
                    this.requestData()
                }).catch(e => {
                    this.$message({
                        message: e.response.data.message,
                        type: 'error',
                        showClose: true
                    })
                })
            }).catch(e => console.log(e))
        }
    },
    mounted() {
        this.requestData()
        this.$store.commit('getBankList')
    }

}
</script>
