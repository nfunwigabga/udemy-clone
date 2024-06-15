<template>
  <BaseAuthPage>
    <template #title>Login</template>
    <q-form @submit="login" class="space-y-4">
      <BaseFormInput
        type="email"
        placeholder="Email Address"
        v-model="form.email"
        label="Email"
        icon="las la-envelope"
        :error="form.errors?.get('email')"
      />
      <BaseFormInput
        type="password"
        v-model="form.password"
        label="Password"
        icon="las la-lock"
        :error="form.errors?.get('password')"
      />
      <BaseButton type="submit" class="py-3" :loading="form.busy" block>
        Sign in
      </BaseButton>

      <div class="text-base space-y-4 text-center pt-2">
        <div>
          <nuxt-link to="#" class="font-bold"> Forgot password? </nuxt-link>
        </div>

        <div>
          No Account?
          <nuxt-link to="/register" class="font-bold"> Sign up </nuxt-link>
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
const auth = useAuth();
const redirectPath = useCookie("skillmetr_redirect", {
  default: () => "/",
  watch: true,
});

const form = reactive(
  $form({
    email: "fgneba@gmail.com",
    password: "Den455-Idle429",
  })
);

async function login() {
  try {
    await auth.loginWith("cookie", { body: form.data() });
    // await auth.loginWith("local", { body: form.data() });
    navigateTo(redirectPath.value);
    redirectPath.value = null;
  } catch (error) {
    if (error?.response?.status === 422) {
      form.errors.set(error.response._data.errors);
    } else {
      form.errors.set("email", "An unexpected error occured!");
    }
  }
}
</script>

<style lang="scss" scoped></style>
