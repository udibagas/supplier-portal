<template>
    <el-card :body-style="{ padding: '0px' }">
        <div slot="header" class="clearfix">
            COMPANY MANAGEMENT
            <el-button icon="el-icon-plus" style="float: right; padding: 3px 0" type="text" @click="showForm = true">ADD DATA</el-button>
        </div>

        <el-table :data="tableData.data" stripe>
            <el-table-column prop="type" label="Type" show-overflow-tooltip></el-table-column>
            <el-table-column prop="name" label="Name" show-overflow-tooltip></el-table-column>
            <el-table-column prop="position" label="Position" show-overflow-tooltip></el-table-column>
            <el-table-column prop="id_number" label="ID Number" show-overflow-tooltip></el-table-column>
            <el-table-column prop="date_of_birth" label="Date of Birth" show-overflow-tooltip></el-table-column>
            <el-table-column prop="religion" label="Religion" show-overflow-tooltip></el-table-column>
            <el-table-column width="40px">
                <template slot-scope="scope">
                    <el-dropdown>
                        <span class="el-dropdown-link">
                            <i class="el-icon-more"></i>
                        </span>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item @click.native.prevent="() => { formModel = scope.row; showForm = true; }"><i class="el-icon-edit-outline"></i> Edit</el-dropdown-item>
                            <el-dropdown-item @click.native.prevent="deleteData(scope.row.id)"><i class="el-icon-delete"></i> Delete</el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>
                </template>
            </el-table-column>
        </el-table>

        <el-dialog :visible.sync="showForm" :title="!!formModel.id ? 'EDIT MANAGEMENT' : 'ADD MANAGEMENT'" width="500px">
            <el-form label-width="150px">
                <el-form-item label="Type" :class="formErrors.type ? 'is-error' : ''">
                    <el-select v-model="formModel.type" placeholder="Type" style="width:100%">
                        <el-option
                        v-for="(t, i) in ['Komisaris', 'Direksi', 'Pemegang Saham']"
                        :value="t" :label="t" :key="i">
                        </el-option>
                    </el-select>
                    <div class="el-form-item__error" v-if="formErrors.type">{{formErrors.type[0]}}</div>
                </el-form-item>

                <el-form-item label="Name" :class="formErrors.name ? 'is-error' : ''">
                    <el-input placeholder="Name" v-model="formModel.name"></el-input>
                    <div class="el-form-item__error" v-if="formErrors.name">{{formErrors.name[0]}}</div>
                </el-form-item>

                <el-form-item label="Position" :class="formErrors.position ? 'is-error' : ''">
                    <el-input placeholder="Position" v-model="formModel.position"></el-input>
                    <div class="el-form-item__error" v-if="formErrors.position">{{formErrors.position[0]}}</div>
                </el-form-item>

                <el-form-item label="KTP/SIM Number" :class="formErrors.id_number ? 'is-error' : ''">
                    <el-input placeholder="KTP/SIM Number" v-model="formModel.id_number"></el-input>
                    <div class="el-form-item__error" v-if="formErrors.id_number">{{formErrors.id_number[0]}}</div>
                </el-form-item>

                <el-form-item label="Birth of Date" :class="formErrors.date_of_birth ? 'is-error' : ''">
                    <el-date-picker
                    style="width:100%"
                    type="date"
                    value-format="yyyy-MM-dd"
                    format="dd-MMM-yyyy"
                    placeholder="Birth of Date"
                    v-model="formModel.date_of_birth">
                    </el-date-picker>
                    <div class="el-form-item__error" v-if="formErrors.date_of_birth">{{formErrors.date_of_birth[0]}}</div>
                </el-form-item>

                <el-form-item label="Religion" :class="formErrors.religion ? 'is-error' : ''">
                    <el-select v-model="formModel.religion" placeholder="Religion" style="width:100%">
                        <el-option
                        v-for="(t, i) in ['Islam', 'Kristen', 'Katolik', 'Hindhu', 'Buddha', 'Kong Hu Cu']"
                        :value="t" :label="t" :key="i">
                        </el-option>
                    </el-select>
                    <div class="el-form-item__error" v-if="formErrors.religion">{{formErrors.religion[0]}}</div>
                </el-form-item>
            </el-form>

            <span slot="footer">
                <el-button type="primary" @click="() => !!formModel.id ? update() : store()"><i class="el-icon-success"></i> SAVE</el-button>
                <el-button type="info" @click="showForm = false"><i class="el-icon-error"></i> CANCEL</el-button>
            </span>
        </el-dialog>

        <div style="text-align:right;border-top:1px solid #EBEEF5;line-height:60px;padding: 0 20px;">
            <el-button plain icon="el-icon-d-arrow-left" type="primary" @click="$emit('back', 2)">BACK</el-button>
            <el-button icon="el-icon-d-arrow-right" type="primary" @click="next">NEXT</el-button>
        </div>

    </el-card>
</template>

<script>
export default {
    data() {
        return {
            tableData: {},
            formModel: {},
            formErrors: [],
            showForm: false
        }
    },
    methods: {
        next() {
            this.$emit('next', 4)
            return
            if (this.tableData.data.length == 0) {
                this.$message({
                    message: 'Please add data',
                    type: 'error',
                    showClose: true
                })
            } else {
                this.$emit('next', 4)
            }
        },
        requestData() {
            let params = {
                vendor_id: this.$store.state.vendor_id,
                sort: 'name',
                order: 'ascending'
            }
            axios.get('/vendorCompanyManagement', { params: params }).then(r => {
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
            axios.put('/vendorCompanyManagement/' + this.formModel.id, this.formModel).then(r => {
                this.$message({
                    message: 'Data has been saved!',
                    type: 'success',
                    showClose: true
                })
                this.showForm = false
                this.formModel = {}
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
            axios.post('/vendorCompanyManagement', this.formModel).then(r => {
                this.$message({
                    message: 'Data has been saved!',
                    type: 'success',
                    showClose: true
                })
                this.showForm = false
                this.formModel = {}
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
                axios.delete('/vendorCompanyManagement/' + id).then(r => {
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
    }

}
</script>
