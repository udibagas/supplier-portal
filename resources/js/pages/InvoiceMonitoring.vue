<template>
    <div>
        <el-page-header @back="$emit('goBack')" content="INVOICE MONITORING">
        </el-page-header>
        <el-divider></el-divider>
        <el-form :inline="true" style="text-align:right" @submit.native.prevent="() => { return }">
            <el-form-item style="margin-right:0;">
                <el-input v-model="keyword" placeholder="Search" prefix-icon="el-icon-search" :clearable="true" @change="(v) => { keyword = v; requestData(); }">
                    <el-button @click="() => { page = 1; keyword = ''; requestData(); }" slot="append" icon="el-icon-refresh"></el-button>
                </el-input>
            </el-form-item>
        </el-form>

        <el-table :data="tableData.data" stripe
        :default-sort = "{prop: sort, order: order}"
        height="calc(100vh - 345px)"
        v-loading="loading"
        @sort-change="sortChange">
            <el-table-column prop="po_number" label="PO Number" sortable="custom" show-overflow-tooltip min-width="120px"></el-table-column>
            <el-table-column prop="po_date" label="PO Date" sortable="custom" show-overflow-tooltip min-width="120px"></el-table-column>
            <el-table-column prop="vendor" label="Vendor" sortable="custom" show-overflow-tooltip min-width="200px"></el-table-column>
            <el-table-column prop="currency" label="Currency" sortable="custom" show-overflow-tooltip min-width="100px"></el-table-column>
            <el-table-column prop="po_ammount" label="PO Amount" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
            <el-table-column prop="invoice_no" label="Invoice No" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
            <el-table-column prop="faktur_no" label="Faktur No" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
            <el-table-column prop="payment_schedule" label="Payment Schedule" sortable="custom" show-overflow-tooltip min-width="170px"></el-table-column>
            <el-table-column align="center" header-align="center" fixed="right" prop="status" label="Status" sortable="custom" show-overflow-tooltip min-width="150px">
                <template slot-scope="scope">
                    <el-tag type="success" size="mini">{{scope.row.status}}</el-tag>
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
    </div>
</template>

<script>
export default {
    data() {
        return {
            showForm: false,
            formErrors: {},
            error: {},
            formModel: {},
            keyword: '',
            page: 1,
            pageSize: 10,
            tableData: {
                data: [
                    {
                        po_number: '1000001',
                        po_date: '19-Aug-2019',
                        vendor: 'Lamjaya Global Solusi',
                        currency: 'IDR',
                        po_ammount: '4.500.000',
                        invoice_no: 'INV/2019/08/01',
                        faktur_no: '9999',
                        payment_schedule: '31-Aug-2019',
                        status: 'User Checking'
                    },
                    {
                        po_number: '1000002',
                        po_date: '21-Aug-2019',
                        vendor: 'Abadi Jaya',
                        currency: 'IDR',
                        po_ammount: '1.200.000',
                        invoice_no: 'INV/2019/07/20',
                        faktur_no: '5555',
                        payment_schedule: '31-Aug-2019',
                        status: 'Tax Checking'
                    },
                    {
                        po_number: '1000003',
                        po_date: '11-Aug-2019',
                        vendor: 'Graha Menara',
                        currency: 'IDR',
                        po_ammount: '3.700.000',
                        invoice_no: 'INV/2019/06/02',
                        faktur_no: '4444',
                        payment_schedule: '31-Aug-2019',
                        status: 'Treasury Checking'
                    },
                    {
                        po_number: '1000004',
                        po_date: '10-Aug-2019',
                        vendor: 'Duta Global',
                        currency: 'IDR',
                        po_ammount: '3.500.000',
                        invoice_no: 'INV/2019/07/22',
                        faktur_no: '2222',
                        payment_schedule: '31-Aug-2019',
                        status: 'Approved'
                    },
                ]
            },
            sort: 'name',
            order: 'ascending',
            loading: false
        }
    },
    methods: {
        sortChange(c) {
            if (c.prop != this.sort || c.order != this.order) {
                this.sort = c.prop; this.order = c.order; this.requestData()
            }
        },
        openForm(data) {
            this.error = {}
            this.formErrors = {}
            this.formModel = JSON.parse(JSON.stringify(data));
            this.showForm = true
        },
        store() {
            this.loading = true;
            axios.post('/partnershipType', this.formModel).then(r => {
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
        update() {
            this.loading = true;
            axios.put('/partnershipType/' + this.formModel.id, this.formModel).then(r => {
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
                axios.delete('/partnershipType/' + id).then(r => {
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
            axios.get('/partnershipType', {params: params}).then(r => {
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
        // this.requestData();
    }
}
</script>
