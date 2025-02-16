<template>
  <div class="w-full min-h-screen flex flex-col">
    <Navigation />
    <main id="main-content" class="w-full pt-16 flex-grow" role="main">
      <router-view></router-view>
    </main>
    <Footer />
  </div>
</template>

<script>
import Navigation from './Navigation.vue'
import Footer from './Footer.vue'
import { userStore } from '../store/user'

export default {
  name: 'MainLayout',
  components: {
    Navigation,
    Footer
  },
  setup() {
    return {
      userStore
    }
  }
}
</script>
