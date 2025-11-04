<script setup lang="ts">
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import type { Product } from '@/types/models'
import AppLayout from '@/layouts/AppLayout.vue'
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog'
import { Button } from '@/components/ui/button'

const props = defineProps<{
    product: Product
    relatedProducts: Product[]
}>()

const quantity = ref(1)
const addingToCart = ref(false)
const cartDialog = ref(false)

const addToCart = () => {
    addingToCart.value = true
    // This would typically add to a cart state/store
    // For now, we'll just show confirmation
    setTimeout(() => {
        addingToCart.value = false
        cartDialog.value = true
    }, 500)
}

const incrementQuantity = () => {
    if (quantity.value < props.product.stock_quantity) {
        quantity.value++
    }
}

const decrementQuantity = () => {
    if (quantity.value > 1) {
        quantity.value--
    }
}
</script>

<template>
    <AppLayout :title="product.name">
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Breadcrumb -->
                <nav class="mb-8 flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li>
                            <Link
                                href="/"
                                class="text-gray-700 hover:text-green-600 dark:text-gray-400"
                            >
                                Home
                            </Link>
                        </li>
                        <li>
                            <span class="mx-2 text-gray-400">/</span>
                            <Link
                                href="/products"
                                class="text-gray-700 hover:text-green-600 dark:text-gray-400"
                            >
                                Products
                            </Link>
                        </li>
                        <li>
                            <span class="mx-2 text-gray-400">/</span>
                            <span class="text-gray-500 dark:text-gray-500">
                                {{ product.name }}
                            </span>
                        </li>
                    </ol>
                </nav>

                <!-- Product Details -->
                <div class="grid gap-8 lg:grid-cols-2">
                    <!-- Product Image -->
                    <div class="overflow-hidden rounded-lg bg-gray-200 dark:bg-gray-700">
                        <img
                            v-if="product.image"
                            :src="`/storage/${product.image}`"
                            :alt="product.name"
                            class="aspect-square h-full w-full object-cover"
                        />
                        <div v-else class="flex aspect-square items-center justify-center text-gray-400">
                            <svg
                                class="h-32 w-32"
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

                    <!-- Product Info -->
                    <div>
                        <div class="mb-4">
                            <Link
                                :href="`/products?category=${product.category_id}`"
                                class="text-sm text-green-600 hover:text-green-700"
                            >
                                {{ product.category?.name }}
                            </Link>
                        </div>

                        <h1 class="mb-4 text-3xl font-bold text-gray-900 dark:text-white">
                            {{ product.name }}
                        </h1>

                        <div class="mb-6">
                            <span class="text-4xl font-bold text-green-600">
                                ${{ Number(product.price).toFixed(2) }}
                            </span>
                            <span class="ml-2 text-gray-600 dark:text-gray-400">
                                per {{ product.unit }}
                            </span>
                        </div>

                        <div class="mb-6">
                            <p class="text-gray-700 dark:text-gray-300">
                                {{ product.description || 'Fresh from our farm to your table.' }}
                            </p>
                        </div>

                        <!-- Stock Status -->
                        <div class="mb-6">
                            <div
                                v-if="product.stock_quantity > 0"
                                class="flex items-center text-green-600"
                            >
                                <svg
                                    class="mr-2 h-5 w-5"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                <span class="font-medium">
                                    In Stock ({{ product.stock_quantity }} available)
                                </span>
                            </div>
                            <div v-else class="flex items-center text-red-600">
                                <svg
                                    class="mr-2 h-5 w-5"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                <span class="font-medium">Out of Stock</span>
                            </div>
                        </div>

                        <!-- Quantity Selector -->
                        <div v-if="product.stock_quantity > 0" class="mb-6">
                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Quantity
                            </label>
                            <div class="flex items-center space-x-3">
                                <button
                                    @click="decrementQuantity"
                                    :disabled="quantity <= 1"
                                    class="rounded-md bg-gray-200 px-4 py-2 font-semibold text-gray-700 hover:bg-gray-300 disabled:opacity-50 dark:bg-gray-700 dark:text-gray-300"
                                >
                                    -
                                </button>
                                <span class="text-xl font-semibold">{{ quantity }}</span>
                                <button
                                    @click="incrementQuantity"
                                    :disabled="quantity >= product.stock_quantity"
                                    class="rounded-md bg-gray-200 px-4 py-2 font-semibold text-gray-700 hover:bg-gray-300 disabled:opacity-50 dark:bg-gray-700 dark:text-gray-300"
                                >
                                    +
                                </button>
                            </div>
                        </div>

                        <!-- Add to Cart Button -->
                        <div class="flex space-x-4">
                            <button
                                v-if="product.stock_quantity > 0"
                                @click="addToCart"
                                :disabled="addingToCart"
                                class="flex-1 rounded-lg bg-green-600 px-8 py-3 font-semibold text-white transition hover:bg-green-700 disabled:opacity-50"
                            >
                                {{ addingToCart ? 'Adding...' : 'Add to Cart' }}
                            </button>
                            <button
                                v-else
                                disabled
                                class="flex-1 rounded-lg bg-gray-400 px-8 py-3 font-semibold text-white"
                            >
                                Out of Stock
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Related Products -->
                <div v-if="relatedProducts.length > 0" class="mt-16">
                    <h2 class="mb-6 text-2xl font-bold text-gray-900 dark:text-white">
                        Related Products
                    </h2>
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        <Link
                            v-for="relatedProduct in relatedProducts"
                            :key="relatedProduct.id"
                            :href="`/products/${relatedProduct.id}`"
                            class="group overflow-hidden rounded-lg bg-white shadow-md transition hover:shadow-xl dark:bg-gray-800"
                        >
                            <div class="aspect-square bg-gray-200 dark:bg-gray-700 overflow-hidden">
                                <img
                                    v-if="relatedProduct.image"
                                    :src="`/storage/${relatedProduct.image}`"
                                    :alt="relatedProduct.name"
                                    class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                                <div
                                    v-else
                                    class="flex h-full items-center justify-center text-gray-400"
                                >
                                    <svg
                                        class="h-16 w-16"
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
                                    {{ relatedProduct.name }}
                                </h3>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-xl font-bold text-green-600">
                                        ${{ Number(relatedProduct.price).toFixed(2) }}
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        per {{ relatedProduct.unit }}
                                    </span>
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cart Success Dialog -->
        <Dialog v-model:open="cartDialog">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Added to Cart</DialogTitle>
                    <DialogDescription>
                        Added {{ quantity }} {{ product.unit }}(s) of {{ product.name }} to your cart!
                    </DialogDescription>
                </DialogHeader>
                <DialogFooter>
                    <Button variant="outline" @click="cartDialog = false">
                        Continue Shopping
                    </Button>
                    <Button as-child>
                        <Link href="/orders">View Cart</Link>
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </AppLayout>
</template>
