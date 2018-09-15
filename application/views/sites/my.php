<div id="my">
  <section class="hero is-light is-bold" style="margin: 52px 0 10px 0">
    <div class="hero-body">
      <div class="container wow slideInLeft" data-wow-duration="1s">
        <p class="subtitle">You Are Here Now...</p>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="columns">
      <div
        class="column is-8 is-offset-2 wow zoomIn"
        data-wow-duration="1s"
        data-wow-delay="0.6s"
      >
        
        <div v-if="!error">
          <div id="map" ref="map" style="height: 500px"></div>

          <br>

          <div class="box">
            <p>
              <strong>Address</strong>
            </p>
            <p>{{ address }}</p>
          </div>
        </div>

        <div class="box has-text-centered" v-if="error">
          <p class="title">
            <i class="fas fa-sad-tear fa-2x"></i>
          </p>
          <p class="subtitle">
            {{ errorMsg }}
          </p>
        </div>

        <br>

        <div class="has-text-centered">
          <button class="button is-dark" @click="refresh">
            <span class="icon">
              <i class="fas fa-sync"></i>
            </span>
            <span>Reload</span>
          </button>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
const my = new Vue({
  el: '#my',
  data: () => ({
    map: '',
    marker: '',
    latLng: '',
    geocoder: '',
    lat: '',
    lng: '',
    address: '',
    errorMsg: '',
    error: false,
  }),

  mounted() {
    this.getLocation();
  },

  methods: {
    initMap() {
      this.latLng = new google.maps.LatLng(this.lat, this.lng);

      this.geocoder = new google.maps.Geocoder
      this.geocoder.geocode({ 'location': my.latLng }, function (results, status) {
        if (status !== 'OK') {
          alert('Error. Please refresh/reload page');

        } else {
          my.address = results[0].formatted_address;
        }
      })

      this.map = new google.maps.Map(this.$refs.map, {
        center: my.latLng,
        zoom: 13,
        disableDefaultUI: true
      });

      this.marker = new google.maps.Marker({
        map: my.map,
        position: my.latLng,
        anchorPoint: new google.maps.Point(0, -29)
      });
    },

    getLocation() {
      navigator.geolocation.getCurrentPosition(this.showLocation, this.showError);
    },

    showLocation(position) {
      this.error = false;
      this.lat = position.coords.latitude;
      this.lng = position.coords.longitude;

      this.initMap();
    },

    showError(err) {
      this.error = true;

      switch (err.code) {
        case 1: // Permission Denied
          this.errorMsg = err.message
          break;

        case 2: // Position Unavailable
          this.errorMsg = err.message
          break;

        case 3: // Timeout
          this.errorMsg = err.message
          break;
      }
    },

    refresh() {
      location.reload();
    },
  },
});
</script>
