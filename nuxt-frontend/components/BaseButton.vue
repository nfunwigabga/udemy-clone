<template>
    <q-btn
        :type="type"
        :color="color"
        :loading="loading"
        :disabled="loading || disabled"
        unelevated
        :outline="outline"
        :size="size"
        :no-caps="!caps"
        v-bind="$attrs"
        :class="{ 'w-full': block }"
        class="px-3 rounded font-bold text-base"
    >
        <template #loading>
            <q-spinner-facebook class="on-left" />
        </template>
        <slot />
    </q-btn>
</template>

<script setup>
    defineProps({
        type: {
            type: String,
            default: "button",
        },
        outline: Boolean,
        loading: Boolean,
        caps: Boolean,
        round: Boolean,
        disabled: Boolean,
        size: String,
        block: Boolean,
        color: {
            type: String,
            default: "black",
        },
    });
</script>
