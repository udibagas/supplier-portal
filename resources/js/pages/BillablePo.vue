<template>
    <div>
        <el-page-header @back="$emit('goBack')" content="BILLABLE PO">
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
            <el-table-column prop="po_item" label="PO Item" sortable="custom" show-overflow-tooltip min-width="100px"></el-table-column>
            <el-table-column prop="description" label="Description" sortable="custom" show-overflow-tooltip min-width="200px"></el-table-column>
            <el-table-column prop="qty" label="Qty" sortable="custom" show-overflow-tooltip min-width="100px"></el-table-column>
            <el-table-column prop="uom" label="UOM" sortable="custom" show-overflow-tooltip min-width="100px"></el-table-column>
            <el-table-column prop="price" label="Price" sortable="custom" show-overflow-tooltip min-width="100px"></el-table-column>
            <el-table-column prop="total" label="Total" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
            <el-table-column prop="text" label="Text" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
            <el-table-column prop="delivery_date" label="Delivery Date" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
            <el-table-column fixed="right" prop="gr_status" label="GR Status" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
            <el-table-column fixed="right" min-width="150px">
                <template slot-scope="scope">
                    <el-button type="primary" plain size="small" icon="el-icon-edit">Submit Invoice</el-button>
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
            invoiceForm: false,
            tableData: {
                data: [
                    {
                        po_number: '1000001',
                        po_date: '19-Aug-2019',
                        vendor: 'Lamjaya Global Solusi',
                        currency: 'IDR',
                        po_item: '10',
                    },
                    {
                        po_number: '1000002',
                        po_date: '21-Aug-2019',
                        vendor: 'Abadi Jaya',
                        currency: 'IDR',
                        po_item: '10',
                    },
                    {
                        po_number: '1000003',
                        po_date: '11-Aug-2019',
                        vendor: 'Graha Menara',
                        currency: 'IDR',
                        po_item: '10',
                    },
                    {
                        po_number: '1000004',
                        po_date: '10-Aug-2019',
                        vendor: 'Duta Global',
                        currency: 'IDR',
                        po_item: '10',
                    },
                ]
            },
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
