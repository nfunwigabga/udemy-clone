<template>
  <GMapAutocomplete
    :required="required"
    :readonly="readonly"
    :autofocus="autofocus"
    :placeholder="placeholder"
    :label="label"
    :name="id"
    :error="error"
    :modelValue="modelValue?.display"
    v-bind="$attrs"
    :types="['(cities)']"
    :componentRestrictions="{ country: ['ca', 'us'] }"
    @place_changed="setPlace"
  >
    <template #input="slotProps">
      <BaseFormInput icon="las la-map-marker" v-bind="slotProps" ref="input" />
    </template>
  </GMapAutocomplete>
  <!-- :types="['address']" -->
</template>

<script setup>
const emit = defineEmits(["update:modelValue"]);
defineProps({
  id: String,
  modelValue: { type: [String, Object], default: "" },
  error: { type: String, default: null },
  required: { type: Boolean, default: false },
  autofocus: { type: Boolean, default: false },
  placeholder: { type: String, default: "" },
  label: { type: String, default: undefined },
  type: { type: String, default: "text" },
  readonly: { type: Boolean, default: false },
});

function setPlace(place) {
  const payload = {
    display: place.formatted_address,
    locality: place.address_components[0]?.long_name,
    lat: place.geometry.location.lat(),
    lng: place.geometry.location.lng(),
    vicinity: place.vicinity,
    utc_offset_minutes: place.utc_offset_minutes,
  };
  emit("update:modelValue", payload);
}
</script>

<style>
.pac-container {
  @apply shadow-xl shadow-gray-200;
  @apply border-0;
  @apply rounded-b-lg;
  @apply text-lg;
}
.pac-container:after {
  @apply hidden;
}

.pac-container .pac-item {
  @apply py-2.5 pr-2 pl-4;
  @apply cursor-pointer;
}
.pac-container .pac-item,
.pac-container .pac-item-query {
  @apply text-base;
}

.pac-icon.pac-icon-marker {
  @apply hidden;
}
</style>
