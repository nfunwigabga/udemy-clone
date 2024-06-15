<template>
  <q-page>
    <Head>
      <Title>Welcome</Title>
    </Head>
    <section class="relative bg-gray-900 shadow mb-8">
      <div class="container py-14 grid grid-cols-8 gap-x-6">
        <!-- Left form -->
        <div class="col-span-5">
          <div class="mt-6 sm:max-w-xl">
            <h1
              class="text-4xl font-bold tracking-tight text-gray-200 sm:text-5xl"
            >
              Learn anything, from anywhere.
            </h1>
          </div>
        </div>

        <!-- Right image -->
        <div class="col-span-3 relative">
          <q-img
            class="w-full shadow-xl shadow-gray-700 rounded-xl"
            src="/concert.jpg"
          />
        </div>
      </div>
    </section>

    <section class="container">
      <div class="grid grid-cols-4 gap-4">
        <div v-for="course in courses" :key="course.id">
          <BaseCourseCard :course="course" />
        </div>
      </div>
    </section>
  </q-page>
</template>

<script setup>
const { $api } = useNuxtApp();

const { data: courses, pending } = $api(`/courses`);
</script>

<style lang="scss" scoped></style>
