<template>
    <div>
        <el-table :data="data" stripe>
            <el-table-column prop="created_at" label="Time"></el-table-column>
            <el-table-column prop="user.name" label="Verificator"></el-table-column>
            <el-table-column prop="note" label="Note"></el-table-column>
            <el-table-column label="Verification Status">
                <template slot-scope="scope">
                    <el-tag size="mini" :type="scope.row.verification_status ? 'success' : 'danger'">{{scope.row.verification_status ? 'Approved' : 'Rejected'}}</el-tag>
                </template>
            </el-table-column>
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
