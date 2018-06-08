<template>
    <div id="user-index">
        <ck-table-page
            :col-data="colData"
            :fetch-list="fetchList">
        </ck-table-page>
    </div>
</template>

<script>
    import { fetchList } from '../../api/users'
    import CkTablePage from "../../components/CkTablePage"
    export default {
        name: "user-index",
        created() {
            this.colData = [
                { prop: 'id', label: 'ID' },
                { prop: 'name', label: '姓名' },
                { prop: 'email', label: '电子邮箱' },
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
            handleEdit(row) {
                this.$router.push('/user/edit/'+ row.id)
            }
        },
        components: {
            CkTablePage
        }
    }
</script>

<style scoped>

</style>