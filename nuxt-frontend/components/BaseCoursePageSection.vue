<template>
  <section class="mb-12">
    <h5 class="text-xl font-bold mb-3">{{ title }}</h5>
    <q-card flat>
      <slot />
    </q-card>
  </section>
</template>

<script setup>
defineProps({
  title: String,
});
</script>

<style lang="scss" scoped></style>
