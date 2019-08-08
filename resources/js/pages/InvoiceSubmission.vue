<template>
    <div>
        <el-page-header @back="$emit('goBack')" content="PURCHASE ORDER">
        </el-page-header>
        <el-divider></el-divider>

        <el-form :inline="true" style="text-align:right" @submit.native.prevent="() => { return }">
            <el-form-item>
                <el-button icon="el-icon-plus" @click="openForm({})" type="primary">CREATE INVOICE SUBMISSION</el-button>
            </el-form-item>
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
            <el-table-column fixed="left" type="expand"></el-table-column>
            <el-table-column fixed="left" prop="po_number" label="PO Number" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
            <el-table-column prop="po_date" label="PO Date" sortable="custom" show-overflow-tooltip min-width="200px"></el-table-column>
            <el-table-column prop="currency" label="Currency" sortable="custom" show-overflow-tooltip min-width="100px"></el-table-column>
            <el-table-column prop="po_item" label="PO Item" sortable="custom" show-overflow-tooltip min-width="100px"></el-table-column>
            <el-table-column prop="description" label="Description" sortable="custom" show-overflow-tooltip min-width="100px"></el-table-column>
            <el-table-column prop="qty" label="Qty" sortable="custom" show-overflow-tooltip min-width="100px"></el-table-column>
            <el-table-column prop="uom" label="UoM" sortable="custom" show-overflow-tooltip min-width="100px"></el-table-column>
            <el-table-column prop="price" label="Price" sortable="custom" show-overflow-tooltip min-width="100px"></el-table-column>
            <el-table-column prop="total" label="Total" sortable="custom" show-overflow-tooltip min-width="100px"></el-table-column>
            <el-table-column prop="text" label="Text" sortable="custom" show-overflow-tooltip min-width="100px"></el-table-column>
            <el-table-column prop="delivery_date" label="Delivery Date" sortable="custom" show-overflow-tooltip min-width="100px"></el-table-column>
            <el-table-column prop="gr_status" label="GR Status" sortable="custom" show-overflow-tooltip min-width="100px"></el-table-column>

            <el-table-column fixed="right" width="40px">
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
            page: 1,
            pageSize: 10,
            tableData: {
                data: []
            },
            keyword: '',
            openForm: false
        }
    },
    methods: {
        requestData() {

        }
    }

}
</script>

<style lang="scss" scoped>

</style>
