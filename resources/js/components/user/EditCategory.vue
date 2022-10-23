<template>
    <div
        class="h-full w-full animated fadeIn faster  fixed  left-0 top-0 flex justify-center items-center inset-0 z-50 outline-none focus:outline-none bg-no-repeat bg-center bg-cover"
        id="editCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="absolute bg-black opacity-80 inset-0 z-0"/>
        <div class="modal-dialog relative w-25 pointer-events-none">
            <div
                class="w-full max-w-lg p-0.5 relative mx-auto my-auto rounded-xl shadow-lg bg-white flex flex-col pointer-events-auto bg-clip-padding text-current">
                <div
                    class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                    <h5 class="text-xl font-medium leading-normal text-gray-800"
                        id="exampleModalLabel">
                        Edit categories
                    </h5>
                    <button type="button"
                            class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                            @click="$emit('close')">
                    </button>
                </div>
                <Form :validation-schema="schema" v-slot="{ errors }" @submit="updateCategory">
                    <div class="modal-body relative p-4">
                        <label
                            class="text-gray-800 text-sm font-bold leading-tight tracking-normal">
                            Name
                        </label>
                        <Field
                            id="name"
                            name="name"
                            type="text"
                            placeholder="Name"
                            v-model="selectedCategory.name"
                            :class="{ 'is-invalid': errors.name }"
                            class="mb-2 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border form-control">
                        </Field>
                        <div class="invalid-feedback ">
                            {{ errors.name }}
                        </div>
                        <label class="mb-2 font-semibold text-gray-700">
                            Description
                        </label>
                        <Field
                            id="description"
                            name="description"
                            type="text"
                            as="textarea"
                            placeholder="Category Description..."
                            v-model="selectedCategory.description"
                            :class="{ 'is-invalid': errors.description }"
                            class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border shadow-sm h-36 form-control">
                        </Field>
                        <div class="invalid-feedback ">
                            {{ errors.description }}
                        </div>
                    </div>
                    <div
                        class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end space-x-4 p-4 border-t border-gray-200 rounded-b-md">
                        <button type="button" @click="$emit('close')"
                                class="px-6 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out">
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
    name: "EditCategory.vue",
    emits: ["close", "updateEditCategory"],
    components: {
        Form,
        Field,
    },
    props: [
        'selectedCategory',
        'changesCategory'
    ],
    data() {
        return {
            category: {
                'name': '',
                'description': ''
            }
        }
    },

    computed: {
        schema() {
            return yup.object().shape({
                name: yup.string()
                    .required("Тhe name is required. Please fill in.")
                    .min(3, "The name must be at least 3 characters.")
                    .max(200, "The name must be no more than 200 characters."),
                description: yup.string()
                    .required("Тhe description is required. Please fill in.")
                    .min(3, "The description must be at least 3 characters.")
                    .max(700, "The description must be no more than 700 characters.")
            });
        }
    },

    methods: {
        updateCategory() {
            axios.post('dashboard/category/edit', this.selectedCategory)
                .then(response => {
                    if (response.data.category) {
                        this.$emit('updateEditCategory', response.data.category)
                    }
                })
                .catch(error => console.log(error))
                .finally(() => this.loading = false)
        }
    }
}
</script>
