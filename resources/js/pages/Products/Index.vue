<script setup lang="ts">
import { computed, ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import type { Category, Product } from '@/types/models'
import AppLayout from '@/layouts/AppLayout.vue'

const props = defineProps<{
    products: Product[]
    categories: Category[]
}>()

const selectedCategory = ref<number | null>(null)

const filteredProducts = computed(() => {
    if (!selectedCategory.value) {
        return props.products
    }
    return props.products.filter(p => p.category_id === selectedCategory.value)
})

const featuredProducts = computed(() => {
    return props.products.filter(p => p.is_featured)
})
</script>

<template>
    <AppLayout title="Products">
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Fresh Farm Products
                    </h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Browse our selection of fresh, organic produce
                    </p>
                </div>

                <!-- Category Filter -->
                <div class="mb-8 flex flex-wrap gap-2">
                    <button
                        @click="selectedCategory = null"
                        :class="[
                            'rounded-full px-4 py-2 text-sm font-medium transition',
                            !selectedCategory
                                ? 'bg-green-600 text-white'
                                : 'bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300',
                        ]"
                    >
                        All Products
                    </button>
                    <button
                        v-for="category in categories"
                        :key="category.id"
                        @click="selectedCategory = category.id"
                        :class="[
                            'rounded-full px-4 py-2 text-sm font-medium transition',
                            selectedCategory === category.id
                                ? 'bg-green-600 text-white'
                                : 'bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300',
                        ]"
                    >
                        {{ category.name }}
                    </button>
                </div>

                <!-- Featured Products -->
                <div v-if="!selectedCategory && featuredProducts.length > 0" class="mb-12">
                    <h2 class="mb-4 text-2xl font-bold text-gray-900 dark:text-white">
                        Featured Products
                    </h2>
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        <Link
                            v-for="product in featuredProducts"
                            :key="product.id"
                            :href="`/products/${product.id}`"
                            class="group overflow-hidden rounded-lg bg-white shadow-md transition hover:shadow-xl dark:bg-gray-800"
                        >
                            <div class="aspect-square bg-gray-200 dark:bg-gray-700 overflow-hidden">
                                <img
                                    v-if="product.image"
                                    :src="`/storage/${product.image}`"
                                    :alt="product.name"
                                    class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                                <div
                                    v-else
                                    class="flex h-full items-center justify-center text-gray-400"
                                >
                                    <svg
                                        class="h-20 w-20"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                </div>
                            </div>
                            <div class="p-4">
                                <span
                                    class="mb-2 inline-block rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800 dark:bg-green-900 dark:text-green-200"
                                >
                                    Featured
                                </span>
                                <h3
                                    class="text-lg font-semibold text-gray-900 group-hover:text-green-600 dark:text-white"
                                >
                                    {{ product.name }}
                                </h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ product.category?.name }}
                                </p>
                                <div class="mt-3 flex items-center justify-between">
                                    <span class="text-xl font-bold text-green-600">
                                        ${{ Number(product.price).toFixed(2) }}
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        per {{ product.unit }}
                                    </span>
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>

                <!-- All Products -->
                <div>
                    <h2 class="mb-4 text-2xl font-bold text-gray-900 dark:text-white">
                        {{ selectedCategory ? 'Filtered Products' : 'All Products' }}
                    </h2>
                    <div
                        v-if="filteredProducts.length > 0"
                        class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4"
                    >
                        <Link
                            v-for="product in filteredProducts"
                            :key="product.id"
                            :href="`/products/${product.id}`"
                            class="group overflow-hidden rounded-lg bg-white shadow-md transition hover:shadow-xl dark:bg-gray-800"
                        >
                            <div class="aspect-square bg-gray-200 dark:bg-gray-700 overflow-hidden">
                                <img
                                    v-if="product.image"
                                    :src="`/storage/${product.image}`"
                                    :alt="product.name"
                                    class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                                <div
                                    v-else
                                    class="flex h-full items-center justify-center text-gray-400"
                                >
                                    <svg
                                        class="h-20 w-20"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3
                                    class="text-lg font-semibold text-gray-900 group-hover:text-green-600 dark:text-white"
                                >
                                    {{ product.name }}
                                </h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ product.category?.name }}
                                </p>
                                <div class="mt-3 flex items-center justify-between">
                                    <span class="text-xl font-bold text-green-600">
                                        ${{ Number(product.price).toFixed(2) }}
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        per {{ product.unit }}
                                    </span>
                                </div>
                                <div class="mt-2">
                                    <span
                                        v-if="product.stock_quantity > 0"
                                        class="text-xs text-green-600"
                                    >
                                        In Stock ({{ product.stock_quantity }})
                                    </span>
                                    <span v-else class="text-xs text-red-600">
                                        Out of Stock
                                    </span>
                                </div>
                            </div>
                        </Link>
                    </div>
                    <div
                        v-else
                        class="rounded-lg bg-gray-100 p-8 text-center dark:bg-gray-800"
                    >
                        <p class="text-gray-600 dark:text-gray-400">
                            No products found in this category.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
