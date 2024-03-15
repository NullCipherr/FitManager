<template>
    <div class="">

      <Head title="Avaliações" />
      <h1 class="mb-8 text-3xl font-bold">Avaliações</h1>
      <div class="flex items-center justify-between mb-6">
        <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
          <!-- <label class="block text-red-700">Tipo:</label> -->
          <!-- <select v-model="form.type" class="form-select mt-1 w-full">
            <option :value="null" />
            <option value="Aluno">Aluno</option>
            <option value="Funcionario">Funcionário</option>
            <option value="Professor">Professor</option>
          </select> -->
          <label class="block mt-4 text-red-700">Excluídos</label>
          <select v-model="form.trashed" class="form-select mt-1 w-full">
            <option :value="null" />
            <option value="with">Com excluídos</option>
            <option value="only">Apenas excluídos</option>
          </select>

        </search-filter>
        <div class="flex items-center mr-4 " >

<!-- <label class="text-red-500" for="start-date">Início:</label> -->
<input id='start-date' class="relative px-3 py-3 w-full rounded focus:shadow-outline mr-1"
    autocomplete="off" type="date" v-model="startDate" />

<!-- <label class="text-red-500" for="end-date">Fim:</label> -->
<input id="end-date" class="relative px-3 py-3 w-full rounded focus:shadow-outline" autocomplete="off"
    type="date" v-model="endDate" />
<button class="text-gray-500 hover:text-red-700 focus:text-red-500 text-sm ml-1 mr-2" type="button"
    @click="resetInput">Resetar</button>


</div>
        <Link class="btn-red" href="/avaliacoes/create">
        <span>Nova</span>
        <span class="hidden md:inline">&nbsp;Avaliação</span>
        </Link>
      </div>
      <div class="bg-white rounded-md shadow overflow-x-auto">
        <table class="w-full whitespace-nowrap">
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 px-6">Descrição</th>
            <th class="pb-4 pt-6 px-6">Nota</th>
            <th class="pb-4 pt-6 px-6">Aluno</th>
            <th class="pb-4 pt-6 px-6" colspan="2">Data</th>
          </tr>
          <tr v-for="avaliacao in avaliacoes" :key="avaliacao.id" class="hover:bg-red-100 focus-within:bg-red-100">
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-red-500" :href="`/avaliacoes/${avaliacao.id}/edit`">
              <img v-if="avaliacao.photo" class="block -my-2 mr-2 w-5 h-5 rounded-full" :src="avaliacao.photo" />
              {{ avaliacao.descr }}
              <icon v-if="avaliacao.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-red-400" />
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/avaliacoes/${avaliacao.id}/edit`" tabindex="-1">
              {{ avaliacao.nota }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/avaliacoes/${avaliacao.id}/edit`" tabindex="-1">
              {{ avaliacao.aluno }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/avaliacoes/${avaliacao.id}/edit`" tabindex="-1">
              {{ formatDate(avaliacao.created_a) }}
              </Link>
            </td>
            <td class="w-px border-t">
              <Link class="flex items-center px-4" :href="`/avaliacoes/${avaliacao.id}/edit`" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-red-400" />
              </Link>
            </td>
          </tr>
          <tr v-if="avaliacoes.length === 0">
            <td class="px-6 py-4 border-t" colspan="4">Nenhum usuário encontrado.</td>
          </tr>
        </table>
      </div>
      <!-- <pagination class="mt-6" :links="avaliacoes.links" /> -->

    </div>
  </template>

  <script>
  import { Head, Link } from '@inertiajs/vue3'
  // import Layout from '@/Shared/Layout'

  import Icon from '@/Shared/Icon'
  import pickBy from 'lodash/pickBy'
  import Layout from '@/Shared/Layout'
  import throttle from 'lodash/throttle'
  import mapValues from 'lodash/mapValues'
  import SearchFilter from '@/Shared/SearchFilter'
  import Pagination from '@/Shared/Pagination'
  import { ref } from 'vue';
  import moment from 'moment';

  export default {
    setup() {
        const date = ref(new Date());

        return {
            date,
        }
    },
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
      avaliacoes: Object,
      auth: Object

    },
    data() {
      return {
        form: {
          search: this.filters.search,
          trashed: this.filters.trashed,
        },
        startDate: '',
        endDate: '',

      }
    },
    watch: {
      form: {
        deep: true,
        handler: throttle(function () {
          this.$inertia.get('/avaliacoes', pickBy(this.form), { preserveState: true })
        }, 150),
      },
    },
    methods: {
      reset() {
        this.form = mapValues(this.form, () => null)
      },
      formatDate(date) {
            console.log(this.avaliacoes[0])
            return moment(date).format('DD/MM/YYYY');
        },
        resetInput() {
            this.startDate = '';
            this.endDate = '';
        }
    },

    computed: {
        filteredByDateRange() {
            // console.log(this.avaliacoes)

            const routeKeys = Object.keys(this.avaliacoes[0].descr);
            console.log(routeKeys)
            // Filtra as rotas de acordo com o intervalo entre as datas
            const filteredByDateRange = routeKeys.filter(key => {
                const avalDate = new Date(this.avaliacoes[0].created_at);
                const startDate = this.startDate ? new Date(this.startDate) : null;
                const endDate = this.endDate ? new Date(this.endDate) : null;
                return (!startDate || avalDate >= startDate) && (!endDate || avalDate <= endDate.setDate(endDate.getDate() + 1));
            }).map(key => this.avaliacoes.data[key]);
            console.log(filteredByDateRange)
            return filteredByDateRange;
        }
    }
  }
  </script>
