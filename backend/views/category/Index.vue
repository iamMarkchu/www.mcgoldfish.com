<template>
    <div id="category-index">
        <div class="tree-section">
            <el-col :span="6">
                <el-tree
                    :data="treeData"
                    :props="defaultProps"
                    node-key="id"
                    default-expand-all>
                    <span class="custom-tree-node" slot-scope="{ node, data }">
                        <span>{{ node.label }}</span>
                        <span v-if="data.id">
                          <el-button
                              type="text"
                              size="mini"
                              @click="handleEdit(data.id)">
                              编辑
                          </el-button>
                          <el-button
                                type="text"
                                size="mini"
                                @click="handleEdit(data.id)">
                              删除
                          </el-button>
                        </span>
                      </span>
                </el-tree>
            </el-col>
        </div>
    </div>
</template>

<script>
    import { FRONT_FULL_URL_WITHOUT_SLASH } from "../../api/upload";
    import { tree, fetchList } from "../../api/categories"
    let categoryData = [
        {
            id: 0,
            category_name: '类别列表',
            children: [],
        }
    ]
    export default {
        name: "Category-Index",
        created() {
            this.colData = [
                { prop: 'id', label: 'ID' },
                { slot: 'name' },
                { prop: 'grade', label: '等级' },
                { prop: 'display_order', label: '排序' },
                { prop: 'status', label: '状态' },
                { prop: 'domain', label: '域名' },
                { slot: 'operation' }
            ]
            this.fetchTree();
        },
        data() {
            return {
                colData: [],
                fetchList: fetchList,
                treeData: categoryData,
                defaultProps: {
                    label: 'category_name',
                    children: 'children',
                },
            }
        },
        methods: {
            handleAdd() {
                this.$router.push('/category/add')
            },
            handleEdit(id) {
                this.$router.push('/category/edit/'+ id)
            },
            getFullRequestPath(requestPath) {
                return FRONT_FULL_URL_WITHOUT_SLASH + requestPath
            },
            fetchTree() {
                tree()
                    .then((response) => {
                        categoryData[0].children = response.data.result
                        this.treeData = categoryData
                        console.log(this.treeData)
                    })
            },
        }
    }
</script>

<style scoped>

</style>