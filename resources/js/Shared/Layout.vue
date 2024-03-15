<template>
  <div>
    <div id="dropdown" />
    <div class="md:flex md:flex-col">
      <div class="md:flex md:flex-col md:h-screen">
        <div class=" md:flex md:flex-shrink-0">
          <div
            class="flex items-center justify-between px-6 py-4 bg-[#1e1e21] md:flex-shrink-0 md:justify-center md:w-56">
            <Link class="mt-1" href="/">
            </Link>
            <dropdown class="md:hidden" placement="bottom-end">
              <template #default>
                <svg class="w-6 h-6 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                </svg>
              </template>
              <template #dropdown>
                <div class="mt-2 px-8 py-4 bg-red-800 rounded shadow-lg">
                  <main-menu />
                </div>
              </template>
            </dropdown>
          </div>
          <div
            class="md:text-md flex items-center justify-between p-4 w-full text-sm bg-white border-b md:px-12 md:py-0">
            <div class="mr-4 mt-1"></div>
            <dropdown class="mt-1" placement="bottom-end">
              <template #default>
                <div class="group flex items-center cursor-pointer select-none">
                  <div class="mr-1 text-gray-700 group-hover:text-red-600 focus:text-red-600 whitespace-nowrap">
                    <!-- <span>{{ auth.user.id }}</span>
                    <span>{{ auth.user.name }}</span> -->

                    <span>{{ auth.user.name }}</span>
                    <!-- <span >{{ auth.user.type }}</span> -->

                    <!-- <span>{{ auth.user.role }}</span> -->
                    <!-- <button type="button"
                                            class="text-white text-xs flex justify-between -mr-5 ml-3    font-medium rounded-sm"
                                            @click="browse(`${auth}`)">
                                            <icon name="trash" id="icone" class="justify-end w-5 h-5 fill-gray-400" />
                                        </button> -->
                    <!--<span class="hidden md:inline">&nbsp;{{ auth.user.last_name }}</span>-->
                  </div>
                  <icon class="w-5 h-5 fill-gray-700 group-hover:fill-red-600 focus:fill-red-600"
                    name="cheveron-down" />
                </div>
              </template>
              <template #dropdown>
                <div class="mt-2 py-2 text-sm bg-white rounded shadow-xl">
                  <Link class="block px-6 py-2 hover:text-white hover:bg-[#cb5d56]"
                    :href="`/users/${auth.user.id}/edit`">Meu
                  perfil</Link>
                  <Link class="block px-6 py-2 hover:text-white hover:bg-[#cb5d56]" href="/users">Gerenciar usuários
                  </Link>
                  <Link class="block px-6 py-2 w-full text-left hover:text-white hover:bg-[#cb5d56]" href="/logout"
                    method="delete" as="button">Logout</Link>
                </div>
              </template>
            </dropdown>
          </div>
        </div>
        <div class="md:flex  md:flex-grow md:overflow-hidden">

          <main-menu-aluno v-if="auth.user.type == 'Aluno' || auth.user.type == 'Professor'"
            class="hidden  flex-shrink-0 p-12 w-56 overflow-y-auto md:block" />
          <main-menu  v-if="auth.user.type == 'Funcionario'"
            class="hidden  flex-shrink-0 p-12 w-56 overflow-y-auto md:block" />



          <div class="px-4 py-8  md:flex-1 md:p-12 md:overflow-y-auto" scroll-region>
            <flash-messages />
            <slot />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'
import Icon from '@/Shared/Icon'
import Dropdown from '@/Shared/Dropdown'
import MainMenu from '@/Shared/MainMenu'
import MainMenuAluno from '@/Shared/MainMenuAluno'
import FlashMessages from '@/Shared/FlashMessages'

export default {
  components: {
    Dropdown,
    FlashMessages,
    Icon,
    Link,
    // Logo,
    MainMenu,
    MainMenuAluno,

  },
  props: {
    auth: Object,
  },
  methods: {


  },
}
</script>
