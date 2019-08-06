<template>
    <el-card :body-style="{ padding: '0px' }">
        <div slot="header" class="clearfix">
            COMPANY DOCUMENT
            <el-button icon="el-icon-plus" style="float: right; padding: 3px 0" type="text" @click="showForm = true">Add Data</el-button>
        </div>

        <el-table :data="tableData.data" stripe height="calc(100vh - 460px)">
            <el-table-column prop="name" label="Name" show-overflow-tooltip></el-table-column>
            <el-table-column prop="expiry_date" label="Expiry Date" show-overflow-tooltip></el-table-column>
            <el-table-column prop="file_path" label="File" show-overflow-tooltip></el-table-column>
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

        <el-dialog :visible.sync="showForm" :title="!!formModel.id ? 'EDIT DOCUMENT' : 'ADD DOCUMENT'" width="500px">
            <el-form label-width="150px">
                <el-form-item label="Name" :class="formErrors.name ? 'is-error' : ''">
                    <el-input placeholder="Name" v-model="formModel.name"></el-input>
                    <div class="el-form-item__error" v-if="formErrors.name">{{formErrors.name[0]}}</div>
                </el-form-item>

                <el-form-item label="Expiry Date" :class="formErrors.expiry_date ? 'is-error' : ''">
                    <el-date-picker
                    style="width:100%"
                    type="date"
                    value-format="yyyy-MM-dd"
                    format="dd-MMM-yyyy"
                    placeholder="Expiry Date"
                    v-model="formModel.expiry_date">
                    </el-date-picker>
                    <div class="el-form-item__error" v-if="formErrors.expiry_date">{{formErrors.expiry_date[0]}}</div>
                </el-form-item>

                <el-form-item label="File" :class="formErrors.file_path ? 'is-error' : ''">
                    <el-upload action="/vendorDocument/upload"
                    :headers="{'Authorization': 'bearer ' + $store.state.token, 'Accept': 'application/json, text/plain, */*'}"
                    :on-success="handleSuccess"
                    :on-error="handleError"
                    :on-remove="removeFile"
                    :limit="1">
                        <el-button type="primary">Click to upload</el-button>
                        <div slot="tip" class="el-upload__tip">Allowed  extension : jpg, jpeg, png, bmp, pdf</div>
                    </el-upload>
                    <div class="el-form-item__error" v-if="formErrors.file_path">{{formErrors.file_path[0]}}</div>
                </el-form-item>
            </el-form>

            <span slot="footer">
                <el-button type="primary" @click="() => !!formModel.id ? update() : store()"><i class="el-icon-success"></i> SAVE</el-button>
                <el-button type="info" @click="showForm = false"><i class="el-icon-error"></i> CANCEL</el-button>
            </span>
        </el-dialog>

        <div style="text-align:right;border-top:1px solid #EBEEF5;line-height:60px;padding: 0 20px;">
            <el-button plain icon="el-icon-d-arrow-left" type="primary" @click="$emit('back', 1)">BACK</el-button>
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
        handleSuccess(response, file, fileList) {
            this.$message({
                message: response.message,
                type: 'success',
                showClose: true
            })
            this.formModel.file_path = response.file;
            console.log(response)
        },
        handleError(err, file, fileList) {
            this.$message({
                message: JSON.parse(err.message).message,
                type: 'error',
                showClose: true
            })
        },
        removeFile(file, fileList) {
            console.log(file)
        },
        next() {
            this.$emit('next', 3)
            return

            if (this.tableData.data.length == 0) {
                this.$message({
                    message: 'Please upload document',
                    type: 'error',
                    showClose: true
                })
            } else {
                this.$emit('next', 3)
            }
        },
        requestData() {
            let params = { vendor_id: this.$store.state.vendor_id }
            axios.get('/vendorDocument', { params: params }).then(r => {
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
            axios.put('/vendorDocument/' + this.formModel.id, this.formModel).then(r => {
                this.$message({
                    message: 'Data has been saved!',
                    type: 'success',
                    showClose: true
                })
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
            axios.post('/vendorDocument', this.formModel).then(r => {
                this.$message({
                    message: 'Data has been saved!',
                    type: 'success',
                    showClose: true
                })
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
        delete(id) {
            this.$confirm('Are you sure?', 'Confirm', { type: 'warning'}).then(() => {
                axios.delete('/vendorDocument/' + id).then(r => {
                    this.$message({
                        message: 'Data has been deleted!',
                        type: 'success',
                        showClose: true
                    })
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
