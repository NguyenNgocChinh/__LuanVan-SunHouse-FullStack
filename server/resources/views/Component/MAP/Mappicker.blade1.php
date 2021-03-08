<!-- LEAFLET -->
<link rel="stylesheet" href="{{ asset('css/leaflet.css') }}"/>
<script src="{{ asset('js/leaflet.js') }}"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css"/>
<!-- locate leaflet -->
<link rel="stylesheet" href="{{ asset('css/L.Control.Locate.min.css') }}"/>
<style>
    #mapwrap {
        width: 100%;
        height: 600px;
        height: 70vh;
        border: 1px solid #333;
        position: relative;
        overflow: hidden;
    }

    #leafletmap {
        width: 100%;
        height: 600px;
        height: 100vh;
    }

</style>

<div id="mapwrap">
    <div id="leafletmap"></div>
</div>


<script src="https://unpkg.com/leaflet-geosearch@3.1.0/dist/geosearch.umd.js"></script>
<script src="{{ asset('js/L.Control.Locate.min.js') }}" charset="utf-8"></script>


<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css"/>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
    var map = L.map('leafletmap', {
        zoomControl: false,
    });
    map.scrollWheelZoom.disable();
    var mapTiles = L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}@2x.png?key=uXpXh7cCekRxZCcvL34I', {
        maxZoom: 19,

        attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>'
    });

    mapTiles.addTo(map);
    map.setView([10.7379, 106.67826], 1); //18
    new L.Control.Zoom({
        position: 'topright'
    }).addTo(map);

    var marker;
    const search = new GeoSearch.GeoSearchControl({
        provider: new GeoSearch.OpenStreetMapProvider({
            params: {
                email: 'karikname1999@gmail.com', // auth for large number of requests
            },

        }),
        style: 'bar',
        autoComplete: true, // optional: true|false  - default true
        autoCompleteDelay: 200, // optional: number      - default 250
        showMarker: true, // optional: true|false  - default true
        showPopup: false, // optional: true|false  - default false
        marker: {
            icon: new L.Icon.Default(),
            draggable: true,
        },
        popupFormat: ({
                          query,
                          result
                      }) => result.label, // optional: function    - default returns result label
        maxMarkers: 1, // optional: number      - default 1
        retainZoomLevel: false, // optional: true|false  - default false
        animateZoom: true, // optional: true|false  - default true
        autoClose: true, // optional: true|false  - default false
        searchLabel: 'Nhập địa chỉ cần tìm kiếm',
        keepResult: true, // optional: true|false  - default false
        updateMap: true, // optional: true|false  - default true
    });
    map.addControl(search);
    // mylocate
    var lc = L.control
        .locate({
            position: "topright",
            strings: {
                title: "Cho tôi biết tôi đang ở đâu!",
            },
            flyTo: true,
            cacheLocation: true,
            locateOptions: {
                enableHighAccuracy: true,
            },
        })
        .addTo(map);

    //watermark
    L.Control.Watermark = L.Control.extend({
        onAdd: function (map) {
            var img = L.DomUtil.create("img");
            img.src = "{{ asset('favicon.svg') }}";
            img.style.width = "150px";
            img.style.margin = "0 0 100px -32px";
            return img;
        },
    });
    L.control.watermark = function (opts) {
        return new L.Control.Watermark(opts);
    };
    L.control.watermark({
        position: "bottomleft"
    }).addTo(map);


    //INPUT DIA CHi
    map.on('locationfound', function (ev) {
        if (!marker) {
            marker = L.marker(ev.latlng);
        } else {
            map.removeLayer(marker);
            //marker.setLatLng(ev.latlng);
        }
        var x = marker._latlng.lat;
        var y = marker._latlng.lng;
        getX_Y(x, y);
        $.get('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + x + '&lon=' + y, function (
            data) {
            var tendaidien = data.address.amenity;
            var display_name = data.display_name;
            var display_name = data.display_name;
            console.log(data)

            var sonha = data.address.house_number;
            if (sonha === undefined)
                sonha = '';

            $('.glass').val(display_name);
            if ($('#diachi') != undefined) {
                $('#diachi').val(
                    `${tendaidien} ${sonha} ${data.address.road} - ${data.address.neighbourhood} - ${data.address.suburb} - ${data.address.country}`
                );
            }
        });

    })

    // geocoder = new L.Control.Geocoder.Nominatim();
    // var yourQuery =
    //     `${tendaidien} ${sonha} ${data.address.road} - ${data.address.neighbourhood} - ${data.address.suburb}`;
    // console.log(yourQuery)
    // geocoder.geocode(yourQuery, function(results) {
    //     console.log(results)
    //     latLng = new L.LatLng(results[0].center.lat, results[0].center.lng);
    //     marker = new L.Marker(latLng);
    //     map.addLayer(marker);
    // });

    //CHANG LABLE

    $('.glass').change(function (e) {

        geocoder = new L.Control.Geocoder.Nominatim();
        var yourQuery = $('.glass').val();
        geocoder.geocode(yourQuery, function (results) {
            if (results[0].name != undefined) {
                $('#diachi').val(results[0].name)
                getX_Y(results[0].center.lat, results[0].center.lng);
            }
        });
    });


    map.on('geosearch/marker/dragend', function (marker, event) {
        position = marker.location;
        var x = position.lat;
        var y = position.lng;
        getX_Y(x, y);
        $.get('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + x + '&lon=' + y, function (
            data) {
            var tendaidien = data.address.amenity;

            if (tendaidien === undefined)
                tendaidien = '';
            else
                tendaidien = tendaidien + " - ";
            var sonha = data.address.house_number;
            if (sonha === undefined)
                sonha = '';

            console.log(data.address);

            $('.glass').val(
                `${tendaidien} ${sonha} ${data.address.road} - ${data.address.neighbourhood} - ${data.address.suburb} - ${data.address.country}`
            );
            if ($('#diachi') != undefined) {
                $('#diachi').val(
                    `${tendaidien} ${sonha} ${data.address.road} - ${data.address.neighbourhood} - ${data.address.suburb} - ${data.address.country}`
                );
            }
        });
    });
    lc.start();

    function getX_Y(x, y) {
        if (x != undefined && y != undefined) {
            $('#toadoX').val(x);
            $('#toadoY').val(y);
        }
    }

</script>
