<template>
    <div class="overflow-hidden shadow-sm sm:rounded-lg">
        <!--        Category Table-->
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex items-center justify-between mb-6">
                            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                                Categories
                            </h1>
                            <button type="button"
                                    class="px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
                                    @click="openAddCategoryModal = !openAddCategoryModal">
                                Add Category
                            </button>
                        </div>
                        <div v-if="Object.values(categories).length">
                            <table class="table-fixed w-full">
                                <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2">Name</th>
                                    <th class="px-4 py-2 w-25 ">Description</th>
                                    <th class="px-4 py-2 w-15">Status</th>
                                    <th class="px-4 py-2 w-15">Created Date</th>
                                    <th class="px-4 py-2 w-25">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="category in categories.data">
                                    <td class="border px-4 py-2">{{ category.name }}</td>
                                    <td class="border px-4 py-2">{{ category.description }}</td>
                                    <td class="border px-4 py-2">
                                     <span
                                         :class="category.status === 'processing' ? 'bg-blue-500' : category.status === 'reject' ? 'bg-red-500' : 'bg-green-600'"
                                         class="text-white rounded-full w-[80px] d-block text-center"
                                     >
                             {{ category.status }}
                            </span>
                                    </td>
                                    <td class="border px-4 py-2">{{ category.created_at }}</td>
                                    <td class="px-4 py-2 md:border md:border-grey-500 text-left block md:table-cell">
                                        <button data-bs-target="#editCategory"
                                                class="px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
                                                type="submit" @click=editCategory(category)>
                                            Edit
                                        </button>
                                        <button type="button" class="mx-2 btn btn-danger px-4 py-2"
                                                data-bs-toggle="modalDeleteCategory" data-bs-target="#deleteCategory"
                                                @click="deleteCategoryModal(category.id)">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div v-if="categories.links.length > 3">
<!--                                v-if="categories.links.length > 3 || categories.data.length > 4"-->
                                <div class="mt-10 flex justify-center mt-8">
                                    <template v-for="(link, key) in categories.links" :key="key">
                                        <div
                                            v-if="link.url === null"
                                            class="py-1.5 px-3 border-0 bg-transparent outline-none transition-all duration-300 rounded-full text-gray-500 pointer-events-none focus:shadow-none"
                                            v-html="link.label"
                                        />
                                        <button
                                            v-else
                                            @click="getCategories(link.url)"
                                            class="mr-1 mb-1 px-2 py-1 text-sm leading-4 border rounded hover:bg-white focus:border-primary focus:text-primary"
                                            :class="{ 'bg-blue-700 text-white': link.active }"
                                            v-html="link.label"
                                        ></button>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            Loading...
                        </div>
                        <AddCategory
                            v-if="openAddCategoryModal"
                            @addCategory="addCategory"
                            @close="openAddCategoryModal = false">
                        </AddCategory>
                        <EditCategory
                            v-if="openEditCategoryModal"
                            @close="openEditCategoryModal = false"
                            @updateEditCategory="updateEditCategory"
                            :selectedCategory="selectedCategory"
                            :changesCategory="changesCategory">
                        </EditCategory>
                        <DeleteCategory
                            v-if="openDeleteCategoryModal"
                            :id="selectedCategoryId"
                            :current_page="categories.current_page"
                            @close="openDeleteCategoryModal = false"
                            @deleteCategory="deleteCategory">
                        </DeleteCategory>
                    </div>
                </div>
            </div>
        </div>
        <!--        Product Table-->
        <div class="py-12">
            <div class="max-w-[85%] mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex items-center justify-between mb-6">
                            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                                Products
                            </h1>
                            <button type="button"
                                    class="px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
                                    @click="openAddProductModal = !openAddProductModal">
                                Add Product
                            </button>
                        </div>
                        <div v-if="Object.values(products).length">
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
                                <tr v-for="product in products.data">
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
                                    <td class="px-4 py-2 md:border md:border-grey-500 text-left block md:table-cell">
                                        <button data-bs-target="#editProduct"
                                                class="px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
                                                type="submit" @click=editProduct(product)>
                                            Edit
                                        </button>
                                        <button type="button" class="mx-2 btn btn-danger px-4 py-2"
                                                data-bs-toggle="modalDeleteProduct" data-bs-target="#deleteProduct"
                                                @click="deleteProductModal(product.id)">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div v-if="products.links.length > 3">
                                <div class="mt-10 flex justify-center mt-8">
                                    <template v-for="(link, key) in products.links" :key="key">
                                        <div
                                            v-if="link.url === null"
                                            class="py-1.5 px-3 border-0 bg-transparent outline-none transition-all duration-300 rounded-full text-gray-500 pointer-events-none focus:shadow-none"
                                            v-html="link.label"
                                        />
                                        <button
                                            v-else
                                            @click="getProducts(link.url)"
                                            class="mr-1 mb-1 px-2 py-1 text-sm leading-4 border rounded hover:bg-white focus:border-primary focus:text-primary"
                                            :class="{ 'bg-blue-700 text-white': link.active }"
                                            v-html="link.label"
                                        ></button>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            Loading...
                        </div>
                        <AddProduct
                            v-if="openAddProductModal"
                            :categories="categoryList"
                            @close="openAddProductModal = false"
                            @addProduct="addProduct">
                        </AddProduct>
                        <EditProduct
                            v-if="openEditProductModal"
                            :categories="categoryList"
                            :selectedProduct="selectedProduct"
                            :changesProduct="changesProduct"
                            @close="openEditProductModal = false"
                            @updateEditProduct="updateEditProduct">
                        </EditProduct>
                        <DeleteProduct
                            v-if="openDeleteProductModal"
                            :id="selectedProductId"
                            :current_page="products.current_page"
                            @close="openDeleteProductModal = false"
                            @deleteProduct="deleteProduct">
                        </DeleteProduct>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import AddCategory from './AddCategory.vue';
import AddProduct from './AddProduct.vue';
import EditCategory from './EditCategory.vue';
import EditProduct from './EditProduct.vue';
import DeleteCategory from './DeleteCategory.vue';
import DeleteProduct from './DeleteProduct.vue';

export default {
    name: "UserDashboard.vue",

    components: {
        AddCategory,
        AddProduct,
        EditCategory,
        EditProduct,
        DeleteCategory,
        DeleteProduct
    },

    data() {
        return {
            categoryId: null,
            productId: null,
            openAddCategoryModal: false,
            openAddProductModal: false,
            openEditCategoryModal: false,
            openEditProductModal: false,
            openDeleteProductModal: false,
            openDeleteCategoryModal: false,
            selectedCategoryId: null,
            selectedProductId: null,
            selectedCategory: {},
            selectedProduct: {},
            changesCategory: {},
            changesProduct: {},
            categories: {},
            products: {},
            categoryList: []
        }
    },

    methods: {
        /**
         * Add Category and Product
         *
         * @param item
         */
        addCategory(item) {
            if (this.categories.current_page === 1) {
                this.categories.data.unshift(item);
            }
            if (this.categories.data.length > 5) {
                this.categories.data.pop();
            }
            this.categories.total++;
            const perPage = Math.ceil(this.categories.total / 5);
            if (perPage > (this.categories.links.length - 2)) {
                const categoriesLink = {
                    url: window.location.origin + '/get-categories?page=' + perPage,
                    label: perPage,
                    active: false
                };
                this.categories.links.splice(this.categories.links.length - 1, 0, categoriesLink);
            }
            this.openAddCategoryModal = false;
            this.getCategoryList();
        },

        addProduct(item) {
            if (this.products.current_page === 1) {
                this.products.data.unshift(item);
            }
            if (this.products.data.length > 5) {
                this.products.data.pop();
            }
            this.products.total++;
            const perPage = Math.ceil(this.products.total / 5);
            if (perPage > (this.products.links.length - 2)) {
                const productsLink = {
                    url: window.location.origin + '/get-products?page=' + perPage,
                    label: perPage,
                    active: false
                };
                this.products.links.splice(this.products.links.length - 1, 0, productsLink);
            }
            this.openAddProductModal = false;
        },

        /**
         * Edit Category and Product
         *
         * @param category
         */
        editCategory(category) {
            this.openEditCategoryModal = !this.openEditCategoryModal;
            this.selectedCategory.id = category.id;
            this.selectedCategory.name = category.name;
            this.selectedCategory.description = category.description;
            this.changesCategory = category;
        },

        updateEditCategory(item) {
            this.selectedCategoryId = item;
            this.openEditCategoryModal = false;
        },

        editProduct(product) {
            this.openEditProductModal = !this.openEditProductModal;
            this.selectedProduct.id = product.id;
            this.selectedProduct.name = product.name;
            this.selectedProduct.category_id = product.category_id;
            this.selectedProduct.price = product.price;
            this.changesProduct = product;
        },

        updateEditProduct(product) {
            this.changesProduct.name = product.name;
            this.changesProduct.category = product.category;
            this.changesProduct.price = product.price;
            this.openEditProductModal = false;
        },

        /**
         * Delete Category and Product
         */
        deleteCategory(category) {
            this.categories.data.forEach((item, index) => {
                if (item.id === this.selectedCategoryId) {
                    this.categories.data.splice(index, 1);
                }
            });
            if (this.categories.data.length === 4) {
                if (category)
                this.categories.data.push(category);
            }
            this.categories.total--;
            const perPage = Math.ceil(this.categories.total / 5);
            if (perPage < (this.categories.links.length - 2)) {
                this.categories.links.splice(this.categories.links.length - 2, 1);
            }
            if (this.categories.current_page) {
                if (this.categories.data.length === 0){
                    const pages = this.categories.current_page - 1;
                    this.getCategories('/get-categories?page=' + pages);
                }
            }
            this.openDeleteCategoryModal = false;
        },

        deleteCategoryModal(id) {
            this.openDeleteCategoryModal = true;
            this.selectedCategoryId = id;
        },

        deleteProduct(product) {
            this.products.data.forEach((item, index) => {
                if (item.id === this.selectedProductId) {
                    this.products.data.splice(index, 1);
                }
            });
            if (this.products.data.length === 4) {
                if (product)
                    this.products.data.push(product);
            }
            this.products.total--;
            const perPage = Math.ceil(this.products.total / 5);
            if (perPage < (this.products.links.length - 2)) {
                this.products.links.splice(this.products.links.length - 2, 1);
            }
            if (this.products.current_page) {
                if (this.products.data.length === 0){
                    const pages = this.products.current_page - 1;
                    this.getProducts('/get-products?page=' + pages);
                }
            }
            this.openDeleteProductModal = false;
        },

        deleteProductModal(id) {
            this.openDeleteProductModal = true;
            this.selectedProductId = id;
        },

        /**
         * Pagination for Categories and Products tables
         *
         * @param link
         */

        getCategories(link = null) {
            axios.get(link ?? '/get-categories').then(res => {
                this.categories = res.data.categories;
            });
        },

        getProducts(link = null) {
            axios.get(link ?? '/get-products').then(res => {
                this.products = res.data.products;
            });
        },

        getCategoryList() {
            axios.get('/get-category-list').then(res => {
                this.categoryList = res.data.category_list;
            });
        }
    },

    created() {
        this.getCategories();
        this.getProducts();
        this.getCategoryList();
    }
}
</script>

<style scoped>

</style>
