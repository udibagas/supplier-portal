<template>
    <div>
        <el-page-header @back="$emit('goBack')" content="BILLABLE PO">
        </el-page-header>
        <el-divider></el-divider>

        <el-form :inline="true" style="text-align:right" @submit.native.prevent="() => { return }">
            <el-form-item>
                <el-button :disabled="formModel.items.length == 0" icon="el-icon-plus" @click="showForm = true" type="primary">SUBMIT INVOICE</el-button>
            </el-form-item>
            <el-form-item style="margin-right:0;">
                <el-input v-model="keyword" placeholder="Search" prefix-icon="el-icon-search" :clearable="true" @change="(v) => { keyword = v; requestData(); }">
                    <el-button @click="() => { page = 1; keyword = ''; requestData(); }" slot="append" icon="el-icon-refresh"></el-button>
                </el-input>
            </el-form-item>
        </el-form>
        <el-table :data="tableData.data" stripe
        ref="poList"
        :default-sort="{prop: sort, order: order}"
        @selection-change="(val) => { formModel.items = val }"
        height="calc(100vh - 290px)"
        v-loading="loading"
        @sort-change="sortChange">
            <el-table-column type="selection" width="55"> </el-table-column>
            <el-table-column prop="po_number" label="PO Number" sortable="custom" show-overflow-tooltip min-width="120px"></el-table-column>
            <el-table-column prop="po_date" label="PO Date" sortable="custom" show-overflow-tooltip min-width="120px"></el-table-column>
            <el-table-column v-if="$store.state.user.role != 31" prop="vendor" label="Vendor" sortable="custom" show-overflow-tooltip min-width="200px"></el-table-column>
            <el-table-column prop="po_item" label="PO Item" sortable="custom" min-width="95px"></el-table-column>
            <el-table-column prop="description" label="Description" sortable="custom" show-overflow-tooltip min-width="200px"></el-table-column>
            <el-table-column prop="text" label="Text" sortable="custom" show-overflow-tooltip min-width="100px"></el-table-column>
            <el-table-column prop="qty" label="Qty" sortable="custom" show-overflow-tooltip min-width="70px"></el-table-column>
            <el-table-column prop="uom" label="UoM" sortable="custom" show-overflow-tooltip min-width="80px"></el-table-column>
            <el-table-column prop="currency" label="Currency" sortable="custom" show-overflow-tooltip min-width="100px"></el-table-column>
            <el-table-column prop="price" label="Price" sortable="custom" min-width="100px" align="right" header-align="right">
                <template slot-scope="scope">
                    {{scope.row.price | formatNumber}}
                </template>
            </el-table-column>
            <el-table-column prop="total" label="Total" sortable="custom" min-width="100px" align="right" header-align="right">
                <template slot-scope="scope">
                    {{scope.row.price * scope.row.qty | formatNumber}}
                </template>
            </el-table-column>
            <el-table-column prop="delivery_date" label="Delivery Date" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
            <el-table-column fixed="right" prop="gr_status" label="GR Status" sortable="custom" min-width="150px">
                <template slot-scope="scope">
                    <el-tag size="mini" :type="scope.row.gr_status ? 'success' : 'info'">{{scope.row.gr_status ? 'Delivered' : 'Undeliverd'}}</el-tag>
                </template>
            </el-table-column>
            <el-table-column fixed="right" prop="invoice_status" label="Invoice Status" sortable="custom" min-width="150px">
                <template slot-scope="scope">
                    <el-tag size="mini" :type="scope.row.invoice_status ? 'success' : 'info'">{{scope.row.invoice_status ? 'Submitted' : 'Billable'}}</el-tag>
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

        <InvoiceSubmissionForm
        :data="formModel"
        :visible.sync="showForm"
        @close-form="() => { showForm = false; formModel = { items: [] }; $refs.poList.clearSelection(); }" />
    </div>
</template>

<script>
import InvoiceSubmissionForm from './InvoiceSubmissionForm'

export default {
    components: {InvoiceSubmissionForm },
    data() {
        return {
            baseUrl: BASE_URL,
            keyword: '',
            page: 1,
            pageSize: 10,
            showForm: false,
            formModel: { items: [] },
            sort: 'po_number',
            order: 'ascending',
            loading: false,
            tableData: { }
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
            axios.get('/purchaseOrderVendor', {params: params}).then(r => {
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
        this.requestData()
    }
}
</script>

<style lang="scss" scoped>

</style>
