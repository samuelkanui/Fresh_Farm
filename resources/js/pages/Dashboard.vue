<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'

type OrderItem = {
  id: number
  product?: { id: number; name: string }
  quantity: number
  subtotal: number
}

type Order = {
  id: number
  order_number: string
  status: 'pending' | 'approved' | 'processing' | 'completed' | 'cancelled'
  total: number
  created_at: string
  items?: OrderItem[]
}

type Booking = {
  id: number
  booking_number: string
  type: 'tour' | 'event' | 'workshop' | 'private'
  booking_date: string
  booking_time: string
  number_of_people: number
  status: 'pending' | 'confirmed' | 'cancelled' | 'completed'
}

const props = defineProps<{
  recentOrders: Order[]
  upcomingBookings: Booking[]
}>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6">
            <!-- Welcome Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">Dashboard</h1>
                    <p class="text-muted-foreground">Welcome back! Here's your farm activity overview.</p>
                </div>
                <Button as-child>
                    <Link href="/products">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Browse Products
                    </Link>
                </Button>
            </div>

            <!-- Quick Stats -->
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">Total Orders</CardTitle>
                        <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ props.recentOrders?.length || 0 }}</div>
                        <p class="text-xs text-muted-foreground">Recent orders</p>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">Bookings</CardTitle>
                        <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ props.upcomingBookings?.length || 0 }}</div>
                        <p class="text-xs text-muted-foreground">Upcoming visits</p>
                    </CardContent>
                </Card>
                <Card as-child>
                    <Link href="/products" class="cursor-pointer transition-colors hover:bg-accent">
                        <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle class="text-sm font-medium">Browse Products</CardTitle>
                            <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </CardHeader>
                        <CardContent>
                            <div class="text-sm font-medium text-primary">Shop Now</div>
                            <p class="text-xs text-muted-foreground">Fresh farm products</p>
                        </CardContent>
                    </Link>
                </Card>
                <Card as-child>
                    <Link href="/bookings/create" class="cursor-pointer transition-colors hover:bg-accent">
                        <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle class="text-sm font-medium">Book a Visit</CardTitle>
                            <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </CardHeader>
                        <CardContent>
                            <div class="text-sm font-medium text-primary">Schedule Visit</div>
                            <p class="text-xs text-muted-foreground">Tours, events & more</p>
                        </CardContent>
                    </Link>
                </Card>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <!-- Recent Orders -->
                <Card>
                    <CardHeader>
                        <div class="flex items-center justify-between">
                            <div>
                                <CardTitle>Recent Orders</CardTitle>
                                <CardDescription>Your latest order history</CardDescription>
                            </div>
                            <Button variant="ghost" size="sm" as-child>
                                <Link href="/orders">View all</Link>
                            </Button>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <div v-if="props.recentOrders?.length" class="space-y-3">
                            <Link v-for="order in props.recentOrders" :key="order.id" :href="`/orders/${order.id}`" class="flex items-center justify-between rounded-lg border p-4 transition-colors hover:bg-accent">
                                <div class="space-y-1">
                                    <p class="text-sm font-medium leading-none">{{ order.order_number }}</p>
                                    <p class="text-sm text-muted-foreground">{{ order.items?.length || 0 }} item(s)</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <Badge :variant="order.status === 'completed' ? 'default' : order.status === 'pending' ? 'secondary' : 'outline'">{{ order.status }}</Badge>
                                    <span class="text-sm font-semibold">${{ Number(order.total).toFixed(2) }}</span>
                                </div>
                            </Link>
                        </div>
                        <div v-else class="flex flex-col items-center justify-center rounded-lg border border-dashed p-8 text-center">
                            <svg class="mb-4 h-12 w-12 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <p class="text-sm text-muted-foreground">No orders yet. <Link href="/products" class="text-primary hover:underline">Start shopping</Link></p>
                        </div>
                    </CardContent>
                </Card>

                <!-- Upcoming Bookings -->
                <Card>
                    <CardHeader>
                        <div class="flex items-center justify-between">
                            <div>
                                <CardTitle>Upcoming Bookings</CardTitle>
                                <CardDescription>Your scheduled farm visits</CardDescription>
                            </div>
                            <Button variant="ghost" size="sm" as-child>
                                <Link href="/bookings">View all</Link>
                            </Button>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <div v-if="props.upcomingBookings?.length" class="space-y-3">
                            <div v-for="b in props.upcomingBookings" :key="b.id" class="flex items-center justify-between rounded-lg border p-4">
                                <div class="space-y-1">
                                    <p class="text-sm font-medium leading-none capitalize">{{ b.type }} Visit</p>
                                    <p class="text-sm text-muted-foreground">{{ b.number_of_people }} {{ b.number_of_people === 1 ? 'person' : 'people' }} • #{{ b.booking_number }}</p>
                                </div>
                                <div class="text-right">
                                    <Badge :variant="b.status === 'confirmed' ? 'default' : 'secondary'">{{ b.status }}</Badge>
                                    <p class="mt-1 text-xs text-muted-foreground">{{ new Date(b.booking_date).toLocaleDateString() }}</p>
                                </div>
                            </div>
                        </div>
                        <div v-else class="flex flex-col items-center justify-center rounded-lg border border-dashed p-8 text-center">
                            <svg class="mb-4 h-12 w-12 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm text-muted-foreground">No bookings scheduled. <Link href="/bookings/create" class="text-primary hover:underline">Book a visit</Link></p>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
