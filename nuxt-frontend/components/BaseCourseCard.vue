<template>
  <a :href="`/c/${course.slug}`">
    <q-card bordered class="cursor-pointer shadow-md shadow-gray-200">
      <q-img :src="course.cover" />
      <q-card-section>
        <div class="text-lg truncate">{{ course.title }}</div>
        <div class="text-subtitle2 text-grey-8">
          by {{ course.author?.name }}
        </div>
        <div class="row no-wrap items-center">
          <q-rating
            :model-value="4.3"
            size="1.2em"
            readonly
            color="orange"
            icon="star_border"
            icon-selected="star"
            icon-half="star_half"
          ></q-rating>
          <span class="text-caption text-grey q-ml-sm">4.2 (551)</span>
        </div>
        <div class="text-h6 text-right">
          {{ course.price_formatted }}
        </div>
      </q-card-section>
    </q-card>
  </a>
</template>

<script setup>
defineProps({
  course: Object,
});
</script>

<style scoped></style>
