<template>
    <div>
        <gmap-map
          ref="map"
          :center="{lat:-12.153794, lng:-76.95287}"
          :zoom="12"
          style="width: 100%; height: 500px"
        >
      </gmap-map>
      <div class="form-group range-group">
        <div class="form-group">
          <label>Fecha inicial:</label>
          <datepicker language="es" v-model="start_date"></datepicker>
        </div>
        <div class="form-group">
          <label>Fecha final:</label>
          <datepicker language="es" v-model="end_date"></datepicker>
        </div>
        <div class="form-group">
          <label>Hora inicial:</label><br>
          <vue-timepicker :minute-interval="10" v-model="start_hour"></vue-timepicker>
        </div>
        <div class="form-group">
          <label>Hora final:</label><br>
          <vue-timepicker :minute-interval="10" v-model="end_hour"></vue-timepicker>
        </div>
        <div class="form-group">
          <label>&nbsp;</label><br>
          <button class="btn" v-on:click="searchIncidents()">Buscar</button>
        </div>
      </div>


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
    const stations = await axios.get('/api/stations');

    let boundary = new google.maps.Data({map: vm.$refs.map.$mapObject});
    let layers = new google.maps.Data({map: vm.$refs.map.$mapObject});
    boundary.setStyle({
      strokeColor: 'black',
      strokeWeight: 2
    });
    layers.setStyle({
      strokeColor: 'grey',
      strokeWeight: 1
    });

    boundary.addGeoJson(JSON.parse(vmt.data.boundary));
    layers.addGeoJson(JSON.parse(vmt.data.layers));

    const incidents = await axios.get('/api/incidents');
    let points = _.map(incidents.data, function(incindent) {
      return new google.maps.LatLng(incindent.lat, incindent.long);
    });

    vm.heatmap.setMap(this.$refs.map.$mapObject);
  },
  data () {
    return {
      heatmap: {},
      start_date: new Date(),
      end_date: new Date(),
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
  .range-group {
    margin-top:10px;
    display: none;
  }
  .form-group {
    float: left;
    margin-right: 10px;
  }
</style>