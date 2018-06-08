<template>
    <div id="article-index">
        <ck-table-page
                :col-data="colData"
                :fetch-list="fetchList">
            <el-table-column slot="title" align="center" label="标题" min-width="150">
                <template slot-scope="scope">
                    <span><a href="javascript:;" @click="handleViewArticle(scope.row)">{{scope.row.title}}</a> <el-tag v-if="scope.row.category">{{scope.row.category.category_name}}</el-tag></span>
                </template>
            </el-table-column>
            <el-table-column slot="status" label="状态" >
                <template slot-scope="scope">
                    <el-tag :type="scope.row.status| statusTagFilter">{{ scope.row.status | statusFilter }}</el-tag>
                </template>
            </el-table-column>
            <el-table-column slot="source" label="来源" >
                <template slot-scope="scope">
                    <el-tag :type="scope.row.source| sourceTagFilter">{{ scope.row.source | sourceFilter }}</el-tag>
                </template>
            </el-table-column>
            <el-table-column slot="created_updated" label="修改时间" >
                <template slot-scope="scope">
                    <p>{{ scope.row.updated_at }}</p>
                </template>
            </el-table-column>
            <el-table-column slot="operation" label="操作">
                <template slot-scope="scope">
                    <el-button type="primary" size="mini" @click="handleEdit(scope.row.id)">编辑</el-button>
                </template>
            </el-table-column>
        </ck-table-page>
    </div>
</template>

<script>
    import { fetchList } from '../../api/articles'
    import CkTablePage from "../../components/CkTablePage"
    export default {
        name: "article-index",
        created() {
            this.colData = [
                { prop: 'id', label: 'ID' },
                { slot: 'title' },
                { prop: 'user.name', label: '作者' },
                { prop: 'display_order', label: '排序' },
                { slot: 'status'},
                { slot: 'source'},
                { slot: 'created_updated'},
                { slot: 'operation' }
            ]
        },
        data() {
            return {
                fetchList: fetchList,
                colData: [],
            }
        },
        filters: {
            sourceFilter: function(val) {
                const statusMap = {
                    origin: '原创',
                    reprint: '转载'
                }
                return statusMap[val]
            },
            sourceTagFilter: function(val) {
                const statusMap = {
                    origin: 'success',
                    reprint: 'info'
                }
                return statusMap[val]
            },
            statusFilter: function(val) {
                const statusMap = {
                    republish: '待发布',
                    active: '有效',
                    deleted: '已删除',
                    pending: '待处理'
                }
                return statusMap[val]
            },
            statusTagFilter: function(val) {
                const statusMap = {
                    republish: 'info',
                    active: 'success',
                    deleted: 'danger'
                }
                return statusMap[val]
            }
        },
        methods: {
            handleEdit(id) {
                this.$router.push('/article/edit/'+ id)
            }
        },
        components: {
            CkTablePage
        }
    }
</script>

<style scoped>
    .table-tag {
        margin-right: 5px;
        margin-bottom: 3px;
    }
</style>