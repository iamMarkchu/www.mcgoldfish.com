<template>
    <div id="article-detail">
        <el-form ref="form" :model="form" :rules="rules" label-width="120px">
            <el-form-item label="标题" prop="title">
                <el-col :span="8">
                    <el-input v-model="form.title"></el-input>
                </el-col>
            </el-form-item>
            <el-form-item label="封面">
                <ck-upload :image="form.image" @action="form.image = $event"></ck-upload>
            </el-form-item>
            <el-form-item label="类别">
                <ck-tree
                    :categoryIds="form.category_id"
                    :is-show-checkbox='false'
                    :is-highlight='true'
                    :is-expand-all='false'
                    @nodeClick="form.category_id = $event"
                    >
                </ck-tree>
            </el-form-item>
            <el-form-item label="标签">
                <ck-tag :default-tags="form.tag_ids" @change="form.tag_ids = $event"></ck-tag>
            </el-form-item>
            <el-form-item label="来源">
                <el-select v-model="form.source" placeholder="请选择">
                    <el-option
                            v-for="item in sourceOptions"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="内容">
                <el-col :span="12">
                    <el-input
                        type="textarea"
                        :rows="12"
                        placeholder="请输入内容"
                        v-model="form.content">
                    </el-input>
                </el-col>
            </el-form-item>
            <el-form-item label="排序">
                <el-col :span="2">
                    <el-input-number v-model="form.display_order" :step="5"></el-input-number>
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
    import CkUpload from "../../../components/CkUpload"
    import { fetch, add, update } from "../../../api/articles"
    import CkTree from "../../../components/CkTree"
    import CkTag from "../../../components/CkTag"

    const form = {
        category_id: 0,
        tag_ids: [],
        title: '',
        image: '',
        content: '',
        display_order: 99,
        source: 'origin'
    }

    const sourceOptions = [
        { key: 'origin', value: 'origin', label: '原创' },
        { key: 'reprint', value: 'reprint', label: '转载' }
    ]
    const validRules = {
        title: [
            { required: true, message: '请输入标题', trigger: 'blur' },
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
                rules: validRules,
                sourceOptions,
                submitText: '',
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
                        response.data.result.tag_ids = response.data.result.tags.map(function(val) {
                            return val.id
                        })
                        this.form = Object.assign({}, response.data.result)
                        console.log(this.form)
                    })
            },
            onSubmit(formName) {
                console.log(this.$refs[formName])
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        if (this.isEdit)
                        {
                            console.log(this.form)
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
        },
        components: {
            CkUpload,
            CkTree,
            CkTag,
        }
    }
</script>

<style scoped></style>