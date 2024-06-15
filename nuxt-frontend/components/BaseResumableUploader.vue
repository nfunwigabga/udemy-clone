<template>
  <div class="uploading-video">
    <div class="flex items-center justify-between gap-x-2">
      <div class="flex-1">
        <q-linear-progress color="green" size="10px" :value="progress" />
      </div>

      <q-badge v-if="status == 'success'" color="positive"> done </q-badge>
      <q-badge v-else-if="status == 'canceled'" color="grey-9">
        canceled
      </q-badge>
      <q-badge v-else-if="status == 'error'" color="negative">
        server error
      </q-badge>
      <q-badge v-else-if="status == 'retrying'" color="orange-8">
        failed. retrying...
      </q-badge>
      <q-badge v-else color="black"> {{ uploadedAmount }}% </q-badge>
    </div>

    <div v-if="isUploading" class="flex items-center justify-end gap-x-2 my-4">
      <q-btn
        size="sm"
        unelevated
        color="primary"
        @click="isPaused ? resume() : pause()"
      >
        {{ isPaused ? "resume" : "pause" }}
      </q-btn>
      <q-btn unelevated size="sm" color="negative" @click="cancel()">
        cancel
      </q-btn>
    </div>
  </div>
</template>

<script setup>
const props = defineProps(["file", "status", "progress"]);
const emit = defineEmits(["cancel"]);
const isPaused = ref(false);

const isUploading = computed(
  () => !["success", "canceled"].includes(props.status)
);

const uploadedAmount = computed(() => (props.progress * 100).toFixed(2));

function upload() {
  props.file.resumableObj.upload();
  isPaused.value = false;
}

function pause() {
  props.file.pause();
  isPaused.value = true;
}

function resume() {
  pause(); // not sure why, but we have to call pause again before upload will resume
  upload();
}

function cancel() {
  emit("cancel", props.file);
}
</script>
