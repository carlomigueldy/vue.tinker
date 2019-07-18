<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' }</script>

        <title>Larticles App</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.5.1/leaflet.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.5.1/leaflet.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
        {{-- <div id="app">
            <div class="container p-3">
                <Articles></Articles>
            </div>
        </div> --}}
        <div id="map"></div>

        <script src="{{ asset('js/app.js') }}"></script>
        <script>
        const map = L.map('map').setView([8.021155456563914, 124.00543212890626], 8);

        const tileLayer = L.tileLayer(
        'https://cartodb-basemaps-{s}.global.ssl.fastly.net/rastertiles/voyager/{z}/{x}/{y}.png',
        {
            maxZoom: 18,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, &copy; <a href="https://carto.com/attribution">CARTO</a>',
        }
        );
        tileLayer.addTo(map);
        </script>

        <script>
        const drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        const drawControl = new L.Control.Draw({
            draw: {
                circle: false,
                circlemarker: false,
            },
            edit: {
                featureGroup: drawnItems,
                edit: false,
            }
        });
        map.addControl(drawControl);
        </script>

        <script>
        map.on('draw:created', function (e) {
            const type = e.layerType, 
                layer = e.layer;

            drawnItems.addLayer(layer);

            if(type == 'polygon' || type == 'rectangle') {
                var points = layer.toGeoJSON();
                var coordinates = JSON.stringify(points.geometry.coordinates[0]);

                /*---------------------------------------/
                |  Check if it works, and yes it did!    |
                /---------------------------------------*/
                console.log(coordinates);
                var popupContent = 'Do you want to add this polygon? <br>';
                popupContent += "<form method='post' action='api/article'>" + 
                "<br>Title: <input type='text' name='title'>" +
                "<br>Body: <input type='text' name='body'>" +
                "<textarea name='coordinates'>" + coordinates + "</textarea>" + 
                "<br><input type='Submit' value='Add'>" 
                + "</form>";
            }

            drawnItems.bindPopup(popupContent).openPopup();
        });
        </script>
    </body>
</html>
