import colors from 'vuetify/es5/util/colors'

export default {
    // Disable server-side rendering: https://go.nuxtjs.dev/ssr-mode
    ssr: false,
    // Target: https://go.nuxtjs.dev/config-target
    target: 'static',

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
        link: [{ rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }],
        script: [{ src: 'https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js', type: 'text/javascript' }],
    },
    router: {
        // middleware: 'checkAdmin',
    },
    // Global CSS: https://go.nuxtjs.dev/config-css
    css: [],

    // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
    plugins: [{ src: '@/plugins/spinners.js', ssr: false }],

    // Auto import components: https://go.nuxtjs.dev/config-components
    components: true,

    // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
    buildModules: [
        // '@nuxtjs/eslint-module',
        '@nuxtjs/vuetify',
    ],

    // Modules: https://go.nuxtjs.dev/config-modules
    modules: ['@nuxtjs/axios', '@nuxtjs/auth-next', '@nuxtjs/toast'],
    // Axios module configuration: https://go.nuxtjs.dev/config-axios
    axios: {
        // proxy: true,
        credentials: true,
    },

    auth: {
        strategies: {
            laravelSanctum: {
                provider: 'laravel/sanctum',
                url: process.env.APP_URL,

                cookie: {
                    // (optional) If set we check this cookie exsistence for loggedIn check
                    name: 'XSRF-TOKEN',
                },
                endpoints: {
                    login: { url: '/api/auth/login', method: 'post', propertyName: false },
                    logout: { url: '/api/auth/logout' },
                    user: { url: '/api/auth/user', method: 'get', propertyName: false },
                    csrf: {
                        url: '/sanctum/csrf-cookie',
                    },
                },

                redirect: {
                    login: '/login',
                    logout: '/',
                    home: '/',
                },
                user: {
                    property: false,
                },
            },
            google: {
                responseType: 'code',
                clientId: '824756884382-m5p5icl9lgeqtmd9lmftj1m5moho6cuo.apps.googleusercontent.com',
                accessType: 'offline',
                codeChallengeMethod: 'S256',
                grantType: 'authorization_code',
                redirectUri: 'http://localhost:3000/login',
            },
        },
        redirect: {
            login: '/login',
            logout: '/',
            callback: '/login',
            home: '/',
        },
    },
    // loading: {
    //     color: '#3CB372',
    //     failedColor: 'red',
    //     height: '5px',
    //     continuous: true,
    // },
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
        theme: 'outline',
        keepOnHover: true,
    },
    // Vuetify module configuration: https://go.nuxtjs.dev/config-vuetify
    vuetify: {
        customVariables: ['~/assets/variables.scss'],
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
