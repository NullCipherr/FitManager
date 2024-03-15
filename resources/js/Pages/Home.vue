<template>


  <div id="app">

    <div class="login-page">
      <transition name="fade">
        <div v-if="!registerActive" class="wallpaper-login"></div>
      </transition>
      <div class="wallpaper-register"></div>

      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-8 mx-auto">
            <div v-if="!registerActive" class="card login" v-bind:class="{ error: emptyFields }">
              <h1>Entrarr</h1>
              <form class="form-group">
                <input v-model="form.emailLogin" type="email" class="form-control" placeholder="Email" required>
                <input v-model="form.passwordLogin" type="password" class="form-control" placeholder="Password"
                  required>
                <input type="submit" class="btn btn-primary" @click="doLogin">
                <p>Não tem uma conta? <a href="#"
                    @click="registerActive = !registerActive, emptyFields = false">Registre-se aqui</a>
                </p>
                <p><a href="#">Esqueceu sua senha?</a></p>
              </form>
            </div>

            <div v-else class="card register" v-bind:class="{ error: emptyFields }">
              <h1>Registre-se</h1>
              <form class="form-group">
                <input v-model="emailReg" type="email" class="form-control" placeholder="Email" required>
                <input v-model="passwordReg" type="password" class="form-control" placeholder="Password" required>
                <input v-model="confirmReg" type="password" class="form-control" placeholder="Confirm Password"
                  required>
                <input type="submit" class="btn btn-primary" @click="doRegister">
                <p>Já tem uma conta? <a href="#"
                    @click="registerActive = !registerActive, emptyFields = false">Entre</a>
                </p>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</template>

<style lang="scss">
p {
  line-height: 1rem;
}

.card {
  padding: 20px;
}

.form-group {
  input {
    margin-bottom: 20px;
  }
}

.login-page {
  align-items: center;
  display: flex;
  height: 100vh;

  .wallpaper-login {
    background: url(https://images.pexels.com/photos/1552252/pexels-photo-1552252.jpeg) no-repeat center center;
    background-size: cover;
    height: 100%;
    position: absolute;
    width: 100%;
  }

  .fade-enter-active,
  .fade-leave-active {
    transition: opacity .5s;
  }

  .fade-enter,
  .fade-leave-to {
    opacity: 0;
  }

  .wallpaper-register {
    background: url(https://images.pexels.com/photos/533671/pexels-photo-533671.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260) no-repeat center center;
    background-size: cover;
    height: 100%;
    position: absolute;
    width: 100%;
    z-index: -1;
  }

  h1 {
    margin-bottom: 1.5rem;
  }
}

.error {
  animation-name: errorShake;
  animation-duration: 0.3s;
}

@keyframes errorShake {
  0% {
    transform: translateX(-25px);
  }

  25% {
    transform: translateX(25px);
  }

  50% {
    transform: translateX(-25px);
  }

  75% {
    transform: translateX(25px);
  }

  100% {
    transform: translateX(0);
  }
}
</style>

<script>
import { Head } from '@inertiajs/vue3'
//   import TextInput from '@/Shared/TextInput'
import LoadingButton from '../Shared/LoadingButton'

export default {
  components: {
    Head,
    LoadingButton,
    //   Logo,
    //   TextInput,
  },
  data() {
    return {
      form: this.$inertia.form({
        emailLogin: 'user1@example.com',
        passwordLogin: 'secret',
        remember: false,
      }),
    }
  },
  methods: {
    login() {
      this.form.post('/login')
    },
    handleInput(event) {
      document.cookie = "email=" + (event.target.value || "") + "; path=/";
    },
  },
}
</script>
