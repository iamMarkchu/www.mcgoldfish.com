<template>
    <div id="role-detail">
        <el-form ref="form" :model="form" :rules="rules" label-width="120px">
            <el-form-item label="名称" prop="name">
                <el-col :span="8">
                    <el-input v-model="form.name"></el-input>
                </el-col>
            </el-form-item>
            <el-form-item label="持有权限">
                <el-col :span="6">
                    <el-checkbox-group v-if="permissionOptions.length" v-model="form.permission_names">
                        <el-checkbox v-for="permission in permissionOptions" :label="permission.label" :key="permission.key" border>{{permission.label}}</el-checkbox>
                    </el-checkbox-group>
                    <span v-else>暂无数据</span>
                </el-col>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="onSubmit('form')">{{ $route.name }}</el-button>
                <el-button @click="$router.go(-1)">取消</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
    import helper from "../../../utils/helper"
    import { fetch, add, update } from "../../../api/roles"
    import { fetchList as fetchPermissionList } from "../../../api/permissions";

    const form = {
        name: '',
        permission_names: [],
    }

    const validRules = {
        tag_name: [
            { required: true, message: '请输入名字', trigger: 'blur' },
            { min: 2, max: 50, message: '长度在 2 到 50 个字符', trigger: 'blur' },
        ],
        display_order: [
            { type: 'number', message: '必须为整数', trigger: 'change' }
        ]
    }

    export default {
        name: "RoleDetail",
        created() {
            if (this.isEdit)
            {
                let id = this.$route.params.id
                this.fetchData(id)
            } else {
                this.form = Object.assign({}, form)
            }
            let query = { pageSize: 1000 }
            this.fetchPermissionList(query)
                .then((response) => {
                    this.permissionOptions = response.data.result.data.map((val) => {
                        return { key:val.id, label: val.name }
                    })
                })
        },
        props: {
            isEdit: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                permissionOptions: [],
                form: Object.assign({}, form),
                rules: validRules,
                submitText: '',
                isHighlight: true,
            }
        },
        computed: {
            requestPath() {
                return '';
            }
        },
        methods: {
            fetchData(id) {
                fetch(id)
                    .then((response) => {
                        this.form.permission_names = response.data.result.permissions.map((val) => {
                            return val.name
                        })
                        this.form.name = response.data.result.name
                        this.$set(this.form, 'id', response.data.result.id)
                    })
            },
            fetchPermissionList,
            onSubmit(formName) {
                console.log(this.$refs[formName])
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        if (this.isEdit)
                        {
                            update(this.form, this.form.id)
                                .then((repsonse) => {
                                    helper.message('修改成功!')
                                    this.$router.go(-1)
                                })
                        } else {
                            add(this.form)
                                .then((response) => {
                                    helper.message('创建成功!')
                                    this.$router.go(-1)
                                })
                        }
                    } else {
                        console.log('error submit!!')
                        return false
                    }
                })
            },
        }
    }
</script>

<style scoped></style>