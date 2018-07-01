<template>
    <div id="image-index">
        <ck-table-page
                :col-data="colData"
                :fetch-list="fetchList">
        </ck-table-page>
    </div>
</template>

<script>
    import { fetchList } from '../../api/images'
    import CkTablePage from "../../components/CkTablePage"
    export default {
        name: "image-index",
        created() {
            this.colData = [
                { prop: 'id', label: 'ID' },
                { prop: 'user_id', label: '用户ID' },
                { prop: 'name', label: '图片名字' },
                { prop: 'url_name', label: '地址' },
                { prop: 'display_order', label: '排序' },
                { prop: 'status', label: '状态' },
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
                this.$router.push('/tag/edit/'+ id)
            }
        },
        components: {
            CkTablePage
        }
    }
</script>

<style scoped>

</style>