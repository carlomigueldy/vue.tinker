<template>
    <div>
        <h2>EthnoGIS with Leaflet Draw Feature</h2>
        <div id="map"></div>
    </div>
</template>

<style>
#map { 
    height: 400px;
}
</style>

<script>
export default {
    mounted() {
        console.log('Component mounted, coming from the Articles component.')
        this.initMap();
        this.leafletDraw();
    },

    methods: {
        printIt: function(request) {
            console.log(request);
        },

        leafletDraw: function() {
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

            this.map.on('draw:created', function (e) {
                const type = e.layerType;
                const layer = e.layer;

                drawnItems.addLayer(layer);

                if(type == 'polygon' || type == 'rectangle') {
                    var points = layer.toGeoJSON();
                    var coords = JSON.stringify(points.geometry.coordinates[0]);

                    /*---------------------------------------/
                    |  Check if it works, and yes it did!    |
                    /---------------------------------------*/
                    console.log(coords);
                }

                if (type == 'marker') {
                    var lat = layer.getLatLng().lat;
                    var lng = layer.getLatLng().lng;

                    /*---------------------------------------/
                    |  Check if it works, and yes it did!    |
                    /---------------------------------------*/
                    console.log("Latitude: " + lat + " | Longitude: " + lng);
                }
            });
        },

        initMap: function() {
            this.map = L.map('map').setView([-41.2858, 174.78682], 14);

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