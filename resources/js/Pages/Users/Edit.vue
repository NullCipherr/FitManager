<template>
    <div>
      <Head :title="`${form.name}`" />
      <div class="flex justify-start mb-8 max-w-3xl">
        <h1 class="text-3xl font-bold">
          <Link class="text-red-400 hover:text-red-600" href="/users">Users</Link>
          <span class="text-red-400 font-medium">/</span>
          {{ form.name }}
        </h1>
        <img v-if="user.photo" class="block ml-4 w-8 h-8 rounded-full" :src="user.photo" />
      </div>
      <trashed-message v-if="user.deleted_at" class="mb-6" @restore="restore"> This user has been deleted. </trashed-message>
      <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
        <form @submit.prevent="update">
          <div class="flex flex-wrap -mb-8 -mr-6 p-8">
            <text-input v-model="form.name" :error="form.errors.name" pattern="'/^[A-Za-zÀ-ú]{2,}(?:\s+[A-Za-zÀ-ú]{2,})+$/'" class="pb-8 pr-6 w-full lg:w-1/3" label="Nome" />
            <text-input v-model="form.email" :error="form.errors.email" class="pb-8 pr-6 w-full lg:w-1/3" label="Email" />
            <text-input v-model="form.cpf" :error="form.errors.cpf" class="pb-8 pr-6 w-full lg:w-1/3" v-mask="'###.###.###-##'" label="CPF" />
            <text-input v-model="form.password" :error="form.errors.password" class="pb-8 pr-6 w-full lg:w-1/2" type="password" autocomplete="new-password" label="Senha" />
            <select-input v-model="form.type" :error="form.errors.type" class="pb-8 pr-6 w-full lg:w-1/2" label="Tipo">
              <option value="Aluno">Aluno</option>
              <option value="Funcionario">Funcionario</option>
              <option value="Professor">Professor</option>
            </select-input>
            <file-input v-model="form.photo" :error="form.errors.photo" class="pb-8 pr-6 w-full lg:w-1/2" type="file" accept="image/*" label="Photo" />
          </div>
          <div class="flex items-center justify-end px-8 py-4 bg-red-50 border-t border-red-100">
            <loading-button :loading="form.processing" class="btn-red" type="submit">Criar usuário</loading-button>
          </div>
        </form>
      </div>
    </div>
  </template>

  <script>

  import { Head, Link } from '@inertiajs/vue3'
  import Layout from '@/Shared/Layout'
  import TextInput from '@/Shared/TextInput'
  import FileInput from '@/Shared/FileInput'
  import SelectInput from '@/Shared/SelectInput'
  import LoadingButton from '@/Shared/LoadingButton'
  import TrashedMessage from '@/Shared/TrashedMessage'
  import { TheMask } from 'vue-the-mask'
import { mask } from 'vue-the-mask'


  export default {
    components: {
      FileInput,
      Head,
      Link,
      LoadingButton,
      SelectInput,
      TextInput,
      TrashedMessage,
      TheMask,

    },
    directives: { mask },

    layout: Layout,
    props: {
      user: Object,
    },
    remember: 'form',
    data() {
      return {
        form: this.$inertia.form({
          _method: 'put',
          name: this.user.name,
          email: this.user.email,
          cpf: this.user.cpf,
          password: '',
          type: this.user.type,
          owner: this.user.owner,
          photo: null,
        }),
      }
    },
    methods: {
      update() {
        this.form.post(`/users/${this.user.id}`, {
          onSuccess: () => this.form.reset('password', 'photo'),
        })
      },
      destroy() {
        if (confirm('Tem certeza que deseja remover este usuário?')) {
          this.$inertia.delete(`/users/${this.user.id}`)
        }
      },
      restore() {
        if (confirm('Tem certeza que deseja restaurar este usuário?')) {
          this.$inertia.put(`/users/${this.user.id}/restore`)
        }
      },
    },
  }
  </script>
