<template>
    <div>
        <el-page-header @back="$emit('goBack')" content="INVOICE SUBMISSION">
        </el-page-header>
        <el-divider></el-divider>

        <el-form :inline="true" style="text-align:right" @submit.native.prevent="() => { return }">
            <el-form-item style="margin-right:0;">
                <el-input v-model="keyword" placeholder="Search" prefix-icon="el-icon-search" :clearable="true" @change="(v) => { keyword = v; requestData(); }">
                    <el-button @click="() => { page = 1; keyword = ''; requestData(); }" slot="append" icon="el-icon-refresh"></el-button>
                </el-input>
            </el-form-item>
        </el-form>

        <el-table stripe height="calc(100vh - 345px)" :data="submission">
            <el-table-column prop="vendor" label="Vendor" show-overflow-tooltip min-width="150px"></el-table-column>
            <el-table-column prop="invoice_no" label="Invoice No" min-width="150px"></el-table-column>
            <el-table-column prop="invoice_date" label="Invoice Date" min-width="150px"></el-table-column>
            <el-table-column prop="faktur_no" bel="Faktur No" min-width="150px"></el-table-column>
            <el-table-column prop="faktur_date" label="Faktur Date" min-width="150px"></el-table-column>
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
                            <!-- <el-dropdown-item @click.native.prevent="openForm(scope.row)"><i class="el-icon-edit-outline"></i> Edit</el-dropdown-item> -->
                            <el-dropdown-item @click.native.prevent="reviewForm = true"><i class="el-icon-edit-outline"></i> Add Review</el-dropdown-item>
                            <el-dropdown-item @click.native.prevent="deleteData(scope.row.id)"><i class="el-icon-delete"></i> Delete</el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>
                </template>
            </el-table-column>
        </el-table>

        <!-- <el-table :data="tableData.data" stripe
        :default-sort = "{prop: sort, order: order}"
        height="calc(100vh - 345px)"
        v-loading="loading"
        @sort-change="sortChange">
            <el-table-column fixed="left" type="expand"></el-table-column>
            <el-table-column fixed="left" prop="po_number" label="PO Number" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
            <el-table-column prop="po_date" label="PO Date" sortable="custom" show-overflow-tooltip min-width="200px"></el-table-column>
            <el-table-column prop="currency" label="Currency" sortable="custom" show-overflow-tooltip min-width="180px"></el-table-column>
            <el-table-column prop="po_item" label="PO Item" sortable="custom" show-overflow-tooltip min-width="180px"></el-table-column>
            <el-table-column prop="description" label="Description" sortable="custom" show-overflow-tooltip min-width="180px"></el-table-column>
            <el-table-column prop="qty" label="Qty" sortable="custom" show-overflow-tooltip min-width="180px"></el-table-column>
            <el-table-column prop="uom" label="UoM" sortable="custom" show-overflow-tooltip min-width="180px"></el-table-column>
            <el-table-column prop="price" label="Price" sortable="custom" show-overflow-tooltip min-width="180px"></el-table-column>
            <el-table-column prop="total" label="Total" sortable="custom" show-overflow-tooltip min-width="180px"></el-table-column>
            <el-table-column prop="text" label="Text" sortable="custom" show-overflow-tooltip min-width="180px"></el-table-column>
            <el-table-column prop="delivery_date" label="Delivery Date" sortable="custom" show-overflow-tooltip min-width="180px"></el-table-column>
            <el-table-column prop="gr_status" label="GR Status" sortable="custom" show-overflow-tooltip min-width="180px"></el-table-column>

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
        </el-table> -->

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
                        <el-option v-for="(t, i) in ['Document', 'Tax', 'Treasury']" :label="t" :value="t" :key="i"></el-option>
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
    </div>
</template>

<script>
export default {
    data() {
        return {
            page: 1,
            pageSize: 10,
            reviewForm: false,
            formModel: {},
            submission: [
                {
                    vendor: 'PT Lamjaya Global Solusi',
                    invoice_no: 'INV/2019/08/01',
                    invoice_date: '10-Aug-2019',
                    faktur_no: '12345',
                    faktur_date: '10-Aug-2019'
                },
                {
                    vendor: 'PT Lamjaya Global Solusi',
                    invoice_no: 'INV/2019/08/01',
                    invoice_date: '10-Aug-2019',
                    faktur_no: '12345',
                    faktur_date: '10-Aug-2019'
                },
                {
                    vendor: 'PT Lamjaya Global Solusi',
                    invoice_no: 'INV/2019/08/01',
                    invoice_date: '10-Aug-2019',
                    faktur_no: '12345',
                    faktur_date: '10-Aug-2019'
                },
                {
                    vendor: 'PT Lamjaya Global Solusi',
                    invoice_no: 'INV/2019/08/01',
                    invoice_date: '10-Aug-2019',
                    faktur_no: '12345',
                    faktur_date: '10-Aug-2019'
                },
                {
                    vendor: 'PT Lamjaya Global Solusi',
                    invoice_no: 'INV/2019/08/01',
                    invoice_date: '10-Aug-2019',
                    faktur_no: '12345',
                    faktur_date: '10-Aug-2019'
                },
            ],
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
