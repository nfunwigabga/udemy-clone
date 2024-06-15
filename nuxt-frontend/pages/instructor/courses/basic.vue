<template>
  <q-card bordered class="rounded-xl border-gray-400 shadow-md shadow-gray-200">
    <q-card-section class="pb-1">
      <h5 class="text-xl font-semibold">Basic information</h5>
    </q-card-section>
    <q-separator />
    <q-form @submit="submit">
      <q-card-section class="space-y-4 p-4xl">
        <BaseFormInput
          v-model="form.title"
          :error="form.errors.get('title')"
          label="Course Title"
        />

        <BaseFormInput
          v-model="form.subtitle"
          :error="form.errors?.subtitle"
          label="Course Subtitle"
        />
        <BaseFormRichEditor
          label="Course description"
          v-model="form.description"
          placeholder="Enter course description"
          :error="form.errors.get('description')"
        />
        <div class="grid grid-cols-2 gap-4">
          <BaseFormSelectInput
            label="Category"
            :options="categories"
            v-model="form.category"
            :error="form.errors.get('category')"
          />
          <BaseFormSelectInput
            :disabled="!form.category"
            label="Sub Category"
            :options="subcategories"
            v-model="form.subcategory"
            :error="form.errors.get('subcategory')"
          />
          <BaseFormSelectInput
            label="Course Level"
            :options="levels"
            v-model="form.level"
            :error="form.errors.get('level')"
          />
        </div>

        <div class="p-2 text-right">
          <BaseButton type="submit" :loading="form.busy"> Save </BaseButton>
        </div>
      </q-card-section>
    </q-form>

    <q-separator></q-separator>
    <q-card-section class="py-2">
      <h5 class="my-0">Course Image</h5>
    </q-card-section>
    <q-card-section>
      <BaseInstructorCourseCoverImageUploader :course="course" />
    </q-card-section>
  </q-card>
</template>

<script setup>
import { useRoute } from "vue-router";

definePageMeta({
  layout: "course-management",
  middleware: ["auth", "verified"],
});
const $q = useQuasar();
const route = useRoute();
const { $form } = useNuxtApp();
const { $api } = useNuxtApp();

// state shared with layout
const course = useState('course', () => null)
const levels = ref([]);
const categories = ref([]);

const form = reactive(
  $form({
    title: "",
    subtitle: "",
    description: "",
    level: "",
    category: "",
    subcategory: "",
  })
);

await $api(
  `/instructor/c/${route.params.course}/basic`,
  {
    async onResponse({ response }) {
      const payload = response._data
      course.value = payload.course
      levels.value = payload.levels;
      categories.value = payload.categories;
      form.title = payload.course.title;
      form.subtitle = payload.course.subtitle;
      form.description = payload.course.description || "";
      form.level = payload.course.level;
      form.category = payload.course.category?.id;
      form.subcategory = payload.course.subcategory?.id;
    },
    async onResponseError({response}){
      console.log(response._data)
      // if(error.value){
      //   const {statusCode, statusMessage} = error.value
      //   // fatal: true forces nuxt to show the error page on the client side.
      //   throw createError({statusCode, statusMessage, fatal: true})
      // }
    }
  }
);

watch(
  () => form.category,
  (value) => {
    if (value) {
      form.subcategory = "";
    }
  }
);

const subcategories = computed(() => {
  if (!form.category) return [];
  return categories.value.find((c) => c.id === form.category)?.children;
});

function submit() {
  form
    .put(`/instructor/c/${route.params.course}/basic`)
    .then((response) => {
      course.value = response
      $q.notify("Data updated successfully");
    })
    .catch((error) => {
      console.error("Error", error);
    });
}
</script>

<style lang="scss" scoped></style>
