<template>
  <q-page class="relative">
    <Head>
      <Title>{{ course.title }}</Title>
    </Head>
    <div class="absolute top-10 right-20">
      <q-card class="w-96 min-h-96 overflow-hidden bg-white border border-gray-600">
        <q-img :src="course.cover">
          <div
            class="absolute cursor-pointer group inset-0 flex items-center justify-center"
          >
            <q-icon
              name="play_circle"
              class="transition-scale duration-300 text-8xl group-hover:scale-110"
            />
          </div>
        </q-img>
        <q-card-section>
          <h4 class="text-4xl flex gap-x-2 items-end font-bold">
            {{ course.price_formatted }}
          </h4>
          <div class="flex my-4 gap-2 items-center">
            <q-btn unelevated class="w-full py-3" color="primary"> Add to cart </q-btn>
            <q-btn
              :href="`/c/${route.params.course}/purchase`"
              class="w-full py-3"
              outline
            >
              Buy now
            </q-btn>
          </div>
        </q-card-section>
      </q-card>
    </div>
    <div class="py-12 min-h-60 bg-gray-900 text-white">
      <div class="container pr-96 space-y-2">
        <h4 class="text-4xl font-bold">{{ course.title }}</h4>
        <p class="text-xl">{{ course.subtitle }}</p>
        <div>
          <q-rating
            :model-value="3.5"
            size="1.4em"
            readonly
            color="orange"
            icon="star_border"
            icon-selected="star"
            icon-half="star_half"
          ></q-rating>
          (12 ratings), 1230 students
        </div>
        <div class="my-2">
          Created by
          <Link href="#" class="text-indigo-300">John Doe</Link>
        </div>
        <div class="my-2">Last updated 12/2021</div>
      </div>
    </div>

    <div class="container py-8 pr-96">
      <div class="pr-12">
        <!-- What you'll learn -->
        <q-card bordered flat class="mb-4">
          <q-card-section>
            <BaseCoursePageSection title="What you'll learn">
              <div class="grid my-4 grid-cols-2 gap-4 text-lg">
                <div
                  class="flex space-x-2"
                  v-for="item in course.what_to_learn"
                  :key="item.id"
                >
                  <q-icon name="check"></q-icon>
                  <span>{{ item.text }}</span>
                </div>
              </div>
            </BaseCoursePageSection>
          </q-card-section>
        </q-card>

        <!-- Course stats -->
        <!-- <BaseCoursePageSection title="This course includes">
          <div class="grid grid-cols-3 gap-4 mb-8">
            <q-card flat bordered>
              <q-card-section class="flex items-center gap-3">
                <div class="text-4xl">
                  <q-icon name="play_circle" />
                </div>
                <div class="text-md font-semibold">
                  12hours of video content
                </div>
              </q-card-section>
            </q-card>
            <q-card flat bordered>
              <q-card-section class="flex items-center gap-3">
                <div class="text-4xl">
                  <q-icon name="description" />
                </div>
                <div class="text-md font-semibold">Text lessons</div>
              </q-card-section>
            </q-card>
            <q-card flat bordered>
              <q-card-section class="flex items-center gap-3">
                <div class="text-4xl">
                  <q-icon name="paid" />
                </div>
                <div class="text-md font-semibold">30-day money-back</div>
              </q-card-section>
            </q-card>
          </div>
        </BaseCoursePageSection> -->

        <!-- <pre>{{ course }}</pre> -->

        <!-- Course stats -->
        <BaseCoursePageSection title="Course Content">
          <q-list bordered class="mb-4">
            <q-expansion-item
              switch-toggle-side
              v-for="section in course.sections"
              :key="section.id"
              class="border-b border-b-gray-300 bg-zinc-50"
            >
              <template #header>
                <q-item-section class="font-bold">
                  {{ section.title }}
                </q-item-section>
                <q-item-section side class="text-slate-600">
                  6 lectures, 14 mins
                </q-item-section>
              </template>
              <q-list
                class="bg-white border-b border-b-gray-200"
                v-for="lecture in section.lectures"
                :key="lecture.id"
              >
                <q-item clickable :href="`/c/${course.slug}/learn/${lecture.id}`">
                  <q-item-section avatar class="text-slate-500">
                    <q-icon v-if="lecture.type === 'video'" name="play_circle" />
                    <q-icon v-else name="description" />
                  </q-item-section>
                  <q-item-section>
                    {{ lecture.title }}
                  </q-item-section>
                  <q-item-section side>
                    {{ lecture.duration.hms }}
                  </q-item-section>
                </q-item>
              </q-list>
            </q-expansion-item>
          </q-list>
        </BaseCoursePageSection>

        <BaseCoursePageSection title="Description">
          <div v-html="course.description" />
        </BaseCoursePageSection>

        <h5 class="text-xl font-bold">Author</h5>
        <q-card flat>
          <div v-html="course.description" />
        </q-card>

        <h5 class="text-xl font-bold">Reviews</h5>
        <q-card flat>
          <div v-html="course.description" />
        </q-card>
      </div>
    </div>
  </q-page>
</template>

<script setup>
const { $api } = useNuxtApp();
const route = useRoute();

const { data: course, error } = await $api(`/c/${route.params.course}`);

if (!course.value && error.value) {
  const { statusCode, statusMessage } = error.value;
  // fatal: true forces nuxt to show the error page on the client side.
  throw createError({ statusCode, statusMessage, fatal: true });
}
</script>

<style lang="scss" scoped></style>
