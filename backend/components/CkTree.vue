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
            :default-expand-all="isExpandAll"
            @node-click="handleNodeClick"
            @check-change="handleCheckChange">
        </el-tree>
    </el-col>
</template>

<script>
    import { tree } from "../api/categories";

    let categoryData = []
    const defaultProps = {
        label: 'category_name',
        children: 'children',
    }
    export default {
        name: "CkTree",
        created() {
            this.fetchTree()
        },
        watch: {
            categoryIds(val) {
                this.$refs.tree.setCurrentKey(val)
            }
        },
        props: {
            categoryIds: {
                type: [Array, Number],
                default: function () {
                    return []
                },
            },
            isShowCheckbox: {
                type: Boolean,
                default: true,
            },
            isHighlight: {
                type: Boolean,
                default: false,
            },
            isExpandAll: {
                type: Boolean,
                default: true,
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
                console.log(node)
                this.$emit('nodeClick', node.id)
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