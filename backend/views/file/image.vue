<template>
    <div id="image-single">

    </div>
</template>

<script>
    export default {
        name: "image-single",
        created() {
        },
        data() {
            return {
                name: 'file',
                action: UPLOAD_URL,
                headers: HEADERS,
                disabled: false,
                dialogVisible: false,
                dialogImageUrl: '',
                file: '',
            }
        },
        methods: {
            onPreview(file) {
                this.dialogImageUrl = file.url
                this.dialogVisible = true
            },
            onSuccess(response, file, fileList) {
                this.file = response
                alert(this.file)
            },
            onExceed(files, fileList) {
                this.$message.error('只能上传一张图片，请删除后再试')
            }
        }
    }
</script>

<style scoped>

</style>