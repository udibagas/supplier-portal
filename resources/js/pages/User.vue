<template>
    <div>
        <el-form :inline="true" style="text-align:right" @submit.native.prevent="() => { return }">
            <el-form-item>
                <el-button icon="el-icon-plus" @click="openForm({password: ''})" type="primary">ADD NEW USER</el-button>
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
            <el-table-column fixed="left" prop="name" label="Name" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
            <el-table-column prop="email" label="Email" sortable="custom" show-overflow-tooltip min-width="200px"></el-table-column>
            <el-table-column prop="phone" label="Phone" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
            <el-table-column prop="role" label="Role" sortable="custom" show-overflow-tooltip min-width="150px">
                <template slot-scope="scope">
                    {{$store.state.roleList[scope.row.role]}}
                </template>
            </el-table-column>
            <el-table-column prop="department" label="Department" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
            <el-table-column prop="vendor" label="Vendor" sortable="custom" show-overflow-tooltip min-width="150px"></el-table-column>
            <el-table-column fixed="right" prop="active" align="center" header-align="center" label="Status" sortable="custom" show-overflow-tooltip min-width="150px">
                <template slot-scope="scope">
                    <el-tag size="mini" :type="scope.row.active ? 'success' : 'info'">{{scope.row.active ? 'Active' : 'Inactive'}}</el-tag>
                </template>
            </el-table-column>

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

        <el-dialog top="60px" :visible.sync="showForm" :title="!!formModel.id ? 'EDIT USER' : 'ADD NEW USER'" width="550px" v-loading="loading" :close-on-click-modal="false">
            <el-alert type="error" title="ERROR"
                :description="error.message + '\n' + error.file + ':' + error.line"
                v-show="error.message"
                style="margin-bottom:15px;">
            </el-alert>

            <el-form label-width="170px">
                <el-form-item label="Name" :class="formErrors.name ? 'is-error' : ''">
                    <el-input placeholder="Name" v-model="formModel.name"></el-input>
                    <div class="el-form-item__error" v-if="formErrors.name">{{formErrors.name[0]}}</div>
                </el-form-item>

                <el-form-item label="Email" :class="formErrors.email ? 'is-error' : ''">
                    <el-input placeholder="Email" v-model="formModel.email"></el-input>
                    <div class="el-form-item__error" v-if="formErrors.email">{{formErrors.email[0]}}</div>
                </el-form-item>

                <el-form-item label="Phone" :class="formErrors.phone ? 'is-error' : ''">
                    <el-input placeholder="Phone" v-model="formModel.phone"></el-input>
                    <div class="el-form-item__error" v-if="formErrors.phone">{{formErrors.phone[0]}}</div>
                </el-form-item>

                <el-form-item label="Role" :class="formErrors.role ? 'is-error' : ''">
                    <el-select v-model="formModel.role" placeholder="Role" style="width:100%">
                        <el-option v-for="(t, i) in $store.state.roleList"
                        :value="parseInt(i)"
                        :label="t"
                        :key="i">
                        </el-option>
                    </el-select>
                    <div class="el-form-item__error" v-if="formErrors.role">{{formErrors.role[0]}}</div>
                </el-form-item>

                <el-form-item v-show="formModel.role == 21" label="Department" :class="formErrors.department_id ? 'is-error' : ''">
                    <el-select clearable v-model="formModel.department_id" placeholder="Department" style="width:100%">
                        <el-option v-for="(t, i) in $store.state.departmentList"
                        :value="t.id"
                        :label="t.name"
                        :key="i">
                        </el-option>
                    </el-select>
                    <div class="el-form-item__error" v-if="formErrors.department_id">{{formErrors.department_id[0]}}</div>
                </el-form-item>

                <el-form-item clearable v-show="formModel.role == 31" label="Vendor" :class="formErrors.vendor_id ? 'is-error' : ''">
                    <el-select v-model="formModel.vendor_id" placeholder="Vendor" style="width:100%">
                        <el-option v-for="(t, i) in $store.state.vendorList"
                        :value="t.id"
                        :label="t.name"
                        :key="i">
                        </el-option>
                    </el-select>
                    <div class="el-form-item__error" v-if="formErrors.vendor_id">{{formErrors.vendor_id[0]}}</div>
                </el-form-item>

                <el-form-item label="Password" :class="formErrors.password ? 'is-error' : ''">
                    <el-input type="password" placeholder="Password" v-model="formModel.password"></el-input>
                    <div class="el-form-item__error" v-if="formErrors.password">{{formErrors.password[0]}}</div>
                </el-form-item>

                <el-form-item label="Password Confirmation" :class="formErrors.password ? 'is-error' : ''">
                    <el-input type="password" placeholder="Password Confirmation" v-model="formModel.password_confirmation"></el-input>
                </el-form-item>

                <el-form-item label="Status" :class="formErrors.active ? 'is-error' : ''">
                    <el-switch
                    :active-value="1"
                    :inactive-value="0"
                    v-model="formModel.active"
                    active-color="#13ce66">
                    </el-switch>
                    <el-tag :type="formModel.active ? 'success' : 'info'" size="small" style="margin-left:10px">{{!!formModel.active ? 'Active' : 'Inactive'}}</el-tag>

                    <div class="el-form-item__error" v-if="formErrors.active">{{formErrors.active[0]}}</div>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button type="primary" @click="() => !!formModel.id ? update() : store()"><i class="el-icon-success"></i> SAVE</el-button>
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
        store() {
            this.loading = true;
            axios.post('/user', this.formModel).then(r => {
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
            axios.put('/user/' + this.formModel.id, this.formModel).then(r => {
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
                axios.delete('/user/' + id).then(r => {
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
            axios.get('/user', {params: params}).then(r => {
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
