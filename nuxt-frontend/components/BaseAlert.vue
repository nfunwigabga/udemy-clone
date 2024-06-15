<template>
    <q-banner :class="[{
        'text-green-800 bg-green-100 border-green-200': type === 'success',
        'text-red-800 bg-red-100 border-red-200': type === 'danger',
        'text-orange-400 bg-orange-100 border-orange-200': type === 'warning',
      }, 'mb-4 text-center p-2 font-medium text-sm border rounded-md']">
        <slot />
    </q-banner>
</template>
  
<script setup>
defineProps({
type: {
    type: String,
    default: "success"
}
});
</script>

  