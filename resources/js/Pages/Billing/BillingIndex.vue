<template>
  <app-layout>
    <template #header>
      <h1>Bills</h1>
    </template>
    <template #body>
      <div class="mb-6">
        <billing-stats />
      </div>
      <billing-table />
    </template>
  </app-layout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import BillingStats from '@/Pages/Billing/Partials/BillingStats.vue'
import BillingTable from '@/Pages/Billing/Partials/BillingTable.vue'
</script>