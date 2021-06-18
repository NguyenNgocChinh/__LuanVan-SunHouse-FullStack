import colors from 'vuetify/es5/util/colors'
import vi from './locale/vi'
export default {
    ssr: false,
    target: 'static',
    // generate: {
    //     fallback: true,
    // },

    // Global page headers: https://go.nuxtjs.dev/config-head
    head: {
        titleTemplate: 'SUNHOUSE',
        title: 'SUNHOUSE',
        htmlAttrs: {
            lang: 'vi',
        },
        meta: [
            { charset: 'utf-8' },
            {
                name: 'viewport',
                content: 'width=device-width, initial-scale=1',
            },
            { hid: 'description', name: 'description', content: '' },
        ],
        link: [
            { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
            { rel: 'stylesheet', href: 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css' },
        ],
        script: [
            {
                src: 'https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js',
                type: 'text/javascript',
            },

            {
                src: '/notify.js',
                type: 'text/javascript',
            },
            {
                src: 'https://cdn.onesignal.com/sdks/OneSignalSDK.js',
                type: 'text/javascript',
            },
            { src: '/jquery-3.6.0.min.js' },
        ],
    },
    router: {
        // middleware: 'auth',
    },
    // Global CSS: https://go.nuxtjs.dev/config-css
    css: ['~/assets/css/formatToast.css', '~/assets/css/formatGlobal.css'],

    // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
    plugins: [
        { src: '~/plugins/spinners.js', ssr: false },
        { src: '~/plugins/rules.js', ssr: false },
        { src: '~/plugins/lodash.js', ssr: false },
        { src: '~plugins/leaflet.js', ssr: false },
        { src: '~plugins/sweetAlert.js', ssr: false },
        { src: '~plugins/moment.js', ssr: false },
        { src: '~/plugins/echo.js', ssr: false },
    ],
    // Auto import components: https://go.nuxtjs.dev/config-components
    components: true,

    // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
    buildModules: [
        // '@nuxtjs/eslint-module',
        '@nuxtjs/vuetify',
        ['@nuxtjs/laravel-echo'],
    ],
    // echo: {
    //     plugins: [],
    // },

    modules: ['@nuxtjs/axios', '@nuxtjs/auth-next', '@nuxtjs/toast'],
    axios: {
        credentials: true,
    },

    auth: {
        strategies: {
            laravelSanctum: {
                provider: 'laravel/sanctum',
                url: process.env.APP_URL,
                endpoints: {
                    login: {
                        url: '/login',
                        method: 'post',
                        propertyName: false,
                    },
                    logout: { url: '/logout' },
                    user: {
                        url: '/user',
                        method: 'get',
                        propertyName: false,
                    },
                    csrf: {
                        url: '/sanctum/csrf-cookie',
                    },
                },

                redirect: {
                    login: '/login',
                    logout: '/',
                    home: '/',
                },
            },
        },
        redirect: {
            login: '/login',
            logout: '/',
            callback: '/login',
            home: '/',
        },
    },

    loading: '~/components/Loading.vue',
    toast: {
        position: 'top-right',
        duration: 2000,
        action: {
            text: 'Đóng',
            onClick: (e, toastObject) => {
                toastObject.goAway(0)
            },
        },
        theme: 'outline',
        keepOnHover: true,
    },
    // Vuetify module configuration: https://go.nuxtjs.dev/config-vuetify
    vuetify: {
        customVariables: ['~/assets/variables.scss'],
        treeShake: true,
        lang: {
            locales: { vi },
            current: 'vi',
        },
        theme: {
            dark: false,
            themes: {
                light: {
                    primary: colors.blue.darken2,
                    accent: colors.grey.darken3,
                    secondary: colors.amber.darken3,
                    info: colors.teal.lighten1,
                    warning: colors.amber.base,
                    error: colors.deepOrange.accent4,
                    success: colors.green.accent3,

                    sunhouse_primary: '#3CB372',
                    sunhouse_secondary: '#2C9494',
                    sunhouse_pinkLinght: '#FBB2D2',
                    sunhouse_pinkDeep: '#FF9CC7',
                    sunhouse_darkSky: '#23717D',
                },
            },
        },
    },

    // Build Configuration: https://go.nuxtjs.dev/config-build
    build: {},
}
