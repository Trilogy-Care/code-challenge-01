<template>
    <div class="flex justify-center items-center y-screen my-7">
        <h1 class="text-3xl text-purple-600 font-bold">Bills</h1>
        
    </div>
    <div class="flex justify-center items-center y-screen">
        <div class="w-3/4 h-auto bg-gray-100 p-5">
            <Link href="/bills/create" as="button" type="button" class="float-right text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800" >
                Create Bill
            </Link>
        </div>
    </div>
    <div class="flex justify-center items-center y-screen">
        <div class="w-3/4 h-auto bg-gray-100">
            <div class="flex flex-row">
                <div class="basis-1/3 bg-gray-200 m-5 p-5">
                    <b>Total number submitted bills</b>
                    <p class="text-2xl font-semibold">{{ submitted_counts }}</p>
                </div>
                <div class="basis-1/3 bg-gray-200 m-5 p-5">
                    <b>Total number approved bills</b>
                    <p class="text-2xl font-semibold">{{ approved_counts }}</p>

                </div>
                <div class="basis-1/3 bg-gray-200 m-5 p-5">
                    <b>Total number on hold bills</b>
                    <p class="text-2xl font-semibold">{{ on_hold_counts }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-center items-center y-screen">
        <div class="w-3/4 h-auto bg-gray-100">
            <div class="flex flex-row">
                <div class="w-full bg-white m-5 p-5">
                    <b>Users</b>
                    <table class="mt-5">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Total bills</th>
                                <th class="px-4 py-2">Total submitted</th>
                                <th class="px-4 py-2">Total approved</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(user, index) in users" :key="index">
                                <td class="px-4">{{ user.id }}</td>
                                <td class="px-4">{{ user.name }}</td>
                                <td class="px-4">{{ user.bills_count }}</td>
                                <td class="px-4">{{ user.submitted_count }}</td>
                                <td class="px-4">{{ user.approved_count }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Link
    },
    props: {
        users: Array,
        submitted_counts: 0,
        approved_counts: 0,
        on_hold_counts: 0
    },
    data() {
        return {
            
        }
    },
    created() {
        //
    },
    mounted() {
        //
    },
    methods: {
        submit() {
            this.$inertia.post('/bills', this.form, {
                preserveScroll: true,
                onSuccess: () => {
                    this.form.bill_reference = null
                    this.form.bill_date = null
                    this.form.bill_stage_id = 1

                    this.message = this.$page.props.flash.message
                },
                onError: () => {
                    console.log('Error')
                },
            })
        },
    },
}
</script>