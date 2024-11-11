<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Bar, Pie } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement } from 'chart.js';
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement);
import { ref, onMounted } from 'vue';

const props = defineProps({
  empleados: { type: Array, required: true }, // Datos de empleados
  restaurantes: { type: Array, required: true }, // Datos de restaurantes
  totalRestaurantes: { type: Number, required: true } // Total de restaurantes
});

// Definir las variables reactivas para los datos
const positions = ref([]);
const nationalities = ref([]);
const positionsData = ref([]);
const nationalityData = ref([]);
const restaurantNationalities = ref([]);
const restaurantData = ref([]);
const colors = ref([]);

// Función para generar colores aleatorios
const random = () => {
  return `rgb(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)})`;
};

// Procesar los datos de empleados y restaurantes
onMounted(() => {
  // Datos de empleados
  const positionCount = {};
  const nationalityCount = {};

  props.empleados.forEach((employee) => {
    const position = employee.position;
    positionCount[position] = (positionCount[position] || 0) + 1;

    const nationality = employee.nationality;
    nationalityCount[nationality] = (nationalityCount[nationality] || 0) + 1;
  });

  // Actualizar los datos para los gráficos de empleados
  positions.value = Object.keys(positionCount);
  positionsData.value = Object.values(positionCount);
  nationalities.value = Object.keys(nationalityCount);
  nationalityData.value = Object.values(nationalityCount);

  // Crear colores aleatorios para las barras de empleados
  colors.value = Array(positions.value.length).fill('').map(random);

  // Datos de restaurantes
  const restaurantNationalityCount = {};
  const restaurantEmployeeCount = {};

  props.restaurantes.forEach((restaurant) => {
    const nationality = restaurant.nationality;
    restaurantNationalityCount[nationality] = (restaurantNationalityCount[nationality] || 0) + 1;

    const employeesCount = restaurant.employees_count;
    restaurantEmployeeCount[nationality] = (restaurantEmployeeCount[nationality] || 0) + employeesCount;
  });

  // Actualizar los datos para los gráficos de restaurantes
  restaurantNationalities.value = Object.keys(restaurantNationalityCount);
  restaurantData.value = Object.values(restaurantEmployeeCount);
});

// Datos para las gráficas
const chartOptions = ref({ responsive: true });
const chartDataByPosition = ref({
  labels: positions.value,
  datasets: [{
    label: 'Número de empleados por posición',
    data: positionsData.value,
    backgroundColor: colors.value
  }]
});

const chartDataByNationality = ref({
  labels: nationalities.value,
  datasets: [{
    label: 'Número de empleados por nacionalidad',
    data: nationalityData.value,
    backgroundColor: colors.value
  }]
});

const chartDataByRestaurantNationality = ref({
  labels: restaurantNationalities.value,
  datasets: [{
    label: 'Número de empleados por nacionalidad de restaurante',
    data: restaurantData.value,
    backgroundColor: Array(restaurantNationalities.value.length).fill('').map(random)
  }]
});
</script>

<template>
  <Head title="Dashboard" />
  
  <AuthenticatedLayout>
    <template #header>
      Dashboard
    </template>
    
    <div class="p-4 bg-white rounded-lg shadow-xs">
      <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <!-- Card: Total empleados -->
        <div class="flex border items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
          <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
            </svg>
          </div>
          <div>
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Total empleados</p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ props.empleados.length }}</p>
          </div>
        </div>
        
        <!-- Card: Total restaurantes -->
        <div class="flex border items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
          <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M4 2C2.89543 2 2 2.89543 2 4V16C2 17.1046 2.89543 18 4 18H16C17.1046 18 18 17.1046 18 16V4C18 2.89543 17.1046 2 16 2H4ZM16 4V16H4V4H16Z" />
            </svg>
          </div>
          <div>
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Total restaurantes</p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ props.totalRestaurantes }}</p>
          </div>
        </div>
      </div>

      <!-- Gráficos -->
      <div class="grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg">
        <div class="min-w-0 p-4 rounded-lg shadow-xs">
          <span class="text-lg p-4">Empleados por posición</span>
          <div class="flex items-center">
            <Bar :data="chartDataByPosition" :options="chartOptions" />
          </div>
        </div>

        <div class="min-w-0 p-4 rounded-lg shadow-xs">
          <span class="text-lg p-4">Empleados por nacionalidad</span>
          <div class="flex items-center">
            <Pie :data="chartDataByNationality" :options="chartOptions" />
          </div>
        </div>

        <div class="min-w-0 p-4 rounded-lg shadow-xs">
          <span class="text-lg p-4">Empleados por nacionalidad de restaurante</span>
          <div class="flex items-center">
            <Pie :data="chartDataByRestaurantNationality" :options="chartOptions" />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
