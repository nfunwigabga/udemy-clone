<template>
  <BaseAuthPage>
    <template #title>Email verification required!</template>
    <div class="mb-4 text-sm text-gray-600 text-center">
      Thanks for signing up! Before getting started, could you verify your email
      address by clicking on the link we just emailed to you? If you didn't
      receive the email, we will gladly send you another.
    </div>

    <BaseAlert v-if="verificationLinkSent">
      A new verification link has been sent to the email address you provided
      during registration.
    </BaseAlert>

    <BaseAlert type="danger" v-if="form.errors.has('status')" >
     {{ form.errors.get('status') }}
    </BaseAlert>

    <q-form @submit="submit" class="space-y-4">
      <div>
        <BaseButton type="submit" :loading="form.busy" block dark>
          Resend Verification Email
        </BaseButton>
      </div>

      <div class="text-sm text-center">
        <BaseButton type="button" :disabled="form.busy" outline class="py-3" block @click="logout()">
          Logout
        </BaseButton>
      </div>
    </q-form>
  </BaseAuthPage>
</template>

<script setup>
definePageMeta({
  middleware: ["auth"],
});

const {logout} = useLogout()
const { $form } = useNuxtApp();

const verificationLinkSent = ref(false);

const form = reactive(
  $form({
    status: ""
  })
);

async function submit() {
  try {
    await form.post('/auth/email/verification-notification');
    verificationLinkSent.value = true
  } catch (error) {
    verificationLinkSent.value = false
  }
}
</script>

<style lang="scss" scoped></style>
