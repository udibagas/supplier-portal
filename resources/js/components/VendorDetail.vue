<template>
    <div>
        <el-tabs type="card">
            <el-tab-pane label="Vendor Detail">
                <table style="width:100%">
                    <tbody>
                        <tr><td class="td-label">Name</td><td class="td-value">{{data.business_entity_form}} {{data.name}}</td></tr>
                        <tr><td class="td-label">Establish Date</td><td class="td-value">{{data.establish_date}}</td></tr>
                        <tr><td class="td-label">NPWP</td><td class="td-value">{{data.npwp}}</td></tr>
                        <tr><td class="td-label">Account Group</td><td class="td-value">{{data.account_group.name}}</td></tr>
                        <tr><td class="td-label">Company Status</td><td class="td-value">{{data.company_status}}</td></tr>
                        <tr><td class="td-label">Partnership Type</td><td class="td-value">{{data.partnership_type.name}}</td></tr>
                        <tr><td class="td-label">Industry Type</td><td class="td-value">{{data.industry_type.join(', ')}}</td></tr>
                        <tr><td class="td-label">Product Type</td><td class="td-value">{{data.product_type.join(', ')}}</td></tr>
                        <tr><td class="td-label">Address</td><td class="td-value">{{data.address}}</td></tr>
                        <tr><td class="td-label">Postcode</td><td class="td-value">{{data.postcode}}</td></tr>
                        <tr><td class="td-label">Phone</td><td class="td-value">{{data.phone}}</td></tr>
                        <tr><td class="td-label">Fax</td><td class="td-value">{{data.fax}}</td></tr>
                        <tr><td class="td-label">Email</td><td class="td-value">{{data.email}}</td></tr>
                        <tr><td class="td-label">Website</td><td class="td-value">{{data.website}}</td></tr>
                        <tr><td class="td-label">Contact Person Name</td><td class="td-value">{{data.contact_person_name}}</td></tr>
                        <tr><td class="td-label">Contact Person Phone</td><td class="td-value">{{data.contact_person_phone}}</td></tr>
                        <tr><td class="td-label">Contact Person Email</td><td class="td-value">{{data.contact_person_email}}</td></tr>
                    </tbody>
                </table>
            </el-tab-pane>
            <el-tab-pane label="Documents"><VendorDocument :data="data.documents" /></el-tab-pane>
            <el-tab-pane label="Managements"><VendorManagement :data="data.managements" /></el-tab-pane>
            <el-tab-pane label="Bank Accounts"><VendorBank :data="data.banks" /></el-tab-pane>
            <el-tab-pane label="Review History"><VendorReview :data="data.reviews" /></el-tab-pane>
        </el-tabs>
    </div>
</template>

<script>
import VendorBank from './VendorBank'
import VendorDocument from './VendorDocument'
import VendorManagement from './VendorManagement'
import VendorReview from './VendorReview'

export default {
    components: { VendorBank, VendorDocument, VendorManagement, VendorReview },
    props: ['data']
}
</script>

<style lang="scss" scoped>
.td-label {
    width: 250px;
    font-weight: bold;
    background-color: #ddd;
    padding: 5px 10px;
}

.td-value {
    background-color: #eee;
    padding: 5px 10px;
}
</style>
