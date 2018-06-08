import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export const constantRouterMap = [
    {
        name: '个人中心',
        path: '/',
        component: require('../views/Index'),
    },
    {
        name: '文章管理',
        path: '/article',
        component: require('../components/CkBody'),
        children: [
            {
                name: '文章列表',
                path: 'index',
                component: require('../views/article/Index'),
            },
            {
                name: '创建文章',
                path: 'add',
                component: require('../views/article/Add'),
            },
            {
                name: '修改文章',
                path: 'edit/:id',
                component: require('../views/article/Edit'),
                display: false,
            },
        ],
    },
    {
        name: '类别管理',
        path: '/category',
        component: require('../components/CkBody'),
        children: [
            {
                name: '类别列表',
                path: 'index',
                component: require('../views/category/Index'),
            },
            {
                name: '创建类别',
                path: 'add',
                component: require('../views/category/Add'),
            },
            {
                name: '修改类别',
                path: 'edit/:id',
                component: require('../views/category/Edit'),
                display: false,
            },
        ],
    },
    {
        name: '标签管理',
        path: '/tag',
        component: require('../components/CkBody'),
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
        name: '用户管理',
        path: '/user',
        component: require('../components/CkBody'),
        children: [
            {
                name: '用户列表',
                path: 'index',
                component: require('../views/user/Index'),
            },
            {
                name: '修改用户',
                path: 'edit/:user_id',
                component: require('../views/user/Edit'),
                display: false,
            },
        ]
    },
    {
        name: '文件管理',
        path: '/file',
        component: require('../components/CkBody'),
        children: [
            {
                name: '单个图片上传',
                path: 'image-single',
                component: require('../views/file/image'),
            },
        ]
    },
    {
        name: '角色管理',
        path: '/role',
        component: require('../components/CkBody'),
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
            }
        ]
    }
    ]

export default new Router({
    // mode: 'history', // require service support
    scrollBehavior: () => ({ y: 0 }),
    routes: constantRouterMap
})