<template>
    <div>
      <div id="databox"> Número de hechos reportadas: {{count}}</div>
        <gmap-map
          ref="map"
          :center="{lat:-12.153794, lng:-76.95287}"
          :zoom="12"
          style="width: 100%; height: 500px"
        >

      </gmap-map>
    </div>
</template>

<script>
import axios from 'axios';
import { loaded } from 'vue2-google-maps';
import VueTimepicker from 'vue2-timepicker';
import Datepicker from 'vuejs-datepicker';

export default {
  components: {
    Datepicker,
    VueTimepicker,
  },
  async mounted () {
    let vm = this;
    await loaded;
    const vmt = await axios.get('/api/vmt');

    let boundary = new google.maps.Data({map: vm.$refs.map.$mapObject});
    let layers = new google.maps.Data({map: vm.$refs.map.$mapObject});
    boundary.setStyle({
      strokeColor: 'black',
      strokeWeight: 2
    });

    layers.setStyle(function(feature) {
      var color = feature.getProperty('color');
      return {
        fillColor: 'hsl(' + color[0] + ',' + color[1] + '%,' + color[2] + '%)',
        strokeColor: '#eee',
        fillOpacity: 0.75,
        strokeWeight: 1
      };
    });

    boundary.addGeoJson(JSON.parse(vmt.data.boundary));
    layers.addGeoJson(JSON.parse(vmt.data.layers));

    layers.addListener('mouseover', (e) => {
      layers.revertStyle();
      layers.overrideStyle(e.feature, {strokeWeight: 6});
      vm.count = e.feature.getProperty('count');
    });
    layers.addListener('mouseout', (e) => {
      layers.revertStyle();
    });
  },
  data () {
    return {
      heatmap: {},
      start_date: new Date(),
      end_date: new Date(),
      count: 0,
      start_hour: {
        HH: "00",
        mm: "00",
      },
      end_hour: {
        HH: "23",
        mm: "50",
      },
    }
  },
  methods: {
    async searchIncidents () {
      this.heatmap.setMap(null);
      const incidents = await axios.post('/api/incidents/search', {
        start_date: this.start_date,
        end_date: this.end_date,
        start_hour: this.start_hour,
        end_hour: this.end_hour,
      });
      let points = _.map(incidents.data, function(incindent) {
        return new google.maps.LatLng(incindent.lat, incindent.long);
      });
      this.heatmap = new google.maps.visualization.HeatmapLayer({
        data: points,
      })

      this.heatmap.setMap(this.$refs.map.$mapObject);
    }
  },
}
</script>
<style>
#databox {
  position: relative;
  top: 41px;
  z-index: 1000;
  background: white;
  font-weight: bold;
  width: 300px;
  border: rgb(229, 229, 229) 1px solid;
  left: 107px;
  padding: 3px 3px;
}
</style>