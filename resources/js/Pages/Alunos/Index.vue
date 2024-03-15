<template>
  <div class="">

    <Head title="Alunos" />
    <h1 class="mb-8 text-3xl font-bold">Alunos</h1>
    <div class="flex items-center justify-between mb-6">
      <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
        <label class="block text-red-700">Role:</label>
        <select v-model="form.role" class="form-select mt-1 w-full">
          <option :value="null" />
          <option value="aluno">User</option>
          <option value="owner">Owner</option>
        </select>
        <label class="block mt-4 text-red-700">Trashed:</label>
        <select v-model="form.trashed" class="form-select mt-1 w-full">
          <option :value="null" />
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </search-filter>
      <Link class="btn-red" href="/alunos/create">
      <span>Create</span>
      <span class="hidden md:inline">&nbsp;User</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Name</th>
          <th class="pb-4 pt-6 px-6">Email</th>
          <th class="pb-4 pt-6 px-6" colspan="2">Role</th>
        </tr>
        <tr v-for="aluno in alunos" :key="aluno.id" class="hover:bg-red-100 focus-within:bg-red-100">
          <td class="border-t">
            <Link class="flex items-center px-6 py-4 focus:text-red-500" :href="`/alunos/${aluno.id}/edit`">
            <img v-if="aluno.photo" class="block -my-2 mr-2 w-5 h-5 rounded-full" :src="aluno.photo" />
            {{ aluno.name }}
            <icon v-if="aluno.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-red-400" />
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/alunos/${aluno.id}/edit`" tabindex="-1">
            {{ aluno.email }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/alunos/${aluno.id}/edit`" tabindex="-1">
            {{ aluno.owner ? 'Owner' : 'User' }}
            </Link>
          </td>
          <td class="w-px border-t">
            <Link class="flex items-center px-4" :href="`/alunos/${aluno.id}/edit`" tabindex="-1">
            <icon name="cheveron-right" class="block w-6 h-6 fill-red-400" />
            </Link>
          </td>
        </tr>
        <tr v-if="alunos.length === 0">
          <td class="px-6 py-4 border-t" colspan="4">Nenhum aluno encontrado.</td>
        </tr>
      </table>
    </div>
    <!-- <pagination class="mt-6" :links="alunos.links" /> -->

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
    alunos: Array,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        role: this.filters.role,
        trashed: this.filters.trashed,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/alunos', pickBy(this.form), { preserveState: true })
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
