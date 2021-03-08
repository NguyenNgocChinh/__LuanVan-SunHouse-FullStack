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

