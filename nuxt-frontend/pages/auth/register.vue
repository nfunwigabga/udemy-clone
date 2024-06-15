<template>
  <BaseAuthPage>
    <template #title>Register</template>
    <q-form @submit="register" class="space-y-4">
        <BaseFormInput
            placeholder="Enter First Name"
            v-model="form.first_name"
            label="First Name"
            :error="form.errors?.get('first_name')"
        />
        <BaseFormInput
            placeholder="Enter Last Name"
            v-model="form.last_name"
            label="Last Name"
            :error="form.errors?.get('last_name')"
        />
        <BaseFormInput
            placeholder="Enter a username"
            v-model="form.username"
            label="Username"
            :error="form.errors?.get('username')"
        />
      <BaseFormInput
        type="email"
        placeholder="Email Address"
        v-model="form.email"
        label="Email"
        :error="form.errors?.get('email')"
      />
      <BaseFormInput
        type="password"
        v-model="form.password"
        label="Password"
        :error="form.errors?.get('password')"
      />
      <BaseFormInput
        type="password"
        v-model="form.password_confirmation"
        label="Confirm Password"
        :error="form.errors?.get('password_confirmation')"
      />
      <BaseButton type="submit" class="py-3" :loading="form.busy" block>
        Sign up
      </BaseButton>

      <div class="text-base space-y-4 text-center pt-2">
        <div>
          Already registered?
          <nuxt-link to="/login" class="font-bold"> Login </nuxt-link>
        </div>
      </div>
    </q-form>
  </BaseAuthPage>
</template>

<script setup>
definePageMeta({
  middleware: "guest",
});
const { $form } = useNuxtApp();

const form = reactive(
  $form({
    first_name: "",
    last_name: "",
    username: "",
    email: "",
    password: "",
    password_confirmation: ""
  })
);

async function register() {
  try {
    await form.post('/auth/register')
    navigateTo('/login');
  } catch (error) {
    console.log(error)
  }
}
</script>

<style lang="scss" scoped></style>
