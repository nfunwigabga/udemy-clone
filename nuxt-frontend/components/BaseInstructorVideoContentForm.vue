<template>
  <div class="my-4">
    <div class="space-y-3">
      <BaseResumableUploader
        v-if="video"
        :file="video.file"
        :status="video.status"
        :progress="video.progress"
        @cancel="cancel"
      />

      <label class="block mb-4">
        <input
          type="file"
          ref="uploader"
          :multiple="false"
          accept="video/*"
          class="block !cursor-pointer w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
        />
      </label>
    </div>
  </div>

  <BaseButton @click="cancel" type="button" color="red-6" outline>
    Cancel
  </BaseButton>
</template>

<script setup>
import Resumable from "resumablejs";

const props = defineProps({
  lecture: Object,
});

const config = useRuntimeConfig();

const resumable = new Resumable({
  chunkSize: 1 * 1024 * 1024, // 1MB
  simultaneousUploads: 3,
  testChunks: false,
  throttleProgressCallbacks: 1,
  withCredentials: true,
  target: `${config.public.baseURL}/instructor/files/${props.lecture.id}/chunk`,
});

const emit = defineEmits(["cancel"]);

const { fetchCurriculum } = useCurriculum();

const video = ref(null);

const uploader = ref(null);

function cancel() {
  video.value?.file.cancel();
  video.value = null;
  emit("cancel");
}

onMounted(() => {
  if (!resumable.support) {
    alert("Your browser doesn't support chunked uploads.");
  }
  resumable.assignBrowse(uploader.value);
  resumable.on("fileAdded", (addedFile, event) => {
    addedFile.hasUploaded = false;
    video.value = { file: addedFile, status: "uploading", progress: 0 };
    resumable.upload();
  });

  resumable.on("fileSuccess", (file, event) => {
    video.value.status = "success";
    cancel();
    fetchCurriculum();
  });
  resumable.on("fileError", (file, event) => {
    video.value.status = "error";
    video.value.file.cancel();
  });
  resumable.on("fileRetry", (file, event) => {
    video.value.status = "retrying";
  });
  resumable.on("fileProgress", (file) => {
    // if we are doing multiple chunks we may get a lower progress number if one chunk response comes back early
    if (file.progress() > video.value.progress) {
      video.value.progress = file.progress();
    }
  });
});
</script>

<style scoped></style>
