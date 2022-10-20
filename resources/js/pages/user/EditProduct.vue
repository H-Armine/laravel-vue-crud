<template>
    <div
        class="h-full w-full animated fadeIn faster  fixed  left-0 top-0 flex justify-center items-center inset-0 z-50 outline-none focus:outline-none bg-no-repeat bg-center bg-cover"
        id="editProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="absolute bg-black opacity-80 inset-0 z-0"/>
        <div class="modal-dialog relative w-25 pointer-events-none">
            <div
                class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                <div
                    class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                    <h5 class="text-xl font-medium leading-normal text-gray-800"
                        id="exampleModalLabel">
                        Edit product
                    </h5>
                    <button type="button"
                            class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                            @click="$emit('close')">
                    </button>
                </div>
                <Form :validation-schema="schema" v-slot="{ errors }" @submit="updateProduct">
                    <div class="modal-body relative p-4">
                        <label for="name"
                               class="text-gray-800 text-sm font-bold leading-tight tracking-normal">
                            Name
                        </label>
                        <Field
                            id="name"
                            name="name"
                            type="text"
                            placeholder="Name"
                            v-model="selectedProduct.name"
                            :class="{ 'is-invalid': errors.name}"
                            class="mb-2 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border form-control">
                        </Field>
                        <div class="invalid-feedback">{{ errors.name }}</div>
                        <label for="categories"
                               class="block mt-10 text-sm font-medium text-gray-900 dark:text-gray-400">
                            Category
                        </label>
                        <Field
                            id="category"
                            name="category"
                            type="text"
                            as="select"
                            v-model="selectedProduct.category_id"
                            :class="{ 'is-invalid': errors.category}"
                            class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option v-for="category in categories" :value="category.id" value="" selected>
                                {{ category.name }}
                            </option>
                        </Field>
                        <div class="invalid-feedback">{{ errors.category }}</div>
                        <label for="price"
                               class="pt-5 text-gray-800 text-sm font-bold leading-tight tracking-normal">
                            Price
                        </label>
                        <Field
                            id="price"
                            name="price"
                            type="number"
                            placeholder="Price"
                            v-model="selectedProduct.price"
                            :class="{ 'is-invalid': errors.price }"
                            class="mb-2 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border form-control">
                        </Field>
                        <div class="invalid-feedback ">{{ errors.price }}</div>
                    </div>
                    <div
                        class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end space-x-4 p-4 border-t border-gray-200 rounded-b-md">
                        <button type="button"
                                class="px-6 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out"
                                @click="$emit('close')">
                            Close
                        </button>
                        <button type="submit"
                                class="px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                            Save
                        </button>
                    </div>
                </Form>

            </div>
        </div>
    </div>
</template>

<script>
import {Form, Field} from 'vee-validate';
import * as yup from "yup";

export default {
    name: "EditProduct.vue",

    emits: ["close", "updateEditProduct"],

    components: {
        Form,
        Field,
    },

    data() {
        return {

        }
    },

    props: [
        'categories',
        'selectedProduct',
        'changesProduct',
    ],

    // product: {
    //     'name': '',
    //     'category_id': '',
    //     'price': ''
    // },
    //
    // category: {
    //     'name': '',
    // },

    computed: {
        schema() {
            return yup.object().shape({
                name: yup.string()
                    .required("Тhe name is required. Please fill in.")
                    .min(3, "The name must be at least 3 characters.")
                    .max(35, "The name must be no more than 35 characters."),
                category: yup.string()
                    .required("Тhe category is required. Please choose one of the category."),
                price: yup.string()
                    .required("Тhe price is required. Please fill in.")
                    .matches(/^[0-9](\.[0-9][0-9][0-9])$/, "Only a number in this format of '9.999' is allowed for this field."),
            });
        }

    },

    methods: {
        updateProduct() {
            axios.post('dashboard/product/edit', this.selectedProduct)
                .then(response => {
                    if (response.data.product) {
                        this.$emit('updateEditProduct', response.data.product)
                    }
                })
                .catch(error => console.log(error))
                .finally(() => this.loading = false)
        }
    }
}
</script>

<style scoped>

</style>
