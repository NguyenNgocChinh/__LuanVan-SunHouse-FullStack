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
    var mapTiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
    });

    mapTiles.addTo(map);

    latLng = new L.LatLng("{{ $baidang->toadoX }}", "{{ $baidang->toadoY }}");
    marker = new L.Marker(latLng, {
        draggable: 'true'
    });
    map.addLayer(marker);


    map.setView([latLng.lat, latLng.lng], 18); //18
    new L.Control.Zoom({
        position: 'topright'
    }).addTo(map);

    var marker;
    const search = new GeoSearch.GeoSearchControl({
        provider: new GeoSearch.OpenStreetMapProvider({
            params: {
                email: 'karikname1999@gmail.com', // auth for large number of requests
                countrycodes: 'vn'
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
                maxZoom: 19,
                enableHighAccuracy: true,
            },
        })
        .addTo(map);


    //SCRIPT

    $(document).ready(async function () {
        await changeAddressInput();
    });
    //CHANG LABLE
    $('.glass').change(function (e) {

        geocoder = new L.Control.Geocoder.Nominatim();
        var yourQuery = $('.glass').val();
        geocoder.geocode(yourQuery, function (results) {
            if (typeof results[0].name != "undefined") {
                $('#diachi').attr('value', results[0].name);
                setToaDo(results[0].center.lat, results[0].center.lng);
            }
        });
    });
    //Tìm thấy trên thanh search
    map.on('geosearch/showlocation', function (e) {
        let x = e.location.x;
        let y = e.location.y;

        //map.flyTo([y, x], 13);

        if (typeof window.marker != "undefined") {
            map.removeLayer(window.marker)
        }

    });
    //Tìm tôi đang ở đâu
    map.on('locationfound', function (ev) {
        $('.leaflet-control-locate-circle.leaflet-interactive').remove()
        let x = ev.latitude;
        let y = ev.longitude;
        map.flyTo([x, y], 10);

    })




    //Thay đổi dữ liệu tại ô địa chỉ
    async function changeAddressInput() {
        let timeoutLoading = null;
        var inputDiaChi = document.getElementById('diachi');
        var oldValue = "";

        if (timeoutLoading) clearTimeout(timeoutLoading);
        timeoutLoading = await setTimeout(function () {
            oldValue = $("#diachi").val();
        }, 1000);
        inputDiaChi.addEventListener('keyup', function (e) {
            //debounce lodash

            let timeout = null;
            if (!timeout) clearTimeout(timeout);
            timeout = setTimeout(async function () {
                let addressInput = e.target.value;
                if (oldValue !== addressInput) {
                    let addressObject = await getAdressByAddress(addressInput);
                    if (typeof addressObject == "undefined") return;
                    let address = await processAddress(addressObject);
                    processToaDo(addressObject)
                    if (typeof address != "undefined") {
                        let notifyAddress = document.getElementById('notifyAddress');
                        if (notifyAddress == null)
                            notifyAddress = createNotify('span', 'notifyAddress', address, 'diachi',);
                        else
                            notifyAddress.innerHTML = "Ý của bạn là: " + address;
                    }
                    console.clear()
                }
            }, 1000)

        })
    }


    //Drag Marker
    async function dragMarker(e) {
        let position = e.target._latlng;
        var x = position.lat;
        var y = position.lng;

        let data = await getAdress(x, y);
        let displayName = data.display_name;
        $('input.glass ').val(displayName)
        //let address = processAddress(data);
        let address = displayName;

        setAddress(address, x, y);

    };



    //SET ĐỊA CHỈ, TỌA ĐỘ
    function setAddress(address, x, y) {
        document.getElementById("diachi").setAttribute('value', address)
        document.getElementById('toadoX').setAttribute('value', x);
        document.getElementById('toadoY').setAttribute('value', y);
    }

    function setToaDo(x, y) {
        document.getElementById('toadoX').setAttribute('value', x);
        document.getElementById('toadoY').setAttribute('value', y);
    }

    async function getAdress(x, y) {
        let result = await $.ajax({
            url: "https://nominatim.openstreetmap.org/reverse?format=jsonv2&addressdetails=1&lat=" + x + "&lon=" + y,
            method: "GET",
            type: "json",
            success: function (data) {
                return data;
            },
            error: function (xhr) {
            }
        });
        return result;
    }

    async function getAdressByAddress(address) {
        let result = await $.ajax({
            url: "https://nominatim.openstreetmap.org/?addressdetails=1&q=" + address + "&format=json&limit=1&countrycodes=vn",
            method: "GET",
            type: "json",
            success: function (data) {
                return data;
            },
            error: function (xhr) {
            }
        });
        return result[0];
    }

    function processAddress(data) {
        //Số nhà
        let house_number = typeof data.address.house_number !== "undefined" ? data.address.house_number : "";
        //Đường
        let road = typeof data.address.road != "undefined" ? " - " + data.address.road : "";
        //Phường
        let neighbourhood = typeof data.address.neighbourhood != "undefined" ? " - " + data.address.neighbourhood : "";
        //Xã
        let county = typeof data.address.county != "undefined" ? data.address.county : ""
        //Quận
        let suburb = typeof data.address.suburb != "undefined" ? " - " + data.address.suburb : "";
        //Huyện
        let state = typeof data.address.state != "undefined" ? " - " + data.address.state : "";
        //Thành phố
        let city = typeof data.address.city != "undefined" ? " - " + data.address.city : "";
        //Quốc gia
        let country = typeof data.address.country != "undefined" ? " - " + data.address.country : ""
        let address = house_number + road + county + neighbourhood + suburb + state + city + country;
        return address;

    }

    function processToaDo(data) {
        //Số nhà
        let x = typeof data.lat !== "undefined" ? data.lat : "";
        let y = typeof data.lon !== "undefined" ? data.lon : "";
        setToaDo(x, y);
    }


    function createNotify(tag, ID, content, parentID) {
        let element = document.createElement(tag);
        element.setAttribute('id', ID);
        element.setAttribute('style', 'font-size: 12px; color: orangered');
        element.innerHTML = "Ý của bạn là: " + content;
        let parent = document.getElementById(parentID);
        parent.parentNode.insertBefore(element, parent.nextSibling);
        return element;
    }

</script>
