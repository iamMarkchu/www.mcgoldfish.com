<template>
    <div id="role-edit">
        <role-detail :is-edit='true'></role-detail>
    </div>
</template>

<script>
    import RoleDetail from './components/RoleDetail'
    export default {
        name: "RoleEdit",
        components: {
            RoleDetail
        }
    }
</script>