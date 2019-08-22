<template>
    <div>
        <el-page-header @back="$emit('goBack')" content="QUOTATION REQUEST">
        </el-page-header>
        <el-divider></el-divider>
        <el-form :inline="true" style="text-align:right" @submit.native.prevent="() => { return }">
            <el-form-item>
                <el-button icon="el-icon-plus" @click="openForm()" type="primary">ADD NEW QUOTATION REQUEST</el-button>
            </el-form-item>
            <el-form-item style="margin-right:0;">
                <el-input v-model="keyword" placeholder="Search" prefix-icon="el-icon-search" :clearable="true" @change="(v) => { keyword = v; requestData(); }">
                    <el-button @click="() => { page = 1; keyword = ''; requestData(); }" slot="append" icon="el-icon-refresh"></el-button>
                </el-input>
            </el-form-item>
        </el-form>

        <el-table :data="tableData.data" stripe
        @row-dblclick="(row, column, event) => { selectedData = row; showDetailDialog = true; }"
        :default-sort = "{prop: sort, order: order}"
        height="calc(100vh - 290px)"
        v-loading="loading"
        @sort-change="sortChange">
            <el-table-column prop="updated_at" label="Created At" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
            <el-table-column prop="subject" label="Subject" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
            <el-table-column prop="user.name" label="Requestor" show-overflow-tooltip min-width="150px"></el-table-column>
            <el-table-column prop="department.name" label="Department" sortable="custom" show-overflow-tooltip min-width="200px"></el-table-column>
            <!-- <el-table-column prop="vendorQuotations.length" label="Quotation" sortable="custom" show-overflow-tooltip min-width="100px"></el-table-column> -->
            <el-table-column fixed="right" prop="status" label="Status" sortable="custom" min-width="100px">
                <template slot-scope="scope">
                    <el-tag size="mini" :type="scope.row.status ? 'success' : 'info'">{{scope.row.status ? 'Submitted' : 'Draft'}}</el-tag>
                </template>
            </el-table-column>

            <el-table-column fixed="right" width="40px">
                <template slot-scope="scope">
                    <el-dropdown>
                        <span class="el-dropdown-link">
                            <i class="el-icon-more"></i>
                        </span>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item @click.native.prevent="() => { selectedData = scope.row; showDetailDialog = true; }"><i class="el-icon-zoom-in"></i> Show Detail</el-dropdown-item>
                            <el-dropdown-item @click.native.prevent="reviewQuotationRequest(scope.row)"><i class="el-icon-chat-line-square"></i> Review Request</el-dropdown-item>
                            <el-dropdown-item @click.native.prevent="openAssignmentForm(scope.row)"><i class="el-icon-share"></i> Assign to Vendor</el-dropdown-item>
                            <el-dropdown-item @click.native.prevent="showQuotation = true"><i class="el-icon-document-copy"></i> Show Quotation</el-dropdown-item>
                            <el-dropdown-item @click.native.prevent="createQuotation(scope.row)"><i class="el-icon-plus"></i> Create Quotation</el-dropdown-item>
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

        <el-dialog center top="60px" width="90%" title="DETAIL QUOTATION REQUEST" :visible.sync="showDetailDialog">
            <QuotationRequestDetail v-if="!!selectedData" :data="selectedData" />
        </el-dialog>

        <el-dialog top="60px" width="550px" title="REQUEST QUOTATION ASSIGNMENT" :visible.sync="showAssignmentForm">
            <el-form label-width="150px">
                <el-form-item label="Subject" :class="formErrors.subject ? 'is-error' : ''">
                    <el-input disabled v-model="formModelAssignment.subject"></el-input>
                    <div class="el-form-item__error" v-if="formErrors.subject">{{formErrors.subject[0]}}</div>
                </el-form-item>

                <el-form-item label="Department" :class="formErrors.department_id ? 'is-error' : ''">
                    <el-select disabled clearable v-model="formModelAssignment.department_id" style="width:100%">
                        <el-option v-for="(t, i) in $store.state.departmentList"
                        :value="t.id"
                        :label="t.name"
                        :key="i">
                        </el-option>
                    </el-select>
                    <div class="el-form-item__error" v-if="formErrors.department_id">{{formErrors.department_id[0]}}</div>
                </el-form-item>

                <el-form-item label="Vendor" :class="formErrors.vendors ? 'is-error' : ''">
                    <el-select multiple filterable default-first-option v-model="formModelAssignment.vendors" placeholder="Vendor" style="width:100%">
                        <el-option v-for="vendor in $store.state.vendorList"
                        :value="vendor.id"
                        :label="vendor.name"
                        :key="vendor.id">
                        </el-option>
                    </el-select>
                    <div class="el-form-item__error" v-if="formErrors.vendors">{{formErrors.vendors[0]}}</div>
                </el-form-item>

                <!-- <el-form-item label="Message" :class="formErrors.message ? 'is-error' : ''">
                    <el-input type="textarea" rows="10" placeholder="Message" v-model="formModelAssignment.message"></el-input>
                    <div class="el-form-item__error" v-if="formErrors.message">{{formErrors.message[0]}}</div>
                </el-form-item> -->
            </el-form>
            <div slot="footer">
                <el-button type="primary" icon="el-icon-share" @click="assignQuotation">ASSIGN</el-button>
                <el-button type="info" icon="el-icon-error" @click="showAssignmentForm = false">CANCEL</el-button>
            </div>
        </el-dialog>

        <el-dialog center top="60px" width="90%" :visible.sync="showForm" :title="!!formModel.id ? 'EDIT QUOTATION REQUEST' : 'ADD NEW QUOTATION REQUEST'" v-loading="loading" :close-on-click-modal="false">
            <el-alert type="error" title="ERROR"
                :description="error.message + '\n' + error.file + ':' + error.line"
                v-show="error.message"
                style="margin-bottom:15px;">
            </el-alert>
            <el-card>
                <el-form label-width="120px" label-position="left" style="width:400px">
                    <el-form-item label="Request Date">
                        <el-input disabled v-model="formModel.date"></el-input>
                    </el-form-item>

                    <el-form-item label="Requestor">
                        <el-input disabled :value="$store.state.user.name"></el-input>
                    </el-form-item>

                    <el-form-item label="Subject" :class="formErrors.subject ? 'is-error' : ''">
                        <el-input placeholder="Subject" v-model="formModel.subject"></el-input>
                        <div class="el-form-item__error" v-if="formErrors.subject">{{formErrors.subject[0]}}</div>
                    </el-form-item>

                    <el-form-item label="Department" :class="formErrors.department_id ? 'is-error' : ''">
                        <el-select clearable filterable default-first-option v-model="formModel.department_id" placeholder="Department" style="width:100%">
                            <el-option v-for="(t, i) in $store.state.departmentList"
                            :value="t.id"
                            :label="t.name"
                            :key="i">
                            </el-option>
                        </el-select>
                        <div class="el-form-item__error" v-if="formErrors.department_id">{{formErrors.department_id[0]}}</div>
                    </el-form-item>
                </el-form>
            </el-card>

            <br>

            <el-table :data="formModel.items" stripe>
                <el-table-column prop="part_number" label="Part Number" min-width="100px">
                    <template slot-scope="scope">
                        <el-input size="small" v-model="scope.row.part_number"></el-input>
                    </template>
                </el-table-column>
                <el-table-column prop="part_description" label="Part Description" min-width="120px">
                    <template slot-scope="scope">
                        <el-input size="small" v-model="scope.row.part_description"></el-input>
                    </template>
                </el-table-column>
                <el-table-column prop="requested_qty" label="Qty" min-width="60px">
                    <template slot-scope="scope">
                        <el-input size="small" type="number" v-model="scope.row.requested_qty"></el-input>
                    </template>
                </el-table-column>
                <el-table-column prop="unit" label="Unit" min-width="60px">
                    <template slot-scope="scope">
                        <el-input size="small" v-model="scope.row.unit"></el-input>
                    </template>
                </el-table-column>
                <el-table-column prop="requested_delivery_date" label="Delivery Date" min-width="150px">
                    <template slot-scope="scope">
                        <el-date-picker size="small" value-format="yyyy-MM-dd" format="dd-MMM-yyyy" type="date" v-model="scope.row.requested_delivery_date"></el-date-picker>
                    </template>
                </el-table-column>
                <el-table-column prop="remark" label="Remark" min-width="120px">
                    <template slot-scope="scope">
                        <el-input size="small" type="number" v-model="scope.row.remark"></el-input>
                    </template>
                </el-table-column>
                <el-table-column label="Attachment" min-width="100px">
                    <el-button plain size="small" icon="el-icon-paperclip" type="primary">Attach File</el-button>
                </el-table-column>
                <el-table-column fixed="right" align="right" header-align="right">
                    <template slot="header">
                        <el-button type="primary" plain size="small" icon="el-icon-plus" @click="addItem"></el-button>
                    </template>
                    <template slot-scope="scope">
                        <el-button @click="deleteItem(scope.$index, scope.row.id)" icon="el-icon-delete" size="small" type="danger" plain></el-button>
                    </template>
                </el-table-column>
            </el-table>

            <span slot="footer" class="dialog-footer">
                <el-button plain type="primary" @click="() => !!formModel.id ? update(0) : store(0)"><i class="el-icon-success"></i> SAVE AS DRAFT</el-button>
                <el-button type="primary" @click="() => !!formModel.id ? update(1) : store(1)"><i class="el-icon-success"></i> SAVE AND SUBMIT</el-button>
                <el-button type="info" @click="showForm = false"><i class="el-icon-error"></i> CANCEL</el-button>
            </span>
        </el-dialog>

        <el-dialog :visible.sync="showQuotation" title="VENDOR QUOTATION" top="60px" center width="95%">
            <el-table :data="quotations" height="calc(100vh - 420px)" stripe>
                <el-table-column prop="part_number" label="Part Number" show-overflow-tooltip min-width="100px"></el-table-column>
                <el-table-column prop="part_description" label="Part Description" show-overflow-tooltip min-width="120px"></el-table-column>
                <!-- <el-table-column prop="remark" label="Remark" show-overflow-tooltip min-width="120px"></el-table-column> -->
                <!-- <el-table-column label="Attachment" min-width="100px">
                    <el-button plain size="mini" icon="el-icon-zoom-in" type="primary">View Attachment</el-button>
                </el-table-column> -->
                <el-table-column header-align="center" label="Request">
                    <el-table-column prop="requested_qty" label="Qty" show-overflow-tooltip min-width="50px" align="center" header-align="center"></el-table-column>
                    <el-table-column prop="requested_delivery_date" label="Delivery Date" show-overflow-tooltip min-width="100px"></el-table-column>
                </el-table-column>
                <el-table-column v-for="i in ['A', 'B', 'C']" :key="i" header-align="center">
                    <template slot="header">
                        Vendor {{i}}<br>
                        <el-button type="warning" size="mini" plain @click="bargainDialog = true">BARGAIN</el-button>
                        <el-button type="success" size="mini" plain @click="selectQuotation">SELECT</el-button>
                    </template>
                    <el-table-column prop="requested_qty" label="Qty" show-overflow-tooltip min-width="50px" align="center" header-align="center"></el-table-column>
                    <el-table-column label="Price" min-width="120px" align="right" header-align="center">
                        <template>
                            Rp. 1.000.000
                        </template>
                    </el-table-column>
                    <el-table-column prop="requested_delivery_date" label="Delivery Date" show-overflow-tooltip min-width="100px"></el-table-column>
                    <el-table-column prop="top" label="TOP" show-overflow-tooltip min-width="100px"></el-table-column>
                </el-table-column>
            </el-table>
        </el-dialog>

        <el-dialog :visible="bargainDialog" title="BARGAIN QUOTATION">
            <el-form>
                <el-form-item label="Note">
                    <el-input placeholder="Note" rows="5" type="textarea"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer">
                <el-button type="primary" @click="bargainDialog = false">BARGAIN</el-button>
                <el-button type="info" @click="bargainDialog = false">CANCEL</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
import QuotationRequestDetail from '../components/QuotationRequestDetail'

export default {
    components: { QuotationRequestDetail },
    data() {
        return {
            showForm: false,
            showItemForm: false,
            formErrors: {},
            formErrorsItem: {},
            error: {},
            formModel: {},
            keyword: '',
            page: 1,
            pageSize: 10,
            tableData: {},
            sort: 'updated_at',
            order: 'descending',
            loading: false,
            showDetailDialog: false,
            selectedData: {},
            showAssignmentForm: false,
            formModelAssignment: {},
            showQuotation: false,
            bargainDialog: false,
            quotations: [
                {"id":14,"quotation_request_id":2,"part_number":"6565465","part_description":"Desktop HP","requested_qty":1,"requested_delivery_date":"2019-08-29","remark":"-","attachment":null,"created_at":"2019-08-19 16:06:11","updated_at":"2019-08-19 16:06:11"},
                {"id":15,"quotation_request_id":2,"part_number":"wd","part_description":"efwwfw","requested_qty":100,"requested_delivery_date":"2019-08-30","remark":"-","attachment":null,"created_at":"2019-08-19 16:06:11","updated_at":"2019-08-19 16:06:11"}
            ]
        }
    },
    methods: {
        selectQuotation() {
            this.$confirm('Anda yakin?', 'Confirm', { type: 'warning' }).then(() => {
                alert('Success');
            }).catch(e => console.log(e))
        },
        openAssignmentForm(data) {
            this.formModelAssignment.subject = data.subject
            this.formModelAssignment.department_id = data.department_id
            this.formModelAssignment.quotation_request_id = data.quotation_request_id
            this.showAssignmentForm = true
        },
        assignQuotation() {
            axios.post('/quotationRequestAssigmnet', this.formModelAssignment).then(r => {
                this.showAssignmentForm = false
                this.formModelAssignment = {}
                this.requestData()
                this.$message({
                    message: 'Assignment has been sent',
                    type: 'success',
                    showClose: true
                })
            }).catch(e => {
                if (e.response.status == 422) {
                    this.formErrors = e.response.data.errors;
                }

                else {
                    this.formErrorsItem = {}
                    this.$message({
                        message: 'Failed to save data',
                        type: 'error',
                        showClose: true
                    })
                }
            })
        },
        createQuotation(data) {

        },
        addItem() {
            this.formModel.items.push({
                part_number: '',
                part_description: '',
                requested_qty: '',
                requested_delivery_date: '',
                remark: ''
            });
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
                this.formModel.date = moment(data.created_at).format('DD-MMM-YYYY');
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
        this.$store.commit('getVendorList')
    }
}
</script>

<style scoped>
.td-label {
    width: 150px;
    font-weight: bold;
    background-color: #ddd;
    padding: 5px 10px;
}

.td-value {
    background-color: #eee;
    padding: 5px 10px;
}
</style>

