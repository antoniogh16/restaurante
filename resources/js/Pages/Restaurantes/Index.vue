<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';  
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputGroup from '@/Components/InputGroup.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { Inertia } from '@inertiajs/inertia';

// Props del controlador
const props = defineProps({
  restaurantes: { type: Array },
  countries: { type: Array }
});

const form = useForm({ name: '', last_name: '', country_id: '' });
const v = ref({ id: '', name: '', last_name: '', country: '' });
const showModalView = ref(false);
const showModalForm = ref(false);
const showModalDel = ref(false);
const title = ref('');
const operation = ref(1);  // 1 = Crear, 2 = Editar
const restaurantIdToDelete = ref(null);  // Guardar el id del restaurante a eliminar

// Abrir modal para ver los detalles del restaurante
const openModalView = (r) => {
  showModalForm.value = false;
  showModalDel.value = false;

  v.value.name = r.name;
  v.value.last_name = r.last_name;
  v.value.country = r.country.country;
  showModalView.value = true;
}

// Abrir modal para crear o editar restaurante
const openModalForm = (op, r = null) => {
  showModalView.value = false;
  showModalDel.value = false;

  showModalForm.value = true;
  operation.value = op;
  if (op === 1) {
    title.value = 'Crear Restaurante';
    form.reset();  // Resetear formulario para nuevo restaurante
  } else {
    title.value = 'Editar Restaurante';
    form.name = r.name;
    form.last_name = r.last_name;
    form.country_id = r.country_id;
    v.value.id = r.id;
  }
}

// Abrir modal para confirmar eliminación
const openModalDel = (restaurantId) => {
  showModalView.value = false;
  showModalForm.value = false;

  restaurantIdToDelete.value = restaurantId;
  showModalDel.value = true;
}

// Cerrar modales
const closeModalView = () => {
  showModalView.value = false;
}
const closeModalForm = () => {
  showModalForm.value = false;
  form.reset();  // Resetear los campos del formulario al cerrar
}
const closeModalDel = () => {
  showModalDel.value = false;
}

// Guardar restaurante (Crear/Editar)
const save = () => {
  if (operation.value === 1) {
    form.post(route('restaurantes.store'), {
      onSuccess: () => closeModalForm(),
    });
  } else {
    form.put(route('restaurantes.update', v.value.id), {
      onSuccess: () => closeModalForm(),
    });
  }
}

// Eliminar restaurante
const deleteRestaurant = () => {
  Inertia.delete(route('restaurantes.destroy', restaurantIdToDelete.value), {
    onSuccess: () => {
      closeModalDel();
    }
  });
}
</script>

<template>
  <AuthenticatedLayout>
    <template #header>Restaurantes</template>

    <PrimaryButton @click="openModalForm(1)" class="flex items-center">
      <span class="mr-2">Agregar Restaurante</span>
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
      </svg>
    </PrimaryButton>

    <div class="w-full overflow-hidden rounded-lg border shadow-md">
      <div class="w-full overflow-x-auto bg-white">
        <table class="w-full whitespace-no-wrap">
          <thead>
            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
              <th class="px-4 py-3">#</th>
              <th class="px-4 py-3">Restaurante</th>
              <th class="px-4 py-3">Nombre</th>
              <th class="px-4 py-3">País</th>
              <th class="px-4 py-3">Detalle</th>
              <th class="px-4 py-3">Editar</th>
              <th class="px-4 py-3">Eliminar</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            <tr v-for="(r, i) in restaurantes" :key="r.id" class="text-white">
              <td class="px-4 py-3 text-sm">{{ i + 1 }}</td>
              <td class="px-4 py-3 text-sm">{{ r.name }}</td>
              <td class="px-4 py-3 text-sm">{{ r.last_name }}</td>
              <td class="px-4 py-3 text-sm">{{ r.country.country }}</td>
              <td class="px-4 py-3 text-sm">
                <SecondaryButton @click="openModalView(r)" class="flex items-center">
                  <span class="mr-2">Ver</span>
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c2.5 0 4.5 2 4.5 4.5S14.5 17 12 17 7.5 15 7.5 12.5 9.5 8 12 8zm0 0c4.5 0 8.5 3.5 8.5 8s-4 8-8.5 8-8.5-3.5-8.5-8 4-8 8.5-8z" />
                  </svg>
                </SecondaryButton>
              </td>
              <td class="px-4 py-3 text-sm">
                <WarningButton @click="openModalForm(2, r)" class="flex items-center">
                  <span class="mr-2">Editar</span>
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232a3 3 0 014.243 4.243L7.707 18.071a2 2 0 01-.916.618l-4.535 1.515a1 1 0 01-1.211-1.211l1.515-4.535a2 2 0 01.618-.916L15.232 5.232z" />
                  </svg>
                </WarningButton>
              </td>
              <td class="px-4 py-3 text-sm">
                <DangerButton @click="openModalDel(r.id)" class="flex items-center">
                  <span class="mr-2">Eliminar</span>
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </DangerButton>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal View -->
    <Modal :show="showModalView" @close="closeModalView">
      <div class="p-6">
        <p>Nombre del Restaurante: <span class="text-lg font-medium text-gray-900">{{ v.name }}</span></p>
        <p>Apellido: <span class="text-lg font-medium text-gray-900">{{ v.last_name }}</span></p>
        <p>País: <span class="text-lg font-medium text-gray-900">{{ v.country }}</span></p>
      </div>
    </Modal>

    <!-- Modal Form -->
    <Modal :show="showModalForm" @close="closeModalForm">
      <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900">{{ title }}</h3>
        <form @submit.prevent="save" class="space-y-4">
          <InputGroup label="Nombre del Restaurante" :error="form.errors.name">
            <Input v-model="form.name" required class="border-b focus:ring-0" />
          </InputGroup>
          <InputGroup label="Apellido" :error="form.errors.last_name">
            <Input v-model="form.last_name" required class="border-b focus:ring-0" />
          </InputGroup>
          <SelectInput label="País" v-model="form.country_id" :options="countries" class="border-b focus:ring-0" />
          <PrimaryButton type="submit" class="mt-4">Guardar</PrimaryButton>
        </form>
      </div>
    </Modal>

    <!-- Modal Delete -->
    <Modal :show="showModalDel" @close="closeModalDel">
      <div class="p-6">
        <p>¿Estás seguro de que deseas eliminar este restaurante?</p>
        <div class="mt-4">
          <PrimaryButton @click="deleteRestaurant">Eliminar</PrimaryButton>
          <SecondaryButton @click="closeModalDel">Cancelar</SecondaryButton>
        </div>
      </div>
    </Modal>
  </AuthenticatedLayout>
</template>

<style scoped>
/* Estilo para los campos de formulario con solo barra inferior */
input, select {
  border: none;
  border-bottom: 1px solid #d1d5db;
  padding: 0.5rem;
  width: 100%;
}

input:focus, select:focus {
  outline: none;
  border-color: #4f46e5;
}
</style>
