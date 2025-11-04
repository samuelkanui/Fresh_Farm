<script setup lang="ts">
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog'
import { Package, Star, AlertTriangle, XCircle, Search, Edit, Trash2 } from 'lucide-vue-next'

type Product = {
    id: number
    name: string
    description: string
    price: string
    stock_quantity: number
    image: string | null
    is_featured: boolean
    category: { id: number; name: string }
}

const props = defineProps<{ products: Product[] }>()

const searchQuery = ref('')
const showDeleteDialog = ref(false)
const productToDelete = ref<Product | null>(null)

const filteredProducts = computed(() => {
    if (!searchQuery.value) return props.products
    const query = searchQuery.value.toLowerCase()
    return props.products.filter(p => 
        p.name.toLowerCase().includes(query) || 
        p.category.name.toLowerCase().includes(query)
    )
})

const stats = computed(() => ({
    total: props.products.length,
    featured: props.products.filter(p => p.is_featured).length,
    lowStock: props.products.filter(p => p.stock_quantity < 10 && p.stock_quantity > 0).length,
    outOfStock: props.products.filter(p => p.stock_quantity === 0).length,
}))

const confirmDelete = (product: Product) => {
    productToDelete.value = product
    showDeleteDialog.value = true
}

const deleteProduct = () => {
    if (productToDelete.value) {
        router.delete(`/admin/products/${productToDelete.value.id}`)
        showDeleteDialog.value = false
        productToDelete.value = null
    }
}

const formatCurrency = (amount: string | number) => {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(Number(amount))
}
</script>

<template>
    <AppLayout title="Products">
        <div class="min-h-screen bg-gradient-to-br from-slate-50 via-pink-50 to-rose-50 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 p-6">
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-black bg-gradient-to-r from-pink-600 via-rose-600 to-red-600 bg-clip-text text-transparent mb-2">
                            Products Catalog
                        </h1>
                        <p class="text-slate-600 dark:text-slate-400">Manage your product inventory and listings</p>
                    </div>
                    <Button as-child class="bg-gradient-to-r from-pink-600 to-rose-600 hover:from-pink-700 hover:to-rose-700 shadow-lg shadow-pink-500/30">
                        <Link href="/admin/products/create">
                            <Package class="h-4 w-4 mr-2" />Add Product
                        </Link>
                    </Button>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4 mb-6">
                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-pink-500 to-rose-600 p-4 shadow-lg shadow-pink-500/20 hover:shadow-pink-500/40 transition-all duration-300 hover:scale-105">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <Package class="h-5 w-5 text-white/80 mb-2" />
                        <p class="text-white/80 text-xs font-semibold uppercase mb-1">Total Products</p>
                        <p class="text-3xl font-black text-white">{{ stats.total }}</p>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-amber-500 to-yellow-600 p-4 shadow-lg shadow-amber-500/20 hover:shadow-amber-500/40 transition-all duration-300 hover:scale-105">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <Star class="h-5 w-5 text-white/80 mb-2" />
                        <p class="text-white/80 text-xs font-semibold uppercase mb-1">Featured</p>
                        <p class="text-3xl font-black text-white">{{ stats.featured }}</p>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-orange-500 to-red-600 p-4 shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 transition-all duration-300 hover:scale-105">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <AlertTriangle class="h-5 w-5 text-white/80 mb-2" />
                        <p class="text-white/80 text-xs font-semibold uppercase mb-1">Low Stock</p>
                        <p class="text-3xl font-black text-white">{{ stats.lowStock }}</p>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-red-500 to-rose-600 p-4 shadow-lg shadow-red-500/20 hover:shadow-red-500/40 transition-all duration-300 hover:scale-105">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <XCircle class="h-5 w-5 text-white/80 mb-2" />
                        <p class="text-white/80 text-xs font-semibold uppercase mb-1">Out of Stock</p>
                        <p class="text-3xl font-black text-white">{{ stats.outOfStock }}</p>
                    </div>
                </div>
            </div>

            <Card class="backdrop-blur-xl bg-white/80 dark:bg-slate-900/80 border-white/20 shadow-xl rounded-xl mb-6">
                <CardContent class="p-4">
                    <div class="relative">
                        <Search class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                        <Input v-model="searchQuery" placeholder="Search products by name or category..." class="pl-10 bg-white/50 dark:bg-slate-800/50" />
                    </div>
                </CardContent>
            </Card>

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <Card v-for="product in filteredProducts" :key="product.id" 
                    class="backdrop-blur-xl bg-white/80 dark:bg-slate-900/80 border-white/20 shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105 group overflow-hidden rounded-xl">
                    <div class="relative h-48 bg-slate-200 dark:bg-slate-700 overflow-hidden">
                        <img v-if="product.image" :src="`/storage/${product.image}`" :alt="product.name" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                        <div v-else class="w-full h-full flex items-center justify-center">
                            <Package class="h-16 w-16 text-slate-400" />
                        </div>
                        <Badge v-if="product.is_featured" class="absolute top-3 left-3 bg-amber-500 hover:bg-amber-600 text-white shadow-lg">
                            <Star class="h-3 w-3 mr-1" />Featured
                        </Badge>
                        <Badge v-if="product.stock_quantity < 10 && product.stock_quantity > 0" class="absolute top-3 right-3 bg-orange-500 hover:bg-orange-600 text-white shadow-lg">
                            Low Stock
                        </Badge>
                        <Badge v-if="product.stock_quantity === 0" class="absolute top-3 right-3 bg-red-500 hover:bg-red-600 text-white shadow-lg">
                            Out of Stock
                        </Badge>
                    </div>
                    
                    <CardContent class="p-4">
                        <div class="mb-3">
                            <h3 class="font-bold text-lg mb-1 line-clamp-1">{{ product.name }}</h3>
                            <Badge variant="outline" class="text-xs">{{ product.category.name }}</Badge>
                        </div>
                        
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <p class="text-xs text-slate-500">Price</p>
                                <p class="text-xl font-black bg-gradient-to-r from-pink-600 to-rose-600 bg-clip-text text-transparent">
                                    {{ formatCurrency(product.price) }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-slate-500">Stock</p>
                                <p class="text-lg font-bold" :class="product.stock_quantity === 0 ? 'text-red-600' : product.stock_quantity < 10 ? 'text-orange-600' : 'text-emerald-600'">
                                    {{ product.stock_quantity }}
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <Button variant="outline" size="sm" as-child class="flex-1 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-600 dark:hover:bg-blue-950">
                                <Link :href="`/admin/products/${product.id}/edit`">
                                    <Edit class="h-3 w-3 mr-1" />Edit
                                </Link>
                            </Button>
                            <Button variant="outline" size="sm" @click="confirmDelete(product)" class="flex-1 hover:bg-red-50 hover:text-red-600 hover:border-red-600 dark:hover:bg-red-950">
                                <Trash2 class="h-3 w-3 mr-1" />Delete
                            </Button>
                        </div>
                    </CardContent>
                </Card>

                <Card v-if="!filteredProducts.length" class="backdrop-blur-xl bg-white/80 dark:bg-slate-900/80 border-white/20 border-dashed border-2 rounded-xl md:col-span-2 lg:col-span-3 xl:col-span-4">
                    <CardContent class="flex flex-col items-center justify-center py-12">
                        <div class="p-4 rounded-full bg-slate-200/50 dark:bg-slate-700/50 mb-4">
                            <Package class="h-10 w-10 text-slate-400" />
                        </div>
                        <h3 class="text-lg font-semibold mb-2">No products found</h3>
                        <p class="text-slate-500 text-center">{{ searchQuery ? 'Try adjusting your search' : 'Start by adding your first product' }}</p>
                    </CardContent>
                </Card>
            </div>

            <Dialog v-model:open="showDeleteDialog">
                <DialogContent class="backdrop-blur-xl bg-white/90 dark:bg-slate-900/90">
                    <DialogHeader>
                        <DialogTitle>Delete Product</DialogTitle>
                        <DialogDescription>
                            Are you sure you want to delete "{{ productToDelete?.name }}"? This action cannot be undone.
                        </DialogDescription>
                    </DialogHeader>
                    <DialogFooter>
                        <Button variant="outline" @click="showDeleteDialog = false">Cancel</Button>
                        <Button @click="deleteProduct" class="bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700">
                            <Trash2 class="h-4 w-4 mr-2" />Delete Product
                        </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </div>
    </AppLayout>
</template>
