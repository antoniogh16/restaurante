<template>
  <!-- Transición de fondo oscuro para el menú -->
  <transition
    enter-active-class="transition ease-in-out duration-150"
    enter-from-class="opacity-0"
    enter-to-class="opacity-100"
    leave-active-class="transition ease-in-out duration-150"
    leave-from-class="opacity-100"
    leave-to-class="opacity-0">
    <div v-show="$page.props.showingMobileMenu" class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>
  </transition>

  <!-- Menú lateral móvil con transiciones -->
  <transition
    enter-active-class="transition ease-in-out duration-150"
    enter-from-class="opacity-0 transform -translate-x-20"
    enter-to-class="opacity-100"
    leave-active-class="transition ease-in-out duration-150"
    leave-from-class="opacity-100"
    leave-to-class="opacity-0 transform -translate-x-20">
    <aside v-show="$page.props.showingMobileMenu" class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-purple-800 md:hidden">
      <div class="py-4 text-white">
        <Link class="ml-6 text-lg font-bold " :href="route('dashboard')">
          RESTAURANT
        </Link>
        <ul class="mt-6">
          <!-- Enlace a Dashboard -->
          <li class="relative px-6 py-3">
            <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
              <template #icon>
                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                  <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
              </template>
              Dashboard
            </ResponsiveNavLink>
          </li>

          <!-- Enlace a Users -->
          <li class="relative px-6 py-3">
            <ResponsiveNavLink :href="route('users.index')" :active="route().current('users.index')">
              <template #icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
              </template>
              Users
            </ResponsiveNavLink>
          </li>

          <!-- Enlace a Restaurantes -->
          <li class="relative px-6 py-3">
            <ResponsiveNavLink :href="route('restaurantes.index')" :active="route().current('restaurantes.index')">
              <template #icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
              </template>
              Restaurantes
            </ResponsiveNavLink>
          </li>

          <!-- Enlace de Empleados (con submenú) -->
          <li class="relative px-6 py-3">
            <button @click="showingTwoLevelMenu = !showingTwoLevelMenu"
                    class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800"
                    aria-haspopup="true">
              <span class="inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <span class="ml-4">Empleados</span>
              </span>
              <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
              </svg>
            </button>
            <ul v-show="showingTwoLevelMenu || route().current('empleados.index') || route().current('empleados.create')" class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50"
                aria-label="submenu">
              <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800">
                <ResponsiveNavLink :href="route('empleados.index')" :active="route().current('empleados.index')">
                  List
                </ResponsiveNavLink>
              </li>
              <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800">
                <ResponsiveNavLink :href="route('empleados.create')" :active="route().current('empleados.create')">
                  Create
                </ResponsiveNavLink>
              </li>
            </ul>
          </li>

        </ul>
      </div>
    </aside>
  </transition>
</template>

<script setup>
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'

let showingTwoLevelMenu = ref(false)
</script>
