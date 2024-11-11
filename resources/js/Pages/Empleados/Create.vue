<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';  
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputGroup from '@/Components/InputGroup.vue';
import SelectInput from '@/Components/SelectInput.vue';
import InputError from '@/Components/InputError.vue';

// Definir la estructura del formulario
const form = useForm({
  name: '',
  duration: '',
  description: '',
  mode: '',
  start_date: '',
  finish_date: '',
  cost: 0,
});

// Función para manejar el envío del formulario
const submitForm = () => {
  form.post(route('empleados.store'), {
    onSuccess: () => {
      form.reset();
      // Mostrar mensaje de éxito o redirigir a otra página
      alert('Empleado creado con éxito');
    },
    onError: () => {
      // Mostrar mensaje de error si algo falla
      alert('Hubo un error al crear el empleado');
    }
  });
};

// Para manejar el estado de los errores globales
const formErrors = ref({
  name: '',
  duration: '',
  description: '',
  mode: '',
  start_date: '',
  finish_date: '',
  cost: '',
});
</script>

<template>
  <AuthenticatedLayout>
    <template #header>Crear Empleado</template>

    <div class="max-w-3xl mx-auto p-6 bg-white shadow-lg rounded-lg">
      <h3 class="text-xl font-semibold mb-4">Agregar un nuevo empleado</h3>
      <form @submit.prevent="submitForm" class="space-y-4">

        <!-- Nombre del Empleado -->
        <InputGroup label="Nombre del Empleado" :error="form.errors.name">
          <Input v-model="form.name" required class="border-b focus:ring-0" placeholder="Ingresa el nombre" />
        </InputGroup>

        <!-- Duración -->
        <InputGroup label="Duración" :error="form.errors.duration">
          <Input v-model="form.duration" required class="border-b focus:ring-0" placeholder="Duración del contrato" />
        </InputGroup>

        <!-- Descripción -->
        <InputGroup label="Descripción" :error="form.errors.description">
          <Input v-model="form.description" required class="border-b focus:ring-0" placeholder="Descripción del empleo" />
        </InputGroup>

        <!-- Modo de empleo -->
        <SelectInput label="Modo de Empleo" v-model="form.mode" :options="['Full-Time', 'Part-Time']" class="border-b focus:ring-0" />

        <!-- Fecha de Inicio -->
        <InputGroup label="Fecha de Inicio" :error="form.errors.start_date">
          <Input v-model="form.start_date" required type="date" class="border-b focus:ring-0" />
        </InputGroup>

        <!-- Fecha de Fin -->
        <InputGroup label="Fecha de Fin" :error="form.errors.finish_date">
          <Input v-model="form.finish_date" required type="date" class="border-b focus:ring-0" />
        </InputGroup>

        <!-- Costo -->
        <InputGroup label="Costo" :error="form.errors.cost">
          <Input v-model="form.cost" required type="number" class="border-b focus:ring-0" placeholder="Costo del empleado" />
        </InputGroup>

        <!-- Botón para enviar -->
        <PrimaryButton type="submit" class="w-full mt-4">Guardar</PrimaryButton>
      </form>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
/* Estilo para los campos de formulario con solo barra inferior */
input, select {
  border: none;
  border-bottom: 2px solid #d1d5db;
  padding: 0.5rem;
  width: 100%;
  transition: all 0.3s ease;
}

input:focus, select:focus {
  outline: none;
  border-color: #4f46e5;
}

input::placeholder, select::placeholder {
  color: #6b7280;
}

input:invalid, select:invalid {
  border-color: #f87171;
}

input:valid, select:valid {
  border-color: #34d399;
}

button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>
