<template>
    <div id="permission-edit">
        <permission-detail :is-edit='true'></permission-detail>
    </div>
</template>

<script>
    import PermissionDetail from './components/PermissionDetail'
    export default {
        name: "PermissionEdit",
        components: {
            PermissionDetail
        }
    }
</script>

<style scoped>

</style>