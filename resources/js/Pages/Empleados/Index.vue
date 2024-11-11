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
  empleados: { type: Array },
  countries: { type: Array }
});

const form = useForm({ name: '', duration: '', description: '', mode: '', start_date: '', finish_date: '', cost: 0, image: '' });
const v = ref({ id: '', name: '', duration: '', description: '', mode: '', start_date: '', finish_date: '', cost: '', country: '', image_url: '' });
const showModalView = ref(false);
const showModalForm = ref(false);
const showModalDel = ref(false);
const title = ref('');
const operation = ref(1);  // 1 = Crear, 2 = Editar
const empleadoIdToDelete = ref(null);  // Guardar el id del empleado a eliminar

// Función para manejar la carga de imágenes
const handleImageChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      form.image = e.target.result;
    };
    reader.readAsDataURL(file);
  }
};

// Abrir modal para ver los detalles del empleado
const openModalView = (e) => {
  showModalForm.value = false;
  showModalDel.value = false;

  v.value.name = e.name;
  v.value.duration = e.duration;
  v.value.description = e.description;
  v.value.mode = e.mode;
  v.value.start_date = e.start_date;
  v.value.finish_date = e.finish_date;
  v.value.cost = e.cost;
  v.value.image_url = e.image_url;  // Imagen URL (si existe)
  showModalView.value = true;
}

// Abrir modal para crear o editar empleado
const openModalForm = (op, e = null) => {
  showModalView.value = false;
  showModalDel.value = false;

  showModalForm.value = true;
  operation.value = op;
  if (op === 1) {
    title.value = 'Crear Empleado';
    form.reset();  // Resetear formulario para nuevo empleado
  } else {
    title.value = 'Editar Empleado';
    form.name = e.name;
    form.duration = e.duration;
    form.description = e.description;
    form.mode = e.mode;
    form.start_date = e.start_date;
    form.finish_date = e.finish_date;
    form.cost = e.cost;
    form.image = e.image_url || '';  // Establecer la imagen si existe
    v.value.id = e.id;
  }
}

// Guardar empleado (Crear/Editar)
const save = () => {
  const formData = new FormData();
  formData.append('name', form.name);
  formData.append('duration', form.duration);
  formData.append('description', form.description);
  formData.append('mode', form.mode);
  formData.append('start_date', form.start_date);
  formData.append('finish_date', form.finish_date);
  formData.append('cost', form.cost);
  if (form.image) formData.append('image', form.image); // Agregar la imagen si se ha seleccionado

  if (operation.value === 1) {
    formData.append('_method', 'POST');
    Inertia.post(route('empleados.store'), formData, { onSuccess: () => closeModalForm() });
  } else {
    formData.append('_method', 'PUT');
    Inertia.post(route('empleados.update', v.value.id), formData, { onSuccess: () => closeModalForm() });
  }
}
</script>

<template>
  <AuthenticatedLayout>
    <template #header>Empleados</template>

    <PrimaryButton @click="openModalForm(1)" class="flex items-center">
      <span class="mr-2">Agregar Empleado</span>
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
              <th class="px-4 py-3">Empleado</th>
              <th class="px-4 py-3">Duración</th>
              <th class="px-4 py-3">Modo</th>
              <th class="px-4 py-3">Fecha de Inicio</th>
              <th class="px-4 py-3">Fecha de Fin</th>
              <th class="px-4 py-3">Imagen</th> <!-- Columna para imagen -->
              <th class="px-4 py-3">Ver</th>
              <th class="px-4 py-3">Editar</th>
              <th class="px-4 py-3">Eliminar</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            <tr v-for="(e, i) in empleados" :key="e.id" class="text-white">
              <td class="px-4 py-3 text-sm">{{ i + 1 }}</td>
              <td class="px-4 py-3 text-sm">{{ e.name }}</td>
              <td class="px-4 py-3 text-sm">{{ e.duration }}</td>
              <td class="px-4 py-3 text-sm">{{ e.mode }}</td>
              <td class="px-4 py-3 text-sm">{{ e.start_date }}</td>
              <td class="px-4 py-3 text-sm">{{ e.finish_date }}</td>
              <td class="px-4 py-3 text-sm">
                <img v-if="e.image_url" :src="e.image_url" alt="Imagen de empleado" class="w-10 h-10 rounded-full object-cover">
                <span v-else>No disponible</span>
              </td>
              <td class="px-4 py-3 text-sm">
                <SecondaryButton @click="openModalView(e)" class="flex items-center">
                  <span class="mr-2">Ver</span>
                </SecondaryButton>
              </td>
              <td class="px-4 py-3 text-sm">
                <PrimaryButton @click="openModalForm(2, e)" class="flex items-center">
                  <span class="mr-2">Editar</span>
                </PrimaryButton>
              </td>
              <td class="px-4 py-3 text-sm">
                <DangerButton @click="openModalDel(e.id)" class="flex items-center">
                  <span class="mr-2">Eliminar</span>
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
        <p>Nombre del Empleado: <span class="text-lg font-medium text-gray-900">{{ v.name }}</span></p>
        <p>Duración: <span class="text-lg font-medium text-gray-900">{{ v.duration }}</span></p>
        <p>Descripción: <span class="text-lg font-medium text-gray-900">{{ v.description }}</span></p>
        <p>Modo: <span class="text-lg font-medium text-gray-900">{{ v.mode }}</span></p>
        <p>Fecha de Inicio: <span class="text-lg font-medium text-gray-900">{{ v.start_date }}</span></p>
        <p>Fecha de Fin: <span class="text-lg font-medium text-gray-900">{{ v.finish_date }}</span></p>
        <p>Costo: <span class="text-lg font-medium text-gray-900">{{ v.cost }}</span></p>
        <div v-if="v.image_url" class="mt-4">
          <img :src="v.image_url" alt="Imagen de empleado" class="w-24 h-24 rounded-full object-cover">
        </div>
      </div>
    </Modal>

    <!-- Modal Form -->
    <Modal :show="showModalForm" @close="closeModalForm">
      <div class="p-6">
        <h3 class="text-2xl font-medium text-center">{{ title }}</h3>
        <form @submit.prevent="save">
          <div class="mt-4">
            <label class="block text-sm font-medium">Nombre del Empleado</label>
            <input v-model="form.name" type="text" class="form-input mt-1 block w-full" />
          </div>

          <div class="mt-4">
            <label class="block text-sm font-medium">Duración</label>
            <input v-model="form.duration" type="text" class="form-input mt-1 block w-full" />
          </div>

          <div class="mt-4">
            <label class="block text-sm font-medium">Descripción</label>
            <input v-model="form.description" type="text" class="form-input mt-1 block w-full" />
          </div>

          <div class="mt-4">
            <label class="block text-sm font-medium">Modo</label>
            <input v-model="form.mode" type="text" class="form-input mt-1 block w-full" />
          </div>

          <div class="mt-4">
            <label class="block text-sm font-medium">Fecha de Inicio</label>
            <input v-model="form.start_date" type="date" class="form-input mt-1 block w-full" />
          </div>

          <div class="mt-4">
            <label class="block text-sm font-medium">Fecha de Fin</label>
            <input v-model="form.finish_date" type="date" class="form-input mt-1 block w-full" />
          </div>

          <div class="mt-4">
            <label class="block text-sm font-medium">Costo</label>
            <input v-model="form.cost" type="number" class="form-input mt-1 block w-full" />
          </div>

          <div class="mt-4">
            <label class="block text-sm font-medium">Imagen</label>
            <input @change="handleImageChange" type="file" class="form-input mt-1 block w-full" />
            <div v-if="form.image" class="mt-4">
              <img :src="form.image" alt="Vista previa de imagen" class="w-24 h-24 rounded-full object-cover">
            </div>
          </div>

          <div class="mt-4 text-center">
            <PrimaryButton>Guardar</PrimaryButton>
          </div>
        </form>
      </div>
    </Modal>

    <!-- Modal Delete -->
    <Modal :show="showModalDel" @close="closeModalDel">
      <div class="p-6">
        <p class="text-lg">¿Estás seguro de que quieres eliminar este empleado?</p>
        <div class="mt-4 text-center">
          <DangerButton @click="deleteEmpleado" class="mr-4">Eliminar</DangerButton>
          <SecondaryButton @click="closeModalDel">Cancelar</SecondaryButton>
        </div>
      </div>
    </Modal>
  </AuthenticatedLayout>
</template>