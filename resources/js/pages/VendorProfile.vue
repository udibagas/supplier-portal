<template>
    <div>
        <el-page-header @back="$emit('goBack')" content="VENDOR PROFILE">
        </el-page-header>
        <el-divider></el-divider>
        <el-button type="primary" icon="el-icon-edit">EDIT DATA</el-button>
        <el-divider></el-divider>
        <VendorDetail :data="data" />
    </div>
</template>

<script>
import VendorDetail from '../components/VendorDetail'

export default {
    components: { VendorDetail },
    data() {
        return {
            data: {}
        }
    },
    mounted() {
        axios.get('/vendor/getByUser/' + this.$store.state.user.id).then(r => {
            this.data = r.data
        }).catch(e => console.log(e))
    }
}
</script>

<style lang="scss" scoped>

</style>
