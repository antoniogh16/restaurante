<template>
  <aside class="z-20 hidden w-64 overflow-y-auto bg-purple-900 md:block flex-shrink-0">
    <div class="py-4 text-white">
      <!-- Enlace al Dashboard -->
      <Link class="ml-6 text-lg font-bold text-gray-800" :href="route('dashboard')">
        RESTAURANT
      </Link>

      <ul class="mt-6">
        <!-- Enlace Dashboard -->
        <li class="relative px-6 py-3">
          <NavLink :href="route('dashboard')" :active="route().current('dashboard')" class="border-none shadow-none">
            <template #icon>
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
              </svg>
            </template>
            Dashboard
          </NavLink>
        </li>

        <!-- Enlace Users -->
        <li class="relative px-6 py-3">
          <NavLink :href="route('users.index')" :active="route().current('users.index')" class="border-none shadow-none">
            <template #icon>
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
              </svg>
            </template>
            Users
          </NavLink>
        </li>

        <!-- Enlace Restaurantes -->
        <li class="relative px-6 py-3">
          <NavLink :href="route('restaurantes.index')" :active="route().current('restaurantes.index')" class="border-none shadow-none">
            <template #icon>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
              </svg>
            </template>
            Restaurantes
          </NavLink>
        </li>

        <!-- Enlace Empleados Dropdown -->
        <li class="relative px-6 py-3">
          <button 
            @click="toggleTwoLevelMenu"
            class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800"
            aria-haspopup="true"
            :aria-expanded="showingTwoLevelMenu.toString()">
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
          <ul v-show="showingTwoLevelMenu" class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md bg-gray-50" aria-label="submenu">
            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800">
              <NavLink :href="route('empleados.index')" :active="route().current('empleados.index')" class="border-none shadow-none">
                List
              </NavLink>
            </li>
            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800">
              <NavLink :href="route('empleados.create')" :active="route().current('empleados.create')" class="border-none shadow-none">
                Create
              </NavLink>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </aside>
</template>

<script>
import NavLink from '@/Components/NavLink.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

export default {
  components: {
    NavLink,
    Link,
  },

  setup() {
    const showingTwoLevelMenu = ref(false);

    const toggleTwoLevelMenu = () => {
      showingTwoLevelMenu.value = !showingTwoLevelMenu.value;
    };

    return {
      showingTwoLevelMenu,
      toggleTwoLevelMenu
    };
  },
}
</script>
