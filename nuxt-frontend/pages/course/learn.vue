<template>
  <div>
    <h1 class="text-4xl leading-relaxed">{{ course.title }}</h1>
    <h2 class="text-2xl">{{ course.subtitle }}</h2>
    <div class="flex items-center gap-x-6">
      <div class="text-gray-700">
        <span class="text-xl font-bold text-orange-600">
          4.5 <q-icon name="star" size="sm" />
        </span>
        120 reviews
      </div>

      <div class="text-gray-700">
        <span class="text-xl font-bold">
         4300
        </span>
        Students
      </div>

      <div class="text-gray-700">
        <span class="text-xl font-bold">
         {{course.stats.total_hrs}} hours
        </span>
        total
      </div>
    </div>

    <div class="py-4">
      <h1 class="text-2xl leading-normal font-semibold">Description</h1>
      <div class="text-lg" v-html="course.description" />
    </div>
    
    <div class="py-4">
      <h1 class="text-2xl leading-normal font-semibold">Instructor</h1>
      <q-avatar size="100px" class="ring-2 ring-offset-2">
        <img :src="course.author?.avatar" />
      </q-avatar>
      <div class="mt-2 text-lg font-bold">
        {{ course.author?.name }}
      </div>

    </div>
    <pre>{{ course }}</pre>
  </div>
</template>

<script setup>
definePageMeta({
  middleware:[ "auth", "verified", "can-access-course"],
  layout: "player",
});
const { $api } = useNuxtApp();
const route = useRoute();
const { data: course, error } = await $api(
  `/c/${route.params.course}/overview`
);

</script>

<style lang="scss" scoped></style>
