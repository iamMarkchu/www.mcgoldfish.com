<template>
    <div id="role-index">
        <div class="operate-section">
            <el-button type="primary" @click="handleAdd()">添加角色</el-button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Role-Index",
        created() {

        },
        data() {
            return {

            }
        },
        methods: {
            handleAdd() {
                this.$router.push('/role/add')
            }
        }
    }
</script>

<style scoped>

</style>