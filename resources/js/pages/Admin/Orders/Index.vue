<script setup lang="ts">
import { ref, computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { ShoppingCart, CheckCircle, Clock, XCircle, Search } from 'lucide-vue-next'

type User = { id: number; name: string; email: string }
type Product = { id: number; name: string }
type OrderItem = { id: number; product: Product; quantity: number; price: string; subtotal: string }
type Order = { id: number; order_number: string; user: User; status: string; total: string; items: OrderItem[]; created_at: string }

const props = defineProps<{ orders: Order[] }>()

const searchQuery = ref('')
const selectedStatus = ref('all')

const filteredOrders = computed(() => {
    let filtered = props.orders
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase()
        filtered = filtered.filter(order => 
            order.order_number.toLowerCase().includes(query) ||
            order.user.name.toLowerCase().includes(query) ||
            order.user.email.toLowerCase().includes(query)
        )
    }
    if (selectedStatus.value !== 'all') {
        filtered = filtered.filter(order => order.status === selectedStatus.value)
    }
    return filtered
})

const stats = computed(() => ({
    total: props.orders.length,
    pending: props.orders.filter(o => o.status === 'pending').length,
    approved: props.orders.filter(o => o.status === 'approved').length,
    completed: props.orders.filter(o => o.status === 'completed').length,
    rejected: props.orders.filter(o => o.status === 'rejected').length,
}))

const getStatusColor = (status: string) => {
    const colors: Record<string, string> = {
        pending: 'bg-amber-500/10 text-amber-600 border-amber-500/20',
        approved: 'bg-blue-500/10 text-blue-600 border-blue-500/20',
        completed: 'bg-emerald-500/10 text-emerald-600 border-emerald-500/20',
        rejected: 'bg-red-500/10 text-red-600 border-red-500/20',
    }
    return colors[status] || 'bg-gray-500/10 text-gray-600'
}

const formatCurrency = (amount: string | number) => {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(Number(amount))
}

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
}
</script>

<template>
    <AppLayout title="All Orders">
        <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 p-6">
            <div class="mb-8">
                <h1 class="text-4xl font-black bg-gradient-to-r from-slate-900 via-blue-800 to-indigo-900 dark:from-white dark:via-blue-200 dark:to-indigo-200 bg-clip-text text-transparent mb-2">
                    All Orders
                </h1>
                <p class="text-slate-600 dark:text-slate-400">Manage and track all customer orders</p>
            </div>

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-5 mb-6">
                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 p-4 shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 transition-all duration-300 hover:scale-105">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-2">
                            <ShoppingCart class="h-5 w-5 text-white/80" />
                        </div>
                        <p class="text-white/80 text-xs font-semibold uppercase mb-1">Total</p>
                        <p class="text-3xl font-black text-white">{{ stats.total }}</p>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 p-4 shadow-lg shadow-amber-500/20 hover:shadow-amber-500/40 transition-all duration-300 hover:scale-105">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-2">
                            <Clock class="h-5 w-5 text-white/80" />
                        </div>
                        <p class="text-white/80 text-xs font-semibold uppercase mb-1">Pending</p>
                        <p class="text-3xl font-black text-white">{{ stats.pending }}</p>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-blue-500 to-cyan-600 p-4 shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 transition-all duration-300 hover:scale-105">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-2">
                            <CheckCircle class="h-5 w-5 text-white/80" />
                        </div>
                        <p class="text-white/80 text-xs font-semibold uppercase mb-1">Approved</p>
                        <p class="text-3xl font-black text-white">{{ stats.approved }}</p>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 p-4 shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/40 transition-all duration-300 hover:scale-105">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-2">
                            <CheckCircle class="h-5 w-5 text-white/80" />
                        </div>
                        <p class="text-white/80 text-xs font-semibold uppercase mb-1">Completed</p>
                        <p class="text-3xl font-black text-white">{{ stats.completed }}</p>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-red-500 to-rose-600 p-4 shadow-lg shadow-red-500/20 hover:shadow-red-500/40 transition-all duration-300 hover:scale-105">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-2">
                            <XCircle class="h-5 w-5 text-white/80" />
                        </div>
                        <p class="text-white/80 text-xs font-semibold uppercase mb-1">Rejected</p>
                        <p class="text-3xl font-black text-white">{{ stats.rejected }}</p>
                    </div>
                </div>
            </div>

            <Card class="backdrop-blur-xl bg-white/80 dark:bg-slate-900/80 border-white/20 shadow-xl rounded-xl mb-4">
                <CardContent class="p-4">
                    <div class="flex flex-col md:flex-row gap-3">
                        <div class="flex-1 relative">
                            <Search class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                            <Input v-model="searchQuery" placeholder="Search by order number, customer name or email..." class="pl-10 bg-white/50 dark:bg-slate-800/50" />
                        </div>
                        <div class="flex gap-2">
                            <Button :variant="selectedStatus === 'all' ? 'default' : 'outline'" @click="selectedStatus = 'all'" size="sm" class="bg-gradient-to-r from-blue-600 to-indigo-600">All</Button>
                            <Button :variant="selectedStatus === 'pending' ? 'default' : 'outline'" @click="selectedStatus = 'pending'" size="sm">Pending</Button>
                            <Button :variant="selectedStatus === 'completed' ? 'default' : 'outline'" @click="selectedStatus = 'completed'" size="sm">Completed</Button>
                        </div>
                    </div>
                </CardContent>
            </Card>

            <div class="space-y-3">
                <Card v-for="order in filteredOrders" :key="order.id" 
                    class="backdrop-blur-xl bg-white/80 dark:bg-slate-900/80 border-white/20 shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-[1.01] group relative overflow-hidden rounded-xl">
                    <div :class="['absolute left-0 top-0 bottom-0 w-1', order.status === 'pending' ? 'bg-gradient-to-b from-amber-500 to-orange-500' : order.status === 'completed' ? 'bg-gradient-to-b from-emerald-500 to-teal-500' : order.status === 'approved' ? 'bg-gradient-to-b from-blue-500 to-indigo-500' : 'bg-gradient-to-b from-red-500 to-rose-500']"></div>
                    
                    <CardContent class="p-5">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    <h3 class="text-lg font-bold">{{ order.order_number }}</h3>
                                    <Badge :class="getStatusColor(order.status)" class="capitalize border">{{ order.status }}</Badge>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    <div><span class="text-slate-500">Customer:</span> <span class="font-semibold">{{ order.user.name }}</span></div>
                                    <div><span class="text-slate-500">Email:</span> <span class="font-medium">{{ order.user.email }}</span></div>
                                    <div><span class="text-slate-500">Items:</span> <span class="font-medium">{{ order.items.length }} product(s)</span></div>
                                    <div><span class="text-slate-500">Date:</span> <span class="font-medium">{{ formatDate(order.created_at) }}</span></div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <div class="text-right">
                                    <p class="text-xs text-slate-500">Total Amount</p>
                                    <p class="text-2xl font-black bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                        {{ formatCurrency(order.total) }}
                                    </p>
                                </div>
                                <Button variant="outline" size="sm" as-child class="group-hover:bg-gradient-to-r group-hover:from-blue-600 group-hover:to-indigo-600 group-hover:text-white transition-all">
                                    <Link :href="`/orders/${order.id}`">View Details →</Link>
                                </Button>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <Card v-if="!filteredOrders.length" class="backdrop-blur-xl bg-white/80 dark:bg-slate-900/80 border-white/20 border-dashed border-2 rounded-xl">
                    <CardContent class="flex flex-col items-center justify-center py-12">
                        <div class="p-4 rounded-full bg-slate-200/50 dark:bg-slate-700/50 mb-4">
                            <ShoppingCart class="h-10 w-10 text-slate-400" />
                        </div>
                        <h3 class="text-lg font-semibold mb-2">No orders found</h3>
                        <p class="text-slate-500 text-center">{{ searchQuery || selectedStatus !== 'all' ? 'Try adjusting your filters' : 'Orders will appear here once customers place them' }}</p>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
