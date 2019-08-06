<template>
    <div>
        <el-page-header @back="$emit('goBack')" content="VENDOR INVITATION">
        </el-page-header>
        <el-divider></el-divider>
        <el-form :inline="true" style="text-align:right" @submit.native.prevent="() => { return }">
            <el-form-item>
                <el-button icon="el-icon-message" @click="openForm({role: 0, password: ''})" type="primary">INVITE VENDOR</el-button>
            </el-form-item>
            <el-form-item style="margin-right:0;">
                <el-input v-model="keyword" placeholder="Search" prefix-icon="el-icon-search" :clearable="true" @change="(v) => { keyword = v; requestData(); }">
                    <el-button @click="() => { page = 1; keyword = ''; requestData(); }" slot="append" icon="el-icon-refresh"></el-button>
                </el-input>
            </el-form-item>
        </el-form>

        <el-table :data="tableData.data" stripe
        :default-sort = "{prop: sort, order: order}"
        height="calc(100vh - 290px)"
        v-loading="loading"
        @sort-change="sortChange">
            <el-table-column type="expand">
                <template slot-scope="scope">
                    <table>
                    <tbody>
                        <tr><td class="td-label">Invited At</td><td class="td-value">{{scope.row.created_at}}</td></tr>
                        <tr><td class="td-label">Invited By</td><td class="td-value">{{scope.row.user.name}}</td></tr>
                        <tr><td class="td-label">Contact Name</td><td class="td-value">{{scope.row.name}}</td></tr>
                        <tr><td class="td-label">Contact Email</td><td class="td-value">{{scope.row.email}}</td></tr>
                        <tr><td class="td-label">Vendor Name</td><td class="td-value">{{scope.row.company_name}}</td></tr>
                        <tr><td class="td-label">Invitation URL</td><td class="td-value">{{scope.row.invitation_url}}</td></tr>
                        <tr>
                            <td class="td-label">Status</td>
                            <td class="td-value">
                                <el-tag size="mini" :type="scope.row.status ? 'success' : 'info'">{{scope.row.status ? 'Submitted' : 'Draft'}}</el-tag>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </template>
            </el-table-column>
            <el-table-column prop="created_at" label="Invited At" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
            <el-table-column prop="user.name" label="Invited By" show-overflow-tooltip min-width="150px"></el-table-column>
            <el-table-column prop="name" label="Contact Name" sortable="custom" show-overflow-tooltip min-width="200px"></el-table-column>
            <el-table-column prop="email" label="Contact Email" sortable="custom" show-overflow-tooltip min-width="200px"></el-table-column>
            <el-table-column prop="company_name" label="Vendor Name" sortable="custom" show-overflow-tooltip min-width="200px"></el-table-column>
            <el-table-column prop="invitation_url" label="Invitation URL" sortable="custom" show-overflow-tooltip min-width="200px"></el-table-column>
            <el-table-column fixed="right" prop="status" label="Status" sortable="custom" min-width="100px">
                <template slot-scope="scope">
                    <el-tag size="mini" :type="scope.row.status ? 'success' : 'info'">{{scope.row.status ? 'Submitted' : 'Draft'}}</el-tag>
                </template>
            </el-table-column>

            <el-table-column fixed="right" width="40px">
                <template slot-scope="scope">
                    <el-dropdown v-if="scope.row.status == 0">
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

        <el-dialog :visible.sync="showForm" :title="!!formModel.id ? 'EDIT INVITATION' : 'INVITE VENDOR'" v-loading="loading" :close-on-click-modal="false">
            <el-alert type="error" title="ERROR"
                :description="error.message + '\n' + error.file + ':' + error.line"
                v-show="error.message"
                style="margin-bottom:15px;">
            </el-alert>

            <el-form label-width="150px">
                <el-form-item label="Contact Name" :class="formErrors.name ? 'is-error' : ''">
                    <el-input placeholder="Contact Name" v-model="formModel.name"></el-input>
                    <div class="el-form-item__error" v-if="formErrors.name">{{formErrors.name[0]}}</div>
                </el-form-item>

                <el-form-item label="Contact Email" :class="formErrors.email ? 'is-error' : ''">
                    <el-input placeholder="Contact Email" v-model="formModel.email"></el-input>
                    <div class="el-form-item__error" v-if="formErrors.email">{{formErrors.email[0]}}</div>
                </el-form-item>

                <el-form-item label="Vendor Name" :class="formErrors.company_name ? 'is-error' : ''">
                    <el-input placeholder="Vendor Name" v-model="formModel.company_name"></el-input>
                    <div class="el-form-item__error" v-if="formErrors.company_name">{{formErrors.company_name[0]}}</div>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button plain type="primary" @click="() => !!formModel.id ? update(0) : store(0)"><i class="el-icon-success"></i> SAVE AS DRAFT</el-button>
                <el-button type="primary" @click="() => !!formModel.id ? update(1) : store(1)"><i class="el-icon-success"></i> SAVE AND SUBMIT</el-button>
                <el-button type="info" @click="showForm = false"><i class="el-icon-error"></i> CANCEL</el-button>
            </span>
        </el-dialog>
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
            tableData: {},
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
        store(status) {
            this.loading = true;
            this.formModel.status = status;
            axios.post('/vendorInvitation', this.formModel).then(r => {
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
            axios.put('/vendorInvitation/' + this.formModel.id, this.formModel).then(r => {
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
                axios.delete('/vendorInvitation/' + id).then(r => {
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
            axios.get('/vendorInvitation', {params: params}).then(r => {
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
    }
}
</script>

<style scoped>
.td-label {
    min-width: 150px;
    font-weight: bold;
    background-color: #ddd;
    padding: 5px 10px;
}

.td-value {
    background-color: #eee;
    padding: 5px 10px;
}
</style>

