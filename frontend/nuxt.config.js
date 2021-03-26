import colors from 'vuetify/es5/util/colors'

export default {
    // Disable server-side rendering: https://go.nuxtjs.dev/ssr-mode
    ssr: true,
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
        link: [
            { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
            // {
            //     rel: 'stylesheet',
            //     href: 'https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css',
            // },
        ],
    },

    // Global CSS: https://go.nuxtjs.dev/config-css
    css: [],

    // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
    plugins: [],

    // Auto import components: https://go.nuxtjs.dev/config-components
    components: true,

    // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
    buildModules: [
        // https://go.nuxtjs.dev/eslint
        '@nuxtjs/eslint-module',
        // https://go.nuxtjs.dev/vuetify
        '@nuxtjs/vuetify',
    ],

    // Modules: https://go.nuxtjs.dev/config-modules
    modules: ['@nuxtjs/axios', '@nuxtjs/auth-next'],

    // Axios module configuration: https://go.nuxtjs.dev/config-axios
    axios: {
        baseURL: 'https://api.sunhouse.stuesports.info/api',
    },
    auth: {
        redirect: {
            callback: '/', // sau khi login sẽ chuyển hướng về đây
        },
        strategies: {
            laravelPassport: {
                provider: 'laravel/passport',
                grant_type: 'password',
                endpoints: {
                    userInfo: process.env.USER_INFO_URL,
                },
                url: process.env.API_URL,
                clientId: process.env.CLIENT_ID,
                clientSecret: process.env.CLIENT_SECRET,
            },
            local: {
                endpoints: {
                    login: { url: process.env.USER_LOGIN_URL, method: 'post', propertyName: 'token' },
                    logout: false,
                    user: { url: process.env.USER_INFO_URL, method: 'get', propertyName: false },
                },
            },
        },
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
