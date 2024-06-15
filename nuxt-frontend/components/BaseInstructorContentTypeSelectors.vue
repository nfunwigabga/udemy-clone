<template>
  <q-card bordered flat>
    <q-card-section v-if="selectedContentType === 'ARTICLE'">
      <BaseInstructorArticleContentForm
        @cancel="handleCancel"
        :lecture="lecture"
      />
    </q-card-section>
    <q-card-section v-else-if="selectedContentType === 'VIDEO'">
      <BaseInstructorVideoContentForm
        @cancel="handleCancel"
        :lecture="lecture"
      />
    </q-card-section>

    <q-card-section class="text-center q-gutter-x-md" v-else>
      <q-btn
        @click="selectedContentType = 'VIDEO'"
        no-caps
        outline
        size="xl"
        class="text-center"
      >
        <div>
          <q-icon color="grey-7" name="play_circle"></q-icon>
          <div class="text-caption">Video</div>
        </div>
      </q-btn>

      <q-btn
        @click="selectedContentType = 'ARTICLE'"
        no-caps
        outline
        size="xl"
        class="text-center"
      >
        <div>
          <q-icon color="grey-7" name="description"></q-icon>
          <div class="text-caption">Article</div>
        </div>
      </q-btn>
    </q-card-section>
  </q-card>
</template>

<script setup>
const props = defineProps({
  lecture: Object,
  expanded: Boolean,
});

const selectedContentType = ref(null);

watch(
  () => props.expanded,
  (expanded) => {
    if (!expanded) selectedContentType.value = null;
  }
);

function handleCancel() {
  selectedContentType.value = null;
}
</script>

<style scoped></style>
