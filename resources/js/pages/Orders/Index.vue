<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import type { Order } from '@/types/models'
import AppLayout from '@/layouts/AppLayout.vue'

defineProps<{
    orders: Order[]
}>()

const getStatusColor = (status: string) => {
    const colors = {
        pending: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
        approved: 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
        processing: 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
        completed: 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
        cancelled: 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
    }
    return colors[status as keyof typeof colors] || colors.pending
}

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    })
}
</script>

<template>
    <AppLayout title="My Orders">
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-8 flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                            My Orders
                        </h1>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                            Track and manage your orders
                        </p>
                    </div>
                    <Link
                        href="/products"
                        class="rounded-lg bg-green-600 px-6 py-3 font-semibold text-white transition hover:bg-green-700"
                    >
                        Browse Products
                    </Link>
                </div>

                <!-- Orders List -->
                <div v-if="orders.length > 0" class="space-y-4">
                    <Link
                        v-for="order in orders"
                        :key="order.id"
                        :href="`/orders/${order.id}`"
                        class="block overflow-hidden rounded-lg bg-white shadow-md transition hover:shadow-xl dark:bg-gray-800"
                    >
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ order.order_number }}
                                        </h3>
                                        <span
                                            :class="[
                                                'rounded-full px-3 py-1 text-xs font-semibold',
                                                getStatusColor(order.status),
                                            ]"
                                        >
                                            {{ order.status.charAt(0).toUpperCase() + order.status.slice(1) }}
                                        </span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        Placed on {{ formatDate(order.created_at) }}
                                    </p>
                                    <div v-if="order.delivery_date" class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                        <span class="font-medium">Delivery Date:</span>
                                        {{ formatDate(order.delivery_date) }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-green-600">
                                        ${{ Number(order.total).toFixed(2) }}
                                    </div>
                                    <div class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        {{ order.items?.length || 0 }} item(s)
                                    </div>
                                </div>
                            </div>

                            <!-- Order Items Preview -->
                            <div v-if="order.items && order.items.length > 0" class="mt-4 border-t pt-4 dark:border-gray-700">
                                <div class="space-y-2">
                                    <div
                                        v-for="item in order.items.slice(0, 3)"
                                        :key="item.id"
                                        class="flex items-center justify-between text-sm"
                                    >
                                        <span class="text-gray-700 dark:text-gray-300">
                                            {{ item.product?.name }} × {{ item.quantity }}
                                        </span>
                                        <span class="font-medium text-gray-900 dark:text-white">
                                            ${{ Number(item.subtotal).toFixed(2) }}
                                        </span>
                                    </div>
                                    <div v-if="order.items.length > 3" class="text-sm text-gray-500">
                                        + {{ order.items.length - 3 }} more item(s)
                                    </div>
                                </div>
                            </div>

                            <!-- Delivery Address -->
                            <div v-if="order.delivery_address" class="mt-4 border-t pt-4 dark:border-gray-700">
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-medium">Delivery to:</span>
                                    {{ order.delivery_address }}
                                </p>
                            </div>
                        </div>
                    </Link>
                </div>

                <!-- Empty State -->
                <div
                    v-else
                    class="rounded-lg bg-white p-12 text-center shadow-md dark:bg-gray-800"
                >
                    <svg
                        class="mx-auto h-24 w-24 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                        />
                    </svg>
                    <h3 class="mt-4 text-xl font-semibold text-gray-900 dark:text-white">
                        No orders yet
                    </h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Start shopping to place your first order!
                    </p>
                    <Link
                        href="/products"
                        class="mt-6 inline-block rounded-lg bg-green-600 px-6 py-3 font-semibold text-white transition hover:bg-green-700"
                    >
                        Browse Products
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
