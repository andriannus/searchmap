<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="login">
  <section class="hero is-white is-fullheight">
    <div class="hero-body">
      <div class="container">
        <div class="columns">
          <div class="column is-4 is-offset-4">
            <div class="box">
              <p class="title has-text-centered">Login</p>

              <!-- Pesan error -->
              <div class="field" v-if="isShow">
                <div class="notification is-danger">
                  <button class="delete" @click="resetShow"></button>
                  {{ message }}
                </div>
              </div>

              <!-- Field username -->
              <div class="field">
                <label class="label">Username</label>
                <div class="control">
                  <input
                    class="input"
                    type="text"
                    placeholder="Input username here.."
                    name="username"
                    v-model="username"
                  >
                </div>
              </div>

              <!-- Field password -->
              <div class="field">
                <label class="label">Password</label>
                <div class="control">
                  <input class="input" type="password" placeholder="Input password here.." name="password" v-model="password"></input>
                </div>
              </div>

              <div class="field">
                <button
                  class="button is-dark is-fullwidth"
                  :class="{ 'is-loading': isLoading }"
                  :disabled="!username || !password"
                  @click="submitForm"
                >Submit</button>
              </div>

              <div class="field has-text-centered">
                <p>
                  Don't have an account?
                  <a class="has-text-info" href="<?= base_url('register'); ?>">register</a>
                </p>
              </div>

              <div class="field has-text-centered">
                <p>
                  <a class="button" href="<?= base_url('site') ?>">Home</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
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
const login = new Vue({
  el: '#login',
  data: () => ({
    username: '',
    password: '',
    message: '',
    urlRedirect: '',
    isShow: false,
    isLoading: false,
  }),

  mounted() {
    this.checkRedirectUrl();
  },

  methods: {
    checkRedirectUrl() {
      let url = window.location.href;
      let param = new URL(url).searchParams;
      let redirect = param.get('redirect');

      if (redirect !== null) {
        this.urlRedirect = redirect;
      }
    },

    // Method untuk submit form
    submitForm () {
      this.isLoading = true;

      let data =  'username=' + this.username +
                  '&password=' + this.password;

      axios.post('<?= base_url() ?>' + 'auth/loginProcess', data)
        .then((res) => {
          this.isLoading = false

          if (!res.data.success) {
            this.password = '';
            this.message = res.data.message;
            this.isShow = true;
          
          } else {
            if (!this.urlRedirect) {
              window.location.replace('<?= base_url() ?>'); // Pindah ke halaman awal dengan menghapus history halaman sebelumnya
            
            } else {
              window.location.replace(this.urlRedirect);
            }
          }
        })
        .catch((err) => {
          console.log(err)
        });
    },

    // Method untuk menghapus pesan error
    resetShow() {
      this.message = '';
      this.isShow = false;
    },
  },
});
</script>
