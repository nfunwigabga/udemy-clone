<template>
  <q-layout view="lHh Lpr lFf">
    <main-navigation />
    <q-page-container>
      <q-page padding>
        <div class="text-center mx-auto max-w-2xl py-12">
          <p class="text-2xl font-semibold text-primary-600">{{ error.statusCode }}</p>
          <h1 class="mt-4 text-6xl font-bold tracking-tight text-gray-600">Oops!</h1>
          <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-600">
            {{ error.message }}
          </h1>
          <div class="mt-10 flex items-center justify-center gap-x-6">
            <BaseButton type="button" @click="handleClearError">Go home</BaseButton>
          </div>
        </div>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script setup>
// defineProps({
//   error: Object,
// });
const error = useError();

function handleClearError() {
  clearError({ redirect: "/" });
}
</script>
