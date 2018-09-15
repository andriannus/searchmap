<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="app">
  <nav class="navbar is-fixed-top is-light" role="navigation" aria-label="main dropdown navigation">
    <div class="navbar-brand">
      <a class="navbar-item" href="<?= base_url() ?>">
        SEARCH MAP
      </a>

      <a role="button" class="navbar-burger has-text-dark" :class="{ 'is-active': isActive }" aria-label="menu" aria-expanded="false" @click="switchMenu">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>

    <div class="navbar-menu" :class="{ 'is-active': isActive }">
      <div class="navbar-start">
        <a
          class="navbar-item <?= (isset($menu) && $menu === 'home' ? 'is-active' : ''); ?>"
          href="<?= base_url() ?>"
        >
          <i class="fas fa-home"></i>&nbsp;
          Home
        </a>

        <div class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link" href="#">
            Feature
          </a>

          <div class="navbar-dropdown is-boxed">
            <a
              class="navbar-item <?= (isset($menu) && $menu === 'my' ? 'is-active' : ''); ?>"
              href="<?= base_url('my') ?>"
            >Where am I?</a>

            <a class="navbar-item" href="<?= base_url('map') ?>">Map</a>

            <a class="navbar-item" href="<?= base_url('draw') ?>">Draw Map</a>

            <a
              class="navbar-item <?= (isset($menu) && $menu === 'guest' ? 'is-active' : ''); ?>"
              href="<?= base_url('guest') ?>"
            >Guest Book</a>
          </div>
        </div>
      </div>

      <div class="navbar-end">
        <div class="navbar-item">
          <div class="field is-grouped">
            <p class="control">
              <?php
              if ($this->session->login == TRUE) {
              ?>

              <a class="button is-dark" href="<?= base_url('u/') . $this->session->username ?>">
                <span class="icon">
                  <i class="fas fa-user"></i>
                </span>
              </a>

              <button class="button is-danger" @click="logout">
                <span class="icon">
                  <i class="fas fa-sign-out-alt"></i>
                </span>
              </button>
              
              <?php
              } else {
              ?>

              <a class="button is-dark" href="<?= base_url('login') ?>">
                Login
              </a>

              <a class="button is-dark" href="<?= base_url('register') ?>">
                Register
              </a>

              <?php
              }
              ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </nav>
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

const app = new Vue({
  el: '#app', // tag HTML dengan id = app
  data: () => ({
    isActive: false,
  }),

  methods: {
    switchMenu() {
      this.isActive = !this.isActive;
    },

    logout() {
      window.location.replace('<?= base_url() ?>' + 'logout');
    },
  },
});
</script>