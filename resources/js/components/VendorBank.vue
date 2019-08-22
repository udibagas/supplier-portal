<template>
    <div>
        <el-table :data="data" stripe>
            <el-table-column label="Bank" show-overflow-tooltip>
                <template slot-scope="scope">
                    {{scope.row.bank.code}} - {{scope.row.bank.name}}
                </template>
            </el-table-column>
            <el-table-column prop="branch" label="Branch" show-overflow-tooltip></el-table-column>
            <el-table-column prop="account_number" label="Account Number" show-overflow-tooltip></el-table-column>
            <el-table-column prop="account_holder" label="Account Holder" show-overflow-tooltip></el-table-column>
            <el-table-column prop="currency" label="Currency" show-overflow-tooltip></el-table-column>
        </el-table>
    </div>
</template>

<script>
export default {
    props: ['data']
}
</script>

<style lang="scss" scoped>

</style>
