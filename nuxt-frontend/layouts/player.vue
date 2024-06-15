<template>
  <q-layout view="hHh lpR fFf">
    <q-drawer
      v-if="data"
      show-if-above
      :model-value="true"
      side="right"
      class="bg-gray-900"
      :width="400"
    >
      <q-list dense bordered class="rounded-borders text-white">
        <q-item>
          <q-item-section class="font-extrabold text-xl">
            Course Content
          </q-item-section>
        </q-item>
        <q-expansion-item
          v-for="section in data.course.sections"
          :key="section.id"
          class="border-b border-b-gray-700"
          default-opened
        >
          <template #header>
            <q-item-section class="font-bold">
              {{ section.title }}
            </q-item-section>
            <q-item-section side class="text-slate-400">
              6 lectures, 14 mins
            </q-item-section>
          </template>
          <template #caption>xxxx</template>
          <q-list class="text-white">
            <q-item
              :active="lecture.id === $route.params.lecture"
              active-class="bg-gray-600 text-white"
              v-for="lecture in section.lectures"
              :key="lecture.id"
              clickable
              :to="`/c/${data.course.slug}/learn/${lecture.id}`"
            >
              <q-item-section avatar class="text-slate-400 pr-2 min-w-[0px]">
                <q-icon v-if="lecture.type === 'video'" name="play_circle" />
                <q-icon v-else name="description" />
              </q-item-section>
              <q-item-section class="truncate">
                {{ lecture.title }}
              </q-item-section>
              <q-item-section side class="text-gray-300 text-xs">
                {{ lecture.duration.hms }}
              </q-item-section>
            </q-item>
          </q-list>
        </q-expansion-item>
      </q-list>
    </q-drawer>

    <q-header class="bg-gray-900 text-white">
      <q-toolbar class="px-4">
        <div class="flex items-center divide-x divide-gray-600">
          <q-toolbar-title>
            <nuxt-link to="/" class="text-2xl font-semibold">
              Skillmetr
            </nuxt-link>
          </q-toolbar-title>
          <div class="px-3 text-xl text-white">
            {{ data?.lecture.sort_order }}. {{ data?.lecture.title }}
          </div>
        </div>
        <q-space />
      </q-toolbar>
    </q-header>

    <q-page-container>
      <q-page>
        <div class="group bg-black relative h-[60vh]">
          <template v-if="data?.lecture.type == 'video'">
            <BaseVideoPlayer :lecture="data?.lecture" />
          </template>
          <div class="bg-slate-100 p-20 w-full h-full overflow-y-auto" v-else>
            <div class="text-base" v-html="data?.lecture.body" />
          </div>

          <!-- next / previous -->
          <nuxt-link
            v-if="data?.previous"
            :to="{
              name: $route.name,
              params: {
                course: $route.params.course,
                lecture: data?.previous?.hashid,
              },
            }"
            class="transition-opacity duration-600 absolute opacity-0 group-hover:opacity-100 flex items-center p-2 left-0 top-1/3 bg-black text-white text-4xl"
          >
            <q-icon name="chevron_left" />
            <q-tooltip
              class="bg-black px-4 text-lg"
              anchor="center left"
              self="center right"
              :offset="[10, 10]"
              transition-show="scale"
              transition-hide="scale"
            >
              {{ data?.previous.title }}
            </q-tooltip>
          </nuxt-link>

          <nuxt-link
            v-if="data?.next"
            :to="{
              name: $route.name,
              params: {
                course: $route.params.course,
                lecture: data?.next?.hashid,
              },
            }"
            class="transition-opacity duration-600 absolute opacity-0 group-hover:opacity-100 flex items-center p-2 right-0 top-1/3 bg-black text-white text-4xl"
          >
            <q-icon name="chevron_right" />
            <q-tooltip
              class="bg-black px-4 text-lg"
              anchor="center left"
              self="center right"
              :offset="[10, 10]"
              transition-show="scale"
              transition-hide="scale"
            >
              {{ data?.next.title }}
            </q-tooltip>
          </nuxt-link>
        </div>
        <q-tabs no-caps class="border-b font-bold">
          <q-route-tab
            :to="{
              name: 'courses.learn',
              params: {
                course: $route.params.course,
                lecture: $route.params.lecture,
              },
            }"
            exact
            label="Overview"
          />
          <q-route-tab
            :to="{
              name: 'courses.questions',
              params: {
                course: $route.params.course,
                lecture: $route.params.lecture,
              },
            }"
            exact
            label="Questions"
          />
          <q-route-tab
            :to="{
              name: 'courses.reviews',
              params: {
                course: $route.params.course,
                lecture: $route.params.lecture,
              },
            }"
            exact
            label="Reviews"
          />
        </q-tabs>
        <div class="px-8 py-4">
        <nuxt-page />
      </div>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script setup>
const route = useRoute();
const config = useRuntimeConfig();

// we can access this token because it is fetched from the server and not browser
const authToken = useCookie('XXSRF-TOKEN')
const { data, refresh, error } = await useAsyncData(
  "course",
  () =>
    $fetch(
      `${config.public.baseURL}/c/${route.params.course}/learn/${route.params.lecture}`,
      {
        credentials: "include", // this is needed for client side
        headers: {
          "content-type": "application/json",
          accept: "application/json",
          'Authorization': `Bearer ${authToken.value}`
        },
      }
    ),
  {
    server: true,
  }
);

if(!data.value && error.value){
  const {statusCode, statusMessage} = error.value
  // fatal: true forces nuxt to show the error page on the client side.
    throw createError({statusCode, statusMessage, fatal: true})
}

watch(
  () => route.params.lecture,
  () => refresh("course")
);
</script>

<style lang="scss" scoped></style>
