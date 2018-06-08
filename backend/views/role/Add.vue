<template>
    <div id="role-add">
        <el-form ref="form" :model="form" label-width="80px">
            <el-form-item label="角色名称">
                <el-input v-model="form.name"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="onSubmit">立即创建</el-button>
                <el-button @click="$router.go(-1)">取消</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
    export default {
        name: "Role-Add",
        data() {
            return {
                form: {
                    name: ''
                }
            }
        }
    }
</script>

<style scoped>

</style>