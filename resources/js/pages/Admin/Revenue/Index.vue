<script setup lang="ts">
import { ref, computed } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card'
import { DollarSign, TrendingUp, TrendingDown, Calendar, ShoppingCart, CalendarDays } from 'lucide-vue-next'

type Stats = {
    totalRevenue: number
    orderRevenue: number
    bookingRevenue: number
    thisMonthRevenue: number
    lastMonthRevenue: number
    revenueGrowth: number
    pendingRevenue: number
    completedOrders: number
    completedBookings: number
}

type MonthlyRevenue = { month: string; revenue: number; orders: number; bookings: number }
type CategoryRevenue = { category: string; revenue: number }

const props = defineProps<{
    stats: Stats
    monthlyRevenue: MonthlyRevenue[]
    revenueByCategory: CategoryRevenue[]
}>()

const profitMargin = ref(30)
const estimatedProfit = ref((props.stats.totalRevenue * profitMargin.value) / 100)
const estimatedCosts = ref(props.stats.totalRevenue - estimatedProfit.value)

const updateProfitCalculation = () => {
    estimatedProfit.value = (props.stats.totalRevenue * profitMargin.value) / 100
    estimatedCosts.value = props.stats.totalRevenue - estimatedProfit.value
}

const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(amount)
}

const maxRevenue = computed(() => Math.max(...props.monthlyRevenue.map(m => m.revenue)))
const maxCategoryRevenue = computed(() => Math.max(...props.revenueByCategory.map(c => Number(c.revenue))))
</script>

<template>
    <AppLayout title="Revenue Analytics">
        <div class="min-h-screen bg-gradient-to-br from-slate-50 via-emerald-50 to-teal-50 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 p-6">
            <div class="mb-8">
                <h1 class="text-4xl font-black bg-gradient-to-r from-emerald-600 via-teal-600 to-green-600 bg-clip-text text-transparent mb-2">
                    Revenue & Analytics
                </h1>
                <p class="text-slate-600 dark:text-slate-400">Track earnings, profits, and financial performance</p>
            </div>

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4 mb-6">
                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 p-4 shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/40 transition-all duration-300 hover:scale-105">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <DollarSign class="h-5 w-5 text-white/80 mb-2" />
                        <p class="text-white/80 text-xs font-semibold uppercase mb-1">Total Revenue</p>
                        <p class="text-2xl font-black text-white">{{ formatCurrency(stats.totalRevenue) }}</p>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 p-4 shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 transition-all duration-300 hover:scale-105">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <Calendar class="h-5 w-5 text-white/80 mb-2" />
                        <p class="text-white/80 text-xs font-semibold uppercase mb-1">This Month</p>
                        <p class="text-2xl font-black text-white">{{ formatCurrency(stats.thisMonthRevenue) }}</p>
                        <p class="text-xs mt-1" :class="stats.revenueGrowth >= 0 ? 'text-emerald-200' : 'text-red-200'">
                            {{ stats.revenueGrowth >= 0 ? '+' : '' }}{{ stats.revenueGrowth.toFixed(1) }}%
                        </p>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 p-4 shadow-lg shadow-purple-500/20 hover:shadow-purple-500/40 transition-all duration-300 hover:scale-105">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <TrendingUp class="h-5 w-5 text-white/80 mb-2" />
                        <p class="text-white/80 text-xs font-semibold uppercase mb-1">Estimated Profit</p>
                        <p class="text-2xl font-black text-white">{{ formatCurrency(estimatedProfit) }}</p>
                        <p class="text-xs text-white/70 mt-1">{{ profitMargin }}% margin</p>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-orange-500 to-amber-600 p-4 shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 transition-all duration-300 hover:scale-105">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <TrendingDown class="h-5 w-5 text-white/80 mb-2" />
                        <p class="text-white/80 text-xs font-semibold uppercase mb-1">Pending</p>
                        <p class="text-2xl font-black text-white">{{ formatCurrency(stats.pendingRevenue) }}</p>
                    </div>
                </div>
            </div>

            <Card class="backdrop-blur-xl bg-white/80 dark:bg-slate-900/80 border-white/20 shadow-xl rounded-xl mb-6">
                <CardHeader>
                    <CardTitle>Profit & Cost Analysis</CardTitle>
                    <CardDescription>Adjust profit margin to estimate profits and costs</CardDescription>
                </CardHeader>
                <CardContent class="space-y-4">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-sm font-semibold">Profit Margin (%)</label>
                            <span class="text-2xl font-black text-emerald-600">{{ profitMargin }}%</span>
                        </div>
                        <input v-model.number="profitMargin" @input="updateProfitCalculation" type="range" min="0" max="100" 
                            class="w-full h-3 bg-slate-200 rounded-lg appearance-none cursor-pointer dark:bg-slate-700 accent-emerald-600" />
                    </div>

                    <div class="grid gap-4 md:grid-cols-3">
                        <div class="p-4 rounded-xl border border-blue-500/20 bg-gradient-to-br from-blue-50/50 to-indigo-50/50 dark:from-blue-950/20 dark:to-indigo-950/20">
                            <p class="text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Total Revenue</p>
                            <p class="text-2xl font-black">{{ formatCurrency(stats.totalRevenue) }}</p>
                        </div>
                        <div class="p-4 rounded-xl border border-emerald-500/20 bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-950/30 dark:to-teal-950/30">
                            <p class="text-xs font-semibold text-emerald-700 dark:text-emerald-300 mb-1">Estimated Profit</p>
                            <p class="text-2xl font-black text-emerald-600">{{ formatCurrency(estimatedProfit) }}</p>
                            <div class="mt-2 h-2 bg-emerald-200 dark:bg-emerald-900 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full" :style="`width: ${profitMargin}%`"></div>
                            </div>
                        </div>
                        <div class="p-4 rounded-xl border border-red-500/20 bg-gradient-to-br from-red-50 to-rose-50 dark:from-red-950/30 dark:to-rose-950/30">
                            <p class="text-xs font-semibold text-red-700 dark:text-red-300 mb-1">Estimated Costs</p>
                            <p class="text-2xl font-black text-red-600">{{ formatCurrency(estimatedCosts) }}</p>
                            <div class="mt-2 h-2 bg-red-200 dark:bg-red-900 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-red-500 to-rose-500 rounded-full" :style="`width: ${100 - profitMargin}%`"></div>
                            </div>
                        </div>
                    </div>
                </CardContent>
            </Card>

            <div class="grid gap-6 lg:grid-cols-2 mb-6">
                <Card class="backdrop-blur-xl bg-white/80 dark:bg-slate-900/80 border-white/20 shadow-xl rounded-xl">
                    <CardHeader>
                        <CardTitle>Revenue Sources</CardTitle>
                        <CardDescription>Breakdown by income type</CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-3">
                        <div class="flex items-center justify-between p-4 rounded-xl bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-950/20 dark:to-teal-950/20">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-emerald-500/20 rounded-lg">
                                    <ShoppingCart class="h-5 w-5 text-emerald-600" />
                                </div>
                                <div>
                                    <p class="font-semibold">Product Orders</p>
                                    <p class="text-xs text-slate-500">{{ stats.completedOrders }} orders</p>
                                </div>
                            </div>
                            <p class="text-xl font-black text-emerald-600">{{ formatCurrency(stats.orderRevenue) }}</p>
                        </div>
                        <div class="flex items-center justify-between p-4 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/20 dark:to-indigo-950/20">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-500/20 rounded-lg">
                                    <CalendarDays class="h-5 w-5 text-blue-600" />
                                </div>
                                <div>
                                    <p class="font-semibold">Farm Bookings</p>
                                    <p class="text-xs text-slate-500">{{ stats.completedBookings }} bookings</p>
                                </div>
                            </div>
                            <p class="text-xl font-black text-blue-600">{{ formatCurrency(stats.bookingRevenue) }}</p>
                        </div>
                    </CardContent>
                </Card>

                <Card class="backdrop-blur-xl bg-white/80 dark:bg-slate-900/80 border-white/20 shadow-xl rounded-xl">
                    <CardHeader>
                        <CardTitle>Revenue by Category</CardTitle>
                        <CardDescription>Product category performance</CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-3">
                        <div v-for="category in revenueByCategory.slice(0, 5)" :key="category.category" class="space-y-1">
                            <div class="flex items-center justify-between text-sm">
                                <span class="font-semibold">{{ category.category }}</span>
                                <span class="font-black text-emerald-600">{{ formatCurrency(Number(category.revenue)) }}</span>
                            </div>
                            <div class="h-2 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full" 
                                    :style="`width: ${maxCategoryRevenue > 0 ? (Number(category.revenue) / maxCategoryRevenue) * 100 : 0}%`"></div>
                            </div>
                        </div>
                        <div v-if="!revenueByCategory.length" class="text-center py-6 text-sm text-slate-500">
                            No category data available
                        </div>
                    </CardContent>
                </Card>
            </div>

            <Card class="backdrop-blur-xl bg-white/80 dark:bg-slate-900/80 border-white/20 shadow-xl rounded-xl">
                <CardHeader>
                    <CardTitle>Monthly Revenue Trend</CardTitle>
                    <CardDescription>Performance over the last 12 months</CardDescription>
                </CardHeader>
                <CardContent class="p-6">
                    <div v-if="monthlyRevenue.length" class="h-64">
                        <div class="flex items-end justify-between h-full gap-2">
                            <div v-for="(m, i) in monthlyRevenue" :key="i" class="flex-1 flex flex-col items-center gap-2 group">
                                <div class="relative w-full flex items-end justify-center h-56">
                                    <div class="w-full bg-gradient-to-t from-emerald-600 to-teal-500 rounded-t-lg transition-all duration-500 hover:opacity-80 cursor-pointer relative"
                                        :style="`height: ${maxRevenue > 0 ? (m.revenue / maxRevenue) * 100 : 0}%`">
                                        <div class="absolute -top-10 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-xs font-bold px-3 py-1 rounded-lg shadow-xl whitespace-nowrap">
                                            {{ formatCurrency(m.revenue) }}
                                        </div>
                                    </div>
                                </div>
                                <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">{{ m.month }}</span>
                            </div>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
