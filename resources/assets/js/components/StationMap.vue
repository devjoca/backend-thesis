<template>
  <div>
    <gmap-map
      ref="map"
      :center="{lat:parseFloat(center_lat), lng:parseFloat(center_lng)}"
      :zoom="14"
      style="width: 100%; height: 500px"
    >
      <gmap-marker
        :position="{lat:parseFloat(center_lat), lng:parseFloat(center_lng)}"
        :clickable="true"
        :draggable="false"
      ></gmap-marker>
    </gmap-map>
  </div>
</template>

<script>
import axios from 'axios';
import { loaded } from 'vue2-google-maps';

export default {
  props: ['center_lat', 'center_lng', 'id'],
  async mounted () {
    await loaded;
    const incidents = await axios.get('/api/incidents');
    const station = await axios.get(`/api/stations/${this.id}`);
    const geoJson = JSON.parse(station.data.jurisdictions.geojson);
    const json = this.$refs.map.$mapObject.data.addGeoJson(geoJson);
    const jurisdiction = new google.maps.Polygon({paths: json[0].getGeometry().getArray()})

    let points = _.filter(incidents.data, function(incindent) {
      const location = new google.maps.LatLng(incindent.lat, incindent.long);
      return google.maps.geometry.poly.containsLocation(location, jurisdiction)
    });

    points = _.map(points, function(incindent) {
      return new google.maps.LatLng(incindent.lat, incindent.long);
    });
    this.heatmap = new google.maps.visualization.HeatmapLayer({
      data: points,
    })

    this.heatmap.setMap(this.$refs.map.$mapObject);
  }
}
</script>