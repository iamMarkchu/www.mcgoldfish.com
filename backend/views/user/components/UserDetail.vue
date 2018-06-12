<template>
    <div id="user-detail">
        <el-form ref="form" :model="form" :rules="rules" label-width="120px">
            <el-form-item label="姓名" prop="name">
                <el-col :span="8">
                    <el-input v-model="form.name"></el-input>
                </el-col>
            </el-form-item>
            <el-form-item label="所属角色">
                <el-col :span="6">
                    <el-checkbox-group v-model="form.role_names">
                        <el-checkbox v-for="role in roleOptions" :label="role.label" :key="role.key" border>{{role.label}}</el-checkbox>
                    </el-checkbox-group>
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
    import { fetch, add, update } from "../../../api/users"
    import { fetchList as fetchRoleList } from "../../../api/roles";

    const form = {
        name: '',
        role_names: [],
    }

    const validRules = {
        name: [
            { required: true, message: '请输入类别名字', trigger: 'blur' },
            { min: 2, max: 50, message: '长度在 2 到 50 个字符', trigger: 'blur' },
        ],
        display_order: [
            { type: 'number', message: '必须为整数', trigger: 'change' }
        ]
    }

    export default {
        name: "tagDetail",
        created() {
            if (this.isEdit)
            {
                let id = this.$route.params.id
                this.fetchData(id)
            } else {
                this.form = Object.assign({}, form)
            }
            const query = { pageSize: 1000 }
            fetchRoleList(query)
                .then((response) => {
                    this.roleOptions = response.data.result.data.map((val) => {
                        return { key: val.id, label: val.name }
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
                roleOptions: [],
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
                        this.form.name = response.data.result.name
                        this.form.role_names = response.data.result.roles.map((val) => {
                            return val.name
                        })
                        this.$set(this.form, 'id', response.data.result.id)
                    })
            },
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