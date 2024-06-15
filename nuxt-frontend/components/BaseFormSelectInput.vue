<template>
  <q-select
    outlined
    input-class="text-black"
    emit-value
    map-options
    dropdown-icon="expand_more"
    :option-value="valueField"
    :option-label="labelField"
    :options="options"
    :label="label"
    :model-value="modelValue"
    :disable="disabled"
    no-error-icon
    :error="!!error"
    :error-message="error"
    @update:model-value="$emit('update:modelValue', $event)"
    options-dense
    hide-bottom-space
    popup-content-class="shadow-xl shadow-gray-200 text-lg rounded-b-lg"
  >
    <template #after>
      <slot />
    </template>

    <template v-if="slots.selectOption" v-slot:option="scope">
      <slot name="selectOption" :option="scope.opt" :props="scope.itemProps" />
    </template>

    <template v-if="slots.selectedOption" v-slot:selected-item="scope">
      <slot name="selectedOption" :option="scope.opt" />
    </template>
  </q-select>
</template>

<script setup>
import { useSlots } from "vue";

const slots = useSlots();
const props = defineProps({
  modelValue: [String, Number, Object],
  label: String,
  disabled: Boolean,
  error: String,
  valueField: {
    type: String,
    default: "id",
  },
  labelField: {
    type: String,
    default: "name",
  },
  options: {
    type: Array,
    default: () => [],
  },
});
</script>
