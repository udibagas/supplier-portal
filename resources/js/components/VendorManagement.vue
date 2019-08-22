<template>
    <div>
        <el-table :data="data" stripe>
            <el-table-column prop="type" label="Type" show-overflow-tooltip></el-table-column>
            <el-table-column prop="name" label="Name" show-overflow-tooltip></el-table-column>
            <el-table-column prop="position" label="Position" show-overflow-tooltip></el-table-column>
            <el-table-column prop="id_number" label="ID Number" show-overflow-tooltip></el-table-column>
            <el-table-column prop="date_of_birth" label="Date of Birth" show-overflow-tooltip></el-table-column>
            <el-table-column prop="religion" label="Religion" show-overflow-tooltip></el-table-column>
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
