<template>
    <div>
        <el-select placeholder="Select Year" v-model="year">
            <el-option v-for="y in years" :key="y" :label="y" :value="y"></el-option>
        </el-select>
        <el-select placeholder="Select Month" v-model="month">
            <el-option v-for="(m, i) in months" :key="i" :label="m" :value="i+1"></el-option>
        </el-select>
        <el-button-group>
            <el-button type="primary" plain>Daily</el-button>
            <el-button type="primary" plain>Weekly</el-button>
        </el-button-group>
        <v-chart style="height:300px" :options="chart" ref="bar" autoresize />

        <!-- <el-row :gutter="20">
            <el-col :span="24">

            </el-col>
            <el-col :span="12">
                <el-card class="summary-container bg-pink">
                    <h1 class="summary-info"></h1>
                </el-card>
            </el-col>
            <el-col :span="6">
                <el-card class="summary-container bg-teal">

                </el-card>
            </el-col>
            <el-col :span="6">
                <el-card class="summary-container bg-orange">

                </el-card>
            </el-col>
        </el-row> -->
    </div>
</template>

<script>
import ECharts from 'vue-echarts'
import 'echarts/lib/chart/bar'

export default {
    components: { 'v-chart': ECharts },
    computed: {
        months() {
            return moment.months()
        }
    },
    data() {
        return {
            years: [2017, 2018, 2019],
            year: moment().format('YYYY'),
            month: parseInt(moment().format('M')),
            chart: {
                legend: {},
                tooltip: {},
                dataset: {
                // Provide data.
                source: [
                    ['Product', '2015', '2016', '2017'],
                    ['Matcha Latte', 2,3,4],
                    ['Milk Tea', 2,3,4],
                    ['Cheese Cocoa', 2,3,4],
                    ['Walnut Brownie', 2,3,4]
                ]
                },
                // Declare X axis, which is a category axis, mapping
                // to the first column by default.
                xAxis: { type: 'category' },
                // Declare Y axis, which is a value axis.
                yAxis: {},
                // Declare several series, each of them mapped to a
                // column of the dataset by default.
                series: [{ type: 'bar' }, { type: 'bar' }, { type: 'bar' }]
            }
        }
    }
}
</script>

<style lang="scss" scoped>
.summary-container {
    height: 150px;
    text-align: center;
}

.summary-info {
    font-size: 30px;
}
</style>
