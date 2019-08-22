<template>
    <el-tabs type="card">
        <el-tab-pane label="Request Detail">
            <table style="width:100%">
                <tbody>
                    <tr><td class="td-label">Created At</td><td class="td-value">{{data.updated_at}}</td></tr>
                    <tr><td class="td-label">Subject</td><td class="td-value">{{data.subject}}</td></tr>
                    <tr><td class="td-label">Requestor</td><td class="td-value">{{data.user.name}}</td></tr>
                    <tr><td class="td-label">Unit</td><td class="td-value">{{data.department.name}}</td></tr>
                    <tr>
                        <td class="td-label">Status</td>
                        <td class="td-value">
                            <el-tag size="mini" :type="data.status ? 'success' : 'info'">{{data.status ? 'Submitted' : 'Draft'}}</el-tag>
                        </td>
                    </tr>
                </tbody>
            </table>

            <el-table :data="data.items" stripe>
                <el-table-column prop="part_number" label="Part Number" show-overflow-tooltip min-width="100px"></el-table-column>
                <el-table-column prop="part_description" label="Part Description" show-overflow-tooltip min-width="120px"></el-table-column>
                <el-table-column prop="requested_qty" label="Qty" show-overflow-tooltip min-width="50px" align="center" header-align="center"></el-table-column>
                <el-table-column prop="requested_delivery_date" label="Delivery Date" show-overflow-tooltip min-width="120px"></el-table-column>
                <el-table-column prop="remark" label="Remark" show-overflow-tooltip min-width="120px"></el-table-column>
                <el-table-column label="Attachment" min-width="100px">
                    <el-button plain size="mini" icon="el-icon-zoom-in" type="primary">View Attachment</el-button>
                </el-table-column>
            </el-table>
        </el-tab-pane>
        <el-tab-pane label="Assignment History">

        </el-tab-pane>
        <el-tab-pane label="Vendor Quotation">

        </el-tab-pane>
    </el-tabs>
</template>

<script>
export default {
    props: ['data']
}
</script>

<style lang="scss" scoped>
.td-label {
    width: 150px;
    font-weight: bold;
    background-color: #ddd;
    padding: 5px 10px;
}

.td-value {
    background-color: #eee;
    padding: 5px 10px;
}
</style>
