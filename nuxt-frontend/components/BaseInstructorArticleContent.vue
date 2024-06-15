<template>
  <q-card flat class="border border-t-none">
    <template v-if="isEditing">
      <q-card-section>
        <BaseInstructorArticleContentForm
          @cancel="isEditing = false"
          :lecture="lecture"
        />
      </q-card-section>
    </template>
    <template v-else-if="showVideoPicker">
      <q-card-section>
        <BaseInstructorVideoContentForm
          @cancel="showVideoPicker = false"
          :lecture="lecture"
        />
      </q-card-section>
    </template>
    <template v-else>
      <q-card-section>
        <div class="flex q-gutter-x-md">
          <q-card flat class="bg-black" bordered>
            <q-icon size="5rem" color="white" name="description" />
          </q-card>
          <div class="q-gutter-y-xs">
            <div>{{ lecture.duration?.hms }}</div>
            <div>
              <q-btn
                unelevated
                outline
                dense
                size="sm"
                @click="isEditing = true"
              >
                <q-icon name="edit"></q-icon> Edit content
              </q-btn>
            </div>
            <div>
              <q-btn
                @click="showVideoPicker = true"
                unelevated
                outline
                dense
                size="sm"
              >
                <q-icon name="play_circle"></q-icon>
                Replace with video
              </q-btn>
            </div>
          </div>
        </div>
      </q-card-section>
    </template>
  </q-card>
</template>

<script setup>
const props = defineProps({
  lecture: Object,
});

const isEditing = ref(false);
const showVideoPicker = ref(false);
</script>

<style scoped></style>
