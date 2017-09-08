<template>
    <div>
        <gmap-map
          ref="map"
          :center="{lat:-12.12, lng:-77.02}"
          :zoom="12"
          style="width: 100%; height: 500px"
        >
      </gmap-map>
    </div>
</template>

<script>
    import axios from 'axios';
    import { loaded } from 'vue2-google-maps';

    export default {
      async mounted () {
        let vm = this;
        await loaded;
        const incidents = await axios.get('/api/incidents');
        const stations = await axios.get('/api/stations');

        _.each(stations.data, function(station) {
          new google.maps.Marker({
            position: new google.maps.LatLng(station.lat, station.long),
            title: station.name,
            map: vm.$refs.map.$mapObject,
            draggable: false,
          });
        });

        let points = _.map(incidents.data, function(incindent) {
          return new google.maps.LatLng(incindent.lat, incindent.long);
        });
        let heatmap = new google.maps.visualization.HeatmapLayer({
          data: points,
        })

        heatmap.setMap(this.$refs.map.$mapObject);
      }
    }
</script>
