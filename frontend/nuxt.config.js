import colors from 'vuetify/es5/util/colors'
import vi from './locale/vi'
export default {
    ssr: false,
    target: 'static',
    // fetchOnServer: false,
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
            { hid: 'description', name: 'description', content: 'Trang mua bán bất động sản cho người Việt' },
        ],
        link: [
            { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
            { rel: 'stylesheet', href: '/css/animate.min.css' },
            { rel: 'stylesheet', href: '/css/boxicons.min.css' },
        ],
        script: [
            {
                src: '/js/lodash.min.js',
                type: 'text/javascript',
            },
            {
                src: '/js/OneSignalSDK.js',
                type: 'text/javascript',
            },
            {
                src: '/notify.js',
                type: 'text/javascript',
            },
            { src: '/js/jquery-3.6.0.min.js', type: 'text/javascript' },
        ],
    },
    router: {
        // middleware: 'auth',
    },
    // Global CSS: https://go.nuxtjs.dev/config-css
    css: ['~/assets/css/formatToast.css', '~/assets/css/formatGlobal.css'],

    // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
    plugins: [
        { src: '~/plugins/spinners.js', ssr: false, mode: 'client' },
        { src: '~/plugins/rules.js', ssr: false },
        { src: '~/plugins/lodash.js', ssr: false },
        { src: '~plugins/leaflet.js', ssr: false },
        { src: '~plugins/sweetAlert.js', ssr: false },
        { src: '~plugins/moment.js', ssr: true },
        { src: '~/plugins/echo.js', ssr: false },
        { src: '~/plugins/axios.js', ssr: true },
        { src: '~/plugins/fb-sdk.js', ssr: false },
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
                },
            },
        },
    },

    // Build Configuration: https://go.nuxtjs.dev/config-build
    build: {},
    publicRuntimeConfig: {
        baseUrl: process.env.BASE_URL,
        serverUrl: process.env.SERVER_URL,
        googleLoginUrl: process.env.GOOGLE_LOGIN_URL,
        facebookLoginUrl: process.env.FACEBOOK_LOGIN_URL,
        // baidang
        baidangInfo: process.env.BAIDANG_INFO,
        baidangChoThue: process.env.BAIDANG_CHOTHUE,
        baidangRaoBan: process.env.BAIDANG_RAOBAN,
        baidangNoiBat: process.env.BAIDANG_HOT,
        baidangTimKiem: process.env.BAIDANG_TIMKIEM,
        // users
        users: process.env.USERS,
        userDisable: process.env.USER_DISABLE,
        userEnable: process.env.USER_ENABLE,
    },
    privateRuntimeConfig: {
        apiSecret: process.env.API_SECRET,
        recaptcha: {
            siteKey: process.env.RECAPTCHA_SITEKEY,
            secret: process.env.RECAPTCHA_SECRET,
        },
    },
}
