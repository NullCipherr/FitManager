<template>
  <div id="app">
    <div class="register-page">
      <div class="wallpaper-register"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-8 mx-auto">
            <div class="card register">
              <div class="header">
                <h1>Cadastro</h1>
              </div>
              <form class="form-group" @submit.prevent="register">
                <input v-model="form.name" type="text" class="form-control" placeholder="Nome" required>
                <input v-model="form.email" type="email" class="form-control" placeholder="Email" required>
                <input v-model="form.cpf" type="text" class="form-control" placeholder="CPF" required>
                <input v-model="form.password" type="password" class="form-control" placeholder="Senha" required>
                <input v-model="form.confirmPassword" type="password" class="form-control" placeholder="Confirme a Senha" required>
                <div class="submit-button">
                  <input type="submit" class="btn-red" value="Registrar">
                </div>
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

  .submit-button {
    text-align: right;
  }
}

.register-page {
  align-items: center;
  display: flex;
  height: 100vh;

  // Wallpaper de fundo
  .wallpaper-register {
    background: url(https://images.pexels.com/photos/1552252/pexels-photo-1552252.jpeg) no-repeat center center;
    background-size: cover;
    height: 100%;
    position: absolute;
    width: 100%;
  }

  .header {
    text-align: center;
    margin-bottom: 1.5rem;

    h1 {
      font-size: 2em;
      font-weight: bold;
    }
  }

  .btn-red {
    background-color: red;
    border-color: red;
  }
}
</style>

<script>
import { Head } from '@inertiajs/vue3'

export default {
  components: {
    Head,
  },
  data() {
    return {
      form: this.$inertia.form({
        name: '',
        email: '',
        cpf: '',
        password: '',
        confirmPassword: '',
      }),
    }
  },
  methods: {
    register() {
      if (this.form.name && this.form.email && this.form.cpf && this.form.password && this.form.confirmPassword) 
      {
        // Lógica de registro
        console.log('Registrando o usuário...');
        this.form.post('/register')
      }
    },
  },
}
</script>