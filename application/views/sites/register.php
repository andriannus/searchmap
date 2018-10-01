<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="register">
  <section class="hero is-white is-fullheight">
    <div class="hero-body">
      <div class="container">
        <div class="columns">
          <div class="column is-4 is-offset-4">
            <div class="box">
              <p class="title has-text-centered">Register</p>

              <!-- Field Name -->
              <div class="field">
                <label class="label">Name</label>
                <div class="control">
                  <input
                    class="input"
                    :class="{ 'is-danger': nameErrors.length > 0 }"
                    type="text"
                    placeholder="Input name here.."
                    name="name"
                    v-model="name"
                    @input="checkName"
                  >
                </div>
                <!-- Pesan Error -->
                <p class="help is-danger" v-if="nameErrors">{{ nameErrors[0] }}</p>
              </div>

              <!-- Field E-mail -->
              <div class="field">
                <label class="label">E-mail</label>
                <div class="control">
                  <input
                    class="input"
                    :class="{ 'is-danger': emailErrors.length > 0 }"
                    type="email"
                    placeholder="Input e-mail here.."
                    name="email"
                    v-model="email"
                    @input="isTyping(checkEmail)"
                  >
                </div>
                <!-- Pesan Error -->
                <p class="help is-danger" v-if="emailErrors">{{ emailErrors[0] }}</p>
              </div>

              <!-- Field Username -->
              <div class="field">
                <label class="label">Username</label>
                <div class="control">
                  <input
                    class="input"
                    :class="{ 'is-danger': usernameErrors.length > 0 }"
                    type="text"
                    placeholder="Input username here.."
                    name="username"
                    v-model="username"
                    @input="isTyping(checkUsername)"
                  >
                </div>
                <!-- Pesan Error -->
                <p class="help is-danger" v-if="usernameErrors">{{ usernameErrors[0] }}</p>
              </div>

              <!-- Field Password -->
              <div class="field">
                <label class="label">Password</label>
                <div class="control">
                  <input
                    class="input"
                    :class="{ 'is-danger': passwordErrors.length > 0 }"
                    type="password"
                    placeholder="Input password here.."
                    name="password"
                    v-model="password"
                    @input="checkPassword"
                  >
                </div>
                <!-- Pesan Error -->
                <p class="help is-danger" v-if="passwordErrors">{{ passwordErrors[0] }}</p>
              </div>

              <div class="field">
                <button
                  class="button is-dark is-fullwidth"
                  :class="{ 'is-loading': isLoading }"
                  @click="submitForm()"
                  :disabled="checkForm()"
                >Submit</button>
              </div>

              <div class="field has-text-centered">
                <p>
                  Already have an account?
                  <a class="has-text-info" href="<?= base_url('login'); ?>">login</a>
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
new Vue({
  el: '#register',
  data: () => ({
    name: '',
    email: '',
    username: '',
    password: '',
    baseUrl: '<?= base_url() ?>',
    nameErrors: [],
    emailErrors: [],
    usernameErrors: [],
    passwordErrors: [],
    debounce: '',
    constrains: '',
    isLoading: false,
    isLoadTyping: false,
  }),

  mounted() {
    this.config();
  },

  methods: {
    config() {
      // Function yang akan mengeksekusi method setelah user setelai mengetik.
      this.debounce = _.debounce(function (method) {
        method();
      }, 1000); // Jeda 1ms setelah selesai mengetik

      // Validasi
      this.constrains = {
        name: {
          presence: {
            allowEmpty: false,
          },
          format: {
            pattern: '[a-zA-Z ]+',
            message: 'Name must be the alphabetic'
          },
          length: {
            minimum: 5,
            maximum: 100
          }
        },

        email: {
          presence: {
            allowEmpty: false
          },
          email: true
        },

        username: {
          presence: {
            allowEmpty: false
          },
          format: {
            pattern: '[a-zA-Z0-9]+',
            message: 'Username must be the alphabetic or numeric or both'
          },
          length: {
            minimum: 8,
            maximum: 20
          }
        },

        password: {
          presence: {
            allowEmpty: false
          },
          length: {
            minimum: 8
          }
        }
      }
    },

    isTyping(method) {
      this.isLoadTyping = true;
      this.debounce(method);
    },

    // Method untuk cek nama
    checkName() {
      const errors = validate.single(this.name, this.constrains.name);

      if (!errors) {
        this.nameErrors = [];

      } else {
        this.nameErrors = errors;
      }
    },

    // Method untuk cek e-mail
    checkEmail() {
      const errors = validate.single(this.email, this.constrains.email);

      // Jika tidak ada yang error
      if (!errors) {
        this.emailErrors = [];

        let data = `email=${this.email}`;
        axios.post(`${this.baseUrl}auth/checkEmail`, data) // Cek ketersediaan e-mail
          .then((res) => {
            if (!res.data.success) this.emailErrors.push(res.data.message); // Jika e-mail telah digunakan, tampilkan pesan error
          })
          .catch((err) => {
            console.log(err);
          });
      } else {
        this.emailErrors = errors;
      }

      this.isLoadTyping = false;
    },

    // Method untuk cek username
    checkUsername() {
      const errors = validate.single(this.username, this.constrains.username);

      // Jika tidak ada yang error
      if (!errors) {
        this.usernameErrors = [];

        let data = `username=${this.username}`;
        axios.post(`${this.baseUrl}auth/checkUsername`, data) // Cek ketersediaan username
          .then((res) => {
            if (!res.data.success) this.usernameErrors.push(res.data.message); // Jika username telah digunakan, tampilkan pesan error
          })
          .catch((err) => {
            console.log(err);
          });
      } else {
        this.usernameErrors = errors;
      }

      this.isLoadTyping = false;
    },

    // Method untuk cek password
    checkPassword() {
      const errors = validate.single(this.password, this.constrains.password);

      if (!errors) {
        this.passwordErrors = [];
      } else {
        this.passwordErrors = errors;
      }
    },

    // Method untuk mengaktifkan/menonaktifkan button submit
    checkForm() {
      if (!this.name || !this.email || !this.username || !this.password || this.nameErrors.length > 0 || this.emailErrors.length > 0 || this.usernameErrors.length > 0 || this.passwordErrors.length > 0 || this.isLoadTyping) {
        return true;
      } else {
        return false;
      }
    },

    // Method untuk post data
    submitForm() {
      this.isLoading = true;

      let data =  'name=' + this.name +
                  '&email=' + this.email +
                  '&username=' + this.username +
                  '&password=' + this.password;

      axios.post(`${this.baseUrl}auth/registerProcess`, data)
        .then((res) => {
          if (res.data.success) {
            this.isLoading = false;
            window.location.replace(`${this.baseUrl}login`); // Pindah ke halaman login dengan menghapus history halaman sebelumnya
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
});
</script>
