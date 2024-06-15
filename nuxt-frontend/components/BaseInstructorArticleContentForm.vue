<template>
  <q-form @submit="submit">
    <div class="q-mb-md">
      <BaseFormRichEditor
        label="Article text"
        v-model="form.body"
        placeholder="Enter article content"
        :error="form.errors.get('body')"
      />
    </div>
    <div class="text-right q-gutter-x-md">
      <BaseButton @click="cancel" type="button" color="red-6" outline>
        Cancel
      </BaseButton>
      <BaseButton type="submit">Save Article</BaseButton>
    </div>
  </q-form>
</template>

<script setup>
const props = defineProps({
  lecture: Object,
});
const { $form } = useNuxtApp();
const emit = defineEmits(["cancel"]);

const form = reactive(
  $form({
    body: props.lecture.body || "",
  })
);

const { fetchCurriculum } = useCurriculum();

function cancel() {
  form.reset();
  emit("cancel");
}

function submit() {
  form
    .put(
      `/instructor/c/${props.lecture.course}/lectures/${props.lecture.id}/article`
    )
    .then((_) => {
      fetchCurriculum();
      cancel();
    })
    .catch((error) => console.error(error));
}
</script>

<style scoped></style>
