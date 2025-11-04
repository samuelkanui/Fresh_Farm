<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

const form = useForm({
    type: 'tour',
    booking_date: '',
    booking_time: '10:00',
    number_of_people: 1,
    special_requests: '',
})

const bookingTypes = [
    { value: 'tour', label: 'Farm Tour', price: 10, description: 'Guided tour of our farm facilities' },
    { value: 'event', label: 'Special Event', price: 25, description: 'Attend special farm events' },
    { value: 'workshop', label: 'Workshop', price: 50, description: 'Learn farming techniques' },
    { value: 'private', label: 'Private Visit', price: 100, description: 'Exclusive private farm experience' },
]

const selectedType = () => bookingTypes.find(t => t.value === form.type)

const calculateTotal = () => {
    const type = selectedType()
    return type ? type.price * form.number_of_people : 0
}

const submit = () => {
    form.post('/bookings')
}

const minDate = new Date()
minDate.setDate(minDate.getDate() + 1)
const minDateString = minDate.toISOString().split('T')[0]
</script>

<template>
    <AppLayout title="Book a Visit">
        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Book a Farm Visit
                    </h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Experience our farm firsthand with a guided tour or workshop
                    </p>
                </div>

                <!-- Booking Form -->
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Visit Type -->
                    <div class="rounded-lg bg-white p-6 shadow-md dark:bg-gray-800">
                        <label class="mb-4 block text-lg font-semibold text-gray-900 dark:text-white">
                            Select Visit Type
                        </label>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <label
                                v-for="type in bookingTypes"
                                :key="type.value"
                                :class="[
                                    'cursor-pointer rounded-lg border-2 p-4 transition',
                                    form.type === type.value
                                        ? 'border-green-600 bg-green-50 dark:bg-green-900/20'
                                        : 'border-gray-300 hover:border-green-400 dark:border-gray-600',
                                ]"
                            >
                                <input
                                    type="radio"
                                    v-model="form.type"
                                    :value="type.value"
                                    class="sr-only"
                                />
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h3 class="font-semibold text-gray-900 dark:text-white">
                                            {{ type.label }}
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                            {{ type.description }}
                                        </p>
                                    </div>
                                    <div class="ml-4 text-right">
                                        <p class="font-bold text-green-600">
                                            ${{ type.price }}
                                        </p>
                                        <p class="text-xs text-gray-500">per person</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <p v-if="form.errors.type" class="mt-2 text-sm text-red-600">
                            {{ form.errors.type }}
                        </p>
                    </div>

                    <!-- Date and Time -->
                    <div class="rounded-lg bg-white p-6 shadow-md dark:bg-gray-800">
                        <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                            Date & Time
                        </h2>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Date
                                </label>
                                <input
                                    type="date"
                                    v-model="form.booking_date"
                                    :min="minDateString"
                                    required
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                />
                                <p v-if="form.errors.booking_date" class="mt-1 text-sm text-red-600">
                                    {{ form.errors.booking_date }}
                                </p>
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Time
                                </label>
                                <select
                                    v-model="form.booking_time"
                                    required
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                >
                                    <option value="09:00">9:00 AM</option>
                                    <option value="10:00">10:00 AM</option>
                                    <option value="11:00">11:00 AM</option>
                                    <option value="13:00">1:00 PM</option>
                                    <option value="14:00">2:00 PM</option>
                                    <option value="15:00">3:00 PM</option>
                                    <option value="16:00">4:00 PM</option>
                                </select>
                                <p v-if="form.errors.booking_time" class="mt-1 text-sm text-red-600">
                                    {{ form.errors.booking_time }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Number of People -->
                    <div class="rounded-lg bg-white p-6 shadow-md dark:bg-gray-800">
                        <label class="mb-2 block text-lg font-semibold text-gray-900 dark:text-white">
                            Number of People
                        </label>
                        <div class="flex items-center space-x-4">
                            <button
                                type="button"
                                @click="form.number_of_people = Math.max(1, form.number_of_people - 1)"
                                class="rounded-lg bg-gray-200 px-4 py-2 font-semibold text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300"
                            >
                                -
                            </button>
                            <span class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ form.number_of_people }}
                            </span>
                            <button
                                type="button"
                                @click="form.number_of_people = Math.min(50, form.number_of_people + 1)"
                                class="rounded-lg bg-gray-200 px-4 py-2 font-semibold text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300"
                            >
                                +
                            </button>
                        </div>
                        <p v-if="form.errors.number_of_people" class="mt-2 text-sm text-red-600">
                            {{ form.errors.number_of_people }}
                        </p>
                    </div>

                    <!-- Special Requests -->
                    <div class="rounded-lg bg-white p-6 shadow-md dark:bg-gray-800">
                        <label class="mb-2 block text-lg font-semibold text-gray-900 dark:text-white">
                            Special Requests (Optional)
                        </label>
                        <textarea
                            v-model="form.special_requests"
                            rows="4"
                            placeholder="Any special requirements or questions?"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        ></textarea>
                        <p v-if="form.errors.special_requests" class="mt-2 text-sm text-red-600">
                            {{ form.errors.special_requests }}
                        </p>
                    </div>

                    <!-- Summary -->
                    <div class="rounded-lg bg-green-50 p-6 dark:bg-green-900/20">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                            Booking Summary
                        </h3>
                        <div class="space-y-2">
                            <div class="flex justify-between text-gray-700 dark:text-gray-300">
                                <span>{{ selectedType()?.label }}</span>
                                <span>${{ selectedType()?.price }} × {{ form.number_of_people }}</span>
                            </div>
                            <div class="flex justify-between border-t pt-2 text-xl font-bold dark:border-gray-600">
                                <span class="text-gray-900 dark:text-white">Total</span>
                                <span class="text-green-600">${{ calculateTotal().toFixed(2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex space-x-4">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="flex-1 rounded-lg bg-green-600 px-8 py-3 font-semibold text-white transition hover:bg-green-700 disabled:opacity-50"
                        >
                            {{ form.processing ? 'Submitting...' : 'Submit Booking Request' }}
                        </button>
                        <a
                            href="/bookings"
                            class="rounded-lg border border-gray-300 px-8 py-3 font-semibold text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-800"
                        >
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
