<template>
  <div class="bg-white p-8 overflow-x-auto relative">
    <div class="px-6 mb-8">
      <h3 class="font-semibold">Users</h3>
    </div>
    <tc-spinner v-if="loading"></tc-spinner>
    <tc-table v-else>
      <tc-table-head>
        <tc-table-th>Name</tc-table-th>
        <tc-table-th>Total Bills</tc-table-th>
        <tc-table-th>Total Submitted</tc-table-th>
        <tc-table-th>Total Approved</tc-table-th>
      </tc-table-head>
      <tbody>
        <tr v-for="(bill, index) in bills" :key="index">
          <tc-table-td>{{ bill.name }}</tc-table-td>
          <tc-table-td>{{ bill.total_bills }}</tc-table-td>
          <tc-table-td>{{ bill.total_submitted_bills }}</tc-table-td>
          <tc-table-td>{{ bill.total_submitted_bills }}</tc-table-td>
        </tr>
      </tbody>
    </tc-table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import TcTable from '@/Components/Tables/TcTable.vue'
import TcTableHead from '@/Components/Tables/TcTableHead.vue'
import TcTableTh from '@/Components/Tables/TcTableTh.vue'
import TcTableTd from '@/Components/Tables/TcTableTd.vue'
import TcSpinner from '@/Components/Spinners/TcSpinner.vue'

const bills = ref([])
const loading = ref(true)

const fetch = async () => {
  axios
    .get('/api/bills')
    .then((response) => {
      bills.value = response.data
      loading.value = false
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
