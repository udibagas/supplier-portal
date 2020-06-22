<template>
  <el-table :data="items">
    <el-table-column header-align="center" label="Request">
      <el-table-column prop="part_number" label="Part Number"></el-table-column>
      <el-table-column prop="part_description" label="Part Description"></el-table-column>
      <el-table-column prop="remark" label="Remark"></el-table-column>
      <el-table-column
        prop="requested_qty"
        label="Qty"
        show-overflow-tooltip
        min-width="50px"
        align="center"
        header-align="center"
      ></el-table-column>
      <el-table-column
        prop="unit"
        label="Unit"
        show-overflow-tooltip
        min-width="50px"
        align="center"
        header-align="center"
      ></el-table-column>
      <el-table-column
        prop="requested_delivery_date"
        label="Delivery Date"
        header-align="center"
        show-overflow-tooltip
        width="120px"
      ></el-table-column>
    </el-table-column>
    <el-table-column header-align="center" label="Quotation">
      <el-table-column label="Qty" prop="promised_qty" width="100px" header-align="center"></el-table-column>
      <el-table-column label="Price" prop="price" width="150px" header-align="center"></el-table-column>
      <el-table-column
        label="Delivery Date"
        prop="promised_delivery_date"
        width="170px"
        header-align="center"
      ></el-table-column>
    </el-table-column>
  </el-table>
</template>

<script>
export default {
  props: ["items"]
};
</script>
