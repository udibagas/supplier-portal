<template>
    <el-dialog custom-class="fullscreen-body" center fullscreen title="INVOICE FORM" width="95%" :visible.sync="visible" :show-close="false" :close-on-click-modal="false" :close-on-press-escape="false">
        <el-form label-position="left" label-width="140px">
            <el-row :gutter="30">
                <el-col :span="8">
                    <el-form-item label="Invoice Date" :class="formErrors.invoice_date ? 'is-error' : ''">
                        <el-date-picker value-format="yyyy-MM-dd" format="dd-MMM-yyyy" placeholder="Invoice Date" v-model="formModel.invoice_date" style="width:100%"></el-date-picker>
                        <div class="el-form-item__error" v-if="formErrors.invoice_date">{{formErrors.invoice_date[0]}}</div>
                    </el-form-item>
                    <el-form-item label="Invoice Number" :class="formErrors.invoice_number ? 'is-error' : ''">
                        <el-input placeholder="Invoice Number" v-model="formModel.invoice_number"></el-input>
                        <div class="el-form-item__error" v-if="formErrors.invoice_number">{{formErrors.invoice_number[0]}}</div>
                    </el-form-item>
                    <el-form-item label="Faktur Date" :class="formErrors.faktur_date ? 'is-error' : ''">
                        <el-date-picker value-format="yyyy-MM-dd" format="dd-MMM-yyyy" placeholder="Faktur Date" v-model="formModel.faktur_date" style="width:100%"></el-date-picker>
                        <div class="el-form-item__error" v-if="formErrors.faktur_date">{{formErrors.faktur_date[0]}}</div>
                    </el-form-item>
                    <el-form-item label="Faktur Number" :class="formErrors.faktur_number ? 'is-error' : ''">
                        <el-input placeholder="Faktur Number" v-model="formModel.faktur_number"></el-input>
                        <div class="el-form-item__error" v-if="formErrors.faktur_number">{{formErrors.faktur_number[0]}}</div>
                    </el-form-item>
                    <el-form-item label="Currency" :class="formErrors.currency ? 'is-error' : ''">
                        <el-select placeholder="Currency" v-model="formModel.currency" style="width:100%">
                            <el-option v-for="(c, i) in ['USD', 'IDR']" :key="i" :value="c" :label="c"></el-option>
                        </el-select>
                        <div class="el-form-item__error" v-if="formErrors.currency">{{formErrors.currency[0]}}</div>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="Term of Payment" :class="formErrors.payment_term_id ? 'is-error' : ''">
                        <el-select style="width:100%" placeholder="Term of Payment" clearable filterable default-first-option v-model="formModel.payment_term_id">
                            <el-option v-for="(top, i) in $store.state.paymentTermList" :key="i" :label="top.description" :value="top.id"></el-option>
                        </el-select>
                        <div class="el-form-item__error" v-if="formErrors.payment_term_id">{{formErrors.payment_term_id[0]}}</div>
                    </el-form-item>
                    <el-form-item label="Baseline Date" :class="formErrors.baseline_date ? 'is-error' : ''">
                        <el-date-picker value-format="yyyy-MM-dd" format="dd-MMM-yyyy" placeholder="Baseline Date" v-model="formModel.baseline_date" style="width:100%"></el-date-picker>
                        <div class="el-form-item__error" v-if="formErrors.baseline_date">{{formErrors.baseline_date[0]}}</div>
                    </el-form-item>
                    <el-form-item label="Due Date" :class="formErrors.due_date ? 'is-error' : ''">
                        <el-date-picker readonly value-format="yyyy-MM-dd" format="dd-MMM-yyyy" placeholder="Due Date" v-model="due_date" style="width:100%"></el-date-picker>
                        <div class="el-form-item__error" v-if="formErrors.due_date">{{formErrors.due_date[0]}}</div>
                    </el-form-item>
                    <el-form-item label="WHT Type" :class="formErrors.wht_type_id ? 'is-error' : ''">
                        <el-select style="width:100%" placeholder="WHT Type" clearable filterable default-first-option v-model="formModel.wht_type_id">
                            <el-option v-for="(wht, i) in $store.state.whtTypeList" :key="i" :label="wht.VCH_description" :value="wht.VCH_whtType"></el-option>
                        </el-select>
                        <div class="el-form-item__error" v-if="formErrors.wht_type_id">{{formErrors.wht_type_id[0]}}</div>
                    </el-form-item>
                    <el-form-item label="WHT Code" :class="formErrors.wht_code_id ? 'is-error' : ''">
                        <el-select style="width:100%" placeholder="WHT Code" clearable filterable default-first-option v-model="formModel.wht_code_id">
                            <el-option v-for="(wht, i) in $store.state.whtCodeList.filter(c => c.VCH_WHTType == formModel.wht_type_id)" :key="i" :label="wht.VCH_Description" :value="wht.id"></el-option>
                        </el-select>
                        <div class="el-form-item__error" v-if="formErrors.wht_code_id">{{formErrors.wht_code_id[0]}}</div>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="Total Item">
                        <el-input readonly placeholder="Total Item" v-model="total_item"></el-input>
                    </el-form-item>
                    <el-form-item label="WHT Base Amount">
                        <el-input readonly placeholder="WHT Base Amount" v-model="wht_base_amount"></el-input>
                    </el-form-item>
                    <el-form-item label="WHT Amount">
                        <el-input readonly placeholder="WHT Amount" v-model="wht_amount"></el-input>
                    </el-form-item>
                    <el-form-item label="Tax (PPN 10%)">
                        <el-input readonly placeholder="Tax (PPN 10%)" v-model="ppn_amount"></el-input>
                    </el-form-item>
                    <el-form-item label="Grand Total">
                        <el-input readonly placeholder="Total" v-model="total_invoice"></el-input>
                    </el-form-item>
                </el-col>
                <!-- <el-col :span="6">
                    <el-form-item v-for="(t, i) in ['Invoice Doc', 'Faktur Doc', 'BAST Doc', 'Other Doc']"  :key="i"
                    :label="t">
                        <el-upload :action="baseUrl + '/invoiceSubmissionAttachment/uploadFile?type=' + t"
                        :headers="{'Authorization': 'bearer ' + $store.state.token, 'Accept': 'application/json, text/plain, */*'}"
                        :on-success="handleSuccess"
                        :on-error="handleError"
                        :on-remove="removeFile"
                        :limit="1">
                            <el-button size="mini" type="primary" plain icon="el-icon-paperclip">Click to upload</el-button>
                            <div slot="tip" class="el-upload__tip">Allowed  extension : jpg, jpeg, png, bmp, pdf</div>
                        </el-upload>
                        <div class="el-form-item__error" v-if="formErrors.attachment">{{formErrors.attachment[0]}}</div>
                    </el-form-item>
                </el-col> -->
            </el-row>
        </el-form>

        <br>

        <el-tabs type="card">
            <el-tab-pane label="Item">
                <el-table :data="formModel.items" stripe height="calc(100vh - 565px)">
                    <el-table-column fixed="left" prop="po_number" label="PO Number" min-width="110px"></el-table-column>
                    <el-table-column fixed="left" prop="po_date" label="PO Date" min-width="110px"></el-table-column>
                    <el-table-column fixed="left" prop="po_item" label="PO Item" min-width="90px"></el-table-column>
                    <el-table-column fixed="left" prop="description" label="Description" min-width="200px"></el-table-column>
                    <el-table-column prop="text" label="Text" min-width="100px"></el-table-column>
                    <el-table-column prop="qty" label="Qty" align="center" header-align="center" min-width="70px"></el-table-column>
                    <el-table-column prop="uom" label="UoM" align="center" header-align="center" min-width="70px"></el-table-column>
                    <el-table-column prop="currency" label="Currency" min-width="90px" align="center" header-align="center"></el-table-column>
                    <el-table-column prop="price" label="Price" min-width="100px" align="right" header-align="right">
                        <template slot-scope="scope">
                            {{scope.row.price | formatNumber}}
                        </template>
                    </el-table-column>
                    <el-table-column prop="total" label="Total" min-width="100px" align="right" header-align="right">
                        <template slot-scope="scope">
                            {{scope.row.price * scope.row.qty | formatNumber}}
                        </template>
                    </el-table-column>
                    <el-table-column label="PPH" min-width="55px" align="center" header-align="center">
                        <template slot-scope="scope">
                            <el-checkbox v-model="scope.row.pph"></el-checkbox>
                        </template>
                    </el-table-column>
                    <el-table-column label="PPH Amount" min-width="120px" align="right" header-align="right">
                        <template slot-scope="scope">
                            {{scope.row.pph ? flt_rate * scope.row.price * scope.row.qty / 100 : 0 | formatNumber}}
                        </template>
                    </el-table-column>
                    <el-table-column label="PPN" min-width="55px" align="center" header-align="center">
                        <template slot-scope="scope">
                            <el-checkbox v-model="scope.row.ppn"></el-checkbox>
                        </template>
                    </el-table-column>
                    <el-table-column label="PPN Amount" min-width="120px" align="right" header-align="right">
                        <template slot-scope="scope">
                            {{scope.row.ppn ? scope.row.price * scope.row.qty / 10 : 0 | formatNumber}}
                        </template>
                    </el-table-column>
                    <el-table-column fixed="right" width="70px" align="center">
                        <template slot-scope="scope">
                            <el-button @click="formModel.items.splice(scope.$index, 1)" type="danger" icon="el-icon-delete" size="mini" plain></el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </el-tab-pane>
            <el-tab-pane label="Document Attachment">
                <el-form inline>
                    <el-form-item>
                        <el-select placeholder="Document  Type" v-model="formModel.name">
                            <el-option
                            v-for="(t, i) in ['Invoice Doc', 'Faktur Doc', 'BAST Doc', 'Other Doc']"
                            :key="i" :label="t" :value="t">
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item>
                        <el-upload :action="baseUrl + '/invoiceSubmissionAttachment/uploadFile'"
                        :headers="{'Authorization': 'bearer ' + $store.state.token, 'Accept': 'application/json, text/plain, */*'}"
                        :on-success="handleSuccess"
                        :on-error="handleError"
                        :on-remove="removeFile"
                        :limit="1">
                            <el-button type="primary" plain icon="el-icon-paperclip">Click to upload (only pdf file allowed)</el-button>
                            <!-- <div slot="tip" class="el-upload__tip">Allowed  extension : jpg, jpeg, png, bmp, pdf</div> -->
                        </el-upload>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" icon="el-icon-success">SAVE</el-button>
                    </el-form-item>
                </el-form>

                <el-table :data="attachments" stripe>
                    <el-table-column prop="name" label="Name"></el-table-column>
                    <el-table-column prop="file_path" label="File Path">
                        <template slot-scope="scope">
                            <el-button @click="showFile(scope.row)" type="primary" size="mini" plain icon="el-icon-zoom-in">View File</el-button>
                        </template>
                    </el-table-column>
                    <el-table-column width="70px">
                        <template slot-scope="scope">
                            <el-button @click="showFile(scope.row)" type="danger" size="mini" plain icon="el-icon-delete"></el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </el-tab-pane>
        </el-tabs>

        <span slot="footer" class="dialog-footer">
            <el-button type="primary" plain icon="el-icon-success" @click="() => !!formModel.id ? update(0) : store(0)">SAVE AS DRAFT</el-button>
            <el-button type="primary" icon="el-icon-success" @click="() => !!formModel.id ? update(1) : store(1)">SUBMIT</el-button>
            <el-button type="info" @click="() => { $emit('close-form'); formErrors = {}; }" icon="el-icon-error">CANCEL</el-button>
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ['visible', 'data'],
    data() {
        return {
            baseUrl: BASE_URL,
            formErrors: {},
            loading: false,
            attachments: [{name: 'aaa', file_path: 'aaa'}]
        }
    },
    computed: {
        formModel() {
            return this.data
        },
        flt_rate() {
            try {
                return this.$store.state.whtCodeList.find(c => c.id == this.formModel.wht_code_id).FLT_Rate
            } catch (error) {
                return 0
            }
        },
        wht_base_amount() {
            try {
                return this.formModel.items.filter(i => !!i.pph).reduce((t, c) => { return (c.price * c.qty) + t } , 0)
            } catch (error) {
                return 0
            }
        },
        wht_amount() {
            try {
                return this.formModel.items.filter(i => !!i.pph).reduce((t, c) => { return (c.price * c.qty * this.flt_rate / 100) + t } , 0)
            } catch (error) {
                return 0
            }
        },
        ppn_amount() {
            try {
                return this.formModel.items.filter(i => !!i.ppn).reduce((t, c) => { return (c.price * c.qty / 10) + t } , 0)
            } catch (error) {
                return 0
            }
        },
        due_date() {
            try {
                let days = this.$store.state.paymentTermList.find(t => t.id == this.formModel.payment_term_id).days
                return moment(this.formModel.baseline_date, 'YYYY-MM-DD').add(days, 'days').format('YYYY-MM-DD');
            } catch (error) {
                return ''
            }
        },
        total_item() {
            try {
                return this.formModel.items.reduce((t, c) => { return c.price * c.qty + t }, 0)
            } catch (error) {
                return 0;
            }
        },
        total_invoice() {
            return this.total_item - this.wht_amount + this.ppn_amount;
        }
    },
    methods: {
        showFile(data) {

        },
        handleSuccess(response, file, fileList) {
            this.$message({
                message: response.message,
                type: 'success',
                showClose: true
            })

            this.attachments.push({
                file_path: response.file_path,
                name: response.type
            })
        },
        handleError(err, file, fileList) {
            this.$message({
                message: JSON.parse(err.message).message,
                type: 'error',
                showClose: true
            })
        },
        removeFile(file, fileList) {
            // console.log(file.response.file)
            let params = { file_path: file.response.file }
            axios.delete('/invoiceSubmissionAttachment/deleteFile', { params: params }).then(r => {
                // TODO: delete attachment
                // this.attachments.splice(index, 1);
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
        store(status) {
            this.loading = true;
            this.formModel.status = status
            this.formModel.due_date = this.due_date
            this.formModel.wht_base_amount = this.wht_base_amount
            this.formModel.wht_amount = this.wht_amount
            this.formModel.ppn_amount = this.ppn_amount
            this.formModel.total = this.total_invoice
            this.formModel.attachments = this.attachments

            this.formModel.items = this.formModel.items.map(i => {
                i.total = i.price * i.qty;
                i.pph_amount = this.flt_rate * i.total / 100
                return i;
            })

            axios.post('/invoiceSubmission', this.formModel).then(r => {
                this.$emit('close-form')
                this.$message({
                    message: 'Data berhasil disimpan.',
                    type: 'success',
                    showClose: true
                });
                this.$router.push('invoice-submission');
            }).catch(e => {
                if (e.response.status == 422) {
                    this.formErrors = e.response.data.errors;
                }

                if (e.response.status == 500) {
                    this.formErrors = {}
                    this.$message({
                        message: e.response.data.message,
                        type: 'error',
                        showClose: true
                    });
                }
            }).finally(() => {
                this.loading = false
            })
        },
        update(status) {
            this.loading = true;
            this.formModel.status = status
            this.formModel.due_date = this.due_date
            this.formModel.wht_base_amount = this.wht_base_amount
            this.formModel.wht_amount = this.wht_amount
            this.formModel.ppn_amount = this.ppn_amount
            this.formModel.total = this.total_invoice
            this.formModel.attachments = this.attachments

            this.formModel.items = this.formModel.items.map(i => {
                i.total = i.price * i.qty;
                i.pph_amount = this.flt_rate * i.total / 100
                return i;
            })

            axios.put('/invoiceSubmission/' + this.formModel.id, this.formModel).then(r => {
                this.$emit('close-form')
                this.$emit('saved')
                this.$message({
                    message: 'Data berhasil disimpan.',
                    type: 'success',
                    showClose: true
                });
            }).catch(e => {
                if (e.response.status == 422) {
                    this.formErrors = e.response.data.errors;
                }

                if (e.response.status == 500) {
                    this.formErrors = {}
                    this.$message({
                        message: e.response.data.message,
                        type: 'error',
                        showClose: true
                    });
                }
            }).finally(() => {
                this.loading = false
            })
        },
    },
    mounted() {
        this.$store.commit('getWhtTypeList')
        this.$store.commit('getWhtCodeList')
        this.$store.commit('getPaymentTermList')
    }

}
</script>

<style lang="scss" scoped>

</style>
