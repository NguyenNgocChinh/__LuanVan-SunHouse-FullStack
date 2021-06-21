<template>
    <v-container>
        <div style="height: 600px">
            <l-map id="map" ref="map" :zoom="zoom" :center="center">
                <l-tile-layer :url="layers.url" :subdomains="layers.subdomains" :attribution="layers.attribution" />

                <l-control position="topleft" style="border-radius: 0.1em">
                    <div style="border: 2px solid rgba(0, 0, 0, 0.2)">
                        <v-btn
                            color="white"
                            class="pa-0"
                            style="width: 30px; height: 30px; min-width: 30px"
                            @click="findMyLocationOnMap"
                        >
                            <v-icon v-if="!isFound" size="22" color="blue darken-1">mdi-map-marker-outline</v-icon>

                            <v-icon v-else size="22" color="blue darken-3">mdi-map-marker</v-icon>
                        </v-btn>
                    </div>
                </l-control>
                <l-marker v-if="marker != null" ref="marker" :draggable="true" :lat-lng.sync="marker" @add="openPopup">
                    <l-popup ref="popup" :content="diachicuthe"></l-popup>
                </l-marker>
                <l-circle
                    v-if="marker != null"
                    ref="circle"
                    :lat-lng="marker"
                    :radius="circle.radius"
                    :color="circle.color"
                />
            </l-map>
        </div>
    </v-container>
</template>

<script>
import { GeoSearchControl, OpenStreetMapProvider } from 'leaflet-geosearch'
import { LControl, LMap, LMarker, LPopup, LTileLayer, LCircle } from 'vue2-leaflet'

export default {
    components: { LMap, LTileLayer, LControl, LMarker, LPopup, LCircle },
    data: () => {
        return {
            marker: null,
            zoom: 13,
            center: [100, 100],
            isFound: false,
            layers: {
                url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            },
            diachicuthe: undefined,
            toadoX: undefined,
            toadoY: undefined,
            circle: {
                radius: 5000,
                color: 'red',
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
            console.info(this.$refs.circle)
            const search = new GeoSearchControl({
                provider: new OpenStreetMapProvider(),
                style: 'bar',
                searchLabel: 'Nhập địa chỉ ...',
                animateZoom: true,
                autoClose: true,
                keepResult: true,
                showMarker: false,
            })

            map.addControl(search)

            map.on('geosearch/showlocation', (result) => {
                console.log(result)
                this.marker = [result.location.y, result.location.x]
                this.toadoX = result.location.y
                this.toadoY = result.location.x
                if ('label' in result.location) {
                    const diaChi = result.location.label.split(',')
                    for (let i = 0; i < diaChi.length; i++) {
                        const checkResult2 = /\d{5}/.test(diaChi[i])
                        if (checkResult2) diaChi.splice(i, 1)
                    }
                }
            })

            map.on('click', (event) => {
                this.toadoX = event.latlng.lat
                this.toadoY = event.latlng.lng
                this.marker = [this.toadoX, this.toadoY]
                this.center = [this.toadoX, this.toadoY]
            })
            map.on('geosearch/marker/dragend', (result) => {
                this.toadoX = result.location.lat
                this.toadoY = result.location.lng
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
        setViewFormAddress(address, zoom = 13) {
            if (address !== '' || address != null) {
                this.$nuxt.$axios
                    .$get('https://nominatim.openstreetmap.org/search?q=' + address + '&format=json&limit=1')
                    .then(async (res) => {
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
        findMyLocationOnMap() {
            if (!this.isFound) {
                navigator.geolocation.getCurrentPosition(
                    async (pos) => {
                        this.diachicuthe = 'Vị trí của bạn đang ở đây'
                        this.toadoX = pos.coords.latitude
                        this.toadoY = pos.coords.longitude
                        this.center = [this.toadoX, this.toadoY]
                        this.marker = this.center

                        await this.$refs.map.mapObject.flyTo([pos.coords.latitude, pos.coords.longitude], 13)
                        this.isFound = true
                        console.info(this.$refs.circle.mapObject.getBounds())
                        this.$refs.marker.mapObject.on('dragend', (event) => {
                            const marker = event.target
                            const position = marker.getLatLng()
                            this.toadoX = position.lat
                            this.toadoY = position.lng
                            this.center = [position.lat, position.lng]
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
        openPopup(event) {
            this.$nextTick(() => {
                event.target.openPopup()
            })
        },
    },
}
</script>

<style scoped></style>
