<script setup lang="ts">
import { ref, computed } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent } from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'
import { Input } from '@/components/ui/input'
import { Users, ShoppingCart, DollarSign, Search, Mail, Phone, Calendar } from 'lucide-vue-next'

type Customer = {
    id: number
    name: string
    email: string
    phone: string | null
    created_at: string
    orders_count: number
    total_spent: number
}

const props = defineProps<{ customers: Customer[] }>()

const searchQuery = ref('')

const filteredCustomers = computed(() => {
    if (!searchQuery.value) return props.customers
    const query = searchQuery.value.toLowerCase()
    return props.customers.filter(c => 
        c.name.toLowerCase().includes(query) || 
        c.email.toLowerCase().includes(query)
    )
})

const stats = computed(() => ({
    total: props.customers.length,
    active: props.customers.filter(c => c.orders_count > 0).length,
    totalSpent: props.customers.reduce((sum, c) => sum + (c.total_spent || 0), 0),
    avgSpent: props.customers.length > 0 
        ? props.customers.reduce((sum, c) => sum + (c.total_spent || 0), 0) / props.customers.length 
        : 0,
}))

const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(amount)
}

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
}

const getCustomerLevel = (orders: number) => {
    if (orders >= 10) return { label: 'VIP', color: 'bg-purple-500/10 text-purple-600 border-purple-500/20' }
    if (orders >= 5) return { label: 'Gold', color: 'bg-amber-500/10 text-amber-600 border-amber-500/20' }
    if (orders >= 1) return { label: 'Active', color: 'bg-emerald-500/10 text-emerald-600 border-emerald-500/20' }
    return { label: 'New', color: 'bg-blue-500/10 text-blue-600 border-blue-500/20' }
}
</script>

<template>
    <AppLayout title="Customers">
        <div class="min-h-screen bg-gradient-to-br from-slate-50 via-purple-50 to-indigo-50 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 p-6">
            <div class="mb-8">
                <h1 class="text-4xl font-black bg-gradient-to-r from-purple-600 via-indigo-600 to-blue-600 bg-clip-text text-transparent mb-2">
                    Customer Management
                </h1>
                <p class="text-slate-600 dark:text-slate-400">View and manage your registered customers</p>
            </div>

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4 mb-6">
                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-purple-500 to-indigo-600 p-4 shadow-lg shadow-purple-500/20 hover:shadow-purple-500/40 transition-all duration-300 hover:scale-105">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <Users class="h-5 w-5 text-white/80 mb-2" />
                        <p class="text-white/80 text-xs font-semibold uppercase mb-1">Total Customers</p>
                        <p class="text-3xl font-black text-white">{{ stats.total }}</p>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 p-4 shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/40 transition-all duration-300 hover:scale-105">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <ShoppingCart class="h-5 w-5 text-white/80 mb-2" />
                        <p class="text-white/80 text-xs font-semibold uppercase mb-1">Active Customers</p>
                        <p class="text-3xl font-black text-white">{{ stats.active }}</p>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-blue-500 to-cyan-600 p-4 shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 transition-all duration-300 hover:scale-105">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <DollarSign class="h-5 w-5 text-white/80 mb-2" />
                        <p class="text-white/80 text-xs font-semibold uppercase mb-1">Total Revenue</p>
                        <p class="text-2xl font-black text-white">{{ formatCurrency(stats.totalSpent) }}</p>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 p-4 shadow-lg shadow-amber-500/20 hover:shadow-amber-500/40 transition-all duration-300 hover:scale-105">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <DollarSign class="h-5 w-5 text-white/80 mb-2" />
                        <p class="text-white/80 text-xs font-semibold uppercase mb-1">Avg Customer Value</p>
                        <p class="text-2xl font-black text-white">{{ formatCurrency(stats.avgSpent) }}</p>
                    </div>
                </div>
            </div>

            <Card class="backdrop-blur-xl bg-white/80 dark:bg-slate-900/80 border-white/20 shadow-xl rounded-xl mb-6">
                <CardContent class="p-4">
                    <div class="relative">
                        <Search class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                        <Input v-model="searchQuery" placeholder="Search customers by name or email..." class="pl-10 bg-white/50 dark:bg-slate-800/50" />
                    </div>
                </CardContent>
            </Card>

            <div class="space-y-3">
                <Card v-for="customer in filteredCustomers" :key="customer.id" 
                    class="backdrop-blur-xl bg-white/80 dark:bg-slate-900/80 border-white/20 shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-[1.01] group relative overflow-hidden rounded-xl">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-purple-500 to-indigo-500"></div>
                    
                    <CardContent class="p-5">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                            <div class="flex items-start gap-4 flex-1">
                                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white font-black text-xl shadow-lg">
                                    {{ customer.name.charAt(0).toUpperCase() }}
                                </div>
                                
                                <div class="flex-1 space-y-2">
                                    <div class="flex items-center gap-3">
                                        <h3 class="text-lg font-bold">{{ customer.name }}</h3>
                                        <Badge :class="getCustomerLevel(customer.orders_count).color" class="border">
                                            {{ getCustomerLevel(customer.orders_count).label }}
                                        </Badge>
                                    </div>
                                    
                                    <div class="grid md:grid-cols-2 gap-2 text-sm">
                                        <div class="flex items-center gap-2 text-slate-600 dark:text-slate-400">
                                            <Mail class="h-4 w-4" />
                                            <span>{{ customer.email }}</span>
                                        </div>
                                        <div v-if="customer.phone" class="flex items-center gap-2 text-slate-600 dark:text-slate-400">
                                            <Phone class="h-4 w-4" />
                                            <span>{{ customer.phone }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-slate-600 dark:text-slate-400">
                                            <Calendar class="h-4 w-4" />
                                            <span>Joined {{ formatDate(customer.created_at) }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-slate-600 dark:text-slate-400">
                                            <ShoppingCart class="h-4 w-4" />
                                            <span>{{ customer.orders_count }} {{ customer.orders_count === 1 ? 'order' : 'orders' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                <p class="text-xs text-slate-500">Total Spent</p>
                                <p class="text-2xl font-black bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                    {{ formatCurrency(customer.total_spent || 0) }}
                                </p>
                                <p class="text-xs text-slate-500 mt-1">
                                    {{ customer.orders_count > 0 ? formatCurrency((customer.total_spent || 0) / customer.orders_count) : '$0.00' }} avg/order
                                </p>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <Card v-if="!filteredCustomers.length" class="backdrop-blur-xl bg-white/80 dark:bg-slate-900/80 border-white/20 border-dashed border-2 rounded-xl">
                    <CardContent class="flex flex-col items-center justify-center py-12">
                        <div class="p-4 rounded-full bg-slate-200/50 dark:bg-slate-700/50 mb-4">
                            <Users class="h-10 w-10 text-slate-400" />
                        </div>
                        <h3 class="text-lg font-semibold mb-2">No customers found</h3>
                        <p class="text-slate-500 text-center">{{ searchQuery ? 'Try adjusting your search' : 'Customers will appear here once they register' }}</p>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
