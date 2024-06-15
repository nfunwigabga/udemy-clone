<template>
  <q-page padding class="flex items-start py-28 bg-slate-50 relative isolate">
    <Squares />
    <q-card
      class="w-full container max-w-lg rounded-xl p-4 shadow-gray-200 shadow-lg"
    >
      <q-card-section>
        <div class="text-3xl full-width font-semibold text-center">
          <slot name="title" />
        </div>
      </q-card-section>

      <q-card-section class="pt-0">
        <slot />
      </q-card-section>
    </q-card>
  </q-page>
</template>
