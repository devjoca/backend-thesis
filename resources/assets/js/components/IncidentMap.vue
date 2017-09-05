<template>
    <div>
        <gmap-map
          :center="{lat:-12.12, lng:-77.02}"
          :zoom="12"
          style="width: 100%; height: 500px"
        ></gmap-map>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        mounted () {
            axios.get('/api/incidents').then(({ data }) => {
                this.incidents = data;
            });
        },
        data () {
            return {
                incidents: []
            }
        }
    }
</script>
