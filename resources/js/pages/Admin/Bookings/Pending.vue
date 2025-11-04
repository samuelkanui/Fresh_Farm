<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent } from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import { Calendar, Users, DollarSign, CheckCircle, MapPin, Clock } from 'lucide-vue-next'

type User = { id: number; name: string; email: string; phone: string }
type Booking = {
    id: number
    booking_number: string
    user: User
    booking_date: string
    booking_time: string
    number_of_people: number
    total_amount: string
    special_requests: string | null
    status: string
}

const props = defineProps<{ bookings: Booking[] }>()

const confirmBooking = (bookingId: number) => router.post(`/admin/bookings/${bookingId}/confirm`)

const formatCurrency = (amount: string | number) => {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(Number(amount))
}

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' })
}

const totalVisitors = props.bookings.reduce((sum, b) => sum + b.number_of_people, 0)
const potentialRevenue = props.bookings.reduce((sum, b) => sum + Number(b.total_amount), 0)
</script>

<template>
    <AppLayout title="Pending Bookings">
        <div class="min-h-screen bg-gradient-to-br from-slate-50 via-indigo-50 to-purple-50 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 p-6">
            <div class="mb-8">
                <h1 class="text-4xl font-black bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">
                    Pending Bookings
                </h1>
                <p class="text-slate-600 dark:text-slate-400">Review and confirm farm visit reservations</p>
            </div>

            <div class="grid gap-4 md:grid-cols-3 mb-6">
                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 p-4 shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/40 transition-all duration-300 hover:scale-105">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <Calendar class="h-5 w-5 text-white/80 mb-2" />
                        <p class="text-white/80 text-xs font-semibold uppercase mb-1">Pending Bookings</p>
                        <p class="text-3xl font-black text-white">{{ bookings.length }}</p>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-blue-500 to-cyan-600 p-4 shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 transition-all duration-300 hover:scale-105">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <Users class="h-5 w-5 text-white/80 mb-2" />
                        <p class="text-white/80 text-xs font-semibold uppercase mb-1">Total Visitors</p>
                        <p class="text-3xl font-black text-white">{{ totalVisitors }}</p>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 p-4 shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/40 transition-all duration-300 hover:scale-105">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <DollarSign class="h-5 w-5 text-white/80 mb-2" />
                        <p class="text-white/80 text-xs font-semibold uppercase mb-1">Potential Revenue</p>
                        <p class="text-2xl font-black text-white">{{ formatCurrency(potentialRevenue) }}</p>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <Card v-for="booking in bookings" :key="booking.id" 
                    class="backdrop-blur-xl bg-white/80 dark:bg-slate-900/80 border-white/20 shadow-lg hover:shadow-2xl transition-all duration-300 group relative overflow-hidden rounded-xl">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-indigo-500 to-purple-500"></div>
                    
                    <CardContent class="p-5">
                        <div class="flex flex-col lg:flex-row gap-5">
                            <div class="flex-1 space-y-4">
                                <div class="flex items-center gap-3">
                                    <h3 class="text-lg font-bold">{{ booking.booking_number }}</h3>
                                    <Badge class="bg-indigo-500/10 text-indigo-600 border-indigo-500/20 border">
                                        <Calendar class="h-3 w-3 mr-1" />Pending
                                    </Badge>
                                </div>

                                <div class="grid md:grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <div class="flex items-start gap-2">
                                            <Users class="h-4 w-4 text-indigo-600 mt-0.5" />
                                            <div>
                                                <p class="text-xs text-slate-500">Guest Information</p>
                                                <p class="font-semibold">{{ booking.user.name }}</p>
                                                <p class="text-sm text-slate-600">{{ booking.user.email }}</p>
                                                <p class="text-sm text-slate-600">{{ booking.user.phone }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <div class="flex items-start gap-2">
                                            <Calendar class="h-4 w-4 text-indigo-600 mt-0.5" />
                                            <div>
                                                <p class="text-xs text-slate-500">Visit Details</p>
                                                <p class="font-semibold">{{ formatDate(booking.booking_date) }}</p>
                                                <p class="text-sm text-slate-600">{{ booking.booking_time }}</p>
                                                <p class="text-sm font-semibold text-indigo-600">{{ booking.number_of_people }} {{ booking.number_of_people === 1 ? 'guest' : 'guests' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div v-if="booking.special_requests" class="p-3 rounded-lg bg-indigo-50 dark:bg-indigo-950/20 border border-indigo-500/20">
                                    <p class="text-xs font-semibold text-indigo-600 mb-1">Special Requests:</p>
                                    <p class="text-sm text-slate-700 dark:text-slate-300">{{ booking.special_requests }}</p>
                                </div>
                            </div>

                            <div class="flex flex-col items-end gap-3 min-w-[200px]">
                                <div class="text-right">
                                    <p class="text-xs text-slate-500">Total Amount</p>
                                    <p class="text-3xl font-black bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                        {{ formatCurrency(booking.total_amount) }}
                                    </p>
                                    <p class="text-xs text-slate-500 mt-1">{{ formatCurrency(Number(booking.total_amount) / booking.number_of_people) }} per person</p>
                                </div>
                                
                                <Button @click="confirmBooking(booking.id)" 
                                    class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 shadow-lg shadow-indigo-500/30 group-hover:scale-105 transition-transform">
                                    <CheckCircle class="h-4 w-4 mr-2" />Confirm Booking
                                </Button>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <Card v-if="!bookings.length" class="backdrop-blur-xl bg-white/80 dark:bg-slate-900/80 border-white/20 border-dashed border-2 rounded-xl">
                    <CardContent class="flex flex-col items-center justify-center py-12">
                        <div class="p-4 rounded-full bg-emerald-100 dark:bg-emerald-950 mb-4">
                            <CheckCircle class="h-10 w-10 text-emerald-600" />
                        </div>
                        <h3 class="text-lg font-semibold mb-2">All caught up! 🎉</h3>
                        <p class="text-slate-500 text-center">No pending bookings at the moment. Great job!</p>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
