<template>
  <q-card bordered class="rounded-xl border-gray-400 shadow-md shadow-gray-200">
    <q-card-section class="pb-1">
      <h5 class="text-xl font-semibold">Pricing</h5>
    </q-card-section>
    <q-separator />
    <q-card-section class="space-x-2 flex items-center p-4xl">
      <BaseFormSelectInput
        class="flex-1"
        label="Select Price Tier"
        label-field="label"
        value-field="value"
        :options="price_tiers"
        v-model="priceForm.price"
        :error="priceForm.errors.get('price')"
      />
      <BaseButton
        @click="updatePrice"
        class="py-4 px-6"
        :loading="priceForm.busy"
        >Update</BaseButton
      >
    </q-card-section>

    <template v-if="course?.price > 0">
      <q-card-section class="py-2">
        <h5 class="text-xl font-semibold">Promotion Coupons</h5>
      </q-card-section>
      <q-separator></q-separator>
      <q-card-section class="space-y-4 p-4xl">
        <q-form @submit="createCoupon" class="grid grid-cols-2 gap-3">
          <BaseFormInput
            required
            v-model="couponForm.code"
            :error="couponForm.errors.get('code')"
            label="Coupon Code"
          />
          <BaseFormInput
            type="number"
            required
            v-model="couponForm.quantity"
            :error="couponForm.errors.get('quantity')"
            label="Quantity"
          />
          <BaseFormInput
            type="number"
            required
            v-model="couponForm.percent"
            :error="couponForm.errors.get('percent')"
            label="Discount percent"
          />
          <BaseFormInput
            type="date"
            stack-label
            v-model="couponForm.expires_at"
            :error="couponForm.errors.get('expires_at')"
            label="Expires at"
          />
          <div class="col-span-2 text-right">
            <span class="mr-4" :class="{ 'text-red-500': finalPrice < 0 }">
              Final price: ${{ finalPrice }}
            </span>
            <BaseButton type="submit" :loading="couponForm.busy">
              Save
            </BaseButton>
          </div>
        </q-form>

        <q-markup-table flat class="q-my-lg">
          <thead>
            <tr class="bg-grey-2 text-left">
              <th>Code</th>
              <th>Discount %</th>
              <th>Expiry Date</th>
              <th>Redemptions</th>
              <th>Link</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="coupon in coupons" :key="coupon.id">
              <td>{{ coupon.code }}</td>
              <td>{{ coupon.percent }}% OFF</td>
              <td>{{ coupon.expires_at }}</td>
              <td>0/{{ coupon.quantity }}</td>
              <td>
                <q-btn
                  dense
                  unelevated
                  @click="copyLink(coupon.link)"
                  size="sm"
                  flat
                >
                  Copy Link
                </q-btn>
              </td>
              <td>
                <span v-if="coupon.expired">Expired</span>
                <q-btn
                  v-else
                  size="xs"
                  @click="toggleCouponStatus(coupon.id)"
                  :color="coupon.active ? 'green' : 'red'"
                  outline
                >
                  {{ coupon.active ? "Active" : "Inactive" }}
                </q-btn>
              </td>
            </tr>
          </tbody>
        </q-markup-table>
      </q-card-section>
    </template>
  </q-card>
</template>

<script setup>
definePageMeta({
  layout: "course-management",
  middleware: ["auth", "verified"],
});
const { $api, $form } = useNuxtApp();
const course = useState('course', () => null)
const route = useRoute();

const { data, error, refresh } = await $api(
  `/instructor/c/${route.params.course}/pricing-promotions`
);

const price_tiers = ref([]);
const coupons = ref([]);
const priceForm = reactive(
  $form({
    price: "",
  })
);
const couponForm = reactive(
  $form({
    code: "",
    expires_at: "",
    quantity: "",
    percent: "",
  })
);

watch(
  () => data.value,
  (payload) => {
    if (!error.value && payload) {
      course.value = payload.course
      price_tiers.value = payload.price_tiers;
      coupons.value = payload.coupons;
      priceForm.price = payload.course?.price;
    }
  },
  { immediate: true }
);

const finalPrice = computed(() => {
  const price = course.value?.price;
  if (price > 0) {
    if (!couponForm.percent) price;
    return (price - price * (couponForm.percent / 100)).toFixed(2);
  }
  return 0;
});

function updatePrice() {
  priceForm
    .put(`/instructor/c/${route.params.course}/pricing`)
    .then((_) => console.log("Done"))
    .catch((error) => console.error(error));
}

function createCoupon() {
  if (finalPrice.value < 0) {
    alert("Discount percent cannot be > 100");
    return;
  }
  couponForm
    .post(`/instructor/c/${route.params.course}/coupons`)
    .then((response) => {
      refresh();
      couponForm.reset();
    })
    .catch((error) => console.error(error));
}

function toggleCouponStatus(id) {
  $api(`/instructor/c/${route.params.course}/coupons/${id}`, {
    method: "PUT",
  })
    .then((response) => {
      refresh();
    })
    .catch((error) => console.error(error));
}

function copyLink(link) {
  copyToClipboard(link)
    .then((_) => alert("Link copied to clipboard"))
    .catch((_) => alert("Something went wrong"));
}
</script>

<style lang="scss" scoped></style>
