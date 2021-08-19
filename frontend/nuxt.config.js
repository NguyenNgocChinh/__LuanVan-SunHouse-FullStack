import colors from 'vuetify/es5/util/colors'
import vi from './locale/vi'
// eslint-disable-next-line nuxt/no-cjs-in-config
const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin')
export default {
    ssr: false,
    target: 'static',
    // target: 'server',
    // fetchOnServer: false,
    generate: {
        fallback: true,
        crawler: false,
    },

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
            { hid: 'description', name: 'description', content: 'Trang mua bán bất động sản cho người Việt' },
        ],
        link: [
            { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
            { rel: 'stylesheet', href: '/css/animate.min.css' },
            { rel: 'stylesheet', href: '/css/boxicons.min.css' },
        ],
        script: [
            {
                src: '/js/OneSignalSDK.js',
                type: 'text/javascript',
            },
            { src: '/js/jquery-3.6.0.min.js', type: 'text/javascript' },
            {
                src: '/js/lodash.min.js',
                type: 'text/javascript',
            },
        ],
    },
    router: {
        // middleware: 'auth',
    },
    // Global CSS: https://go.nuxtjs.dev/config-css
    css: ['~/assets/css/formatToast', '~/assets/css/formatGlobal'],

    // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
    plugins: [
        { src: '~/plugins/callapi.js', ssr: false },
        { src: '~/plugins/spinners.js', ssr: false, mode: 'client' },
        { src: '~/plugins/rules.js', ssr: false },
        { src: '~/plugins/lodash.js', ssr: false },
        { src: '~/plugins/moment.js', ssr: true },
        { src: '~/plugins/echo.js', ssr: false },
        { src: '~/plugins/axios.js', ssr: true },
        { src: '~/plugins/fb-sdk.js', ssr: false },
        { src: '~/plugins/sanitize.js', ssr: false },
        { src: '~/plugins/sweetAlert.js', ssr: false },
        { src: '~/plugins/onesignal.js', ssr: false },
    ],
    // Auto import components: https://go.nuxtjs.dev/config-components
    components: true,

    // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
    buildModules: [
        // '@nuxtjs/eslint-module',
        '@nuxtjs/vuetify',
        // ['@nuxtjs/laravel-echo'],
    ],
    // echo: {
    //     plugins: [],
    // },

    modules: ['@nuxtjs/axios', '@nuxtjs/auth-next', '@nuxtjs/toast'],
    axios: {
        credentials: true,
        baseURL: process.env.APP_URL,
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
                        propertyName: 'user',
                    },
                    logout: { url: '/logout' },
                    user: {
                        url: '/user',
                        method: 'get',
                        propertyName: '',
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
            callback: false,
            home: '/',
        },
    },

    loading: '@/components/Loading.vue',
    toast: {
        position: 'top-right',
        duration: 2000,
        action: {
            text: 'Đóng',
            onClick: (e, toastObject) => {
                toastObject.goAway(0)
            },
        },
        // theme: 'outline',
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

                    sunhouse_red1: '#c70512',
                    sunhouse_red2: '#dd2d4a',
                    sunhouse_blue1: '#005fb8',
                    sunhouse_blue2: '#477998',
                    sunhouse_white: '#f4f4f4',
                    sunhouse_grey: '#bbbfca',
                    sunhouse_grey2: '#3b383a',
                    sunhouse_black: '#040101',
                },
            },
        },
    },

    // Build Configuration: https://go.nuxtjs.dev/config-build
    build: {
        extend(config, { isClient, isDev }) {
            config.optimization.splitChunks.maxSize = 30000
        },
        devtool: 'inline-source-map',
        // analyze: true,
        cssSourceMap: false,
        cache: true, // try
        minimize: true,
        splitChunks: {
            chunks: 'all',
            automaticNameDelimiter: '.',
            name: undefined,
            cacheGroups: {},
        },
        plugin: [new VuetifyLoaderPlugin()],
    },
    publicRuntimeConfig: {
        baseUrl: process.env.BASE_URL,
        serverUrl: process.env.SERVER_URL,
        uploadUrl: process.env.UPLOAD_URL,
        googleLoginUrl: process.env.GOOGLE_LOGIN_URL,
        facebookLoginUrl: process.env.FACEBOOK_LOGIN_URL,

        recaptcha: {
            siteKey: process.env.RECAPTCHA_SITEKEY,
            secret: process.env.RECAPTCHA_SECRET,
        },
        onesignal: {
            dev: process.env.ONESIGNAL_DEV,
            prod: process.env.ONESIGNAL_PROD,
        },
    },
    // render: {
    //     // bundleRenderer: {
    //     //     shouldPreload: (file, type) => {
    //     //         return ['script', 'style', 'font'].includes(type)
    //     //     },
    //     // },
    //     // resourceHints: true,
    // },
}
