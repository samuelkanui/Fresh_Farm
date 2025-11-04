<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import type { Order } from '@/types/models'
import AppLayout from '@/layouts/AppLayout.vue'

const props = defineProps<{
    order: Order
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
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    })
}
</script>

<template>
    <AppLayout :title="`Order ${order.order_number}`">
        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <!-- Breadcrumb -->
                <nav class="mb-8 flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li>
                            <Link
                                href="/dashboard"
                                class="text-gray-700 hover:text-green-600 dark:text-gray-400"
                            >
                                Dashboard
                            </Link>
                        </li>
                        <li>
                            <span class="mx-2 text-gray-400">/</span>
                            <Link
                                href="/orders"
                                class="text-gray-700 hover:text-green-600 dark:text-gray-400"
                            >
                                Orders
                            </Link>
                        </li>
                        <li>
                            <span class="mx-2 text-gray-400">/</span>
                            <span class="text-gray-500 dark:text-gray-500">
                                {{ order.order_number }}
                            </span>
                        </li>
                    </ol>
                </nav>

                <!-- Order Header -->
                <div class="mb-8 rounded-lg bg-white p-6 shadow-md dark:bg-gray-800">
                    <div class="flex items-start justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                Order {{ order.order_number }}
                            </h1>
                            <p class="mt-1 text-gray-600 dark:text-gray-400">
                                Placed on {{ formatDate(order.created_at) }}
                            </p>
                        </div>
                        <span
                            :class="[
                                'rounded-full px-4 py-2 text-sm font-semibold',
                                getStatusColor(order.status),
                            ]"
                        >
                            {{ order.status.charAt(0).toUpperCase() + order.status.slice(1) }}
                        </span>
                    </div>

                    <!-- Status Timeline -->
                    <div class="mt-6 border-t pt-6 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div class="flex flex-col items-center">
                                <div
                                    :class="[
                                        'flex h-10 w-10 items-center justify-center rounded-full',
                                        'bg-green-600 text-white',
                                    ]"
                                >
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </div>
                                <span class="mt-2 text-xs text-gray-600 dark:text-gray-400">
                                    Placed
                                </span>
                            </div>

                            <div class="h-0.5 flex-1 bg-gray-300 dark:bg-gray-600"></div>

                            <div class="flex flex-col items-center">
                                <div
                                    :class="[
                                        'flex h-10 w-10 items-center justify-center rounded-full',
                                        ['approved', 'processing', 'completed'].includes(order.status)
                                            ? 'bg-green-600 text-white'
                                            : 'bg-gray-300 text-gray-600 dark:bg-gray-600',
                                    ]"
                                >
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </div>
                                <span class="mt-2 text-xs text-gray-600 dark:text-gray-400">
                                    Approved
                                </span>
                            </div>

                            <div class="h-0.5 flex-1 bg-gray-300 dark:bg-gray-600"></div>

                            <div class="flex flex-col items-center">
                                <div
                                    :class="[
                                        'flex h-10 w-10 items-center justify-center rounded-full',
                                        ['processing', 'completed'].includes(order.status)
                                            ? 'bg-green-600 text-white'
                                            : 'bg-gray-300 text-gray-600 dark:bg-gray-600',
                                    ]"
                                >
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z" />
                                    </svg>
                                </div>
                                <span class="mt-2 text-xs text-gray-600 dark:text-gray-400">
                                    Processing
                                </span>
                            </div>

                            <div class="h-0.5 flex-1 bg-gray-300 dark:bg-gray-600"></div>

                            <div class="flex flex-col items-center">
                                <div
                                    :class="[
                                        'flex h-10 w-10 items-center justify-center rounded-full',
                                        order.status === 'completed'
                                            ? 'bg-green-600 text-white'
                                            : 'bg-gray-300 text-gray-600 dark:bg-gray-600',
                                    ]"
                                >
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 2a5 5 0 00-5 5v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2H7V7a3 3 0 015.905-.75 1 1 0 001.937-.5A5.002 5.002 0 0010 2z" />
                                    </svg>
                                </div>
                                <span class="mt-2 text-xs text-gray-600 dark:text-gray-400">
                                    Delivered
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="mb-8 rounded-lg bg-white p-6 shadow-md dark:bg-gray-800">
                    <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">
                        Order Items
                    </h2>
                    <div class="space-y-4">
                        <div
                            v-for="item in order.items"
                            :key="item.id"
                            class="flex items-center justify-between border-b pb-4 last:border-0 dark:border-gray-700"
                        >
                            <div class="flex items-center space-x-4">
                                <div class="h-16 w-16 rounded-lg bg-gray-200 dark:bg-gray-700"></div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">
                                        {{ item.product?.name }}
                                    </h3>
                                    <span class="text-xl font-bold text-green-600">
                                        ${{ Number(item.unit_price).toFixed(2) }} × {{ item.quantity }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900 dark:text-white">
                                    ${{ Number(item.subtotal).toFixed(2) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="mb-8 rounded-lg bg-white p-6 shadow-md dark:bg-gray-800">
                    <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">
                        Order Summary
                    </h2>
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-700 dark:text-gray-300">
                            <span>Subtotal</span>
                            <span>${{ Number(order.subtotal).toFixed(2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-700 dark:text-gray-300">
                            <span>Tax</span>
                            <span>${{ Number(order.tax).toFixed(2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-700 dark:text-gray-300">
                            <span>Delivery Fee</span>
                            <span>${{ Number(order.delivery_fee).toFixed(2) }}</span>
                        </div>
                        <div
                            class="flex justify-between border-t pt-3 text-xl font-bold dark:border-gray-700"
                        >
                            <span class="text-gray-900 dark:text-white">Total</span>
                            <span class="text-green-600">${{ Number(order.total).toFixed(2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Delivery Information -->
                <div class="rounded-lg bg-white p-6 shadow-md dark:bg-gray-800">
                    <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">
                        Delivery Information
                    </h2>
                    <div class="space-y-3">
                        <div v-if="order.delivery_address">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                Delivery Address
                            </p>
                            <p class="mt-1 text-gray-900 dark:text-white">
                                {{ order.delivery_address }}
                            </p>
                        </div>
                        <div v-if="order.delivery_date">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                Delivery Date
                            </p>
                            <p class="mt-1 text-gray-900 dark:text-white">
                                {{ formatDate(order.delivery_date) }}
                            </p>
                        </div>
                        <div v-if="order.notes">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                Order Notes
                            </p>
                            <p class="mt-1 text-gray-900 dark:text-white">
                                {{ order.notes }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
