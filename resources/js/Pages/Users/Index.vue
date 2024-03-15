<template>
  <div class="">

    <Head title="Users" />
    <h1 class="mb-8 text-3xl font-bold">Users</h1>
    <div class="flex items-center justify-between mb-6">
      <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
        <label class="block text-red-700">Tipo:</label>
        <select v-model="form.type" class="form-select mt-1 w-full">
          <option :value="null" />
          <option value="Aluno">Aluno</option>
          <option value="Funcionario">Funcionário</option>
          <option value="Professor">Professor</option>
        </select>
        <label class="block mt-4 text-red-700">Excluídos</label>
        <select v-model="form.trashed" class="form-select mt-1 w-full">
          <option :value="null" />
          <option value="with">Com excluídos</option>
          <option value="only">Apenas excluídos</option>
        </select>
      </search-filter>
      <Link class="btn-red" href="/users/create">
      <span>Novo</span>
      <span class="hidden md:inline">&nbsp;Usuário</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Nome</th>
          <th class="pb-4 pt-6 px-6">Email</th>
          <th class="pb-4 pt-6 px-6" colspan="2">Tipo</th>
        </tr>
        <tr v-for="user in users" :key="user.id" class="hover:bg-red-100 focus-within:bg-red-100">
          <td class="border-t">
            <Link class="flex items-center px-6 py-4 focus:text-red-500" :href="`/users/${user.id}/edit`">
            <img v-if="user.photo" class="block -my-2 mr-2 w-5 h-5 rounded-full" :src="user.photo" />
            {{ user.name }}
            <icon v-if="user.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-red-400" />
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/users/${user.id}/edit`" tabindex="-1">
            {{ user.email }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/users/${user.id}/edit`" tabindex="-1">
            {{ user.type }}
            </Link>
          </td>
          <td class="w-px border-t">
            <Link class="flex items-center px-4" :href="`/users/${user.id}/edit`" tabindex="-1">
            <icon name="cheveron-right" class="block w-6 h-6 fill-red-400" />
            </Link>
          </td>
        </tr>
        <tr v-if="users.length === 0">
          <td class="px-6 py-4 border-t" colspan="4">Nenhum usuário encontrado.</td>
        </tr>
      </table>
    </div>
    <!-- <pagination class="mt-6" :links="users.links" /> -->

  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Icon from '@/Shared/Icon'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import SearchFilter from '@/Shared/SearchFilter'
import Pagination from '@/Shared/Pagination'

export default {
  components: {
    Head,
    Icon,
    Link,
    SearchFilter,
    Pagination
  },
  layout: Layout,
  props: {
    filters: Object,
    users: Array,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        type: this.filters.type,
        trashed: this.filters.trashed,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/users', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
