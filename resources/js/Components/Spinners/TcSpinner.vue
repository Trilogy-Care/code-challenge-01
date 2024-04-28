<template>
  <div class="flex items-center justify-center">
    <div
      class="spinner border-2 border-solid rounded-full border-gray-500 border-t-transparent animate-spin"
      :class="[`h-${props.size} w-${props.size}`]"
    ></div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue'

const props = defineProps({
  size: {
    type: String,
    default: '8',
  },
})
</script>

<style scoped>
@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
.spinner {
  border-top-color: transparent;
  animation: spin 1s linear infinite;
}
</style>