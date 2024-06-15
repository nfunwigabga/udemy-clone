<template>
  <q-header
    height-hint="64"
    class="bg-white border-b text-gray-800"
  >
    <q-toolbar class="container py-4">
      <div class="flex items-center flex-1">
        <q-toolbar-title class="text-black flex-none mr-3">
          <nuxt-link to="/" class="text-2xl font-semibold">
            Skillmetr
          </nuxt-link>
        </q-toolbar-title>
        <BaseSearchForm />
      </div>
      <q-space />

      <div class="space-x-2">
        <template v-if="!$auth.loggedIn">
          <q-btn to="/login" dense rounded flat no-caps class="px-3">
            Login / Sign up
          </q-btn>
        </template>
        <template v-else>
          <q-btn href="/instructor" dense rounded flat no-caps class="px-3">
            Instructor dashboard
          </q-btn>
          <q-btn round flat>
            <q-avatar
              size="30px"
              class="ring ring-1 ring-primary-600 ring-offset-2"
            >
              <img :src="$auth.user?.avatar" />
            </q-avatar>
            <q-menu auto-close class="shadow-xl border border-t-0 rounded-b-lg">
              <q-list separator dense class="w-48">
                <q-item clickable>
                  <q-item-section>Contact data</q-item-section>
                </q-item>
                <q-item clickable>
                  <q-item-section>Block</q-item-section>
                </q-item>
                <!-- <q-separator /> -->
                <q-item clickable @click="logout()">
                  <q-item-section>Logout</q-item-section>
                </q-item>
              </q-list>
            </q-menu>
          </q-btn>
        </template>
      </div>
    </q-toolbar>
  </q-header>
</template>

<script setup>
const { logout } = useLogout();
</script>

<style lang="scss" scoped></style>
