<template>
    <div id="changeStatus"
         class="overflow-hidden fixed min-w-screen h-screen animated fadeIn faster  fixed  left-0 top-0 flex justify-center items-center inset-0 z-50 outline-none focus:outline-none bg-no-repeat bg-center bg-cover">
        <div class="absolute bg-black opacity-80 inset-0 z-0"/>
        <div class="w-full max-w-lg relative mx-auto my-auto rounded-xl shadow-lg  bg-white">
            <!--content-->
            <div>
                <div
                    class="modal-header flex flex-shrink-0 items-end justify-content-end p-4 border-b border-gray-200 rounded-t-md">
                    <button type="button"
                            class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                            @click="$emit('close')">
                    </button>
                </div>
                <!--body-->
                <div class="text-center p-3 flex-auto justify-center">
                    <svg aria-hidden="true" class="mx-auto mb-4 w-14 h-14 text-gray-400 dark:text-gray-200" fill="none"
                         stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3
                        class="text-xl font-bold text-gray-500 px-4">
                        Are you sure to <u class="uppercase">{{ status }}</u> this product?
                    </h3>
                </div>
                <!--footer-->
                <div class="p-4 mt-2 text-center space-x-4 md:block">
                    <button
                        class="mb-2 md:mb-0 bg-green-500 border border-green-500 px-5 py-2 text-l shadow-l font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-green-600"
                        @click="changeProductStatus"
                    >
                        Yes, I'm sure
                    </button>
                    <button
                        class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100"
                        type="button" @click="$emit('close')">
                        No, cancel
                    </button>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ChangeProductStatus",
    props: [
        'status',
        'changesProductId'
    ],
    data() {
        return {
            allProducts: [],
            product: []
        }
    },

    methods: {
        changeProductStatus(status) {
            axios.post('/dashboard/change-product-status', {id: this.changesProductId, status: this.status})
                .then(response => {
                    this.$emit('changedStatusProduct');
                })
                .catch(error => console.log(error))
                .finally(() => this.loading = false)
        }
    },
}
</script>

<style scoped>

</style>
