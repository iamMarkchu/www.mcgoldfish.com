<template>
    <div id="merchant-detail">
        <el-form ref="form" :model="form" :rules="rules" label-width="120px">
            <el-form-item label="类别名称" prop="category_name">
                <el-col :span="8">
                    <el-input v-model="form.category_name"></el-input>
                </el-col>
            </el-form-item>
            <el-form-item label="排序">
                <el-col :span="2">
                    <el-input-number v-model="form.display_order" :step="5"></el-input-number>
                </el-col>
            </el-form-item>
            <el-form-item label="父类别">
                <el-col :span="6">
                    <el-tree
                            ref="tree"
                            :data="treeData"
                            :props="defaultProps"
                            :highlight-current="isHighlight"
                            node-key="id"
                            default-expand-all
                            @node-click="handleNodeClick">
                    </el-tree>
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
    import { fetch, add, update, tree } from "../../../api/categories"

    const form = {
        category_name: '',
        parent_id: 0,
        display_order: 99,
    }

    let categoryData = [
        {
            id: 0,
            category_name: '顶级类别',
            children: [],
        }
    ]
    const validRules = {
        category_name: [
            { required: true, message: '请输入类别名字', trigger: 'blur' },
            { min: 2, max: 50, message: '长度在 2 到 50 个字符', trigger: 'blur' },
        ],
        display_order: [
            { type: 'number', message: '必须为整数', trigger: 'change' }
        ]
    }

    export default {
        name: "categoryDetail",
        created() {
            this.fetchTree()
            if (this.isEdit)
            {
                let id = this.$route.params.id
                this.fetchData(id)
            } else {
                this.form = Object.assign({}, form)
            }
        },
        props: {
            isEdit: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                form: Object.assign({}, form),
                treeData: categoryData,
                defaultProps: {
                    label: 'category_name',
                    children: 'children',
                },
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
            fetchTree() {
                tree()
                    .then((response) => {
                        categoryData[0].children = response.data.result
                        this.treeData = categoryData
                        console.log(this.treeData)
                    })
            },
            fetchData(id) {
                fetch(id)
                    .then((response) => {
                        this.form = response.data.result
                        this.$refs.tree.setCurrentKey(response.data.result.parent_id)
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
                                    this.$message({
                                        showClose: true,
                                        message: '恭喜你，修改成功!',
                                        type: 'success'
                                    });
                                    this.$router.go(-1)
                                })
                        } else {
                            add(this.form)
                                .then((response) => {
                                    this.$message({
                                        showClose: true,
                                        message: '恭喜你，创建成功!',
                                        type: 'success'
                                    });
                                    this.$router.go(-1)
                                })
                        }
                    } else {
                        console.log('error submit!!')
                        return false
                    }
                })
            },
            handleNodeClick(node) {
                this.form.parent_id = node.id
            }
        }
    }
</script>

<style scoped>
    .el-input .el-select {
        width: 130px;
    }
    .input-with-select .el-input-group__prepend {
        background-color: #fff;
    }
</style>