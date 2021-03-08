@extends('layouts.master')

@section('css')
    <script src="{{ asset('js/leaflet.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/leaflet.css') }}" />
@endsection
@section('noidung')


    <div id="map" style="min-height: 80vh"></div>

    <script>
        var map = L.map("map").setView([21.02533, 105.84947], 3); //18
        L.tileLayer(
            "https://api.maptiler.com/maps/streets/{z}/{x}/{y}@2x.png?key=uXpXh7cCekRxZCcvL34I", {
                attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',
                tileSize: 512,
                zoomOffset: -1,
                circlePadding: [0, 0],
                minZoom: 3,
                crossOrigin: true,
            }
        ).addTo(map);

        //search-box


        var marker;

        function onMapClick(e) {
            if (marker) { // check
                map.removeLayer(marker); // remove
            }
            marker = new L.marker(e.latlng, {
                draggable: 'true'
            });
            var lat_lng = marker.getLatLng();
            marker.on('dragend', function(event) {
                var marker = event.target;
                var position = marker.getLatLng();
                marker.setLatLng(new L.LatLng(position.lat, position.lng), {
                    draggable: 'true'
                });
                map.panTo(new L.LatLng(position.lat, position.lng))
                lat_lng = marker.getLatLng();
                console.log(lat_lng)
            });
            map.addLayer(marker);
        };

        map.on('click', onMapClick);

        //slider bars

    </script>

@endsection
