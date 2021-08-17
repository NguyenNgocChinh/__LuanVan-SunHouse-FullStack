<template>
    <l-map id="map" ref="map" :zoom="zoom" :center="center">
        <l-tile-layer :url="layers.url" :subdomains="layers.subdomains" :attribution="layers.attribution" />

        <l-control position="topleft" style="border-radius: 0.1em">
            <div style="border: 2px solid rgba(0, 0, 0, 0.2)">
                <v-btn color="white" class="pa-0" style="width: 30px; height: 30px; min-width: 30px" @click="findMyLocationOnMap">
                    <v-icon v-if="!isFound" size="22" color="blue darken-1">mdi-map-marker-outline</v-icon>

                    <v-icon v-else size="22" color="blue darken-3">mdi-map-marker</v-icon>
                </v-btn>
            </div>
        </l-control>
        <l-marker v-if="marker != null" ref="marker" :draggable="true" :lat-lng.sync="marker" @add="openPopup">
            <l-popup ref="popup" :content="diachicuthe"></l-popup>
        </l-marker>
    </l-map>
</template>

<script>
import { GeoSearchControl, OpenStreetMapProvider } from 'leaflet-geosearch'
export default {
    name: 'MapLeafLeft',
    data: () => {
        return {
            marker: null,
            zoom: 14,
            center: [100, 100],
            isFound: false,
            layers: {
                url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            },
        }
    },
    head: {
        link: [
            {
                rel: 'stylesheet',
                href: 'https://unpkg.com/leaflet-geosearch@2.6.0/assets/css/leaflet.css',
            },
            {
                rel: 'stylesheet',
                href: 'https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css',
            },
        ],
        script: [{ src: 'https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.umd.js' }],
    },
    mounted() {
        this.$nextTick(() => {
            const map = this.$refs.map.mapObject

            const search = new GeoSearchControl({
                provider: new OpenStreetMapProvider(),
                style: 'bar',
                searchLabel: 'Nhập địa chỉ ...',
                animateZoom: true,
                autoClose: true,
                keepResult: true,
                showMarker: false,
                // maxMarkers: 1,
            })

            map.addControl(search)

            map.on('geosearch/showlocation', (result) => {
                this.marker = [result.location.y, result.location.x]
                this.toadoX = result.location.y
                this.toadoY = result.location.x
                if ('label' in result.location) {
                    const diaChi = result.location.label.split(',')
                    for (let i = 0; i < diaChi.length; i++) {
                        const checkResult2 = /\d{5}/.test(diaChi[i])
                        if (checkResult2) diaChi.splice(i, 1)
                    }
                    this.diachicuthe = diaChi.join(',')
                    this.getSelectOnComboBox(this.diachicuthe)
                } else {
                    this.setDisplayNameFromlatLng(result.location.x, result.location.y)
                }
            })

            map.on('click', (event) => {
                this.toadoX = event.latlng.lat
                this.toadoY = event.latlng.lng
                this.marker = [this.toadoX, this.toadoY]
                this.center = [this.toadoX, this.toadoY]

                this.setDisplayNameFromlatLng(this.toadoX, this.toadoY).then(() => {
                    this.$refs.marker.mapObject.on('dragend', (event) => {
                        const marker = event.target
                        const position = marker.getLatLng()
                        this.center = [position.lat, position.lng]
                        this.toadoX = position.lat
                        this.toadoY = position.lng
                        this.marker = [this.toadoX, this.toadoY]
                        this.setDisplayNameFromlatLng(position.lat, position.lng)
                    })
                })
            })
            map.on('geosearch/marker/dragend', (result) => {
                this.toadoX = result.location.lat
                this.toadoY = result.location.lng

                if ('label' in result.location) {
                    this.diachicuthe = result.location.label
                } else {
                    this.loadingDiaChiCuThe = true
                    this.center = [this.toadoX, this.toadoY]
                    this.setDisplayNameFromlatLng(this.toadoX, this.toadoY)
                }
            })

            // do we support geolocation
            if (!('geolocation' in navigator)) {
                alert('Dịch vụ định vị của máy tính bạn không hoạt động.')
                return
            }
            // get position
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    this.center = [pos.coords.latitude, pos.coords.longitude]
                },
                (err) => {
                    console.log(err)
                }
            )
        })
    },
    methods: {
        getSelectOnComboBox(address) {
            const diaChi = address.split(',')

            const indexTP = this._.findIndex(this.listThanhPho, { name: diaChi[diaChi.length - 2].trim() })
            this.thanhpho = this.listThanhPho[indexTP]
        },
        setViewFormAddress(address, zoom = 13) {
            if (address !== '' || address != null) {
                this.$nuxt.$axios.$get('https://nominatim.openstreetmap.org/search?q=' + address + '&format=json&limit=1').then(async (res) => {
                    if (res.length === 0) {
                        this.$refs.modalPleaseMoveToMarker.open()
                    } else {
                        const lat = res[0].lat
                        const lng = res[0].lon
                        this.toadoX = lat
                        this.toadoY = lng
                        await this.$refs.map.mapObject.flyTo([lat, lng], zoom)
                        this.marker = [lat, lng]
                    }
                })
            }
        },
        async setDisplayNameFromlatLng(lat, lng) {
            this.loadingDiaChiCuThe = true
            await this.$nuxt.$axios
                .$get('https://nominatim.openstreetmap.org/reverse?lat=' + lat + '&lon=' + lng + '&format=json&limit=1')
                .then((result) => {
                    if (result.display_name != null) {
                        const diaChi = result.display_name.split(',')
                        for (let i = 0; i < diaChi.length; i++) {
                            const checkResult = /\(?([0-9]{2})\)?([ .-]?)([0-9]{3})\2([0-9]{3})?([ .-]?)([0-9]{3})/.test(diaChi[i])

                            const checkResult2 = /\d{5}/.test(diaChi[i])
                            if (checkResult) {
                                diaChi.splice(i, 1)
                            }
                            if (checkResult2) {
                                diaChi.splice(i, 1)
                            }
                        }
                        const displayName = diaChi.join(',')
                        this.diachicuthe = displayName
                        const glass = document.querySelector('.glass ')
                        glass.value = displayName

                        this.getSelectOnComboBox(displayName)
                    }
                })
                .finally(() => {
                    this.loadingDiaChiCuThe = false
                })
        },
        async getAllLoai() {
            try {
                const loai = await this.$axios.$get('/loai')
                this.items = loai
            } catch (e) {
            } finally {
                this.loadingLoai = false
            }
        },
        findMyLocationOnMap() {
            if (!this.isFound) {
                navigator.geolocation.getCurrentPosition(
                    async (pos) => {
                        this.toadoX = pos.coords.latitude
                        this.toadoY = pos.coords.longitude
                        this.center = [this.toadoX, this.toadoY]
                        this.marker = this.center
                        this.$refs.map.mapObject.flyTo([pos.coords.latitude, pos.coords.longitude], 15)
                        this.isFound = true
                        await this.setDisplayNameFromlatLng(this.toadoX, this.toadoY)
                        this.$refs.marker.mapObject.on('dragend', (event) => {
                            const marker = event.target
                            const position = marker.getLatLng()
                            this.toadoX = position.lat
                            this.toadoY = position.lng
                            this.center = [position.lat, position.lng]
                            this.setDisplayNameFromlatLng(position.lat, position.lng)
                        })
                    },
                    (err) => {
                        this.isFound = false
                        console.log(err)
                    }
                )
            } else {
                this.marker = null
                this.isFound = false
            }
        },
    },
}
</script>

<style scoped></style>
