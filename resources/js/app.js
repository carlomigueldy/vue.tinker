require('./bootstrap');

window.Vue = require('vue');

import Articles from './components/Articles';

const app = new Vue({
    el: '#app',

    components: { Articles },

    mounted() {
        this.initMap();
        this.leafletDraw();
    },

    methods: {
        leafletDraw() {
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

                // console.log("Check value for drawnItems => ");
                // console.log(drawnItems);
                // console.log(layer);
                // console.log(type);
                // console.log("Check value for layer => ");
                // console.log(this.layer);

                drawnItems.addLayer(layer);

                if(type == 'polygon' || type == 'rectangle') {
                    const coordinates = (JSON.stringify(layer.getLatLngs().map(function(point) {
                            console.log(`${point[i].lat}, ${point[i].lat}`);
                            return ([point.lat, point.lng]);  
                        })
                    ));
                }

                // if (this.type == 'marker') {
                //     this.lat = layer.getLatLng().lat;
                //     this.lng = layer.getLatLng().lng;
                //     console.log("Latitude: " + this.lat + " | Longitude: " + this.lng);
                // }
            });
        },

        initMap() {
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

    },
});
