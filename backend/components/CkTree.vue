<template>
    <el-col :span="6">
        <el-tree
            ref="tree"
            :data="treeData"
            :props="treeProps"
            :highlight-current="isHighlight"
            :default-checked-keys="categoryIds"
            :show-checkbox="isShowCheckbox"
            node-key="id"
            default-expand-all
            @node-click="handleNodeClick"
            @check-change="handleCheckChange">
        </el-tree>
    </el-col>
</template>

<script>
    import { tree } from "../api/categories";

    let categoryData = []
    const defaultProps = {
        label: 'name',
        children: 'children',
    }
    export default {
        name: "CkTree",
        created() {
            this.fetchTree()
        },
        props: {
            categoryIds: {
                type: [Array, Number],
                default: [],
            },
            isShowCheckbox: {
                type: Boolean,
                default: true,
            },
            isHighlight: {
                type: Boolean,
                default: false,
            }
        },
        data() {
            return {
                treeData: categoryData,
                treeProps: defaultProps,
            }
        },
        methods: {
            handleNodeClick(node) {
                // console.log(this.$refs.tree.getCheckedKeys())
            },
            handleCheckChange() {
                console.log(this.$refs.tree.getCheckedKeys())
                this.$emit('check-change', this.$refs.tree.getCheckedKeys())
            },
            fetchTree() {
                tree()
                    .then((response) => {
                        this.treeData = response.data.result
                        // console.log(this.treeData)
                    })
            }
        }
    }
</script>

<style scoped>

</style>