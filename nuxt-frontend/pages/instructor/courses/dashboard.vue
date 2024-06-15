<template>
  <q-page padding>
    <div class="container">
      <h4 class="text-3xl my-0 font-semibold">My Courses</h4>
      <div class="flex justify-between align-center my-4">
        <div>Search input?</div>
        <q-btn
          color="primary"
          @click="showCreateCourseDialog = true"
          unelevated
          no-caps
        >
          New course
        </q-btn>
      </div>
      <div class="space-y-4">
        <BaseInstructorCourseItem
          v-for="course in courses"
          :key="course.id"
          :course="course"
        />
      </div>
    </div>

    <q-dialog
      v-model="showCreateCourseDialog"
      maximized
      persistent
      transition-duration="300"
      transition-show="slide-up"
      transition-hide="slide-down"
    >
      <BaseInstructorCreateCourseForm
        @cancelled="showCreateCourseDialog = false"
        @created="handleCourseCreated"
      />
    </q-dialog>
  </q-page>
</template>

<script setup>
definePageMeta({
  layout: "instructor",
  middleware: ["auth", "verified"],
});
const { $api } = useNuxtApp();
const showCreateCourseDialog = ref(false);

const {
  data: courses,
  error,
  refresh,
  pending,
} = await $api("/instructor/courses");

function handleCourseCreated(data) {
  refresh();
  showCreateCourseDialog.value = false;
}
</script>

<style lang="scss" scoped></style>
