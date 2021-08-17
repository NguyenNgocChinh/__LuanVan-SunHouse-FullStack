window.OneSignal = window.OneSignal || []
// eslint-disable-next-line no-undef
OneSignal.push(function () {
    // eslint-disable-next-line no-undef
    OneSignal.init({
        appId: process.env.NODE_ENV !== 'production' ? process.env.ONESIGNAL_DEV : process.env.ONESIGNAL_PROD,
    })
})
