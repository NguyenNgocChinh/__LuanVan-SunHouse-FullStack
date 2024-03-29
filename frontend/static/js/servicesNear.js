// using in ChiTietBaiDang
import axios from 'axios'
const API_BING_KEY = 'AlV_4k55Lq1amnv2OxEkXYYV7Tb2x-herLgYbqKsDvOS96Dp3ajO30XtxVu_ZgaU'
const API_BING_KEY2 = 'Anw00y2mhnc85AKvRbu1T_GyW1MDDN-PVp21Dbqoj0YC7n1bDnSSfWg1kz5b7T2r'
const API_BING_KEY3 = 'AquqOGbx9Qd8w6L9ZnSAXKJXNd354grC-8gn6cbcSkDysPjbC_1iL7_X1bUX0sXP'
// https://nominatim.openstreetmap.org/search?q=schools%20in%20180%20Cao%20Lo&format=json
// https://nominatim.openstreetmap.org/search?q=schools%20near%20180%20Cao%20Lo&format=json/
// https://nominatim.openstreetmap.org/?q=' + address + '[bank]&addressdetails=1&format=json&limit=15&countrycodes=vn
export function getTruongHoc(address, postLocate) {
    return new Promise(function (resolve) {
        axios.get('https://nominatim.openstreetmap.org/?q=' + address + '[school]&addressdetails=1&format=json&limit=15').then(async (data) => {
            const result = await processAddNewItem(data.data, postLocate)
            resolve(result)
        })
    })
}

export function getBenhVien(address, postLocate) {
    return new Promise(function (resolve) {
        axios.get('https://nominatim.openstreetmap.org/?q=' + address + '[hospitals]&addressdetails=1&format=json&limit=15').then((data) => {
            processAddNewItem(data.data, postLocate).then(function (list) {
                resolve(list)
            })
        })
    })
}

export function getNganHang(address, postLocate) {
    return new Promise(function (resolve) {
        axios.get('https://nominatim.openstreetmap.org/?q=' + address + '[bank]&addressdetails=1&format=json&limit=15&countrycodes=vn').then((data) => {
            processAddNewItem(data.data, postLocate).then(function (list) {
                resolve(list)
            })
        })
    })
}

async function processAddNewItem(data, postLocate) {
    if (data.length > 0) {
        const top10 = data
            .sort(function (a, b) {
                return a.importance > b.importance ? 1 : -1
            })
            .slice(0, 10)

        var list = []

        await top10.forEach(function (item) {
            if (typeof item.address.amenity !== 'undefined') {
                const amenity = item.address.amenity
                // const schoolLocation = item.lon + ',' + item.lat //f
                const schoolLocation = item.lon + ',' + item.lat
                getDistanceBing(postLocate, schoolLocation, API_BING_KEY).then((distance) => {
                    if (distance === -1) return
                    const split = distance.split('-')
                    list.push({ name: amenity, distance: split[0], time: split[1] })
                })
            }
        })
        return list
    }
}

/// /
/// ////

export function getPostLocation(address) {
    const url = 'https://nominatim.openstreetmap.org/?q=' + address + '&addressdetails=1&format=json&limit=1'
    return new Promise(function (resolve, reject) {
        try {
            axios.get(url).then(function (data) {
                const result = data.data[0]
                if (result) {
                    const x = result.lat
                    const y = result.lon
                    const lngLat = y + ',' + x
                    resolve(lngLat)
                }
                // reject(result)
            })
        } catch (e) {
            reject(e)
        }
    })
}

function getDistance(p1, p2) {
    return new Promise(function (resolve, reject) {
        try {
            console.log('timeing')
            const url = 'https://router.project-osrm.org/route/v1/driving/' + p1 + ';' + p2 + '?exclude=motorway'
            axios
                .get(url)
                .then((result) => {
                    result = result.data.routes[0]
                    const distance = (result.distance / 1000).toFixed(2)
                    if (distance > 10) {
                        return -1
                    }
                    const duration = secondsToHms(result.duration)
                    const kq = distance + ' km ' + ' - ' + duration
                    resolve(kq)
                })
                .catch((e) => {
                    resolve(getDistanceBing(p1, p2, API_BING_KEY))
                })
        } catch (e) {
            reject(e)
        }
    })
}

// LIB
function secondsToHms(d) {
    d = Number(d)
    const h = Math.floor(d / 3600)
    const m = Math.floor((d % 3600) / 60)
    const s = Math.floor((d % 3600) % 60)

    const hDisplay = h > 0 ? h + (h === 1 ? ' giờ ' : ' giờ ') : ''
    const mDisplay = m > 0 ? m + (m === 1 ? ' phút ' : ' phút ') : ''
    const sDisplay = s > 0 ? s + (s === 1 ? ' giây' : ' giây') : ''
    return hDisplay + mDisplay + sDisplay
}

/// GET DISTENCE BING MAP
function getDistanceBing(p1, p2, API_BING_KEY) {
    p1 = p1.split(',').reverse().join(',')
    p2 = p2.split(',').reverse().join(',')
    const url = 'https://dev.virtualearth.net/REST/V1/Routes/Driving?o=json&wp.0=' + p1 + '&wp.1=' + p2 + '&avoid=minimizeTolls&key=' + API_BING_KEY
    return new Promise(function (resolve, reject) {
        try {
            axios
                .get(url)
                .then((data) => {
                    const result = data.data.resourceSets[0].resources[0]
                    console.log('Bing...')
                    let distance = 0
                    let duration = 0

                    if (result.distanceUnit === 'meter') {
                        distance = (result.travelDistance / 1000).toFixed(2)
                    } else distance = (result.travelDistance / 1).toFixed(2)
                    if (distance > 10) {
                        return -1
                    }
                    if (result.durationUnit !== 'Second') {
                        duration = result.travelDuration + ' phút'
                    } else duration = secondsToHms(result.travelDuration)

                    const kq = distance + ' km ' + '- ' + duration
                    resolve(kq)
                })
                .catch((err) => {
                    if (err.response.status !== 404) {
                        p1 = p1.split(',').reverse().join(',')
                        p2 = p2.split(',').reverse().join(',')
                        resolve(getDistanceBing(p1, p2, API_BING_KEY2 || API_BING_KEY3))
                    }
                })
        } catch (e) {
            reject(e)
        }
    })
}
