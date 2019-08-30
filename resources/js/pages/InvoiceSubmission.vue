<template>
    <div>
        <el-page-header @back="$emit('goBack')" content="INVOICE SUBMISSION">
        </el-page-header>
        <el-divider></el-divider>

        <el-form :inline="true" style="text-align:right" @submit.native.prevent="() => { return }">
            <el-form-item>
                <el-button icon="el-icon-plus" @click="showForm = true" type="primary">CREATE NON PO INVOICE</el-button>
            </el-form-item>
            <el-form-item style="margin-right:0;">
                <el-input v-model="keyword" placeholder="Search" prefix-icon="el-icon-search" :clearable="true" @change="(v) => { keyword = v; requestData(); }">
                    <el-button @click="() => { page = 1; keyword = ''; requestData(); }" slot="append" icon="el-icon-refresh"></el-button>
                </el-input>
            </el-form-item>
        </el-form>

        <el-table stripe height="calc(100vh - 290px)"
        :data="tableData.data"
        :default-sort="{prop: sort, order: order}"
        v-loading="loading"
        @sort-change="sortChange">
            <el-table-column fixed="left" prop="invoice_number" label="Invoice No" min-width="100px"></el-table-column>
            <el-table-column prop="vendor" label="Vendor" show-overflow-tooltip min-width="150px"></el-table-column>
            <el-table-column prop="invoice_date" sortable="custom" label="Invoice Date" min-width="130px"></el-table-column>
            <el-table-column prop="faktur_number" label="Faktur No" min-width="120px"></el-table-column>
            <el-table-column prop="faktur_date" label="Faktur Date" min-width="120px"></el-table-column>
            <el-table-column prop="payment_term" label="Term of Payment" min-width="130px" show-overflow-tooltip=""></el-table-column>
            <el-table-column prop="due_date" sortable="custom" label="Due Date" min-width="120px"></el-table-column>
            <el-table-column prop="wht_type" label="WHT Type" min-width="120px"></el-table-column>
            <el-table-column prop="wht_code" label="WHT Code" min-width="120px"></el-table-column>
            <el-table-column prop="wht_base_amount" label="WHT Base Amount" min-width="150px" align="right" header-align="right">
                <template slot-scope="scope">
                    {{ scope.row.wht_base_amount | formatNumber }}
                </template>
            </el-table-column>
            <el-table-column prop="wht_amount" label="WHT Amount" min-width="120px" align="right" header-align="right">
                <template slot-scope="scope">
                    {{ scope.row.wht_amount | formatNumber }}
                </template>
            </el-table-column>
            <el-table-column prop="total" label="Total" min-width="120px" align="right" header-align="right">
                <template slot-scope="scope">
                    {{ scope.row.total | formatNumber }}
                </template>
            </el-table-column>
            <el-table-column label="Invoice Doc" min-width="120px">
                <template>
                    <el-button size="mini" type="primary" plain icon="el-icon-zoom-in">Show File</el-button>
                </template>
            </el-table-column>
            <el-table-column label="Faktur Doc" min-width="120px">
                 <template>
                    <el-button size="mini" type="primary" plain icon="el-icon-zoom-in">Show File</el-button>
                </template>
            </el-table-column>
            <el-table-column label="BAST Doc" min-width="120px">
                 <template>
                    <el-button size="mini" type="primary" plain icon="el-icon-zoom-in">Show File</el-button>
                </template>
            </el-table-column>
            <el-table-column label="Other Doc" min-width="120px">
                 <template>
                    <el-button size="mini" type="primary" plain icon="el-icon-zoom-in">Show File</el-button>
                </template>
            </el-table-column>

            <el-table-column fixed="right" label="Status" min-width="120px">
                 <template>
                    <el-tag type="success">Approved</el-tag>
                </template>
            </el-table-column>

            <el-table-column fixed="right"  width="40px">
                <template slot-scope="scope">
                    <el-dropdown>
                        <span class="el-dropdown-link">
                            <i class="el-icon-more"></i>
                        </span>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item @click.native.prevent="()=> { selectedData = scope.row; showDetail = true; }"><i class="el-icon-zoom-in"></i> Show Detail</el-dropdown-item>
                            <el-dropdown-item @click.native.prevent="reviewForm = true"><i class="el-icon-chat-line-square"></i> Add Review</el-dropdown-item>
                            <el-dropdown-item v-if="$store.state.user.role == 31" @click.native.prevent="() => { showForm = true; formModel = scope.row; }"><i class="el-icon-edit-outline"></i> Edit</el-dropdown-item>
                            <el-dropdown-item v-if="$store.state.user.role == 31" @click.native.prevent="deleteData(scope.row.id)"><i class="el-icon-delete"></i> Delete</el-dropdown-item>
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

        <el-dialog :visible="reviewForm" title="REVIEW INVOICE SUBMISSION">
            <el-form label-width="70px" label-position="left">
                <el-form-item label="Type">
                    <el-select placeholder="type" style="width:100%" v-model="formModel.type">
                        <el-option v-for="(t, i) in ['User Checking', 'Tax Checking', 'Treasury Checking']" :label="t" :value="t" :key="i"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="Note">
                    <el-input v-model="formModel.note" placeholder="Note" rows="5" type="textarea"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer">
                <el-button type="primary" @click="reviewForm = false">SUBMIT</el-button>
                <el-button type="info" @click="reviewForm = false">CANCEL</el-button>
            </div>
        </el-dialog>

        <InvoiceSubmissionForm
        :data="formModel"
        :visible.sync="showForm"
        @saved="requestData"
        @close-form="() => { showForm = false; formModel = { items: [] }; }" />
    </div>
</template>

<script>
import InvoiceSubmissionForm from './InvoiceSubmissionForm'

export default {
    components: { InvoiceSubmissionForm },
    data() {
        return {
            page: 1,
            pageSize: 10,
            reviewForm: false,
            formModel: {},
            tableData: {},
            keyword: '',
            showForm: false,
            sort: 'created_at',
            order: 'descending',
            loading: false,
            selectedData: {},
            showDetail: false
        }
    },
    methods: {
        sortChange(c) {
            if (c.prop != this.sort || c.order != this.order) {
                this.sort = c.prop; this.order = c.order; this.requestData()
            }
        },
        requestData() {
            let params = {
                page: this.page,
                keyword: this.keyword,
                pageSize: this.pageSize,
                sort: this.sort,
                order: this.order,
                vendor_id: this.$store.state.user.vendor_id
            }

            this.loading = true;
            axios.get('/invoiceSubmission', { params: params }).then(r => {
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
        },
        deleteData(id) {
            this.$confirm('Anda yakin akan menghapus data ini?', 'Warning', { type: 'warning' }).then(() => {
                axios.delete('/invoiceSubmission/' + id).then(r => {
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
        }
    },
    mounted() {
        this.requestData()
    }

}
</script>

<style lang="scss" scoped>

</style>
