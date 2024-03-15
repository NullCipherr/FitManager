<template>
    <div>
      <Head :title="`${form.name}`" />
      <div class="flex justify-start mb-8 max-w-3xl">
        <h1 class="text-3xl font-bold">
          <Link class="text-red-400 hover:text-red-600" href="/alunos">Alunos</Link>
          <span class="text-red-400 font-medium">/</span>
          {{ form.name }}
        </h1>
        <img v-if="aluno.photo" class="block ml-4 w-8 h-8 rounded-full" :src="aluno.photo" />
      </div>
      <trashed-message v-if="aluno.deleted_at" class="mb-6" @restore="restore"> This aluno foi deletado. </trashed-message>
      <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
        <form @submit.prevent="update">
          <div class="flex flex-wrap -mb-8 -mr-6 p-8">
            <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="First name" />
            <text-input v-model="form.email" :error="form.errors.email" class="pb-8 pr-6 w-full lg:w-1/2" label="Email" />
            <text-input v-model="form.password" :error="form.errors.password" class="pb-8 pr-6 w-full lg:w-1/2" type="password" autocomplete="new-password" label="Password" />
            <select-input v-model="form.owner" :error="form.errors.owner" class="pb-8 pr-6 w-full lg:w-1/2" label="Owner">
              <option :value="true">Yes</option>
              <option :value="false">No</option>
            </select-input>
            <file-input v-model="form.photo" :error="form.errors.photo" class="pb-8 pr-6 w-full lg:w-1/2" type="file" accept="image/*" label="Photo" />
          </div>
          <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
            <button v-if="!aluno.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Deletar aluno</button>
            <loading-button :loading="form.processing" class="btn-red ml-auto" type="submit">Atualizar aluno</loading-button>
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

  export default {
    components: {
      FileInput,
      Head,
      Link,
      LoadingButton,
      SelectInput,
      TextInput,
      TrashedMessage,
    },
    layout: Layout,
    props: {
      aluno: Object,
    },
    remember: 'form',
    data() {
      return {
        form: this.$inertia.form({
          _method: 'put',
          name: this.aluno.name,
          email: this.aluno.email,
          password: '',
          photo: null,
        }),
      }
    },
    methods: {
      update() {
        this.form.post(`/alunos/${this.aluno.id}`, {
          onSuccess: () => this.form.reset('password', 'photo'),
        })
      },
      destroy() {
        if (confirm('Tem certeza que deseja remover este aluno?')) {
          this.$inertia.delete(`/alunos/${this.aluno.id}`)
        }
      },
      restore() {
        if (confirm('Tem certeza que deseja restaurar este aluno?')) {
          this.$inertia.put(`/alunos/${this.aluno.id}/restore`)
        }
      },
    },
  }
  </script>
