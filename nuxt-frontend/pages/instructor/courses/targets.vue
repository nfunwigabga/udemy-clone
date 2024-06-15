<template>
  <q-card bordered class="rounded-xl border-gray-400 shadow-md shadow-gray-200">
    <q-card-section class="pb-1">
      <h5 class="text-xl font-semibold">Course Targets</h5>
    </q-card-section>

    <q-form @submit="submit" class="space-y-2">
      <template v-for="item in Object.keys(form.data())" :key="item">
        <q-separator />
        <q-card-section>
          <h5 class="my-0 text-lg font-semibold">{{ getTitle(item) }}</h5>
          <Draggable
            :group="item"
            item-key="id"
            ghost-class="bg-gray-200"
            class="space-y-4"
            tag="div"
            :list="form[item]"
            handle=".move"
            @change="updateDraggable(item)"
          >
            <template #item="{ element: target, index }">
              <div class="group">
                <BaseFormInput
                  placeholder="Enter text"
                  dense
                  v-model="target.text"
                  :error="form.errors.get(`${item}.${index}.text`)"
                >
                  <q-btn-group
                    unelevated
                    class="opacity-0 group-hover:opacity-100 transition duration-500"
                  >
                    <q-btn
                      outline
                      class="text-gray-400"
                      @click="handleRemove(item,index)"
                    >
                      <q-icon name="delete" color="black" />
                    </q-btn>
                    <q-btn outline class="text-gray-400 move cursor-move">
                      <q-icon name="menu" color="black" />
                    </q-btn>
                  </q-btn-group>
                </BaseFormInput>
              </div>
            </template>
          </Draggable>

          <div class="mt-3">
            <BaseButton
              outline
              class="text-xs"
              type="button"
              @click.prevent="handleAddEvent(item)"
            >
              <q-icon name="add" />
              Add an answer
            </BaseButton>
          </div>
        </q-card-section>
      </template>

      <q-separator />
      <q-card-section class="mt-3 text-end">
        <BaseButton type="submit" :loading="form.busy"> Save </BaseButton>
      </q-card-section>
    </q-form>
  </q-card>
</template>

<script setup>
import { useRoute } from "vue-router";

definePageMeta({
  layout: "course-management",
  middleware: ["auth", "verified"],
});
const $q = useQuasar();
const route = useRoute();
const { $form } = useNuxtApp();
const { $api } = useNuxtApp();
const course = useState('course', () => null)

const form = reactive(
  $form({
    requirement: [],
    what_to_learn: [],
    target_student: [],
  })
);

const { refresh } = await $api(
  `/instructor/c/${route.params.course}/targets`,
  {
    async onResponse({ response }) {
      const payload = response._data;
      course.value = payload.course;
      form.reset();
      payload.targets.forEach((item) => {
        form[item.type].push({
          id: item.id,
          text: item.text,
          sort_order: item.sort_order,
        });
      });
    },
    async onResponseError({ response }) {
      console.log(response._data);
    },
  }
);

function getTitle(type) {
  switch (type) {
    case "what_to_learn":
      return "What will students learn?";
    case "requirement":
      return "What are the requirements or prerequisites for taking this course?";
    case "target_student":
      return "Who are the target students?";
  }
}

function handleAddEvent(type) {
  let item = form[type];
  if (item.length != 0 && item[item.length - 1].text.trim() == "") {
    return;
  }
  item.push({ id: "", text: "", sort_order: 0 });
}

function handleRemove(type, index) {
  form[type].splice(index, 1);
}

function submit() {
  form
    .post(`/instructor/c/${route.params.course}/targets`)
    .then((response) => {
      refresh();
    })
    .catch((error) => {
      console.error("Error", error);
    });
}

function updateDraggable(type) {
  form[type].map((item, index) => {
    item.sort_order = index + 1;
  });

  $api(`/instructor/c/${route.params.course}/targets`, {
    method: "PUT",
    body: {data: form[type]}
  });
}
</script>

<style lang="scss" scoped></style>
