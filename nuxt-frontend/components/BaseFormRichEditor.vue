<template>
  <div>
    <div>{{ label }}</div>
    <q-editor
      toolbar-bg="white"
      class="rounded bg-white no-shadow text-black border-gray-400 border-opacity-80"
      min-height="6rem"
      :model-value="modelValue"
      :placeholder="placeholder"
      :readonly="readonly"
      paragraph-tag="p"
      @update:model-value="$emit('update:modelValue', $event)"
      :toolbar="[['bold', 'underline', 'italic', 'unordered', 'ordered']]"
    >
    </q-editor>
    <span v-if="error" class="text-negative text-caption">
      {{ error }}
    </span>
  </div>
</template>

<script setup>
const props = defineProps({
  error: String,
  modelValue: {
    type: String,
    default: "",
  },
  placeholder: String,
  label: String,
  readonly: Boolean,
});
const emit = defineEmits(["update:modelValue"]);
</script>
