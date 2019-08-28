<template>
    <div>
        <el-page-header @back="$emit('goBack')" content="BILLABLE PO">
        </el-page-header>
        <el-divider></el-divider>
        <el-form :inline="true" style="text-align:right" @submit.native.prevent="() => { return }">
            <el-form-item>
                <el-button :disabled="selectedData.length == 0" icon="el-icon-plus" @click="invoiceForm = true" type="primary">SUBMIT INVOICE</el-button>
            </el-form-item>
            <el-form-item style="margin-right:0;">
                <el-input v-model="keyword" placeholder="Search" prefix-icon="el-icon-search" :clearable="true" @change="(v) => { keyword = v; requestData(); }">
                    <el-button @click="() => { page = 1; keyword = ''; requestData(); }" slot="append" icon="el-icon-refresh"></el-button>
                </el-input>
            </el-form-item>
        </el-form>

        <el-table :data="tableData.data" stripe
        :default-sort="{prop: sort, order: order}"
        @selection-change="(val) => { selectedData = val; }"
        height="calc(100vh - 345px)"
        v-loading="loading"
        @sort-change="sortChange">
            <el-table-column type="selection" width="55"> </el-table-column>
            <el-table-column prop="po_number" label="PO Number" sortable="custom" show-overflow-tooltip min-width="120px">
                <!-- <template slot="header">
                    <el-popover placement="bottom" trigger="hover">
                        <el-input v-model="filter.po_number" @change="requestData" size="mini" placeholder="Search PO Number"></el-input>
                        <el-button size="mini" type="text">Confirm</el-button>
                        <el-button size="mini" type="text">Reset</el-button>
                        <el-button slot="reference" type="text">PO Number</el-button>
                    </el-popover>
                </template> -->
            </el-table-column>
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
        </el-table>

        <br>

        <el-dialog center top="60px" title="INVOICE FORM" width="80%" :visible.sync="invoiceForm">
            <el-form label-position="left" label-width="120px">
                <el-row :gutter="50">
                    <el-col :span="12">
                        <el-form-item label="Invoice Date" :class="formErrors.invoice_date ? 'is-error' : ''">
                            <el-date-picker value-format="yyyy-MM-dd" format="dd-MMM-yyyy" placeholder="Invoice Date" v-model="formModel.invoice_date" style="width:100%"></el-date-picker>
                            <div class="el-form-item__error" v-if="formErrors.invoice_date">{{formErrors.invoice_date[0]}}</div>
                        </el-form-item>
                        <el-form-item label="Invoice Number" :class="formErrors.invoice_no ? 'is-error' : ''">
                            <el-input placeholder="Invoice Number" v-model="formModel.invoice_no"></el-input>
                            <div class="el-form-item__error" v-if="formErrors.invoice_no">{{formErrors.invoice_no[0]}}</div>
                        </el-form-item>
                        <el-form-item label="Faktur Date" :class="formErrors.faktur_date ? 'is-error' : ''">
                            <el-date-picker value-format="yyyy-MM-dd" format="dd-MMM-yyyy" placeholder="Faktur Date" v-model="formModel.faktur_date" style="width:100%"></el-date-picker>
                            <div class="el-form-item__error" v-if="formErrors.faktur_date">{{formErrors.faktur_date[0]}}</div>
                        </el-form-item>
                        <el-form-item label="Faktur Number" :class="formErrors.faktur_no ? 'is-error' : ''">
                            <el-input placeholder="Faktur Number" v-model="formModel.faktur_no"></el-input>
                            <div class="el-form-item__error" v-if="formErrors.faktur_no">{{formErrors.faktur_no[0]}}</div>
                        </el-form-item>
                        <el-form-item label="TOP Date" :class="formErrors.top_date ? 'is-error' : ''">
                            <el-input placeholder="TOP Date" v-model="formModel.top_date"></el-input>
                            <div class="el-form-item__error" v-if="formErrors.top_date">{{formErrors.top_date[0]}}</div>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Invoice Doc" :class="formErrors.faktur_no ? 'is-error' : ''">
                            <el-upload action="/invoice/uploadDoc">
                                <el-button plain icon="el-icon-paperclip" type="primary">Attach file</el-button>
                            </el-upload>
                            <div class="el-form-item__error" v-if="formErrors.invoice_doc">{{formErrors.invoice_doc[0]}}</div>
                        </el-form-item>
                        <el-form-item label="Faktur Doc" :class="formErrors.faktur_no ? 'is-error' : ''">
                            <el-upload action="/invoice/uploadDoc">
                                <el-button plain icon="el-icon-paperclip" type="primary">Attach file</el-button>
                            </el-upload>
                            <div class="el-form-item__error" v-if="formErrors.invoice_doc">{{formErrors.invoice_doc[0]}}</div>
                        </el-form-item>
                        <el-form-item label="BAST Doc" :class="formErrors.faktur_no ? 'is-error' : ''">
                            <el-upload action="/invoice/uploadDoc">
                                <el-button plain icon="el-icon-paperclip" type="primary">Attach file</el-button>
                            </el-upload>
                            <div class="el-form-item__error" v-if="formErrors.invoice_doc">{{formErrors.invoice_doc[0]}}</div>
                        </el-form-item>
                        <el-form-item label="Other Doc" :class="formErrors.faktur_no ? 'is-error' : ''">
                            <el-upload action="/invoice/uploadDoc">
                                <el-button plain icon="el-icon-paperclip" type="primary">Attach file</el-button>
                            </el-upload>
                            <div class="el-form-item__error" v-if="formErrors.invoice_doc">{{formErrors.invoice_doc[0]}}</div>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>

            <el-table :data="selectedData" stripe>
                <el-table-column prop="po_number" label="PO Number" show-overflow-tooltip min-width="120px"></el-table-column>
                <el-table-column prop="po_date" label="PO Date" show-overflow-tooltip min-width="120px"></el-table-column>
                <el-table-column prop="currency" label="Currency" show-overflow-tooltip min-width="100px"></el-table-column>
                <el-table-column prop="po_item" label="PO Item" show-overflow-tooltip min-width="100px"></el-table-column>
                <el-table-column prop="description" label="Description" show-overflow-tooltip min-width="200px"></el-table-column>
                <el-table-column prop="qty" label="Qty" show-overflow-tooltip min-width="100px"></el-table-column>
                <el-table-column prop="uom" label="UOM" show-overflow-tooltip min-width="100px"></el-table-column>
                <el-table-column prop="price" label="Price" show-overflow-tooltip min-width="100px"></el-table-column>
                <el-table-column prop="total" label="Total" show-overflow-tooltip min-width="150px"></el-table-column>
                <el-table-column prop="text" label="Text" show-overflow-tooltip min-width="150px"></el-table-column>
                <el-table-column fixed="right" width="70px" align="center">
                    <template slot-scope="scope">
                        <el-button @click="selectedData.splice(scope.$index, 1)" type="danger" icon="el-icon-delete" size="mini" plain></el-button>
                    </template>
                </el-table-column>
            </el-table>

            <span slot="footer" class="dialog-footer">
                <el-button type="primary"><i class="el-icon-success"></i> SUBMIT</el-button>
                <el-button type="info" @click="invoiceForm = false"><i class="el-icon-error"></i> CANCEL</el-button>
            </span>
        </el-dialog>

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
            keyword: '',
            page: 1,
            pageSize: 10,
            invoiceForm: false,
            formErrors: {},
            formModel: {},
            selectedData: [],
            sort: 'po_number',
            order: 'ascending',
            loading: false,
            filter: {},
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
    },
    methods: {
        sortChange(c) {
            if (c.prop != this.sort || c.order != this.order) {
                this.sort = c.prop; this.order = c.order; this.requestData()
            }
        },
        requestData() {
            console.log(this.filter)
        }
    },
    mounted() {
        // this.requestData()
    }
}
</script>

<style lang="scss" scoped>

</style>
