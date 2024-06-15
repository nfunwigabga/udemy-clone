<template>
  <q-card flat square bordered class="bg-white border border-slate-800">
    <q-card-section>
      <q-form @submit="submit">
        <BaseFormInput
          label="Lecture title"
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
          >
            Cancel
          </BaseButton>
          <BaseButton :loading="form.busy" type="submit">
            Add lecture
          </BaseButton>
        </div>
      </q-form>
    </q-card-section>
  </q-card>
</template>

<script setup>
const props = defineProps({
  section: Object,
});

const { fetchCurriculum } = useCurriculum();
const emit = defineEmits(["cancel"]);
const { $form } = useNuxtApp();

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
    .post(
      `/instructor/c/${props.section.course}/sections/${props.section.id}/lectures`
    )
    .then((response) => {
      fetchCurriculum();
      cancel();
    })
    .catch((error) => console.error(error));
}
</script>

<style scoped></style>
