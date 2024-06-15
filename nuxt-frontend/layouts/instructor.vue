<template>
  <q-layout view="lhh lpR fFf">
    <q-header class="bg-gray-900 border-b py-2 text-white">
      <q-toolbar class="container">
        <q-toolbar-title>
          <nuxt-link to="/instructor" class="text-2xl font-semibold">
            Skillmetr <span class="text-xs">Instructor panel</span>
          </nuxt-link>
        </q-toolbar-title>
        <q-btn
          :text-color="$route.name === link.route ? 'primary' : ''"
          v-for="link in links"
          :key="link.route"
          :to="{ name: link.route }"
          dense
          rounded
          flat
          no-caps
          class="px-3 text-lg"
        >
          {{ link.title }}
        </q-btn>

        <q-space />

        <q-btn round flat>
          <q-avatar size="30px">
            <img :src="$auth.user?.avatar" />
          </q-avatar>
          <q-menu auto-close class="shadow-xl rounded-b-xl">
            <q-list dense class="w-48">
              <q-item clickable href="/" exact>
                <q-item-section>Back to site</q-item-section>
              </q-item>
              <q-separator />
              <q-item clickable @click="logout">
                <q-item-section>Logout</q-item-section>
              </q-item>
            </q-list>
          </q-menu>
        </q-btn>
      </q-toolbar>
    </q-header>

    <q-page-container>
      <nuxt-page />
    </q-page-container>
  </q-layout>
</template>

<script setup>
const { logout } = useLogout();

const links = [
  {
    title: "Courses",
    icon: "las la-book",
    route: "instructor.dashboard",
  },
  {
    title: "Questions",
    icon: "las la-question-circle",
    route: "instructor.questions.index",
  },
];
</script>
