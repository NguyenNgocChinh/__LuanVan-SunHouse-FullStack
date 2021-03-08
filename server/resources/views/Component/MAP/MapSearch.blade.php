<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css" />
<style>
    #mapwrap {
        width: 100%;
        height: 600px;
        height: 100vh;
        border: 1px solid #333;
        position: relative;
        overflow: hidden;
    }

    #leafletmap {
        width: 100%;
        height: 600px;
        height: 100vh;
    }

    #toolbar {
        background: rgba(255, 255, 255, 1);
        opacity: .6;
        width: 300px;
        height: 600px;
        height: 100vh;
        position: absolute;
        left: -300px;
        z-index: 1;
        transition: .5s left;
        padding: 20px;
        box-sizing: border-box;
    }

    #toolbar.open {
        left: 0;
        opacity: .95;
    }

    #toolbar .hamburger {
        height: 100px;
        width: 25px;
        background: #000;
        box-shadow: 1px 0 2px rgba(0, 0, 0, .3);
        position: absolute;
        right: -25px;
        top: 40%;
        border-top-right-radius: 3px;
        border-bottom-right-radius: 3px;
        border: 1px solid #333;
        cursor: pointer;
    }

    .hamburger span {
        color: #fff;
        display: inline-block;
        position: relative;
        transform: rotate(90deg);
        top: 39px;
        left: -21px;
    }

    #tourstops {
        overflow-y: scroll;
        max-height: 95vh;

    }

    #toolbar ul {
        margin: 0;
        padding: 0;
    }

    #toolbar li {
        list-style-type: none;
        border-bottom: 1px solid #ccc;
        padding: 6px 3px;
        cursor: pointer;
    }

    #toolbar li:hover {
        color: #666;
    }

    .notify-icon span {
        display: inline-block;
        border: 1px solid orange;
        border-radius: 50%;
        height: 24px;
        width: 24px;
        animation: pulse .6s 4 forwards;
        transform-origin: center center;
    }

    @keyframes pulse {
        0% {
            transform: scale(5.5);
            opacity: .2;
        }

        50% {
            opacity: .8;
        }

        100% {
            transform: scale(.1);
            opacity: 1;
        }
    }

</style>



<div id="mapwrap">
    <div id="toolbar">
        <div class="hamburger">
            <span>Tìm&nbsp;Kiếm</span>
        </div>
        <div id="tourstops">
            <h2>Tìm kiếm</h2>
            <ul>
            </ul>
        </div>
    </div>
    <div id="leafletmap"></div>
</div>




<script src="https://unpkg.com/leaflet-geosearch@3.1.0/dist/geosearch.umd.js"></script>
<script>
    $('#toolbar .hamburger').on('click', function() {
        $(this).parent().toggleClass('open');
    });
    var mymap = L.map('leafletmap', {
        zoomControl: false,
    });
    mymap.scrollWheelZoom.disable();
    var mapTiles = L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}@2x.png?key=uXpXh7cCekRxZCcvL34I', {
        maxZoom: 19,

        attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>'
    });

    mapTiles.addTo(mymap);
    mymap.setView([10.7379, 106.67826], 10); //18
    new L.Control.Zoom({
        position: 'topright'
    }).addTo(mymap);

    var buildingLayers = L.layerGroup().addTo(mymap);

    if (mymap.getSize().x < 768) {
        $('#toolbar').removeClass('open');
    }


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
    mymap.addControl(search);


    mymap.on('geosearch/marker/dragend', function(marker, event) {
        position = marker.location;
        var x = position.lat;
        var y = position.lng;
        console.log(x + "  " + y);

        $.get('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + x + '&lon=' + y, function(
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
        });
    });



    // function onMapClick(e) {
    //     if (marker) { // check
    //         mymap.removeLayer(marker); // remove
    //     }
    //     marker = new L.marker(e.latlng, {
    //         draggable: 'true'
    //     });
    //     var lat_lng = marker.getLatLng();
    //     marker.on('dragend', function(event) {
    //         var marker = event.target;
    //         var position = marker.getLatLng();
    //         marker.setLatLng(new L.LatLng(position.lat, position.lng), {
    //             draggable: 'true'
    //         });
    //         mymap.panTo(new L.LatLng(position.lat, position.lng))
    //         lat_lng = marker.getLatLng();
    //         console.log(lat_lng)
    //     });
    //     mymap.addLayer(marker);
    // };

    // mymap.on('click', onMapClick);

</script>
