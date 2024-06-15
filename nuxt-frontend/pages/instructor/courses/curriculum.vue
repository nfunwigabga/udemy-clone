<template>
  <q-card bordered class="rounded-xl border-gray-400 shadow-md shadow-gray-200">
    <q-card-section class="pb-1">
      <h5 class="text-xl font-semibold">Curriculum</h5>
    </q-card-section>
    <q-separator />    
    <q-card-section class="space-y-4 p-4xl">
      <Draggable
        group="sections"
        item-key="id"
        ghost-class="bg-gray-800"
        class="space-y-4"
        tag="div"
        :list="sections"
        handle=".section-title"
        @change="handleSectionDrag"
      >
        <template #item="{ element: section, index }">
          <BaseInstructorCourseSection :section="section">
            <Draggable
              group="lectures"
              itemKey="id"
              ghost-class="dragged-ghost"
              class="space-y-4"
              tag="div"
              :list="section.lectures"
              handle=".drag-handle"
              @change="handleLectureDrag"
            >
              <template #item="{ element: lecture }">
                <BaseInstructorLectureItem :lecture="lecture" />
              </template>
            </Draggable>
          </BaseInstructorCourseSection>
        </template>
      </Draggable>
    </q-card-section>

    <q-card-section class="p-4xl">
      <div class="space-x-4 text-right" v-if="!showCreateSectionForm">
        <q-btn
          @click="showCreateSectionForm = true"
          outline
          size="md"
          unelevated
          no-caps
        >
          <q-icon size="sm" name="add"></q-icon> Create section
        </q-btn>
      </div>

      <BaseInstructorCreateSectionForm
        v-if="showCreateSectionForm"
        @cancel="showCreateSectionForm = false"
        :course="course"
      />
    </q-card-section>
  </q-card>
</template>

<script setup>
definePageMeta({
  layout: "course-management",
  middleware: ["auth", "verified"],
});

const course = useState('course')
const sections = useState('sections')
const { fetchCurriculum, handleLectureDrag, handleSectionDrag } =
  useCurriculum();

await fetchCurriculum()

const showCreateSectionForm = ref(false);

</script>

<style lang="scss" scoped></style>
