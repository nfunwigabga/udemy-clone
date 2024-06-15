<template>
  <q-card flat class="border border-t-none">
    <q-card-section v-if="!isEditing">
      <div class="flex q-gutter-x-md">
        <q-card flat class="bg-black" bordered>
          <q-icon size="5rem" color="white" name="play_circle"></q-icon>
        </q-card>
        <div class="q-gutter-y-xs">
          <div>{{ lectureData.video?.filename }}</div>
          <div>{{ lectureData.duration?.hms }}</div>
          <div v-if="lectureData.video?.status !== 'processing'">
            <q-btn unelevated outline dense size="sm" @click="isEditing = true">
              <q-icon name="edit"></q-icon>
              Edit content
            </q-btn>
          </div>
        </div>
      </div>
      <div class="q-mt-sm" v-if="lectureData.video?.status === 'processing'">
        {{ lectureData.video?.status }} ({{ lectureData.video?.percent }}%)
        <q-linear-progress
          color="green"
          :value="lectureData.video?.percent / 100"
        />
      </div>
      <div
        class="q-mt-sm text-red-6"
        v-if="lectureData.video?.status === 'failed'"
      >
        <span
          >Video processing failed. Please try to re-upload the video.
        </span>
      </div>
    </q-card-section>
    <q-card-section v-else>
      <BaseInstructorVideoContentForm
        @cancel="isEditing = false"
        :lecture="lectureData"
      />
    </q-card-section>
  </q-card>
</template>

<script setup>
const props = defineProps({
  lecture: Object,
});
const { $echo } = useNuxtApp();
const isEditing = ref(false);
const lectureData = ref(props.lecture);

onMounted(() => {
  $echo
    .private(`lecture-${props.lecture.id}`)
    .listen(".video.upload.progress", (data) => {
      lectureData.value = data;
    });
});

onBeforeUnmount(() => {
  $echo.leave(`lecture-${props.lecture.id}`);
});
</script>
