export interface User {
    id: number
    name: string
    email: string
    role: 'customer' | 'admin'
    email_verified_at: string | null
    created_at: string
    updated_at: string
}

export interface Category {
    id: number
    name: string
    slug: string
    description: string | null
    image: string | null
    is_active: boolean
    sort_order: number
    created_at: string
    updated_at: string
}

export interface Product {
    id: number
    category_id: number
    name: string
    slug: string
    description: string | null
    price: number
    unit: string
    stock_quantity: number
    image: string | null
    is_available: boolean
    is_featured: boolean
    created_at: string
    updated_at: string
    category?: Category
}

export interface OrderItem {
    id: number
    order_id: number
    product_id: number
    quantity: number
    unit_price: number
    subtotal: number
    created_at: string
    updated_at: string
    product?: Product
}

export interface Order {
    id: number
    user_id: number
    order_number: string
    status: 'pending' | 'approved' | 'processing' | 'completed' | 'cancelled'
    subtotal: number
    tax: number
    delivery_fee: number
    total: number
    delivery_address: string | null
    delivery_date: string | null
    notes: string | null
    approved_at: string | null
    created_at: string
    updated_at: string
    user?: User
    items?: OrderItem[]
}

export interface Booking {
    id: number
    user_id: number
    booking_number: string
    type: 'tour' | 'event' | 'workshop' | 'private'
    booking_date: string
    booking_time: string
    number_of_people: number
    status: 'pending' | 'confirmed' | 'cancelled' | 'completed'
    special_requests: string | null
    total_price: number
    confirmed_at: string | null
    created_at: string
    updated_at: string
    user?: User
}

export interface DashboardStats {
    total_orders: number
    pending_orders: number
    total_revenue: number
    total_customers: number
    total_products: number
    pending_bookings: number
}
