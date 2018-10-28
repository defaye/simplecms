
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

window.Vue = require('vue')

import Vuex from 'vuex'

Vue.use(Vuex)

require('./fontawesome')

require('./components')


import autosize from 'autosize'
Vue.directive('autosize', el => {
    autosize(el)
})

Vue.component('notifications', require('./components/Notifications.vue'))
Vue.component('navigation', require('./components/Navigation.vue'))
Vue.component('responsive-image', require('./components/ResponsiveImage.vue'))
Vue.component('carousel', require('./components/Carousel.vue'))

import storeConfiguration from './store/configuration'

storeConfiguration.state = Object.assign(storeConfiguration.state, {
    page: undefined
})

storeConfiguration.actions = {
    load(context, path) {
        axios.post('/api/router', {
            path
        }).then(response => {
            let title = response.data.hasOwnProperty('title') ? response.data.title + ' — ***REMOVED*** ***REMOVED***' : (
                response.data.hasOwnProperty('name') ? response.data.name + ' — ***REMOVED*** ***REMOVED***' : '***REMOVED*** ***REMOVED***'
            )
            window.history.pushState(Object.assign({}, response.data), title, path)
            document.title = title
            context.state.page = response.data
            document.querySelector('body').scrollIntoView({ behavior: 'instant', block: 'start' })
        }).catch(error => {
            console.error(e.response.data)
        })
    }
}

const store = new Vuex.Store(storeConfiguration)

const app = new Vue({
    el: '#app',
    store,
    mounted() {
        store.dispatch('load', new URL(window.location.href).pathname)

        window.onpopstate = event => {
            document.title = event.state && event.state.title
            store.state.page = event.state
        }
    }
})
