<template>
  <BaseAuthPage>
    <template #title>Email verification</template>
    <BaseAlert  v-if="!pending && !error">
      Email successfully verified!
    </BaseAlert>
    <BaseAlert type="danger" v-else-if="error">
      {{ error.data.status }}
    </BaseAlert>
  </BaseAuthPage>
</template>

<script setup>
definePageMeta({
  middleware: ["auth"],
});

const route = useRoute()
const {$api} = useNuxtApp()
const { pending, error } = await $api(route.query.verify_url)

</script>

<style lang="scss" scoped></style>
