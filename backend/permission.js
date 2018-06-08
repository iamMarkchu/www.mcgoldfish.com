import router from './router/routes'
import NProgress from 'nprogress' // progress bar
import 'nprogress/nprogress.css'// progress bar style

router.beforeEach((to, from, next) => {
    NProgress.start()
    next()
})

router.afterEach(() => {
    NProgress.done() // finish progress bar
})