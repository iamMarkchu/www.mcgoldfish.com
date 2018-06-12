<template>
    <div id="permission-index">
        <ck-table-page
                :col-data="colData"
                :fetch-list="fetchList">
            <el-table-column slot="roles" label="所属角色">
                <template slot-scope="scope">
                    <el-tag v-for="role in scope.row.roles" :key="role.id">{{ role.name }}</el-tag>
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
    import { fetchList } from '../../api/permissions'
    import CkTablePage from "../../components/CkTablePage"
    export default {
        name: "user-index",
        created() {
            this.colData = [
                { prop: 'id', label: 'ID' },
                { prop: 'name', label: '标签名字' },
                { slot: 'roles' },
                { prop: 'created_at', label: '创建时间' },
                { prop: 'updated_at', label: '更新时间' },
                { slot: 'operation' }
            ]
        },
        data() {
            return {
                fetchList: fetchList,
                colData: [],
            }
        },
        methods: {
            handleEdit(id) {
                this.$router.push('/permission/edit/'+ id)
            }
        },
        components: {
            CkTablePage
        }
    }
</script>

<style scoped>
    .el-tag+.el-tag {
        margin-left: 10px;
    }
</style>