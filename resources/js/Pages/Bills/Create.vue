<template>
    <div class="flex justify-center items-center y-screen my-7">
        <h1 class="text-3xl text-purple-600 font-bold">Add new Bill</h1>
    </div>
    <div class="flex justify-center items-center y-screen">
        <div class="w-1/2 h-auto bg-gray-100 p-5">
            <Link href="/" as="button" type="button" class="float-left text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800" >
                Back
            </Link>
        </div>
    </div>
    <div class="flex justify-center items-center y-screen">
        <div class="w-1/2 h-auto bg-gray-100 py-5">
            <div v-if="message" class="flex items-center bg-green-500 text-white text-sm font-bold px-4 py-3 my-4" role="alert">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                <p>{{ message }}</p>
            </div>
            <form @submit.prevent="submit" class="max-w-sm mx-auto">
                <div class="mb-5">
                    <label for="bill_reference" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">
                        Bill Reference
                    </label>
                    <input type="text"  v-model="form.bill_reference" id="bill_reference" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    <div v-if="errors.bill_reference" class="text-red-600">
                        {{ errors.bill_reference }}
                    </div>
                </div>
                <div class="mb-5">
                    <label for="bill_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">
                        Bill Date
                    </label>
                    <Datepicker v-model="form.bill_date" :enable-time-picker="false"/>
                    <div v-if="errors.bill_date" class="text-red-600">
                        {{ errors.bill_date }}
                    </div>
                </div>
                <div class="mb-5">
                    <label for="bill_reference" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">
                        Bill Stage
                    </label>
                    <select v-model="form.bill_stage_id" name="status" class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option v-for="(stage, index) in bill_stages" :key="index" :value="stage.id">{{ stage.label }}</option>
                    </select>
                    <div v-if="errors.bill_stage_id" class="text-red-600">
                        {{ errors.bill_stage_id }}
                    </div>
                </div>
                <div class="p-2 flex">
                    <div class="w-1/2"></div>
                    <div class="w-1/2 flex justify-end">
                        <button type="submit" :disabled="form.processing" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 ml-2">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css';
import { Link } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Datepicker,
        Link
    },
    props: {
        errors: Object,
        bill_stages: Object,
    },
    data() {
        return {
            form: {
                bill_reference: null,
                bill_date: null,
                bill_stage_id: 1, // Draft as default
            },
            message: ''
        }
    },
    created() {
    },
    mounted() {
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
