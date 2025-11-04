<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent } from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import { Clock, CheckCircle, XCircle, AlertCircle, DollarSign, Users } from 'lucide-vue-next'

type User = { id: number; name: string; email: string }
type Product = { id: number; name: string }
type OrderItem = { id: number; product: Product; quantity: number; price: string; subtotal: string }
type Order = { id: number; order_number: string; user: User; status: string; total: string; items: OrderItem[]; created_at: string }

const props = defineProps<{ orders: Order[] }>()

const approveOrder = (orderId: number) => router.post(`/admin/orders/${orderId}/approve`)
const rejectOrder = (orderId: number) => router.post(`/admin/orders/${orderId}/reject`)

const formatCurrency = (amount: string | number) => {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(Number(amount))
}

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
}

const totalValue = props.orders.reduce((sum, o) => sum + Number(o.total), 0)
const totalItems = props.orders.reduce((sum, o) => sum + o.items.length, 0)
</script>

<template>
    <AppLayout title="Pending Orders">
        <div class="min-h-screen bg-gradient-to-br from-slate-50 via-orange-50 to-amber-50 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 p-6">
            <div class="mb-8">
                <h1 class="text-4xl font-black bg-gradient-to-r from-orange-600 via-amber-600 to-yellow-600 bg-clip-text text-transparent mb-2">
                    Pending Orders
                </h1>
                <p class="text-slate-600 dark:text-slate-400">Review and approve customer orders awaiting your action</p>
            </div>

            <div class="grid gap-4 md:grid-cols-3 mb-6">
                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 p-4 shadow-lg shadow-amber-500/20 hover:shadow-amber-500/40 transition-all duration-300 hover:scale-105">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-2">
                            <Clock class="h-5 w-5 text-white/80" />
                        </div>
                        <p class="text-white/80 text-xs font-semibold uppercase mb-1">Pending Orders</p>
                        <p class="text-3xl font-black text-white">{{ orders.length }}</p>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 p-4 shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/40 transition-all duration-300 hover:scale-105">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-2">
                            <DollarSign class="h-5 w-5 text-white/80" />
                        </div>
                        <p class="text-white/80 text-xs font-semibold uppercase mb-1">Total Value</p>
                        <p class="text-2xl font-black text-white">{{ formatCurrency(totalValue) }}</p>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 p-4 shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 transition-all duration-300 hover:scale-105">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-2">
                            <Users class="h-5 w-5 text-white/80" />
                        </div>
                        <p class="text-white/80 text-xs font-semibold uppercase mb-1">Total Items</p>
                        <p class="text-3xl font-black text-white">{{ totalItems }}</p>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <Card v-for="order in orders" :key="order.id" 
                    class="backdrop-blur-xl bg-white/80 dark:bg-slate-900/80 border-white/20 shadow-lg hover:shadow-2xl transition-all duration-300 group relative overflow-hidden rounded-xl">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-amber-500 to-orange-500"></div>
                    
                    <CardContent class="p-5">
                        <div class="flex flex-col lg:flex-row gap-5">
                            <div class="flex-1 space-y-3">
                                <div class="flex items-center gap-3">
                                    <h3 class="text-lg font-bold">{{ order.order_number }}</h3>
                                    <Badge class="bg-amber-500/10 text-amber-600 border-amber-500/20 border"><Clock class="h-3 w-3 mr-1" />Pending</Badge>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    <div><span class="text-slate-500">Customer:</span> <span class="font-semibold">{{ order.user.name }}</span></div>
                                    <div><span class="text-slate-500">Email:</span> <span class="font-medium">{{ order.user.email }}</span></div>
                                    <div><span class="text-slate-500">Date:</span> <span class="font-medium">{{ formatDate(order.created_at) }}</span></div>
                                </div>

                                <div class="pt-2 border-t">
                                    <p class="text-xs font-semibold text-slate-500 mb-2">Order Items:</p>
                                    <div class="space-y-1">
                                        <div v-for="item in order.items" :key="item.id" class="text-sm flex justify-between">
                                            <span>{{ item.product.name }} × {{ item.quantity }}</span>
                                            <span class="font-semibold">{{ formatCurrency(item.subtotal) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col items-end gap-3 min-w-[180px]">
                                <div class="text-right">
                                    <p class="text-xs text-slate-500">Total Amount</p>
                                    <p class="text-3xl font-black bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                        {{ formatCurrency(order.total) }}
                                    </p>
                                </div>
                                
                                <div class="flex gap-2 w-full">
                                    <Button variant="outline" @click="rejectOrder(order.id)" class="flex-1 hover:bg-red-50 hover:text-red-600 hover:border-red-600 dark:hover:bg-red-950" size="sm">
                                        <XCircle class="h-4 w-4 mr-1" />Reject
                                    </Button>
                                    <Button @click="approveOrder(order.id)" class="flex-1 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 shadow-lg shadow-emerald-500/30" size="sm">
                                        <CheckCircle class="h-4 w-4 mr-1" />Approve
                                    </Button>
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <Card v-if="!orders.length" class="backdrop-blur-xl bg-white/80 dark:bg-slate-900/80 border-white/20 border-dashed border-2 rounded-xl">
                    <CardContent class="flex flex-col items-center justify-center py-12">
                        <div class="p-4 rounded-full bg-emerald-100 dark:bg-emerald-950 mb-4">
                            <CheckCircle class="h-10 w-10 text-emerald-600" />
                        </div>
                        <h3 class="text-lg font-semibold mb-2">All caught up! 🎉</h3>
                        <p class="text-slate-500 text-center">No pending orders at the moment. Great job!</p>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
