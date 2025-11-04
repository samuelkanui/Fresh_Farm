<script setup lang="ts">
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import type { DashboardStats } from '@/types/models'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import { 
    ShoppingCart, DollarSign, Users, Package, TrendingUp, 
    ArrowUpRight, Star, AlertTriangle, Calendar, Eye
} from 'lucide-vue-next'

type Product = {
    id: number
    name: string
    image: string | null
    total_sold: number
    total_revenue: number
    stock_quantity: number
}

type Order = {
    id: number
    order_number: string
    user: { name: string }
    status: string
    total: string
    created_at: string
}

type Booking = {
    id: number
    user: { name: string }
    booking_date: string
    booking_time: string
    number_of_people: number
}

type RevenueData = { month: string; revenue: number }

const props = defineProps<{
    stats: DashboardStats
    revenueData?: RevenueData[]
    topProducts?: Product[]
    lowStockProducts?: Product[]
    performanceMetrics?: {
        averageOrderValue: number
        conversionRate: number
        targetProgress: number
    }
    upcomingBookings?: Booking[]
    recentOrders?: Order[]
}>()

const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(amount)
}

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' })
}

const getStatusColor = (status: string) => {
    const colors: Record<string, string> = {
        pending: 'bg-amber-500/10 text-amber-600 border-amber-500/20',
        approved: 'bg-blue-500/10 text-blue-600 border-blue-500/20',
        completed: 'bg-emerald-500/10 text-emerald-600 border-emerald-500/20',
    }
    return colors[status] || 'bg-gray-500/10 text-gray-600'
}

const maxRevenue = computed(() => props.revenueData?.length ? Math.max(...props.revenueData.map(d => d.revenue)) : 0)
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 p-8">
            <!-- Premium Header -->
            <div class="mb-10">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-5xl font-black bg-gradient-to-r from-slate-900 via-blue-800 to-indigo-900 dark:from-white dark:via-blue-200 dark:to-indigo-200 bg-clip-text text-transparent mb-3">
                            Dashboard
                        </h1>
                        <p class="text-slate-600 dark:text-slate-400 text-lg">Welcome back! Here's your business overview.</p>
                    </div>
                    <div class="flex gap-3">
                        <Button variant="outline" class="backdrop-blur-xl bg-white/50 border-white/20 shadow-lg hover:bg-white/80">
                            <Calendar class="h-4 w-4 mr-2" />
                            Today
                        </Button>
                        <Button class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-500/30">
                            <Eye class="h-4 w-4 mr-2" />
                            View Store
                        </Button>
                    </div>
                </div>
            </div>

            <!-- Premium Stats Cards -->
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4 mb-6">
                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-600 p-[1px] shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/40 transition-all duration-300 hover:scale-105">
                    <div class="relative h-full bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl p-4 overflow-hidden">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-2">
                                <div class="p-2 bg-white/20 backdrop-blur-sm rounded-lg">
                                    <DollarSign class="h-5 w-5 text-white" />
                                </div>
                                <Badge class="bg-white/20 backdrop-blur-sm text-white border-0 shadow-lg text-xs">
                                    <TrendingUp class="h-3 w-3 mr-1" />+12.5%
                                </Badge>
                            </div>
                            <h3 class="text-white/90 text-xs font-semibold mb-1 tracking-wide uppercase">Total Revenue</h3>
                            <p class="text-3xl font-black text-white">{{ formatCurrency(stats.total_revenue) }}</p>
                        </div>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-blue-500 via-indigo-500 to-purple-600 p-[1px] shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 transition-all duration-300 hover:scale-105">
                    <div class="relative h-full bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl p-4 overflow-hidden">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-2">
                                <div class="p-2 bg-white/20 backdrop-blur-sm rounded-lg">
                                    <ShoppingCart class="h-5 w-5 text-white" />
                                </div>
                                <Badge class="bg-white/20 backdrop-blur-sm text-white border-0 shadow-lg text-xs">
                                    <TrendingUp class="h-3 w-3 mr-1" />+8.2%
                                </Badge>
                            </div>
                            <h3 class="text-white/90 text-xs font-semibold mb-1 tracking-wide uppercase">Total Orders</h3>
                            <p class="text-3xl font-black text-white">{{ stats.total_orders }}</p>
                            <p class="text-amber-200 text-xs font-semibold mt-1">{{ stats.pending_orders }} pending</p>
                        </div>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-violet-500 via-purple-500 to-fuchsia-600 p-[1px] shadow-lg shadow-purple-500/20 hover:shadow-purple-500/40 transition-all duration-300 hover:scale-105">
                    <div class="relative h-full bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl p-4 overflow-hidden">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-2">
                                <div class="p-2 bg-white/20 backdrop-blur-sm rounded-lg">
                                    <Users class="h-5 w-5 text-white" />
                                </div>
                                <Badge class="bg-white/20 backdrop-blur-sm text-white border-0 shadow-lg text-xs">
                                    <TrendingUp class="h-3 w-3 mr-1" />+15%
                                </Badge>
                            </div>
                            <h3 class="text-white/90 text-xs font-semibold mb-1 tracking-wide uppercase">Customers</h3>
                            <p class="text-3xl font-black text-white">{{ stats.total_customers }}</p>
                        </div>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-orange-500 via-rose-500 to-pink-600 p-[1px] shadow-lg shadow-rose-500/20 hover:shadow-rose-500/40 transition-all duration-300 hover:scale-105">
                    <div class="relative h-full bg-gradient-to-br from-orange-500 to-rose-600 rounded-xl p-4 overflow-hidden">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-2">
                                <div class="p-2 bg-white/20 backdrop-blur-sm rounded-lg">
                                    <Package class="h-5 w-5 text-white" />
                                </div>
                                <Badge class="bg-white/20 backdrop-blur-sm text-white border-0 shadow-lg text-xs">Active</Badge>
                            </div>
                            <h3 class="text-white/90 text-xs font-semibold mb-1 tracking-wide uppercase">Products</h3>
                            <p class="text-3xl font-black text-white">{{ stats.total_products }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid gap-6 lg:grid-cols-3 mb-8">
                <!-- Revenue Chart - Takes 2 columns -->
                <div class="lg:col-span-2">
                    <Card class="backdrop-blur-xl bg-white/80 dark:bg-slate-900/80 border-white/20 shadow-2xl rounded-2xl overflow-hidden">
                        <CardHeader class="border-b border-slate-200/50 dark:border-slate-700/50 bg-gradient-to-r from-transparent to-blue-50/50 dark:to-blue-950/20">
                            <div class="flex items-center justify-between">
                                <div>
                                    <CardTitle class="text-2xl font-bold">Revenue Overview</CardTitle>
                                    <CardDescription class="mt-1">6-month performance trend</CardDescription>
                                </div>
                                <Badge class="bg-emerald-500/10 text-emerald-600 border-emerald-500/20 px-4 py-2">
                                    <TrendingUp class="h-4 w-4 mr-1" />
                                    Growth
                                </Badge>
                            </div>
                        </CardHeader>
                        <CardContent class="p-8">
                            <div v-if="revenueData && revenueData.length > 0" class="h-72">
                                <div class="flex items-end justify-between h-full gap-3">
                                    <div v-for="(data, index) in revenueData" :key="index" class="flex-1 flex flex-col items-center gap-3 group">
                                        <div class="relative w-full flex items-end justify-center h-60">
                                            <div 
                                                class="w-full rounded-t-xl bg-gradient-to-t from-blue-600 via-indigo-500 to-purple-500 shadow-lg shadow-blue-500/30 transition-all duration-700 ease-out hover:shadow-2xl hover:shadow-blue-500/50 cursor-pointer relative overflow-hidden"
                                                :style="`height: ${maxRevenue > 0 ? (data.revenue / maxRevenue) * 100 : 0}%`"
                                            >
                                                <div class="absolute inset-0 bg-gradient-to-t from-white/0 to-white/20"></div>
                                                <div class="absolute -top-12 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-all duration-300 bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-sm font-bold px-4 py-2 rounded-lg shadow-xl whitespace-nowrap">
                                                    {{ formatCurrency(data.revenue) }}
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">{{ data.month }}</span>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Performance Metrics -->
                <div class="space-y-6">
                    <Card class="backdrop-blur-xl bg-gradient-to-br from-emerald-500/10 to-teal-500/10 border-emerald-500/20 shadow-xl rounded-2xl overflow-hidden">
                        <CardContent class="p-6">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="p-2 bg-emerald-500/20 rounded-lg">
                                    <DollarSign class="h-5 w-5 text-emerald-600" />
                                </div>
                                <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wide">Avg Order</h3>
                            </div>
                            <p class="text-3xl font-black bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                {{ formatCurrency(performanceMetrics?.averageOrderValue || 0) }}
                            </p>
                        </CardContent>
                    </Card>

                    <Card class="backdrop-blur-xl bg-gradient-to-br from-blue-500/10 to-indigo-500/10 border-blue-500/20 shadow-xl rounded-2xl overflow-hidden">
                        <CardContent class="p-6">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="p-2 bg-blue-500/20 rounded-lg">
                                    <TrendingUp class="h-5 w-5 text-blue-600" />
                                </div>
                                <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wide">Conversion</h3>
                            </div>
                            <p class="text-3xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                {{ (performanceMetrics?.conversionRate || 0).toFixed(1) }}%
                            </p>
                        </CardContent>
                    </Card>

                    <Card class="backdrop-blur-xl bg-gradient-to-br from-purple-500/10 to-pink-500/10 border-purple-500/20 shadow-xl rounded-2xl overflow-hidden">
                        <CardContent class="p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-purple-500/20 rounded-lg">
                                    <Star class="h-5 w-5 text-purple-600" />
                                </div>
                                <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wide">Target</h3>
                            </div>
                            <p class="text-2xl font-black bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-3">
                                {{ (performanceMetrics?.targetProgress || 0).toFixed(1) }}%
                            </p>
                            <div class="h-3 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                                <div 
                                    class="h-full bg-gradient-to-r from-purple-600 to-pink-600 rounded-full transition-all duration-1000 shadow-lg shadow-purple-500/50"
                                    :style="`width: ${Math.min(performanceMetrics?.targetProgress || 0, 100)}%`"
                                ></div>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>

            <!-- Bottom Grid -->
            <div class="grid gap-6 lg:grid-cols-2">
                <!-- Top Products -->
                <Card class="backdrop-blur-xl bg-white/80 dark:bg-slate-900/80 border-white/20 shadow-2xl rounded-2xl overflow-hidden">
                    <CardHeader class="border-b border-slate-200/50 dark:border-slate-700/50 bg-gradient-to-r from-amber-50/50 to-orange-50/50 dark:from-amber-950/20 dark:to-orange-950/20">
                        <div class="flex items-center justify-between">
                            <div>
                                <CardTitle class="text-xl font-bold flex items-center gap-2">
                                    <Star class="h-5 w-5 text-amber-500" />
                                    Top Products
                                </CardTitle>
                                <CardDescription>Best performers</CardDescription>
                            </div>
                            <Link href="/admin/products">
                                <Button variant="ghost" size="sm" class="hover:bg-white/50">
                                    View All <ArrowUpRight class="h-4 w-4 ml-1" />
                                </Button>
                            </Link>
                        </div>
                    </CardHeader>
                    <CardContent class="p-6">
                        <div v-if="topProducts && topProducts.length > 0" class="space-y-4">
                            <div v-for="(product, idx) in topProducts.slice(0, 5)" :key="product.id" 
                                class="flex items-center gap-4 p-4 rounded-xl hover:bg-slate-100/50 dark:hover:bg-slate-800/50 transition-all duration-300 group cursor-pointer">
                                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-br from-amber-500 to-orange-500 text-white font-black shadow-lg">
                                    {{ idx + 1 }}
                                </div>
                                <div class="w-14 h-14 rounded-xl bg-slate-200 dark:bg-slate-700 overflow-hidden shadow-lg">
                                    <img v-if="product.image" :src="`/storage/${product.image}`" :alt="product.name" class="w-full h-full object-cover" />
                                    <div v-else class="w-full h-full flex items-center justify-center">
                                        <Package class="h-6 w-6 text-slate-400" />
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-slate-900 dark:text-white truncate group-hover:text-blue-600 transition-colors">{{ product.name }}</p>
                                    <p class="text-sm text-slate-500">{{ product.total_sold }} sold</p>
                                </div>
                                <p class="font-black text-lg text-emerald-600">{{ formatCurrency(product.total_revenue || 0) }}</p>
                            </div>
                        </div>
                        <p v-else class="text-center py-12 text-slate-500">No sales data yet</p>
                    </CardContent>
                </Card>

                <!-- Low Stock Alert -->
                <Card class="backdrop-blur-xl bg-gradient-to-br from-orange-50 to-red-50 dark:from-orange-950/40 dark:to-red-950/40 border-orange-500/20 shadow-2xl rounded-2xl overflow-hidden">
                    <CardHeader class="border-b border-orange-200/50 dark:border-orange-700/50">
                        <div class="flex items-center justify-between">
                            <div>
                                <CardTitle class="text-xl font-bold flex items-center gap-2 text-orange-900 dark:text-orange-100">
                                    <AlertTriangle class="h-5 w-5 text-orange-500" />
                                    Low Stock Alert
                                </CardTitle>
                                <CardDescription>Immediate attention needed</CardDescription>
                            </div>
                        </div>
                    </CardHeader>
                    <CardContent class="p-6">
                        <div v-if="lowStockProducts && lowStockProducts.length > 0" class="space-y-3">
                            <div v-for="product in lowStockProducts.slice(0, 5)" :key="product.id" 
                                class="flex items-center gap-4 p-4 rounded-xl bg-white/60 dark:bg-slate-900/60 backdrop-blur-sm border border-orange-200/50 dark:border-orange-700/50">
                                <div class="w-12 h-12 rounded-xl bg-white dark:bg-slate-800 overflow-hidden shadow-lg">
                                    <img v-if="product.image" :src="`/storage/${product.image}`" :alt="product.name" class="w-full h-full object-cover" />
                                    <div v-else class="w-full h-full flex items-center justify-center">
                                        <Package class="h-6 w-6 text-slate-400" />
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-slate-900 dark:text-white truncate">{{ product.name }}</p>
                                    <p class="text-sm text-orange-600 dark:text-orange-400 font-semibold">Only {{ product.stock_quantity }} left!</p>
                                </div>
                                <Badge class="bg-orange-500 hover:bg-orange-600 text-white shadow-lg px-3 py-1">
                                    {{ product.stock_quantity }}
                                </Badge>
                            </div>
                        </div>
                        <div v-else class="text-center py-12">
                            <div class="w-16 h-16 bg-emerald-500/20 rounded-full flex items-center justify-center mx-auto mb-3">
                                <Package class="h-8 w-8 text-emerald-600" />
                            </div>
                            <p class="font-semibold text-emerald-600">All products well stocked! ✅</p>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
