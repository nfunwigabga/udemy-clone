<template>
  <q-form @submit="submit" class="flex-1">
    <q-select
      class="mx-auto w-full text-md"
      outlined
      dense
      rounded
      v-model="form.keyword"
      use-input
      hide-selected
      option-value="id"
      option-label="name"
      map-options
      emit-value
      fill-input
      bg-color="white"
      placeholder="Teach me..."
      hide-dropdown-icon
      input-debounce="0"
      :options="options"
      @filter="filterFn"
      popup-content-class="shadow-xl shadow-gray-200 text-lg rounded-b-lg"
    >
      <template v-slot:prepend>
        <q-icon name="las la-search" />
      </template>
      <template v-slot:no-option>
        <q-item>
          <q-item-section class="text-grey"> No results </q-item-section>
        </q-item>
      </template>
      <template v-slot:option="scope">
        <q-item v-bind="scope.itemProps">
          <q-item-section side>
            <q-icon name="las la-user" />
          </q-item-section>
          <q-item-section>
            <q-item-label>{{ scope.opt.name }}</q-item-label>
          </q-item-section>
          <q-item-section side :class="{ 'default-type': !scope.opt.type }">
            Cars
          </q-item-section>
        </q-item>
      </template>
    </q-select>
  </q-form>
</template>

<script setup>
import { ref } from "vue";

const { $form } = useNuxtApp();
const form = reactive({
  keyword: ""
})
// const form = reactive(
//   $form({
//     keyword: "",
//   })
// );

const options = [
  { id: "photography", name: "Photography" },
  { id: "fishing", name: "Fishing" },
  { id: "hair-styling", name: "Hair styling" },
  { id: "gardening", name: "Gardening" },
  { id: "baking", name: "Baking" },
  { id: "lawn-care", name: "Lawn care" },
];

const searchResults = ref([]);

function filterFn(val, update, abort) {
  if (val.length < 2) {
    abort();
    return;
  }

  update(() => {
    const needle = val.toLowerCase();
    searchResults.value = options.filter((o) =>
      o.name.toLowerCase().includes(needle)
    );
  });
}

function submit() {
  // form.errors.clear();
  // if (form.errors.any()) {
  //   return;
  // }
  // navigateTo({ name: "search", params: { keyword: form.keyword } });
}
</script>

<style scoped></style>
