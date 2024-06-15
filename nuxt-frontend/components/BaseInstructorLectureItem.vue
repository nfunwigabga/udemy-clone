<template>
  <q-list bordered class="border-slate-800">
    <q-expansion-item
      v-model="expanded"
      :expand-icon-class="isEditing ? 'hidden' : ''"
      expand-icon="expand_more"
      expand-icon-toggle
      header-class="bg-white"
    >
      <template #header>
        <div
          v-if="!isEditing"
          class="group text-base flex w-full items-center justify-between"
        >
          <div class="flex items-center gap-x-1">
            <q-icon
              :class="{ 'text-green-600': lecture.has_content }"
              :name="
                lecture.has_content ? 'check_circle' : 'radio_button_unchecked'
              "
            />
            Lecture {{ lecture.sort_order }}:
            <q-icon
              class="text-slate-600"
              :name="lecture.type === 'video' ? 'play_circle' : 'description'"
            />
            {{ lecture.title }}
          </div>

          <div class="flex items-center">
            <div
              class="transition-opacity duration-300 opacity-0 group-hover:opacity-100 space-x-2 q-mr-md"
            >
              <q-btn flat dense icon="delete" @click="deleteLecture"></q-btn>
              <q-btn flat dense icon="edit" @click="isEditing = true"></q-btn>
              <q-btn
                flat
                dense
                class="drag-handle cursor-move"
                icon="open_with"
              ></q-btn>
            </div>
            <div class="mr-4" v-if="!expanded && !lecture.has_content">
              <q-btn @click="expanded = true" size="sm" outline
                >Add content</q-btn
              >
            </div>
          </div>
        </div>

        <div class="full-width" v-else>
          <q-form @submit="submit">
            <div class="q-my-md">
              <BaseFormInput
                v-model="form.title"
                :error="form.errors.get('title')"
              />
            </div>
            <div class="q-my-md q-gutter-x-md text-right">
              <BaseButton
                @click="cancelEdit"
                :disabled="form.busy"
                outline
                color="red-7"
                type="button"
                >Cancel</BaseButton
              >
              <BaseButton :loading="form.busy" type="submit">
                Save lecture
              </BaseButton>
            </div>
          </q-form>
        </div>
      </template>
      <template v-if="!lecture.has_content">
        <BaseInstructorContentTypeSelectors
          :expanded="expanded"
          :lecture="lecture"
        />
      </template>
      <template v-else-if="lecture.type === 'text'">
        <BaseInstructorArticleContent :lecture="lecture" />
      </template>
      <template v-else-if="lecture.type === 'video'">
        <BaseInstructorVideoContent :lecture="lecture" />
      </template>
    </q-expansion-item>
  </q-list>
</template>

<script setup>
import { useQuasar } from "quasar";

const props = defineProps({
  lecture: Object,
});
const { $form, $api } = useNuxtApp();
const $q = useQuasar();
const route = useRoute();
const expanded = ref(false);
const isEditing = ref(false);
const form = reactive(
  $form({
    title: props.lecture.title,
  })
);

const { fetchCurriculum } = useCurriculum();

function cancelEdit() {
  form.reset();
  isEditing.value = false;
}

function submit() {
  form
    .put(
      `/instructor/c/${route.params.course}/lectures/${props.lecture.id}`
    )
    .then((_) => {
      fetchCurriculum();
      isEditing.value = false;
    })
    .catch((error) => console.error(error));
}

function deleteLecture() {
  $q.dialog({
    message: "Confirm delete. This action is permanent",
    cancel: true,
    persistent: true,
  }).onOk(async () => {
    await $api(
      `/instructor/c/${route.params.course}/lectures/${props.lecture.id}`,
      {
        method: "DELETE",
      }
    );
    fetchCurriculum();
  });
}
</script>
