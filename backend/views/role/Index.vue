<template>
    <div id="role-index">
        <ck-table-page
                :col-data="colData"
                :fetch-list="fetchList">
            <el-table-column slot="permissions" label="所有权限">
                <template slot-scope="scope">
                    <span v-for="permission in scope.row.permissions">{{ permission.name }}</span>
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
    import { fetchList } from '../../api/roles'
    import CkTablePage from "../../components/CkTablePage"
    export default {
        name: "roleIndex",
        created() {
            this.colData = [
                { prop: 'id', label: 'ID' },
                { prop: 'name', label: '角色名字' },
                { slot: 'permissions' },
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
                this.$router.push('/role/edit/'+ id)
            }
        },
        components: {
            CkTablePage
        }
    }
</script>

<style scoped>

</style>