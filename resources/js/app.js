import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faPhone } from "@fortawesome/free-solid-svg-icons";
// import { InertiaProgress } from '@inertiajs/progress'
// import NProgress from 'nprogress'
// router.on('start', () => NProgress.start())
// router.on('finish', () => NProgress.done())


/* add some free styles */
import { faTwitter } from '@fortawesome/free-brands-svg-icons'
import { faUserSecret } from '@fortawesome/free-solid-svg-icons'
import { faSearch } from '@fortawesome/free-solid-svg-icons'
library.add(faTwitter, faUserSecret, faSearch, faPhone)

// InertiaProgress.init({
//   // The delay after which the progress bar will
//   // appear during navigation, in milliseconds.
//   delay: 1000,

//   // The color of the progress bar.
//   color: '#f542f5',

//   // Whether to include the default NProgress styles.
//   includeCSS: true,
//   // Whether the NProgress spinner will be shown.
//   showSpinner: false,
// })

createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  title: title => title ? `${title} - FitManager` : 'FitManager',

  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .component('font-awesome-icon', FontAwesomeIcon)
      .mount(el)
  },
})