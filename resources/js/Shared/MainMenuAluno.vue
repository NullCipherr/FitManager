<template>
    <!-- <div>
      <div class="mb-4">
        <Link class="group flex items-center py-3" href="/">
        <icon name="dashboard" class="mr-2 w-4 h-4"
          :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Dashboard</div>
        </Link>
      </div>
      <div class="mb-4">
        <Link class="group flex items-center py-3" href="/contacts">
        <icon name="users" class="mr-2 w-4 h-4"
          :class="isUrl('contacts') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('contacts') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Clientes</div>
        </Link>
      </div>
      <div class="mb-4">
        <Link class="group flex items-center py-3" href="/products">
        <icon name="product" class="mr-2  -ml-1 w-5 h-5"
          :class="isUrl('products') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('products') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Produtos</div>
        </Link>
      </div>
      <div class="mb-4">
        <Link class="group flex items-center py-3" href="/unitys">
        <icon name="unity" class="mr-2 -ml-1 w-5 h-5"
          :class="isUrl('unitys') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('unitys') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Unidades</div>
        </Link>
      </div>
      <div class="mb-4">
        <Link class="group flex items-center py-3" href="/natures">
        <icon name="nature" class="mr-2 w-4 h-4"
          :class="isUrl('natures') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('natures') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Naturezas</div>
        </Link>
      </div>
      <div class="mb-4">
        <Link class="group flex items-center py-3" href="/shipping">
        <div :class="isUrl('shipping') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Transportadoras</div>
        </Link>
      </div>
      <div class="mb-4">
        <Link class="group flex items-center py-3" href="/mycompany/create">
        <icon name="config" class="mr-2  w-6 h-6"
          :class="isUrl('configs') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('configs') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Configurações</div>
        </Link>
      </div>
      <div class="mb-4">
        <Link class="group flex items-center py-3" href="/reports">
        <icon name="printer" class="mr-2 w-4 h-4"
          :class="isUrl('reports') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('reports') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Relatórios</div>
        </Link>
      </div>
    </div> -->

    <div>
      <sidebar-menu :menu="menu" />
      <!-- <span class="pr-10">{{ relative }}</span> -->


    </div>

  </template>

  <style>
  .v-sidebar-menu .vsm--title {
    /* padding-left: 2px; */
  }

  /* .v-sidebar-menu {
    margin-top: 116px;

  } */

  .v-sidebar-menu.vsm_expanded {
    width: 224px;

  }

  .v-sidebar-menu.vsm_collapsed {
    width: 224px;

  }

  .v-sidebar-menu .vsm--title_hidden {
    background-color: #e2250b;
    color: #e2250b;

  }

  .v-sidebar-menu .vsm--mobile-bg {
    background-color: #e2250b;
  }



  .v-sidebar-menu.vsm_expanded .vsm--link_level-1.vsm--link_open {

    background-color: #e2250b;
  }

  .v-sidebar-menu.vsm_collapsed .vsm--link_level-1.vsm--link_hover .vsm--icon {

    background-color: #e2250b;
  }

  .v-sidebar-menu .vsm-arrow:after {
    font-family: FontAwesome
  }

  .v-sidebar-menu .collapse-btn:after {
    content: "\f07e";
    font-family: FontAwesome;
  }

  .v-sidebar-menu .vsm--link_level-1 .vsm--icon {
    padding-left: 8px;
    /* margin: 10px; */
    /* background-color: #2f365f; */
    background-color: inherit;
    margin: auto;

    position: relative;
    width: 4px;
    height: 4px;

  }

  .img {
    width: 10px;
    height: 10px;
  }

  .v-sidebar-menu .vsm--link_hover {
    background-color: #cb5d56;
  }

  .v-sidebar-menu .vsm--title>span:first-child {
    -webkit-box-flex: 1;
    -ms-flex-positive: 1;
    flex-grow: 0;
    position: center;
    margin: auto;
    width: 85%;
    /* border: 3px solid green; */
    /* padding: 10px; */
    /* padding: 5px 0 0 15px; */
  }

  /*.fa-minus{
    width: 40px;
    height: 40px;
  }*/

  .v-sidebar-menu .vsm--title>span:first-child:hover {
    background-color: inherit;

  }

  .v-sidebar-menu .vsm--link_level-1.vsm--link_active {
    -webkit-box-shadow: inset 3px 0 0 0 #e2250b;
    box-shadow: inset 3px 0 0 0 #e2250b;
  }
  </style>

  <script>
  import '@fortawesome/fontawesome-free/css/all.css'
  import { Link } from '@inertiajs/vue3'
  import Icon from '@/Shared/Icon'
  import { SidebarMenu } from 'vue-sidebar-menu'
  import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'
  import { library } from '@fortawesome/fontawesome-svg-core'
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

  export default {
    components: {
      Icon,
      Link,
      SidebarMenu,
      FontAwesomeIcon,
      library
    },
    methods: {
      onToggleCollapse(collapsed) { },

    },
    props: {

    },
    data() {
      return {
        menu: [
          {
            header: 'start',
            // hidden: true,
            hiddenOnCollapse: true,
            // class: ''


          },



          {
            href: '/treinos',
            title: 'Treinos',
            icon: 'fa-solid fa-dumbbell'
          },

          {
            href: '/avaliacoes',
            title: 'Avaliações',
            icon: 'fa-solid fa-list-check'
          },






        ]
      }
    },

  }
  </script>
