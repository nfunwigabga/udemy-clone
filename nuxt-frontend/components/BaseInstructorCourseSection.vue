<template>
  <q-card flat bordered class="bg-slate-100 border border-slate-800">
    <q-card-section
      v-if="!isEditing"
      class="text-h6 flex justify-between gap-x-4 cursor-move group section-title"
    >
      <span>
        <b>Section {{ section.sort_order }}:</b> {{ section.title }}
      </span>
      <div
        class="gap-x-4 transition-opacity duration-400 opacity-0 group-hover:opacity-100"
      >
        <q-btn
          v-if="section.can_trash"
          flat
          dense
          icon="delete"
          @click="deleteSection"
        ></q-btn>
        <q-btn flat dense icon="edit" @click="isEditing = true"></q-btn>
        <q-btn flat dense class="cursor-move" icon="menu"></q-btn>
      </div>
    </q-card-section>

    <q-card-section v-else class="bg-white">
      <q-form @submit="submit">
        <div class="my-4">
          <BaseFormInput
            v-model="form.title"
            :error="form.errors.get('title')"
          />
        </div>
        <div class="my-4 space-x-4 text-right">
          <BaseButton
            @click="cancelEdit"
            :disabled="form.busy"
            outline
            color="red-7"
            type="button"
          >
            Cancel
          </BaseButton>
          <BaseButton :loading="form.busy" type="submit">
            Update section
          </BaseButton>
        </div>
      </q-form>
    </q-card-section>

    <q-card-section class="space-y-4">
      <slot />
    </q-card-section>

    <q-card-section>
      <div class="space-y-4 text-right" v-if="!showCreateLectureForm">
        <q-btn
          color="black"
          text-color="white"
          @click="showCreateLectureForm = true"
          size="md"
          unelevated
          no-caps
        >
          <q-icon size="xs" name="add"></q-icon>
          Create lecture
        </q-btn>
      </div>

      <BaseInstructorCreateLectureForm
        v-if="showCreateLectureForm"
        @cancel="showCreateLectureForm = false"
        :section="section"
      />
    </q-card-section>
  </q-card>
</template>

<script setup>
import { useQuasar } from "quasar";
import { useRoute } from "vue-router";

const props = defineProps({
  section: Object,
});
const { $form, $api } = useNuxtApp();
const route = useRoute();
const $q = useQuasar();
const showCreateLectureForm = ref(false);
const form = reactive(
  $form({
    title: props.section.title,
  })
);

const { fetchCurriculum } = useCurriculum();

const isEditing = ref(false);

function cancelEdit() {
  form.reset();
  isEditing.value = false;
}

function submit() {
  form
    .put(
      `/instructor/c/${route.params.course}/sections/${props.section.id}`
    )
    .then((response) => {
      fetchCurriculum();
      isEditing.value = false;
    })
    .catch((error) => console.error(error));
}

function deleteSection() {
  $q.dialog({
    message: "Confirm delete. This action is permanent",
    cancel: true,
    persistent: true,
  }).onOk(async () => {
    await $api(
      `/instructor/c/${route.params.course}/sections/${props.section.id}`,
      {
        method: "DELETE",
      }
    );
    fetchCurriculum();
  });
}
</script>
