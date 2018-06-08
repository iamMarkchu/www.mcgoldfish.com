<template>
    <div id="tag-edit">
        <tag-detail :is-edit='true'></tag-detail>
    </div>
</template>

<script>
    import tagDetail from './components/tagDetail'
    export default {
        name: "edit",
        created() {
        },
        data() {
            return {}
        },
        methods: {},
        components:{
            tagDetail
        }
    }
</script>

<style scoped>

</style>