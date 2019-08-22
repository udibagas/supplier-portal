<template>
    <div>
        <el-table :data="data">
            <el-table-column prop="name" label="Document Type" show-overflow-tooltip></el-table-column>
            <el-table-column prop="expiry_date" label="Expiry Date" show-overflow-tooltip></el-table-column>
            <el-table-column label="File">
                <template slot-scope="scope">
                    <el-button @click="() => { selectedData = scope.row; showFilePreview = true; }" icon="el-icon-zoom-in" type="primary" plain size="mini">View File</el-button>
                </template>
            </el-table-column>
        </el-table>

        <el-dialog append-to-body center fullscreen :title="selectedData.name" :visible.sync="showFilePreview">
            <iframe :src="selectedData.file_path" frameborder="0" style="width:100%;height: calc(100vh - 120px)"></iframe>
        </el-dialog>
    </div>
</template>

<script>
export default {
    props: ['data'],
    data() {
        return {
            selectedData: {},
            showFilePreview: false
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
