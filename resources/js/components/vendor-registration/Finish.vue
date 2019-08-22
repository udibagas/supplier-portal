<template>
    <el-card>
        <div style="text-align:center;padding: 20px 0;font-size:16px;">
            <h2>Terimakasih!</h2>
            <p>
                Terimakasih telah mendaftar mejadi rekanan kami.
                Team kami akan memverifikasi data Anda dan
                hasil verifikasi akan kami kirimkan via email.
            </p>
        </div>
    </el-card>
</template>

<script>
export default {
    mounted() {
        axios.post('/vendor/notify/' + this.$store.state.vendor_id).then(r => {
            this.$message({
                message: 'Pendaftaran berhasil',
                type: 'success',
                showClose: true
            })
        }).catch(e => {
            this.$message({
                message: 'Gagal mengirimkan notifikasi',
                type: 'error',
                showClose: true
            })
        })
    }
}
</script>

<style lang="scss" scoped>

</style>
