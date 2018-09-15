<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="place">
  <section class="hero is-light is-bold" style="margin: 52px 0 10px 0">
    <div class="hero-body">
      <div class="container wow slideInLeft" data-wow-duration="1s">
        <?php
        if (!$user->username === $this->session->username) {
        ?>

        <h1 class="title">
          Andre - Recommended Places
          <i class="fas fa-book"></i>
        </h1>
        <p class="subtitle">Find recommended Places from Andre</p>

        <?php
        } else {
        ?>

        <h1 class="title">
          Your Places
          <i class="fas fa-book"></i>
        </h1>
        <p class="subtitle">You can add new, view, or delete</p>

        <?php
        }
        ?>
      </div>
    </div>
  </section>

  <div id="content" style="display: none;">
    <section class="section">
      <div class="columns">
        <div
          class="column is-8 is-offset-2 wow zoomIn"
          data-wow-duration="1s"
          data-wow-delay="0.6s"
          v-if="!loading && count > 0"
        >
          <p class="title">{{ count }} Recommendations</p>

          <?php
          if ($user->username === $this->session->username) {
          ?>

          <p class="subtitle">
            <a href="<?= base_url('map'); ?>" class="button is-primary is-outlined">
              <span class="icon">
                <i class="fas fa-map"></i>
              </span>
              <span>Add</span>
            </a>
          </p>

          <?php
          }
          ?>

          <!-- Pencarian -->
          <div class="field">
            <div class="control has-icons-right">
              <input class="input" type="text" v-model="query" placeholder="Cari disini..." @input="fetchData()">
              <span class="icon is-small is-right">
                <i class="fas fa-search"></i>
              </span>
            </div>
          </div>
          
          <!-- Jika kueri pencarian tidak ditemukan -->
          <div class="box" v-if="!found">
            <p class="title">Query "{{ query }}" Not Found</p>
          </div>

          <!-- Isi data -->
          <div class="box" v-if="found" v-for="(place, index) in newPlaces">
            <article class="media">
              <div class="media-content">
                <div class="content">
                  <p class="heading">
                    <strong>{{ place.name }}</strong>,
                    <em>{{ place.date | moment }}</em>
                  </p>
                  <p class="subtitle">{{ place.place }}</p>
                </div>
              </div>

              <div class="media-right">
                <a
                  class="button is-link"
                  :href="'<?= base_url() ?>' + 'map/' + place.id"
                >
                  <span class="icon">
                    <i class="fas fa-eye"></i>
                  </span>
                </a>

                <?php
                if ($user->username === $this->session->username) {
                ?>

                <button
                  class="button is-danger"
                  @click="switchModal(place.id)"
                >
                  <span class="icon">
                    <i class="fas fa-trash"></i>
                  </span>
                </button>

                <?php
                }
                ?>
              </div>
            </article>
          </div>
        </div>
      </div>
    </section>

    <div class="has-text-centered" v-if="!loading && count < 1">
      <p class="title">
        <i class="fas fa-frown fa-2x"></i>
      </p>

      <?php
      if ($this->session->login && $user->username === $this->session->username) {
      ?>

      <p class="subtitle">
        You don't have a place saved
      </p>
      <a class="button is-link" href="<?= base_url('map') ?>">
        Add New Place
      </a>

      <?php
      } else {
      ?>

      <p class="subtitle">
        No Recomendations
      </p>

      <?php
      }
      ?>
    </div>

    <!-- Loading -->
    <div class="has-text-centered" v-if="loading">
      <p class="title">
        <i class="fas fa-spinner fa-spin"></i>
      </p>
      <p class="subtitle">
        Load Data..
      </p>
    </div>
  </div>

  <!-- Modal konfirmasi hapus data -->
  <div class="modal" :class="{ 'is-active': visibleModalDelete }">
    <div class="modal-background"></div>
    <div class="modal-content">
      <div class="box">
        <p class="title">Really?</p>
        <button class="button is-danger" @click="deletePlace">Yes</button>
        <button class="button" @click="switchModal(null)">No</button>
      </div>
    </div>
  </div>
</div>

<script>
/*
|--------------------------------------------------------------------------
| Vue.js
|--------------------------------------------------------------------------
|
| new Vue({}) -> Instance Vue.js
|
| Digunakan untuk mengawali Vue.js
| 
| el      -> Target yang akan dimanupulasi oleh Vue.js
| data    -> Data (variabel) pada Vue.js
| methods -> Menampung Method yang akan digunakan
| 
| {{}}    -> Menampilkan data (variabel)
| @click  -> Melakukan method tertentu ketika bagian tersebut diklik
|
| Untuk lebih lengkapnya, silahkan kunjungi:
| https://vuejs.org
|
*/

const place = new Vue({
  el: '#place',
  data: () => ({
    places: [],
    newPlaces: [],
    count: '',
    query: '',
    idPlace: '',
    found: true,
    loading: false,
    visibleModalDelete: false,
  }),

  mounted() {
    this.getData();
  },

  methods: {
    // Method untuk mengambil data tempat
    getData() {
      document.getElementById('content').style.display = 'block';
      
      this.loading = true

      axios.get('<?= base_url() ?>' + 'api/getAllPlacesByUsername/' + '<?= $user->username ?>')
        .then((res) => {
          this.places = res.data.data;
          this.count = res.data.data.length;
          this.fetchData();
          this.loading = false;
        })
        .catch((err) => {
          console.log(err)
        });
    },

    // Method untuk filter pencarian berdasarkan field 'nama' dan 'place'
    fetchData() {
      this.newPlaces = [];
      let query = this.query.toLowerCase();
      this.places.map((place) => {
        if (place.name.toLowerCase().indexOf(query) !== -1 || place.place.toLowerCase().indexOf(query) !== -1) {
          this.newPlaces.push(place);
        }
      });

      if (this.newPlaces.length < 1) {
        this.found = false;

      } else {
        this.found = true;
      }
    },

    // Method untuk menghapus tempat
    deletePlace() {
      axios.post('<?= base_url() ?>' + 'api/destroyPlace/' + this.idPlace)
        .then((res) => {
          if (!res.data.success) {
            alert('Error');

          } else {
            location.reload(); // Reload halaman
          }
        })
        .catch((err) => {
          console.log(err);
        })
    },

    // Method untuk menampilkan konfirmasi hapus data
    switchModal (id) {
      let htmlOverflow = document.getElementsByTagName('html')[0];

      if (id === null) {
        this.idPlace = '';

      } else {
        this.idPlace = id;
      }

      this.visibleModalDelete = !this.visibleModalDelete;

      if (!this.visibleModalDelete) {
        htmlOverflow.style.overflow = 'auto';

      } else {
        htmlOverflow.style.overflow = 'hidden';
      }
    }
  },

  // Filter data tertentu
  filters: {
    // Output akan diubah dengan bantuan dari Moment.js
    moment: (date) => moment(date).fromNow(),
  },
});
</script>
