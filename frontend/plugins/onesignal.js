export default function ({ $config }) {
    window.OneSignal = window.OneSignal || []
    // eslint-disable-next-line no-undef
    OneSignal.push(function () {
        // eslint-disable-next-line no-undef
        OneSignal.init({
            appId: process.env.NODE_ENV !== 'production' ? $config.onesignal.dev : $config.onesignal.dev, // prod
        })
    })
}
