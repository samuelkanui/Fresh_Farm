<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Checkbox } from '@/components/ui/checkbox'

type Category = {
    id: number
    name: string
}

const props = defineProps<{
    categories: Category[]
}>()

const form = useForm({
    name: '',
    category_id: null as number | null,
    description: '',
    price: '',
    unit: 'kg',
    stock_quantity: 0,
    image: null as File | null,
    is_featured: false,
})

const submit = () => {
    form.post('/admin/products', {
        forceFormData: true,
    })
}

const units = ['kg', 'g', 'piece', 'bunch', 'pack', 'liter', 'ml', 'dozen']
</script>

<template>
    <AppLayout title="Add Product">
        <div class="space-y-6 p-6">
            <!-- Header -->
            <div>
                <h1 class="text-3xl font-bold tracking-tight">Add New Product</h1>
                <p class="text-muted-foreground">Create a new product for your farm catalog</p>
            </div>

            <!-- Form -->
            <Card>
                <CardHeader>
                    <CardTitle>Product Details</CardTitle>
                    <CardDescription>Fill in the information below to create a new product</CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Image Upload -->
                        <div class="space-y-2">
                            <Label for="image">Product Image</Label>
                            <input
                                id="image"
                                type="file"
                                accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                                @change="(e) => form.image = (e.target as HTMLInputElement).files?.[0] || null"
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                                :class="{ 'border-destructive': form.errors.image }"
                            />
                            <p class="text-xs text-muted-foreground">Max 40MB. Supported: JPEG, PNG, GIF, WebP</p>
                            <p v-if="form.errors.image" class="text-sm text-destructive">{{ form.errors.image }}</p>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <!-- Product Name -->
                            <div class="space-y-2">
                                <Label for="name">Product Name *</Label>
                                <Input
                                    id="name"
                                    v-model="form.name"
                                    placeholder="e.g., Organic Tomatoes"
                                    :class="{ 'border-destructive': form.errors.name }"
                                />
                                <p v-if="form.errors.name" class="text-sm text-destructive">{{ form.errors.name }}</p>
                            </div>

                            <!-- Category -->
                            <div class="space-y-2">
                                <Label for="category">Category *</Label>
                                <select
                                    id="category"
                                    v-model="form.category_id"
                                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                                    :class="{ 'border-destructive': form.errors.category_id }"
                                >
                                    <option :value="null" disabled>Select a category</option>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">
                                        {{ category.name }}
                                    </option>
                                </select>
                                <p v-if="form.errors.category_id" class="text-sm text-destructive">{{ form.errors.category_id }}</p>
                            </div>

                            <!-- Price -->
                            <div class="space-y-2">
                                <Label for="price">Price ($) *</Label>
                                <Input
                                    id="price"
                                    v-model="form.price"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    placeholder="0.00"
                                    :class="{ 'border-destructive': form.errors.price }"
                                />
                                <p v-if="form.errors.price" class="text-sm text-destructive">{{ form.errors.price }}</p>
                            </div>

                            <!-- Unit -->
                            <div class="space-y-2">
                                <Label for="unit">Unit *</Label>
                                <select
                                    id="unit"
                                    v-model="form.unit"
                                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                                    :class="{ 'border-destructive': form.errors.unit }"
                                >
                                    <option v-for="unit in units" :key="unit" :value="unit">
                                        {{ unit }}
                                    </option>
                                </select>
                                <p v-if="form.errors.unit" class="text-sm text-destructive">{{ form.errors.unit }}</p>
                            </div>

                            <!-- Stock Quantity -->
                            <div class="space-y-2">
                                <Label for="stock">Stock Quantity *</Label>
                                <Input
                                    id="stock"
                                    v-model="form.stock_quantity"
                                    type="number"
                                    min="0"
                                    placeholder="0"
                                    :class="{ 'border-destructive': form.errors.stock_quantity }"
                                />
                                <p v-if="form.errors.stock_quantity" class="text-sm text-destructive">{{ form.errors.stock_quantity }}</p>
                            </div>

                            <!-- Featured -->
                            <div class="flex items-center space-x-2 pt-8">
                                <Checkbox id="featured" v-model:checked="form.is_featured" />
                                <Label for="featured" class="cursor-pointer">Mark as featured product</Label>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="space-y-2">
                            <Label for="description">Description</Label>
                            <textarea
                                id="description"
                                v-model="form.description"
                                placeholder="Describe your product..."
                                rows="4"
                                class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                                :class="{ 'border-destructive': form.errors.description }"
                            ></textarea>
                            <p v-if="form.errors.description" class="text-sm text-destructive">{{ form.errors.description }}</p>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-end gap-4">
                            <Button variant="outline" type="button" @click="$inertia.visit('/admin/products')">
                                Cancel
                            </Button>
                            <Button type="submit" :disabled="form.processing">
                                <span v-if="form.processing">Creating...</span>
                                <span v-else>Create Product</span>
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
