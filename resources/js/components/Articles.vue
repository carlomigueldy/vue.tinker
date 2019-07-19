<template>
    <div>
        <h2>{{ title }}</h2>
        <div id="map"></div>
    </div>
</template>

<style>
body {
    margin: 0;
}
html, body, #map { 
    height: 400px;
}
</style>

<script>
export default {
    data() {
        return {
            title: 'EthnoGIS Leaflet Draw Plugin',
            test: 'test',
        }
    },

    mounted() {
        console.log('Component mounted, coming from the Articles component.')
        this.initMap();
        this.initDraw();
    },

    methods: {
        initDraw: function() {
            const drawnItems = new L.FeatureGroup();
            this.map.addLayer(drawnItems);

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
            this.map.addControl(drawControl);

            // from data property
            console.log(this.test);

            this.map.on('draw:created', function (e) {
                const type = e.layerType;
                const layer = e.layer;
                const vm = this;

                drawnItems.addLayer(layer);

                if(type == 'polygon' || type == 'rectangle') {
                    var points = layer.toGeoJSON();
                    var coordinates = JSON.stringify(points.geometry.coordinates[0]);

                    /*
                        Make a form inside the popup content that we 
                        can actually store those coordinates inside the Database
                    */
                    var popupContent = 'Do you want to add this polygon? <br>';
                    popupContent += "<form method='post' action='api/article'>" + 
                    "<br>Title: <input type='text' name='title'>" +
                    "<br>Body: <input type='text' name='body'>" +
                    "<textarea name='coordinates'>" + coordinates + "</textarea>" + 
                    "<br><input type='Submit' value='Add'>" 
                    + "</form>";
                }
                drawnItems.bindPopup(popupContent).openPopup();

                if (type == 'marker') {
                    var lat = layer.getLatLng().lat;
                    var lng = layer.getLatLng().lng;
                    
                    console.log("Latitude: " + lat + " | Longitude: " + lng);
                }
            });
        },

        initMap: function() {
            this.map = L.map('map').setView([8.021155456563914, 124.00543212890626], 8);

            this.tileLayer = L.tileLayer(
            'https://cartodb-basemaps-{s}.global.ssl.fastly.net/rastertiles/voyager/{z}/{x}/{y}.png',
            {
                maxZoom: 18,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, &copy; <a href="https://carto.com/attribution">CARTO</a>',
            }
            );
            this.tileLayer.addTo(this.map);
        },
    }
}
</script>