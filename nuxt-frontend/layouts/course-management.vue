<template>
  <q-layout view="lhh lpR fFf">
    <ClientOnly>
      <Head>
        <Title>{{ course?.title || "Course management" }}</Title>
      </Head>
      <q-header class="bg-black shadow-lg text-white" id="page-header">
        <q-toolbar class="container">
          <a class="text-white" href="/instructor">
            <q-icon name="las la-arrow-left"></q-icon> Back to courses
          </a>
          <q-toolbar-title>
            {{ course?.title }}
            <q-badge
              :class="course?.published ? 'bg-green-600' : 'bg-gray-600'"
              class="uppercase inline-flex"
            >
              {{ course?.status }}
            </q-badge>
          </q-toolbar-title>
        </q-toolbar>
      </q-header>

      <q-page-container>
        <q-page padding class="container">
          <div class="grid grid-cols-12 gap-4">
            <div class="col-span-3">
              <q-list class="shadow-sm rounded-lg">
                <q-item
                  :active="$route.name === item.name"
                  class="text-lg rounded-lg"
                  active-class="bg-gray-100 text-primary-800"
                  v-for="item in menu"
                  :key="item.name"
                  clickable
                  :to="{ name: item.name, params: { course: course?.id } }"
                >
                  <q-item-section>
                    <div class="flex items-center gap-x-2">
                      <q-icon name="las la-arrow-right" />
                      {{ item.title }}
                    </div>
                  </q-item-section>
                </q-item>
              </q-list>
              <div class="my-4 px-4" v-if="course?.canBePublished">
                <q-btn
                  unelevated
                  class="w-full"
                  :color="course?.published ? 'red-5' : 'green-5'"
                  @click="updateCourseStatus"
                >
                  {{ course?.published ? "Unpublish" : "Publish" }}
                  course
                </q-btn>
              </div>
            </div>
            <div class="col-span-9">
              <router-view v-slot="{ Component }">
                <transition
                  enter-active-class="animated fadeIn"
                  leave-active-class="animated fadeOut"
                  appear
                  :duration="300"
                >
                  <div>
                    <component :is="Component" />
                  </div>
                </transition>
              </router-view>
            </div>
          </div>
        </q-page>
      </q-page-container>
    </ClientOnly>
  </q-layout>
</template>

<script setup>

const route = useRoute()
const {$api} = useNuxtApp()
const course = useState('course')

// if(error.value){
//   const {statusCode, statusMessage} = error.value
//   // fatal: true forces nuxt to show the error page on the client side.
//   throw createError({statusCode, statusMessage, fatal: true})
// }

const menu = [
  { name: "instructor.courses.basic", title: "Course landing page" },
  { name: "instructor.courses.targets", title: "Course targets" },
  { name: "instructor.courses.curriculum", title: "Course curriculum" },
  { name: "instructor.courses.pricing", title: "Prices and promotions" },
];


async function updateCourseStatus() {
      const { data } = await $api(
        `/instructor/c/${route.params.course}/status`,
        {
          method: "PUT",
        }
      );
      course.value = data.value;
  }
</script>

<style lang="scss"></style>
