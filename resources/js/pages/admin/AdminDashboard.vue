<template>
    <div class="py-12">
        <div class="max-w-[85%] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                            Products
                        </h1>
                    </div>
                    <table class="table-fixed w-full">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Category</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Created Date</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="product in allProducts.data">
                            <td class="border px-4 py-2">{{ product.name }}</td>
                            <td class="border px-4 py-2">{{ product.category.name }}</td>
                            <td class="border px-4 py-2">{{ product.price }}</td>
                            <td class="border px-4 py-2">
                            <span
                                :class="product.status === 'processing' ? 'bg-blue-500' : product.status === 'reject' ? 'bg-red-500' : 'bg-green-600'"
                                class="text-white rounded-full w-[80px] d-block text-center"
                            >
                            {{ product.status }}
                            </span>
                            </td>
                            <td class="border px-4 py-2">{{ product.created_at }}</td>
                            <td class="px-2 py-2 space-x-4 md:border md:border-grey-500 text-left block md:table-cell">
                                <button
                                    :disabled="product.status === 'approve'"
                                    :class="product.status === 'approve' ? 'bg-gray-400' : 'bg-green-500 hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-600 active:shadow-lg transition duration-150 ease-in-out'"
                                    class="px-6 py-2.5 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md"
                                    @click="changeProductStatus(product, 'approve')"
                                >
                                    Approve
                                </button>
                                <button
                                    :disabled="product.status === 'reject'"
                                    :class="product.status === 'reject' ? 'bg-gray-400' : 'bg-red-500 hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out'"
                                    class="px-6 py-2.5 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md "
                                    @click="changeProductStatus(product, 'reject')"
                                >
                                    Reject
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div v-if="allProducts.links.length > 3">
                        <div class="mt-10 flex justify-center">
                            <template v-for="(link, key) in allProducts.links" :key="key">
                                <div
                                    v-if="link.url === null"
                                    class="py-1.5 px-3 border-0 bg-transparent outline-none transition-all duration-300 rounded-full text-gray-500 pointer-events-none focus:shadow-none"
                                    v-html="link.label"
                                />
                                <a
                                    v-else
                                    class="mr-1 mb-1 px-2 py-1 text-sm leading-4 border rounded hover:bg-white focus:border-primary focus:text-primary"
                                    :class="{ 'bg-blue-700 text-white': link.active }"
                                    :href="link.url"
                                    v-html="link.label"
                                ></a>
                            </template>
                        </div>
                    </div>
                    <ChangeProductStatus
                        v-if="openStatusProductModal"
                        :changesProductId="changesProduct.id"
                        :status="newStatus"
                        @close="openStatusProductModal = false"
                        @changedStatusProduct="changedStatusProduct">
                    </ChangeProductStatus>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ChangeProductStatus from "./ChangeProductStatus.vue";

export default {
    name: "AdminDashboard.vue",

    components: {
        ChangeProductStatus,
    },

    props: [
        'products',
    ],

    data() {
        return {
            openStatusProductModal: false,
            allProducts: [],
            changesProduct: {},
            newStatus: ''
        }
    },

    methods: {
        changeProductStatus(product, status) {
            this.openStatusProductModal = !this.openStatusProductModal;
            this.changesProduct = product;
            this.newStatus = status;
        },

        changedStatusProduct() {
            this.changesProduct.status = this.newStatus;
            this.openStatusProductModal = false;
        }
    },

    created() {
        this.allProducts = this.products
    }
}
</script>

<style scoped>

</style>







