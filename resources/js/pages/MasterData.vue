<template>
    <div>
        <el-page-header @back="$emit('goBack')" content="MASTER DATA">
        </el-page-header>
        <el-divider></el-divider>
        <el-tabs type="card">
            <el-tab-pane lazy label="Account Group"><AccountGroup /></el-tab-pane>
            <el-tab-pane lazy label="Bank"><Bank /></el-tab-pane>
            <el-tab-pane lazy label="Department"><Department /></el-tab-pane>
            <el-tab-pane lazy label="Industry Type"><IndustryType /></el-tab-pane>
            <el-tab-pane lazy label="Partnership Type"><PartnershipType /></el-tab-pane>
            <el-tab-pane lazy label="Payment Term"><PaymentTerm /></el-tab-pane>
            <el-tab-pane lazy label="Product Type"><ProductType /></el-tab-pane>
            <el-tab-pane lazy label="Document Type"><VendorDocumentType /></el-tab-pane>
            <el-tab-pane lazy label="User"><User /></el-tab-pane>
        </el-tabs>
    </div>
</template>

<script>
import AccountGroup from './AccountGroup'
import Bank from './Bank'
import Department from './Department'
import IndustryType from './IndustryType'
import PartnershipType from './PartnershipType'
import PaymentTerm from './PaymentTerm'
import ProductType from './ProductType'
import VendorDocumentType from './VendorDocumentType'
import User from './User'

export default {
    components: {
        AccountGroup,
        Bank,
        Department,
        User,
        IndustryType,
        PartnershipType,
        PaymentTerm,
        ProductType,
        VendorDocumentType
    }
}
</script>

<style lang="scss" scoped>

</style>
