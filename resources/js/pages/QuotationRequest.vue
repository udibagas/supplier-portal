<template>
    <div>
        <el-page-header @back="$emit('goBack')" content="QUOTATION REQUEST">
        </el-page-header>
        <el-divider></el-divider>
        <el-form :inline="true" style="text-align:right" @submit.native.prevent="() => { return }">
            <el-form-item>
                <el-button icon="el-icon-plus" @click="openForm()" type="primary">QUOTATION REQUEST</el-button>
            </el-form-item>
            <el-form-item style="margin-right:0;">
                <el-input v-model="keyword" placeholder="Search" prefix-icon="el-icon-search" :clearable="true" @change="(v) => { keyword = v; requestData(); }">
                    <el-button @click="() => { page = 1; keyword = ''; requestData(); }" slot="append" icon="el-icon-refresh"></el-button>
                </el-input>
            </el-form-item>
        </el-form>

        <el-table :data="tableData.data" stripe
        :default-sort = "{prop: sort, order: order}"
        height="calc(100vh - 290px)"
        v-loading="loading"
        @sort-change="sortChange">
            <el-table-column type="expand">
                <template slot-scope="scope">
                    <table>
                    <tbody>
                        <tr><td class="td-label">Created At</td><td class="td-value">{{scope.row.updated_at}}</td></tr>
                        <tr><td class="td-label">Requestor</td><td class="td-value">{{scope.row.user}}</td></tr>
                        <tr><td class="td-label">Unit</td><td class="td-value">{{scope.row.unit}}</td></tr>
                        <tr>
                            <td class="td-label">Status</td>
                            <td class="td-value">
                                <el-tag size="mini" :type="scope.row.status ? 'success' : 'info'">{{scope.row.status ? 'Submitted' : 'Draft'}}</el-tag>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </template>
            </el-table-column>
            <el-table-column prop="updated_at" label="Created At" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
            <el-table-column prop="user" label="Requestor" show-overflow-tooltip min-width="150px"></el-table-column>
            <el-table-column prop="department" label="Department" sortable="custom" show-overflow-tooltip min-width="200px"></el-table-column>
            <el-table-column fixed="right" prop="status" label="Status" sortable="custom" min-width="100px">
                <template slot-scope="scope">
                    <el-tag size="mini" :type="scope.row.status ? 'success' : 'info'">{{scope.row.status ? 'Submitted' : 'Draft'}}</el-tag>
                </template>
            </el-table-column>

            <el-table-column fixed="right" width="40px">
                <template slot-scope="scope">
                    <el-dropdown v-if="scope.row.status == 0">
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

        <br>

        <el-pagination background
        @current-change="(p) => { page = p; requestData(); }"
        @size-change="(s) => { pageSize = s; requestData(); }"
        layout="prev, pager, next, sizes, total"
        :page-size="pageSize"
        :page-sizes="[10, 25, 50, 100]"
        :total="tableData.total">
        </el-pagination>

        <el-dialog fullscreen :visible.sync="showForm" :title="!!formModel.id ? 'EDIT QUOTATION REQUEST' : 'ADD NEW QUOTATION REQUEST'" v-loading="loading" :close-on-click-modal="false">
            <el-alert type="error" title="ERROR"
                :description="error.message + '\n' + error.file + ':' + error.line"
                v-show="error.message"
                style="margin-bottom:15px;">
            </el-alert>
            <el-form label-width="130px">
                <el-row :gutter="15">
                    <el-col :span="12">
                        <el-form-item label="Request Date">
                            <el-input disabled v-model="formModel.date"></el-input>
                        </el-form-item>

                        <el-form-item label="Subject" :class="formErrors.subject ? 'is-error' : ''">
                            <el-input placeholder="Subject" v-model="formModel.subject"></el-input>
                            <div class="el-form-item__error" v-if="formErrors.subject">{{formErrors.subject[0]}}</div>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Requestor">
                            <el-input disabled :value="$store.state.user.name"></el-input>
                        </el-form-item>

                        <el-form-item label="Department" :class="formErrors.department_id ? 'is-error' : ''">
                            <el-select clearable v-model="formModel.department_id" placeholder="Department" style="width:100%">
                                <el-option v-for="(t, i) in $store.state.departmentList"
                                :value="t.id"
                                :label="t.name"
                                :key="i">
                                </el-option>
                            </el-select>
                            <div class="el-form-item__error" v-if="formErrors.department_id">{{formErrors.department_id[0]}}</div>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>

            <div style="height: calc(100vh - 330px);overflow:auto;">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Part Number</th>
                            <th>Part Description</th>
                            <th>Requested Qty</th>
                            <th>Requested Delivery Date</th>
                            <th>Remark</th>
                            <th>Attachment</th>
                            <th class="text-right">
                                <el-button icon="el-icon-plus" type="primary" plain size="small" @click="addItem">ADD ITEM</el-button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in formModel.items" :key="index">
                            <td>{{item.part_number}}</td>
                            <td>{{item.part_description}}</td>
                            <td>{{item.requested_qty}}</td>
                            <td>{{item.requested_delivery_date}}</td>
                            <td>{{item.remark}}</td>
                            <td>{{item.attachment}}</td>
                            <td class="text-right">
                                <el-button icon="el-icon-edit" type="text" @click="editItem(index, item.id)"></el-button>
                                <el-button icon="el-icon-delete" type="text" @click="deleteItem(index, item.id)"></el-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <span slot="footer" class="dialog-footer">
                <el-button plain type="primary" @click="() => !!formModel.id ? update(0) : store(0)"><i class="el-icon-success"></i> SAVE AS DRAFT</el-button>
                <el-button type="primary" @click="() => !!formModel.id ? update(1) : store(1)"><i class="el-icon-success"></i> SAVE AND SUBMIT</el-button>
                <el-button type="info" @click="showForm = false"><i class="el-icon-error"></i> CANCEL</el-button>
            </span>
        </el-dialog>

        <el-dialog :title="!!formModelItem.id ? 'EDIT NEW ITEM' : 'ADD ITEM'" top="60px" :visible.sync="showItemForm" append-to-body width="500px">
            <el-form label-width="180px">
                <el-form-item label="Part Number" :class="formErrorsItem.part_number ? 'is-error' : ''">
                    <el-input placeholder="Part Number" v-model="formModelItem.part_number"></el-input>
                    <div class="el-form-item__error" v-if="formErrorsItem.part_number">{{formErrorsItem.part_number[0]}}</div>
                </el-form-item>
                <el-form-item label="Part Description" :class="formErrorsItem.part_description ? 'is-error' : ''">
                    <el-input placeholder="Part Description" v-model="formModelItem.part_description"></el-input>
                    <div class="el-form-item__error" v-if="formErrorsItem.part_description">{{formErrorsItem.part_description[0]}}</div>
                </el-form-item>
                <el-form-item label="Requested Quantity" :class="formErrorsItem.requested_qty ? 'is-error' : ''">
                    <el-input type="number" placeholder="Requested Quantity" v-model="formModelItem.requested_qty"></el-input>
                    <div class="el-form-item__error" v-if="formErrorsItem.requested_qty">{{formErrorsItem.requested_qty[0]}}</div>
                </el-form-item>
                <el-form-item label="Requested Delivery Date" :class="formErrorsItem.requested_delivery_date ? 'is-error' : ''">
                    <el-date-picker style="width:100%" value-format="yyyy-MM-dd" format="dd-MMM-yyyy" placeholder="Requested Delivery Date" v-model="formModelItem.requested_delivery_date"></el-date-picker>
                    <div class="el-form-item__error" v-if="formErrorsItem.requested_delivery_date">{{formErrorsItem.requested_delivery_date[0]}}</div>
                </el-form-item>
                <el-form-item label="Remark" :class="formErrorsItem.remark ? 'is-error' : ''">
                    <el-input type="textarea" rows="3" placeholder="Remark" v-model="formModelItem.remark"></el-input>
                    <div class="el-form-item__error" v-if="formErrorsItem.remark">{{formErrorsItem.remark[0]}}</div>
                </el-form-item>
                <el-form-item label="Attachment" :class="formErrorsItem.attachment ? 'is-error' : ''">
                    <el-upload action="/quotationRequestItem/uploadAttachment">
                        <el-button type="primary" icon="el-icon-upload2" plain>Select file</el-button>
                    </el-upload>
                    <div class="el-form-item__error" v-if="formErrorsItem.attachment">{{formErrorsItem.attachment[0]}}</div>
                </el-form-item>
            </el-form>
            <span slot="footer">
                <el-button type="primary" icon="el-icon-success">{{!!formModelItem.id ? 'EDIT' : 'ADD'}} ITEM</el-button>
                <el-button type="info" icon="el-icon-error" @click="showItemForm = false">CANCEL</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>
export default {
    data() {
        return {
            showForm: false,
            showItemForm: false,
            formErrors: {},
            formErrorsItem: {},
            error: {},
            formModelItem: {},
            formModel: {},
            keyword: '',
            page: 1,
            pageSize: 10,
            tableData: {},
            sort: 'name',
            order: 'ascending',
            loading: false,
        }
    },
    methods: {
        addItem() {
            this.showItemForm = true
            this.formModelItem = {}
            this.formErrorsItem = {}
        },
        deleteItem(index, item_id) {
            if (!!item_id) {
                axios.delete('/quotationRequestItem/' + item_id).then(r => {
                    this.formModel.items.splice(index, 1)
                }).then(e => console.log(e))
            } else {
                this.formModel.items.splice(index, 1)
            }
        },
        sortChange(c) {
            if (c.prop != this.sort || c.order != this.order) {
                this.sort = c.prop; this.order = c.order; this.requestData()
            }
        },
        openForm(data = null) {
            this.error = {}
            this.formErrors = {}

            if (data == null) {
                this.formModel = {
                    date: moment().format('DD-MMM-YYYY'),
                    department_id: this.$store.state.user.department_id,
                    items: []
                }
            } else {
                this.formModel = JSON.parse(JSON.stringify(data));
            }

            this.showForm = true
        },
        store(status) {
            this.loading = true;
            this.formModel.status = status;
            axios.post('/quotationRequest', this.formModel).then(r => {
                this.showForm = false;
                this.$message({
                    message: 'Data berhasil disimpan.',
                    type: 'success',
                    showClose: true
                });
                this.requestData();
            }).catch(e => {
                if (e.response.status == 422) {
                    this.error = {}
                    this.formErrors = e.response.data.errors;
                }

                if (e.response.status == 500) {
                    this.formErrors = {}
                    this.error = e.response.data;
                }
            }).finally(() => {
                this.loading = false
            })
        },
        update(status) {
            this.loading = true;
            this.formModel.status = status
            axios.put('/quotationRequest/' + this.formModel.id, this.formModel).then(r => {
                this.showForm = false
                this.$message({
                    message: 'Data berhasil disimpan.',
                    type: 'success',
                    showClose: true
                });
                this.requestData()
            }).catch(e => {
                if (e.response.status == 422) {
                    this.error = {}
                    this.formErrors = e.response.data.errors;
                }

                if (e.response.status == 500) {
                    this.formErrors = {}
                    this.error = e.response.data;
                }
            }).finally(() => {
                this.loading = false
            })
        },
        deleteData(id) {
            this.$confirm('Anda yakin akan menghapus data ini?', 'Warning', { type: 'warning' }).then(() => {
                axios.delete('/quotationRequest/' + id).then(r => {
                    this.requestData();
                    this.$message({
                        message: r.data.message,
                        type: 'success',
                        showClose: true
                    });
                }).catch(e => {
                    this.$message({
                        message: e.response.data.message,
                        type: 'error',
                        showClose: true
                    });
                })
            }).catch(() => console.log(e));
        },
        requestData() {
            let params = {
                page: this.page,
                keyword: this.keyword,
                pageSize: this.pageSize,
                sort: this.sort,
                order: this.order,
            }

            this.loading = true;
            axios.get('/quotationRequest', {params: params}).then(r => {
                    this.tableData = r.data
            }).catch(e => {
                if (e.response.status == 500) {
                    this.$message({
                        message: e.response.data.message + '\n' + e.response.data.file + ':' + e.response.data.line,
                        type: 'error',
                        showClose: true
                    });
                }
            }).finally(() => {
                this.loading = false
            })
        }
    },
    mounted() {
        this.requestData();
        this.$store.commit('getDepartmentList')
    }
}
</script>

<style scoped>
.td-label {
    min-width: 150px;
    font-weight: bold;
    background-color: #ddd;
    padding: 5px 10px;
}

.td-value {
    background-color: #eee;
    padding: 5px 10px;
}
</style>

