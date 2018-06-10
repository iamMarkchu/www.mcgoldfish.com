<template>
    <div id="article-index">
        <div class="filter-section">
            <el-form :inline="true" :model="query" class="demo-form-inline">
                <el-form-item>
                    <el-input v-model="query.title" placeholder="标题"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-select v-model="query.source" :clearable='true' placeholder="来源">
                        <el-option
                            v-for="item in sourceOptions"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item>
                    <el-select v-model="query.status" :clearable='true' placeholder="状态">
                        <el-option
                            v-for="item in statusOptions"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <!--<el-form-item>-->
                    <!--<el-select v-model="orderBy" :clearable='true' placeholder="排序">-->
                        <!--<el-option-->
                            <!--v-for="item in orderOptions"-->
                            <!--:key="item.value"-->
                            <!--:label="item.label"-->
                            <!--:value="item.value">-->
                        <!--</el-option>-->
                    <!--</el-select>-->
                <!--</el-form-item>-->
                <el-form-item>
                    <el-button type="primary" @click="handleSearch">搜索</el-button>
                    <el-button type="primary" @click="handleAdd">创建</el-button>
                </el-form-item>
            </el-form>
        </div>
        <ck-table-page
                ref="table"
                :col-data="colData"
                :fetch-list="fetchList"
                :query="query">
            <el-table-column slot="title" align="center" label="类别/标题" min-width="150">
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.category">{{scope.row.category.category_name}}</el-tag>
                    <span class="title" @click="handleViewArticle(scope.row)">《{{scope.row.title}}》</span>
                </template>
            </el-table-column>
            <el-table-column slot="status" label="状态" align="center">
                <template slot-scope="scope">
                    <el-tag :type="scope.row.status| statusTagFilter">{{ scope.row.status | statusFilter }}</el-tag>
                </template>
            </el-table-column>
            <el-table-column slot="source" label="来源" align="center">
                <template slot-scope="scope">
                    <el-tag :type="scope.row.source| sourceTagFilter">{{ scope.row.source | sourceFilter }}</el-tag>
                </template>
            </el-table-column>
            <el-table-column slot="created_updated" label="修改时间" align="center" >
                <template slot-scope="scope">
                    <p>{{ scope.row.updated_at }}</p>
                </template>
            </el-table-column>
            <el-table-column slot="operation" label="操作" align="center" width="220">
                <template slot-scope="scope">
                    <el-button type="primary" size="mini" @click="handleEdit(scope.row.id)">编辑</el-button>
                    <el-button type="success" size="mini" @click="handleChangeStatus(scope.row, 'active')" v-show="scope.row.status === 'republish'">发布</el-button>
                    <el-button size="mini" @click="handleChangeStatus(scope.row, 'republish')" v-show="scope.row.status !== 'republish'">撤回</el-button>
                    <el-button type="danger" size="mini" @click="handleChangeStatus(scope.row, 'deleted')" v-show="scope.row.status !== 'deleted'">删除</el-button>
                </template>
            </el-table-column>
        </ck-table-page>
    </div>
</template>

<script>
    import { fetchList, changeStatus } from '../../api/articles'
    import CkTablePage from "../../components/CkTablePage"
    import { FRONT_FULL_URL } from "../../api/upload"
    import helper from "../../utils/helper"

    const query = {
        title: '',
        source: '',
        status: 'active',
    }

    const orderBy = null
    const sourceOptions = [
        { key: 'origin', value: 'origin', label: '原创' },
        { key: 'reprint', value: 'reprint', label: '转载' }
    ]
    const statusOptions = [
        { key: 'active', value: 'active', label: '有效' },
        { key: 'republish', value: 'republish', label: '待发布' },
        { key: 'deleted', value: 'deleted', label: '已删除' },
    ]
    const orderOptions = [
        { key: '1', value: '1', label: '按创建时间' },
        { key: '2', value: '2', label: '按创建时间倒序' },
        { key: '3', value: '3', label: '按最后更新时间' },
        { key: '4', value: '4', label: '按最后更新时间倒序' },
        { key: '5', value: '5', label: '按排序等级'},
        { key: '6', value: '6', label: '按排序等级倒序'},
    ]
    export default {
        name: "article-index",
        created() {
            this.colData = [
                { prop: 'id', label: 'ID' },
                { slot: 'title' },
                { prop: 'user.name', label: '作者' },
                { slot: 'status'},
                { slot: 'source'},
                { prop: 'display_order', label: '排序' },
                { slot: 'created_updated'},
                { slot: 'operation' }
            ]
        },
        data() {
            return {
                query,
                orderBy,
                sourceOptions,
                statusOptions,
                orderOptions,
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
                    origin: 'primary',
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
                    active: 'primary',
                    deleted: 'danger'
                }
                return statusMap[val]
            }
        },
        methods: {
            handleAdd() {
                this.$router.push('/article/add')
            },
            handleSearch() {
                this.$refs.table.fetchData()
            },
            handleEdit(id) {
                this.$router.push('/article/edit/'+ id)
            },
            handleViewArticle(row) {
                if (row.status == 'active')
                    window.open(FRONT_FULL_URL +'/article/' + row.id)
                else
                    helper.message('文章还没发布或者已删除!', 'warning')
            },
            handleChangeStatus(row, status) {
                const params = {id: row.id, status: status}
                changeStatus(params).then(response => {
                    if (response.data.code === 200) {
                        const messageMap = {
                            active: '发布成功!',
                            republish: '撤回成功!',
                            deleted: '删除成功'
                        }
                        this.$notify({
                            title: '成功',
                            message: messageMap[status],
                            type: 'success',
                            duration: 2000
                        })
                        row.status = response.data.result.status
                        row.updated_at = response.data.result.updated_at
                    }
                }).catch(error => {
                    console.log(error)
                })
            }
        },
        components: {
            CkTablePage
        }
    }
</script>

<style scoped>
    span.title {
        cursor: pointer;
    }
</style>