<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import type { Booking } from '@/types/models'
import AppLayout from '@/layouts/AppLayout.vue'

defineProps<{
    bookings: Booking[]
}>()

const getStatusColor = (status: string) => {
    const colors = {
        pending: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
        confirmed: 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
        cancelled: 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
        completed: 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
    }
    return colors[status as keyof typeof colors] || colors.pending
}

const getTypeLabel = (type: string) => {
    const labels = {
        tour: 'Farm Tour',
        event: 'Special Event',
        workshop: 'Workshop',
        private: 'Private Visit',
    }
    return labels[type as keyof typeof labels] || type
}

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    })
}

const formatTime = (time: string) => {
    return new Date(`2000-01-01T${time}`).toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
    })
}
</script>

<template>
    <AppLayout title="My Bookings">
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-8 flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                            My Bookings
                        </h1>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                            Manage your farm visit bookings
                        </p>
                    </div>
                    <Link
                        href="/bookings/create"
                        class="rounded-lg bg-green-600 px-6 py-3 font-semibold text-white transition hover:bg-green-700"
                    >
                        New Booking
                    </Link>
                </div>

                <!-- Bookings List -->
                <div v-if="bookings.length > 0" class="space-y-4">
                    <div
                        v-for="booking in bookings"
                        :key="booking.id"
                        class="overflow-hidden rounded-lg bg-white shadow-md dark:bg-gray-800"
                    >
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ getTypeLabel(booking.type) }}
                                        </h3>
                                        <span
                                            :class="[
                                                'rounded-full px-3 py-1 text-xs font-semibold',
                                                getStatusColor(booking.status),
                                            ]"
                                        >
                                            {{ booking.status.charAt(0).toUpperCase() + booking.status.slice(1) }}
                                        </span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        Booking #{{ booking.booking_number }}
                                    </p>
                                    <div class="mt-3 space-y-2">
                                        <div class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                                            <svg
                                                class="mr-2 h-5 w-5 text-gray-400"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                />
                                            </svg>
                                            {{ formatDate(booking.booking_date) }} at {{ formatTime(booking.booking_time) }}
                                        </div>
                                        <div class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                                            <svg
                                                class="mr-2 h-5 w-5 text-gray-400"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                                />
                                            </svg>
                                            {{ booking.number_of_people }} {{ booking.number_of_people === 1 ? 'person' : 'people' }}
                                        </div>
                                    </div>
                                    <div v-if="booking.special_requests" class="mt-3 rounded-lg bg-gray-50 p-3 dark:bg-gray-700">
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Special Requests:
                                        </p>
                                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                            {{ booking.special_requests }}
                                        </p>
                                    </div>
                                </div>
                                <div class="ml-6 text-right">
                                    <div class="text-2xl font-bold text-green-600">
                                        ${{ Number(booking.total_price).toFixed(2) }}
                                    </div>
                                    <div class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        Total
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                        />
                    </svg>
                    <h3 class="mt-4 text-xl font-semibold text-gray-900 dark:text-white">
                        No bookings yet
                    </h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Book a farm visit to experience our farm firsthand!
                    </p>
                    <Link
                        href="/bookings/create"
                        class="mt-6 inline-block rounded-lg bg-green-600 px-6 py-3 font-semibold text-white transition hover:bg-green-700"
                    >
                        Book a Visit
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
