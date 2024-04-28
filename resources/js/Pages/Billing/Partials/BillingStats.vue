<template>
  <div class="grid grid-cols-3 gap-4">
    <tc-card>
      <div class="flex justify-between">
        <h2 class="font-semibold">Total number submitted bills</h2>
        <tc-spinner v-if="loading" size="4" />
        <span v-else class="font-semibold text-gray-500">
          {{ stats.total_submitted_bills }}
        </span>
      </div>
    </tc-card>
    <tc-card>
      <div class="flex justify-between">
        <h2 class="font-semibold">Total number approved bills</h2>
        <tc-spinner v-if="loading" size="4" />
        <span v-else class="font-semibold text-gray-500">
          {{ stats.total_on_hold_bills }}
        </span>
      </div>
    </tc-card>
    <tc-card>
      <div class="flex justify-between">
        <h2 class="font-semibold">Total number on hold bills</h2>
        <tc-spinner v-if="loading" size="4" />
        <span v-else class="font-semibold text-gray-500">
          {{ stats.total_submitted_bills }}
        </span>
      </div>
    </tc-card>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import TcCard from '@/Components/Cards/TcCard.vue'
import TcSpinner from '@/Components/Spinners/TcSpinner.vue'

const stats = ref({})
const loading = ref(false)

const fetch = async () => {
  loading.value = true
  axios
    .get('/api/billing-summary')
    .then((response) => {
      stats.value = response.data
    })
    .catch((error) => {
      console.error(error)
    })
    .finally(() => {
      loading.value = false
    })
}

onMounted(fetch)
</script>
