<template>
  <q-card flat bordered>
    <q-card-section horizontal>
      <q-img class="col-2" :src="course.cover" />

      <q-card-section class="col-10">
        <template v-if="course.published">
          <div class="grid grid-cols-12 gap-x-3">
            <div class="col-span-6 relative">
              <div class="h-full space-y-1">
                <div class="text-xl mb-3">
                  {{ course.title }}
                </div>
                <div class="inline-flex">
                  <q-badge color="grey-10" size="md" label="LIVE" />
                </div>
                <div class="font-extrabold">
                  {{ course.price_formatted }}
                </div>
                <!--                                    <span>-  Public</span>-->
              </div>
              <a
                :href="`/instructor/c/${course.id}/basic`"
                :class="hoverClass"
              >
                Edit / Manage course
              </a>
            </div>

            <div class="col-span-2 relative">
              <div class="text-xl">
                {{ course.price_formatted }}
              </div>
              <div class="text-caption text-grey-8">Earned this month</div>
              <nuxt-link to="#" :class="hoverClass">
                See performance
              </nuxt-link>
            </div>
            <div class="col-span-2 relative text-center">
              <div class="text-xl">10</div>
              <div class="text-caption text-grey-8">Enrollments this month</div>
              <nuxt-link to="#" :class="hoverClass"> See students </nuxt-link>
            </div>

            <div class="col-span-2 relative text-center course-info-section">
              <div class="text-xl">4.3</div>
              <div>
                <q-rating
                  class="inline-flex"
                  :model-value="4.3"
                  size="1.4em"
                  readonly
                  color="orange"
                  icon="star_border"
                  icon-selected="star"
                  icon-half="star_half"
                ></q-rating>
              </div>
              <nuxt-link to="#" :class="hoverClass"> See reviews </nuxt-link>
            </div>
          </div>
        </template>

        <template v-else>
          <div class="grid grid-cols-12">
            <div class="col-span-12 relative">
              <div class="text-xl mb-4">
                {{ course.title }}
              </div>
              <div class="inline-flex">
                <q-badge
                  color="orange-6"
                  size="md"
                  class="uppercase"
                  :label="course.status"
                />
              </div>

              <a
                :href="`/instructor/c/${course.id}/basic`"
                :class="hoverClass"
              >
                Edit / Manage course
              </a>
            </div>
          </div>
        </template>
      </q-card-section>
    </q-card-section>
  </q-card>
</template>

<script setup>
defineProps({
  published: Boolean,
  course: Object,
});

const hoverClass =
  "absolute inset-0 text-lg flex items-center justify-center bg-white transition-opacity duration-300 opacity-0 hover:opacity-90";
</script>

<style lang="scss" scoped></style>
