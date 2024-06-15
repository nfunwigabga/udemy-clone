<template>
  <q-input
    outlined
    input-class="text-black"
    color="primary"
    bg-color="white"
    :label="label"
    :placeholder="placeholder"
    :model-value="modelValue"
    :disable="disabled"
    :type="inputType"
    no-error-icon
    :mask="mask"
    :error="!!error"
    :error-message="error"
    :required="required"
    :stack-label="stackLabel"
    :hide-bottom-space="true"
    :class="error ? 'mb-0' : ''"
    @update:model-value="$emit('update:modelValue', $event)"
  >
    <template v-if="icon" #prepend>
      <q-icon :name="icon" />
    </template>
    <template #after>
      <slot />
    </template>
    <template v-if="type === 'password'" #append>
      <q-btn
        @click="togglePassword"
        round
        dense
        flat
        :icon="isPassword ? 'las la-eye' : 'las la-eye-slash'"
      />
    </template>
  </q-input>
</template>

<script setup>
import { computed, ref } from "vue";
const props = defineProps({
  modelValue: [Number, String],
  icon: String,
  placeholder: String,
  label: String,
  disabled: Boolean,
  required: Boolean,
  stackLabel: Boolean,
  error: String,
  mask: String,
  type: {
    type: String,
    default: "text",
  },
});
const emit = defineEmits(["update:modelValue"]);

const isPassword = ref(props.type === "password");

const inputType = computed(() => {
  if (props.type !== "password") {
    return props.type;
  }

  return isPassword.value ? "password" : "text";
});

function togglePassword() {
  isPassword.value = !isPassword.value;
}
</script>

<style scoped></style>
