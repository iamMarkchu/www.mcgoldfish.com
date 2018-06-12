<template>
    <div id="user-edit">
        <user-detail :is-edit='true'></user-detail>
    </div>
</template>

<script>
    import UserDetail from './components/UserDetail'
    export default {
        name: "edit",
        components:{
            UserDetail
        }
    }
</script>