import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export const constantRouterMap = [
    {
        name: '个人中心',
        path: '/',
        component: require('../views/Index'),
        icon: 'el-icon-document',
    },
    {
        name: '文章管理',
        path: '/article',
        component: require('../components/CkBody'),
        icon: 'el-icon-document',
        children: [
            {
                name: '文章列表',
                path: 'index',
                component: require('../views/article/Index'),
            },
            {
                name: '发布',
                path: 'add',
                component: require('../views/article/Add'),
            },
            {
                name: '更新',
                path: 'edit/:id',
                component: require('../views/article/Edit'),
                display: false,
            },
        ],
    },
    // {
    //     name: '类别管理',
    //     path: '/category',
    //     component: require('../components/CkBody'),
    //     children: [
    //         {
    //             name: '类别列表',
    //             path: 'index',
    //             component: require('../views/category/Index'),
    //         },
    //         {
    //             name: '创建类别',
    //             path: 'add',
    //             component: require('../views/category/Add'),
    //         },
    //         {
    //             name: '修改类别',
    //             path: 'edit/:id',
    //             component: require('../views/category/Edit'),
    //             display: false,
    //         },
    //     ],
    // },
    {
        name: '标签管理',
        path: '/tag',
        component: require('../components/CkBody'),
        icon: 'el-icon-document',
        children: [
            {
                name: '标签列表',
                path: 'index',
                component: require('../views/tag/Index'),
            },
            {
                name: '创建标签',
                path: 'add',
                component: require('../views/tag/Add'),
            },
            {
                name: '修改标签',
                path: 'edit/:id',
                component: require('../views/tag/Edit'),
                display: false,
            },
        ],
    },
    {
        name: '文件管理',
        path: '/image',
        component: require('../components/CkBody'),
        icon: 'el-icon-document',
        children: [
            {
                name: '图片管理',
                path: 'index',
                component: require('../views/image/Index'),
            },
            {
                name: '添加图片',
                path: 'add',
                component: require('../views/image/Add'),
            },
        ]
    },
    {
        name: '用户管理',
        path: '/user',
        component: require('../components/CkBody'),
        icon: 'el-icon-document',
        children: [
            {
                name: '用户列表',
                path: 'index',
                component: require('../views/user/Index'),
            },
            {
                name: '修改用户',
                path: 'edit/:id',
                component: require('../views/user/Edit'),
                display: false,
            },
        ]
    },
    {
        name: '权限管理',
        path: '/permission',
        component: require('../components/CkBody'),
        icon: 'el-icon-document',
        children: [
            {
                name: '权限列表',
                path: 'index',
                component: require('../views/permission/Index')
            },
            {
                name: '添加权限',
                path: 'add',
                component: require('../views/permission/Add')
            },
            {
                name: '编辑权限',
                path: 'edit/:id',
                component: require('../views/permission/Edit'),
                display: false,
            }
        ]
    },
    {
        name: '角色管理',
        path: '/role',
        component: require('../components/CkBody'),
        icon: 'el-icon-document',
        children: [
            {
                name: '角色列表',
                path: 'index',
                component: require('../views/role/Index')
            },
            {
                name: '添加角色',
                path: 'add',
                component: require('../views/role/Add')
            },
            {
                name: '修改角色',
                path: 'edit/:id',
                component: require('../views/role/Edit'),
                display: false,
            }
        ]
    }
    ]

export default new Router({
    // mode: 'history', // require service support
    scrollBehavior: () => ({ y: 0 }),
    routes: constantRouterMap
})