<template>
    <el-card :body-style="{ padding: '0px' }">
        <div slot="header">
            COMPANY DOCUMENT
            <el-button icon="el-icon-plus" style="float: right; padding: 3px 0" type="text" @click="showForm = true">ADD DATA</el-button>
        </div>

        <el-table :data="tableData.data">
            <el-table-column prop="name" label="Document Type" show-overflow-tooltip></el-table-column>
            <el-table-column prop="expiry_date" label="Expiry Date" show-overflow-tooltip></el-table-column>
            <el-table-column label="File">
                <template slot-scope="scope">
                    <el-button @click="() => { selectedData = scope.row; showFilePreview = true; }" icon="el-icon-zoom-in" type="primary" plain size="mini">View File</el-button>
                </template>
            </el-table-column>
            <el-table-column width="70px" fixed="right" align="right">
                <template slot-scope="scope">
                    <el-button type="danger" size="small" plain icon="el-icon-delete" @click="deleteData(scope.row.id)"></el-button>
                </template>
            </el-table-column>
        </el-table>

        <el-dialog :visible.sync="showForm" :title="!!formModel.id ? 'EDIT DOCUMENT' : 'ADD DOCUMENT'" width="500px">
            <el-form label-width="150px">
                <el-form-item label="Document Type" :class="formErrors.name ? 'is-error' : ''">
                    <el-select v-model="formModel.name" placeholder="Document Type" style="width:100%">
                        <el-option v-for="t in $store.state.vendorDocumentTypeList" :value="t.name" :label="t.name" :key="t.id"> </el-option>
                    </el-select>
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
                        <el-button type="primary" plain icon="el-icon-upload2">Click to upload</el-button>
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

        <el-dialog custom-class="no-padding-dialog" append-to-body center fullscreen :title="selectedData.name" :visible.sync="showFilePreview">
            <iframe :src="baseUrl + '/' + selectedData.file_path" frameborder="0" style="width:100%;height: calc(100vh - 60px)"></iframe>
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
            baseUrl: BASE_URL,
            tableData: {},
            formModel: {},
            formErrors: [],
            showForm: false,
            selectedData: {},
            showFilePreview: false
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
            console.log(file.response.file)
            axios.delete('/vendorDocument/deleteFile', { params: params }).then(r => {
                this.$message({
                    message: r.data.message,
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
        },
        next() {
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
            let params = {
                vendor_id: this.$store.state.vendor_id,
                sort: 'name',
                order: 'ascending'
            }
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
            axios.post('/vendorDocument', this.formModel).then(r => {
                this.$message({
                    message: 'Data has been saved!',
                    type: 'success',
                    showClose: true
                })
                this.showForm = false
                this.formModel = {}
                this.requestData();
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
                axios.delete('/vendorDocument/' + id).then(r => {
                    this.$message({
                        message: 'Data has been deleted!',
                        type: 'success',
                        showClose: true
                    })
                    this.requestData();
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
        this.$store.commit('getVendorDocumentTypeList')
    }

}
</script>
