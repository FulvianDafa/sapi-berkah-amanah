<template>
  <nav class="bg-green-700 text-white py-4 px-6">
    <div class="container mx-auto flex items-center justify-between">
      <!-- Logo + Menu -->
      <div class="flex items-center space-x-10">
        <h1 class="text-xl font-bold">Sapi Berkah Amanah</h1>

        <ul class="hidden md:flex space-x-6 items-center">
          <li><router-link to="/" class="hover:text-green-200">Home</router-link></li>

          <!-- Program Dropdown with Delay -->
          <li
            class="relative"
            @mouseenter="openProgram"
            @mouseleave="closeProgramWithDelay"
          >
            <button class="hover:text-green-200 flex items-center">
              Program
              <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <ul
              v-show="isProgramOpen"
              class="absolute bg-white text-green-700 shadow-lg mt-2 rounded-md transition-all duration-200 ease-out z-50"
              @mouseenter="cancelClose"
              @mouseleave="closeProgramWithDelay"
            >
              <li>
                <router-link to="/daftarreseller" class="block px-4 py-2 hover:bg-green-100">Daftar Reseller</router-link>
              </li>
              <li>
                <a href="https://forms.gle/link-titip-sapi" target="_blank" class="block px-4 py-2 hover:bg-green-100">Daftar Titip Sapi</a>
              </li>
            </ul>
          </li>

          <li><router-link to="/produk" class="hover:text-green-200">Katalog</router-link></li>
          <li><router-link to="/faq" class="hover:text-green-200">FAQ</router-link></li>
        </ul>
      </div>

      <!-- Tombol Booking WA (desktop kanan) -->
      <div class="hidden md:block">
        <a
          href="https://wa.me/6282127590547?text=Halo%20saya%20mau%20booking%20sapi%20kurban"
          target="_blank"
          class="bg-white text-green-700 font-semibold px-4 py-2 rounded hover:bg-green-100"
        >
          Booking WA
        </a>
      </div>

      <!-- Mobile Hamburger -->
      <button @click="menuOpen = !menuOpen" class="md:hidden focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>

    <!-- Mobile Menu -->
    <transition name="slide-fade">
      <div v-if="menuOpen" class="md:hidden bg-green-600">
        <ul class="flex flex-col space-y-2 p-4">
          <li><router-link @click="menuOpen = false" to="/">Home</router-link></li>
          <li><router-link @click="menuOpen = false" to="/daftarreseller">Daftar Reseller</router-link></li>
          <li><a @click="menuOpen = false" href="https://forms.gle/link-titip-sapi" target="_blank">Daftar Titip Sapi</a></li>
          <li><router-link @click="menuOpen = false" to="/produk">Katalog</router-link></li>
          <li><router-link @click="menuOpen = false" to="/faq">FAQ</router-link></li>
          <li>
            <a
              href="https://wa.me/6282127590547?text=Halo%20saya%20mau%20booking%20sapi%20kurban"
              target="_blank"
              class="block mt-2 bg-white text-green-700 py-2 text-center rounded hover:bg-green-100"
            >
              Booking WA
            </a>
          </li>
        </ul>
      </div>
    </transition>
  </nav>
</template>

<script setup>
import { ref } from 'vue'

const menuOpen = ref(false)

// Dropdown Program Hover Delay Logic
const isProgramOpen = ref(false)
let programCloseTimeout = null

const openProgram = () => {
  isProgramOpen.value = true
  clearTimeout(programCloseTimeout)
}

const closeProgramWithDelay = () => {
  programCloseTimeout = setTimeout(() => {
    isProgramOpen.value = false
  }, 300) // delay 300ms
}

const cancelClose = () => {
  clearTimeout(programCloseTimeout)
}
</script>

<style scoped>
/* Optional Transition Effect */
.slide-fade-enter-active, .slide-fade-leave-active {
  transition: all 0.3s ease;
}
.slide-fade-enter-from, .slide-fade-leave-to {
  transform: translateY(-10px);
  opacity: 0;
}
</style>
