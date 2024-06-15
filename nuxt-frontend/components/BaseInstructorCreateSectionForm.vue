<template>
  <q-form @submit="submit">
    <BaseFormInput
      label="Section title"
      v-model="form.title"
      :error="form.errors.get('title')"
    />
    <div class="my-4 space-x-4 text-right">
      <BaseButton
        @click="cancel"
        :disabled="form.busy"
        outline
        color="red-7"
        type="button"
        >Cancel</BaseButton
      >
      <BaseButton :loading="form.busy" type="submit"> Add section </BaseButton>
    </div>
  </q-form>
</template>

<script setup>
import { useRoute } from "vue-router";
const props = defineProps({
  course: Object,
});

const { $form } = useNuxtApp();
const emit = defineEmits(["cancel"]);
const route = useRoute();
const { fetchCurriculum } = useCurriculum();
const form = reactive(
  $form({
    title: "",
  })
);

function cancel() {
  form.reset();
  emit("cancel");
}

function submit() {
  form
    .post(`/instructor/c/${route.params.course}/sections`)
    .then((_) => {
      fetchCurriculum();
      cancel();
    })
    .catch((error) => console.error(error));
}
</script>

<style scoped></style>
