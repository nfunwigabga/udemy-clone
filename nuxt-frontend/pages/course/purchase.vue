<template>
  <BaseAuthPage>
    <template #title> Checkout </template>
    <div class="text-center mb-4 space-y-1">
      <div class="text-xl font-semibold">{{ course.title }}</div>
      <p class="text-gray-600">by {{ course?.author.name }}</p>
      <p class="font-bold text-2xl">Price: {{ course.price_formatted }}</p>
    </div>
    <q-separator />
    <div class="py-4">
      <q-form @submit="submit" id="payment-form" class="space-y-3">
        <div id="error-message"></div>
        <BaseAlert v-if="errorMessage" type="danger">{{ errorMessage }}</BaseAlert>
        <div id="payment-element"></div>
        <BaseButton :loading="processing" type="submit" id="submit">Pay Now</BaseButton>
      </q-form>
    </div>
  </BaseAuthPage>
</template>

<script setup>
definePageMeta({
  middleware: ["auth", "verified", "cannot-access-course"],
});

const { $api, $stripe, $form } = useNuxtApp();
const route = useRoute();
const course = ref(null);
const intent = ref(null);
const elements = ref(null);
const errorMessage = ref(null);
// const returnUrl = ref(null)
const processing = ref(false);

const form = reactive(
  $form({
    payment_id: "",
  })
);

const { data, error } = await $api(`/c/${route.params.course}/checkout`);

if (!data.value && error.value) {
  const { statusCode, statusMessage } = error.value;
  // fatal: true forces nuxt to show the error page on the client side.
  throw createError({ statusCode, statusMessage, fatal: true });
}

course.value = data.value?.course;
intent.value = data.value?.intent;

async function submit() {
  processing.value = true;
  const response = await $stripe.confirmPayment({
    elements: elements.value,
    redirect: "if_required",
    //   confirmParams: {
    //     return_url: 'https://example.com/order/123/complete',
    //   },
  });
  const { error: err } = response;
  if (err) {
    console.log(err);
    errorMessage.value = err.message;
  } else {
    form.payment_id = response.paymentIntent.id;
    await form.post(`/c/${route.params.course}/checkout`);
    window.location.href=`/c/${route.params.course}/learn/${course.value?.first_lecture}`
  }
  processing.value = false;
}

onMounted(async () => {
  elements.value = $stripe.elements({
    clientSecret: intent.value,
    // ref: Appearance options https://stripe.com/docs/elements/appearance-api
    appearance: {
      theme: "stripe",
      labels: "floating",
    },
  });

  await nextTick();
  const paymentElement = elements.value.create("payment");
  paymentElement.mount("#payment-element");
 
  
});
</script>

<style lang="scss" scoped></style>
