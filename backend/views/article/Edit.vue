<template>
    <div id="article-edit">
        <article-detail :is-edit='true'></article-detail>
    </div>
</template>

<script>
    import ArticleDetail from './components/ArticleDetail'
    export default {
        name: "ArticleEdit",
        components: {
            ArticleDetail
        }
    }
</script>

<style scoped>

</style>