<script setup>
defineProps({
    message: {
        type: Array,
    },
});
</script>

<template>
    <div v-show="message">
        <p class="text-sm text-red-600">
            {{ message[0] }}
        </p>
    </div>
</template>
