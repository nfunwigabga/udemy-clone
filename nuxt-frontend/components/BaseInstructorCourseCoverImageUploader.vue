<template>
  <div class="grid grid-cols-12 gap-x-4">
    <div class="col-span-6">
      <div class="rounded-lg overflow-hidden">
        <q-img :src="course?.cover" />
      </div>
    </div>
    <div class="col-span-6 space-y-4">
      <div>Your image must be a JPEG or PNG format.</div>
      <q-file
        :error="!!form.errors.get('cover_image')"
        :error-message="form.errors.get('cover_image')"
        v-model="form.cover_image"
        accept=".jpg,.jpeg,.png"
        outlined
        label="Cover image"
      >
        <template v-slot:prepend>
          <q-icon name="attach_file" />
        </template>
        <template v-slot:after>
          <BaseButton class="py-4" @click="submit" :loading="form.busy">
            Upload
          </BaseButton>
        </template>
      </q-file>
    </div>
  </div>
</template>

<script setup>
import { useRoute } from "vue-router";

const props = defineProps({
  course: Object,
});

const { $api, $form } = useNuxtApp();
const course = useState('course')

const form = reactive(
  $form({
    cover_image: null,
  })
);

const route = useRoute();

async function submit() {
  const formData = new FormData();
  formData.append("cover_image", form.cover_image);

  try {
    const { data } = await $api(
      `/instructor/c/${route.params.course}/cover`,
      {
        method: "POST",
        body: formData,
        // headers: {
        //   Accept: "application/json",
        //   "Content-Disposition": formData,
        //   Authorization: useAuth().strategy.token.get(),
        // },
      }
    );
    setCourse(data.value);
    form.reset();
  } catch (error) {
    console.log(error.response);
  }
}
</script>

<style scoped></style>
