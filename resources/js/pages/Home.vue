<template>
    <el-card>
        <el-form inline style="text-align:center">
            <h1>AP AGING REPORT</h1>
            <el-form-item>
                <el-select placeholder="Select Year" v-model="year" @change="() => { chart.series[0].data = fakeData() }" clearable>
                    <el-option v-for="y in years" :key="y" :label="y" :value="y"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item v-show="type != 'Monthly'">
                <el-select placeholder="Select Month" v-model="month" @change="() => { chart.series[0].data = fakeData() }">
                    <el-option v-for="(m, i) in months" :key="i" :label="m" :value="i+1"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item>
                <el-select placeholder="Select Supplier" v-model="supplier_id" @change="() => { chart.series[0].data = fakeData() }" clearable>
                    <el-option v-for="(v, i) in $store.state.vendorList" :key="i" :label="v.name" :value="v.id"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item>
                <el-radio-group v-model="type">
                    <el-radio-button label="Daily"></el-radio-button>
                    <el-radio-button label="Weekly"></el-radio-button>
                    <el-radio-button label="Monthly"></el-radio-button>
                </el-radio-group>
            </el-form-item>
        </el-form>

        <v-chart style="height:calc(100vh - 270px);width:100%" :options="chart" ref="bar" autoresize />

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
    </el-card>
</template>

<script>
import ECharts from 'vue-echarts'
import 'echarts/lib/chart/bar'
import 'echarts/lib/component/title'
import 'echarts/lib/component/tooltip'
import 'echarts/lib/component/legend'
import moment from 'moment'

export default {
    components: { 'v-chart': ECharts },
    watch: {
        type(v) {
            if (v == 'Daily') {
                this.chart.xAxis.data = [...Array(30).keys()].map(d => d + 1)
                this.dataLength = 30
                this.chart.series[0].data = this.fakeData()
            }

            if (v == 'Weekly') {
                this.chart.xAxis.data = ['I', 'II', 'III', 'IV']
                this.dataLength = 4
                this.chart.series[0].data = this.fakeData()
            }

            if (v == 'Monthly') {
                this.chart.xAxis.data = moment.months()
                this.dataLength = 12
                this.chart.series[0].data = this.fakeData()
            }
        }
    },
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
            type: 'Daily',
            supplier_id: '',
            dataLength: 30,
            chart: {
                // legend: {},
                tooltip: {},
                grid: {
                    left: '25px',
                    right: '25px',
                    bottom: '0%',
                    containLabel: true
                },
                xAxis: {
                    type: 'category',
                    boundaryGap: true,
                    data: [...Array(30).keys()].map(d => d + 1)
                },
                yAxis: { type: 'value', name: 'Invoice (Million)'},
                series: [{
                    name: 'Invoice',
                    type: 'bar',
                    color: '#00B8CE',
                    // barGap: '0%',
                    label: {
                        normal: {
                            show: true,
                            position: 'top',
                            formatter: (v) => {
                                return v.value
                            }
                        }
                    },
                    data: [...Array(30).keys()].map(d => (Math.random() * 1000).toFixed(2)),
                }]
            }
        }
    },

    methods: {
        fakeData() {
            return [...Array(this.dataLength).keys()].map(d => (Math.random() * 1000).toFixed(2))
        }
    },
    mounted() {
        console.log(moment().dates())
        this.$store.commit('getVendorList')
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
