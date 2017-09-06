<template>
    <div>
        <gmap-map
          ref="map"
          :center="{lat:-12.12, lng:-77.02}"
          :zoom="12"
          style="width: 100%; height: 500px"
        ></gmap-map>
    </div>
</template>

<script>
    import axios from 'axios';
    import { loaded } from 'vue2-google-maps';

    export default {
      async created () {
        await loaded;
        const response = await axios.get('/api/incidents');

        let points = _.map(response.data, function(incindent) {
          return new google.maps.LatLng(incindent.lat, incindent.long);
        });
        let heatmap = new google.maps.visualization.HeatmapLayer({
          data: points,
        })

        heatmap.setMap(this.$refs.map.$mapObject);
      },
      data () {
          return {
              incidents: []
          }
      }
    }
</script>
