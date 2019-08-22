<template>
    <div>
        <el-page-header @back="$emit('goBack')" content="VENDOR MANAGEMENT"> </el-page-header>
        <el-divider></el-divider>
        <el-tabs type="card">
            <el-tab-pane label="Vendor List">
                <el-form :inline="true" style="text-align:right" @submit.native.prevent="() => { return }">
                    <el-form-item style="margin-right:0;">
                        <el-input v-model="keyword" placeholder="Search" prefix-icon="el-icon-search" :clearable="true" @change="(v) => { keyword = v; requestData(); }">
                            <el-button @click="() => { page = 1; keyword = ''; requestData(); }" slot="append" icon="el-icon-refresh"></el-button>
                        </el-input>
                    </el-form-item>
                </el-form>
                <el-table :data="tableData.data" stripe
                @row-dblclick="(row, column, event) => { selectedData = row; showDetailDialog = true }"
                :default-sort = "{prop: sort, order: order}"
                height="calc(100vh - 345px)"
                v-loading="loading"
                @sort-change="sortChange">
                    <el-table-column fixed="left" prop="name" label="Name" sortable="custom" show-overflow-tooltip min-width="150px">
                        <template slot-scope="scope">
                            {{scope.row.business_entity_form}} {{scope.row.name}}
                        </template>
                    </el-table-column>
                    <el-table-column prop="establish_date" label="Establish Date" sortable="custom" show-overflow-tooltip min-width="200px"></el-table-column>
                    <el-table-column prop="npwp" label="NPWP" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
                    <el-table-column prop="account_group.name" label="Account Group" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
                    <el-table-column prop="company_status" label="Company Status" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
                    <el-table-column prop="partnership_type.name" label="Partnership Type" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
                    <el-table-column prop="industry_type" label="Industry Type" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
                    <el-table-column prop="product_type" label="Product Type" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
                    <el-table-column prop="address" label="Address" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
                    <el-table-column prop="postcode" label="Postcode" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
                    <el-table-column prop="phone" label="Phone" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
                    <el-table-column prop="fax" label="Fax" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
                    <el-table-column prop="email" label="Email" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
                    <el-table-column prop="website" label="Website" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
                    <el-table-column prop="contact_person_name" label="Contact Person Name" sortable="custom" show-overflow-tooltip min-width="190px"></el-table-column>
                    <el-table-column prop="contact_person_phone" label="Contact Person Phone" sortable="custom" show-overflow-tooltip min-width="190px"></el-table-column>
                    <el-table-column prop="contact_person_email" label="Contact Person Email" sortable="custom" show-overflow-tooltip min-width="190px"></el-table-column>
                    <el-table-column fixed="right" prop="verification_status" align="center" header-align="center" label="Status" sortable="custom" show-overflow-tooltip min-width="150px">
                        <template slot-scope="scope">
                            <el-tag size="mini" :type="scope.row.verification_status ? 'success' : 'info'">{{scope.row.verification_status ? 'Approved' : 'Unapproved'}}</el-tag>
                        </template>
                    </el-table-column>

                    <el-table-column fixed="right" width="40px">
                        <template slot-scope="scope">
                            <el-dropdown>
                                <span class="el-dropdown-link">
                                    <i class="el-icon-more"></i>
                                </span>
                                <el-dropdown-menu slot="dropdown">
                                    <el-dropdown-item @click.native.prevent="() => { selectedData = scope.row; showDetailDialog = true }"><i class="el-icon-zoom-in"></i> Show Detail</el-dropdown-item>
                                    <el-dropdown-item @click.native.prevent="() => { selectedData = scope.row; showReviewForm = true; }"><i class="el-icon-chat-line-square"></i> Create Review</el-dropdown-item>
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

            </el-tab-pane>
            <el-tab-pane label="Vendor Invitation">
                <VendorInvitation />
            </el-tab-pane>
        </el-tabs>

        <el-dialog center top="60px" width="90%" title="DETAIL VENDOR" :visible.sync="showDetailDialog">
            <VendorDetail v-if="!!selectedData" :data="selectedData" />
        </el-dialog>

        <el-dialog center top="60px" width="600px" :visible.sync="showReviewForm" title="VENDOR REVIEW">
            <el-form label-width="100px">
                <el-form-item label="Vendor">
                    <el-input :value="selectedData.business_entity_form + ' ' + selectedData.name" readonly></el-input>
                </el-form-item>
                <el-form-item label="Note" :class="formErrors.note ? 'is-error' : ''">
                    <el-input type="textarea" rows="5" placeholder="Note" v-model="formModelReview.note"></el-input>
                    <div class="el-form-item__error" v-if="formErrors.note">{{formErrors.note[0]}}</div>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button type="primary" @click="submitReview(1)"><i class="el-icon-success"></i> APPROVED</el-button>
                <el-button type="danger" @click="submitReview(0)"><i class="el-icon-error"></i> REJECT</el-button>
                <el-button type="info" @click="showReviewForm = false"><i class="el-icon-error"></i> CANCEL</el-button>
            </span>
        </el-dialog>

    </div>
</template>

<script>
import VendorInvitation from './VendorInvitation'
import VendorDetail from '../components/VendorDetail'
import VendorReview from '../components/VendorReview'

export default {
    components: { VendorInvitation, VendorDetail, VendorReview },
    data() {
        return {
            showForm: false,
            formErrors: {},
            error: {},
            formModel: {},
            keyword: '',
            page: 1,
            pageSize: 10,
            tableData: {},
            sort: 'name',
            order: 'ascending',
            loading: false,
            showReviewForm: false,
            selectedData: {},
            showDetailDialog: false,
            showReviewForm: false,
            formModelReview: {}
        }
    },
    methods: {
        sortChange(c) {
            if (c.prop != this.sort || c.order != this.order) {
                this.sort = c.prop; this.order = c.order; this.requestData()
            }
        },
        submitReview(verification_status) {
            this.formModelReview.vendor_id = this.selectedData.id
            this.formModelReview.status = 1;
            this.formModelReview.verification_status = verification_status
            axios.post('/vendorRegistrationReview/', this.formModelReview).then(r => {
                this.$message({
                    message: 'Data berhasil disimpan.',
                    type: 'success',
                    showClose: true
                });
                this.requestData()
                this.showReviewForm = false
                this.formModelReview = {}
                this.formErrors = {}
            }).catch(e => {
                if (e.response.status == 422) {
                    this.error = {}
                    this.formErrors = e.response.data.errors;
                }

                if (e.response.status == 500) {
                    this.formErrors = {}
                    this.$message({
                        message: 'Data gagal disimpan. ' + e.response.data.message,
                        type: 'error',
                        showClose: true
                    });
                }
            })
        },
        // openForm(data) {
        //     this.error = {}
        //     this.formErrors = {}
        //     this.formModel = JSON.parse(JSON.stringify(data));
        //     this.showForm = true
        // },
        // store() {
        //     this.loading = true;
        //     axios.post('/vendor', this.formModel).then(r => {
        //         this.showForm = false;
        //         this.$message({
        //             message: 'Data berhasil disimpan.',
        //             type: 'success',
        //             showClose: true
        //         });
        //         this.requestData();
        //     }).catch(e => {
        //         if (e.response.status == 422) {
        //             this.error = {}
        //             this.formErrors = e.response.data.errors;
        //         }

        //         if (e.response.status == 500) {
        //             this.formErrors = {}
        //             this.error = e.response.data;
        //         }
        //     }).finally(() => {
        //         this.loading = false
        //     })
        // },
        // update() {
        //     this.loading = true;
        //     axios.put('/vendor/' + this.formModel.id, this.formModel).then(r => {
        //         this.showForm = false
        //         this.$message({
        //             message: 'Data berhasil disimpan.',
        //             type: 'success',
        //             showClose: true
        //         });
        //         this.requestData()
        //     }).catch(e => {
        //         if (e.response.status == 422) {
        //             this.error = {}
        //             this.formErrors = e.response.data.errors;
        //         }

        //         if (e.response.status == 500) {
        //             this.formErrors = {}
        //             this.error = e.response.data;
        //         }
        //     }).finally(() => {
        //         this.loading = false
        //     })
        // },
        deleteData(id) {
            this.$confirm('Anda yakin akan menghapus data ini?', 'Warning', { type: 'warning' }).then(() => {
                axios.delete('/vendor/' + id).then(r => {
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
            axios.get('/vendor', {params: params}).then(r => {
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
        this.$store.commit('getRoleList')
        this.$store.commit('getDepartmentList')
        this.$store.commit('getVendorList')
    }
}
</script>
