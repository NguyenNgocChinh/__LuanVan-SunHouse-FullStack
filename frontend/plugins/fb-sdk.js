import Vue from 'vue'

// eslint-disable-next-line camelcase
const vue_fb = {}
vue_fb.install = function install(Vue, options) {
    ;(function (d, s, id) {
        var js
        var fjs = d.getElementsByTagName(s)[0]
        if (d.getElementById(id)) {
            return
        }
        js = d.createElement(s)
        js.id = id
        js.src = '//connect.facebook.net/en_US/sdk.js'
        fjs.parentNode.insertBefore(js, fjs)
        console.log('setting fb sdk')
    })(document, 'script', 'facebook-jssdk')

    window.fbAsyncInit = function onSDKInit() {
        // eslint-disable-next-line no-undef
        FB.init(options)
        // eslint-disable-next-line no-undef
        FB.AppEvents.logPageView()
        // eslint-disable-next-line no-undef
        Vue.FB = FB
        console.log('set vue = fb')
        window.dispatchEvent(new Event('fb-sdk-ready'))
    }
    Vue.FB = undefined
}

Vue.use(vue_fb, {
    appId: '592073171328563',
    autoLogAppEvents: true,
    xfbml: true,
    version: 'v2.9',
})
