<template>
  <q-card>
    <q-form @submit="submit">
      <q-card-section>
        <div class="row justify-center items-center">
          <div class="col-5">
            <div class="text-h6 text-center q-my-lg">Create New Course</div>
            <div class="q-mb-md">
              <BaseFormInput
                v-model="form.title"
                :error="form.errors.get('title')"
                label="Course Title"
              />
            </div>

            <div class="q-mb-md">
              <BaseFormInput
                v-model="form.subtitle"
                :error="form.errors.get('subtitle')"
                label="Course Subtitle"
              />
            </div>

            <div class="q-mb-md">
              <BaseFormSelectInput
                label="Category"
                :options="categories"
                v-model="form.category"
                :error="form.errors.get('category')"
              />
            </div>

            <div class="q-mb-md">
              <BaseFormSelectInput
                :disabled="!form.category"
                label="Sub Category"
                :options="subcategories"
                v-model="form.subcategory"
                :error="form.errors.get('subcategory')"
              />
            </div>

            <div class="space-x-2 text-right">
              <BaseButton @click="cancel" type="button" outline color="red-5"
                >Cancel</BaseButton
              >
              <BaseButton type="submit" :loading="form.busy">
                Submit
              </BaseButton>
            </div>
          </div>
        </div>
      </q-card-section>
    </q-form>
  </q-card>
</template>

<script setup>
const emit = defineEmits(["cancelled", "created"]);
const { $form, $api } = useNuxtApp();
const form = reactive(
  $form({
    title: "React.js essential training",
    subtitle: "Learn React for web development",
    category: "",
    subcategory: "",
  })
);

const { data: categories } = await $api("/categories");

const subcategories = computed(() => {
  if (!form.category) return [];
  return categories.value.find((c) => c.id === form.category)?.children;
});

watch(
  () => form.category,
  (value) => {
    if (value) {
      form.subcategory = "";
    }
  }
);

function cancel() {
  form.reset();
  emit("cancelled");
}

async function submit() {
  try {
    const { data } = await form.post("/instructor/courses");
    form.reset();
    emit("created", data);
  } catch (e) {
    console.log(e);
  }
}
</script>

<style scoped></style>
