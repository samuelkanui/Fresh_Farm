<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@freshfarms.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Test Customer
        $customer = User::create([
            'name' => 'John Customer',
            'email' => 'customer@example.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Fresh Vegetables', 'slug' => 'fresh-vegetables', 'description' => 'Farm-fresh organic vegetables', 'sort_order' => 1],
            ['name' => 'Fresh Fruits', 'slug' => 'fresh-fruits', 'description' => 'Seasonal fruits picked daily', 'sort_order' => 2],
            ['name' => 'Dairy Products', 'slug' => 'dairy-products', 'description' => 'Fresh dairy from our farm', 'sort_order' => 3],
            ['name' => 'Eggs & Poultry', 'slug' => 'eggs-poultry', 'description' => 'Free-range eggs and poultry', 'sort_order' => 4],
            ['name' => 'Herbs & Spices', 'slug' => 'herbs-spices', 'description' => 'Fresh herbs and organic spices', 'sort_order' => 5],
            ['name' => 'Honey & Preserves', 'slug' => 'honey-preserves', 'description' => 'Natural honey and homemade preserves', 'sort_order' => 6],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Create Products
        $vegetables = Category::where('slug', 'fresh-vegetables')->first();
        $fruits = Category::where('slug', 'fresh-fruits')->first();
        $dairy = Category::where('slug', 'dairy-products')->first();
        $eggs = Category::where('slug', 'eggs-poultry')->first();
        $herbs = Category::where('slug', 'herbs-spices')->first();
        $honey = Category::where('slug', 'honey-preserves')->first();

        $products = [
            // Vegetables
            ['category_id' => $vegetables->id, 'name' => 'Organic Tomatoes', 'slug' => 'organic-tomatoes', 'description' => 'Fresh organic tomatoes', 'price' => 3.99, 'unit' => 'kg', 'stock_quantity' => 100, 'is_featured' => true],
            ['category_id' => $vegetables->id, 'name' => 'Fresh Lettuce', 'slug' => 'fresh-lettuce', 'description' => 'Crispy green lettuce', 'price' => 2.49, 'unit' => 'head', 'stock_quantity' => 80, 'is_featured' => false],
            ['category_id' => $vegetables->id, 'name' => 'Organic Carrots', 'slug' => 'organic-carrots', 'description' => 'Sweet organic carrots', 'price' => 2.99, 'unit' => 'kg', 'stock_quantity' => 120, 'is_featured' => true],
            ['category_id' => $vegetables->id, 'name' => 'Bell Peppers', 'slug' => 'bell-peppers', 'description' => 'Colorful bell peppers', 'price' => 4.99, 'unit' => 'kg', 'stock_quantity' => 60, 'is_featured' => false],
            
            // Fruits
            ['category_id' => $fruits->id, 'name' => 'Fresh Strawberries', 'slug' => 'fresh-strawberries', 'description' => 'Sweet seasonal strawberries', 'price' => 5.99, 'unit' => 'kg', 'stock_quantity' => 50, 'is_featured' => true],
            ['category_id' => $fruits->id, 'name' => 'Organic Apples', 'slug' => 'organic-apples', 'description' => 'Crisp organic apples', 'price' => 3.49, 'unit' => 'kg', 'stock_quantity' => 150, 'is_featured' => false],
            ['category_id' => $fruits->id, 'name' => 'Blueberries', 'slug' => 'blueberries', 'description' => 'Fresh blueberries', 'price' => 7.99, 'unit' => 'kg', 'stock_quantity' => 40, 'is_featured' => true],
            
            // Dairy
            ['category_id' => $dairy->id, 'name' => 'Fresh Milk', 'slug' => 'fresh-milk', 'description' => 'Farm-fresh whole milk', 'price' => 4.99, 'unit' => 'liter', 'stock_quantity' => 100, 'is_featured' => true],
            ['category_id' => $dairy->id, 'name' => 'Organic Cheese', 'slug' => 'organic-cheese', 'description' => 'Handmade organic cheese', 'price' => 8.99, 'unit' => 'kg', 'stock_quantity' => 30, 'is_featured' => false],
            ['category_id' => $dairy->id, 'name' => 'Greek Yogurt', 'slug' => 'greek-yogurt', 'description' => 'Creamy Greek yogurt', 'price' => 3.99, 'unit' => 'kg', 'stock_quantity' => 60, 'is_featured' => false],
            
            // Eggs & Poultry
            ['category_id' => $eggs->id, 'name' => 'Free-Range Eggs', 'slug' => 'free-range-eggs', 'description' => 'Fresh free-range eggs', 'price' => 6.99, 'unit' => 'dozen', 'stock_quantity' => 200, 'is_featured' => true],
            ['category_id' => $eggs->id, 'name' => 'Organic Chicken', 'slug' => 'organic-chicken', 'description' => 'Organic free-range chicken', 'price' => 12.99, 'unit' => 'kg', 'stock_quantity' => 25, 'is_featured' => false],
            
            // Herbs
            ['category_id' => $herbs->id, 'name' => 'Fresh Basil', 'slug' => 'fresh-basil', 'description' => 'Aromatic fresh basil', 'price' => 2.99, 'unit' => 'bunch', 'stock_quantity' => 50, 'is_featured' => false],
            ['category_id' => $herbs->id, 'name' => 'Organic Rosemary', 'slug' => 'organic-rosemary', 'description' => 'Fresh organic rosemary', 'price' => 3.49, 'unit' => 'bunch', 'stock_quantity' => 40, 'is_featured' => false],
            
            // Honey & Preserves
            ['category_id' => $honey->id, 'name' => 'Raw Honey', 'slug' => 'raw-honey', 'description' => 'Pure raw honey from our hives', 'price' => 12.99, 'unit' => 'jar', 'stock_quantity' => 80, 'is_featured' => true],
            ['category_id' => $honey->id, 'name' => 'Strawberry Jam', 'slug' => 'strawberry-jam', 'description' => 'Homemade strawberry jam', 'price' => 6.99, 'unit' => 'jar', 'stock_quantity' => 60, 'is_featured' => false],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        // Create Sample Order
        $order = Order::create([
            'user_id' => $customer->id,
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'status' => 'pending',
            'subtotal' => 23.97,
            'tax' => 2.40,
            'delivery_fee' => 5.00,
            'total' => 31.37,
            'delivery_address' => '123 Main St, City, State 12345',
            'delivery_date' => now()->addDays(3),
            'notes' => 'Please deliver in the morning',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => Product::where('slug', 'organic-tomatoes')->first()->id,
            'quantity' => 2,
            'unit_price' => 3.99,
            'subtotal' => 7.98,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => Product::where('slug', 'fresh-milk')->first()->id,
            'quantity' => 3,
            'unit_price' => 4.99,
            'subtotal' => 14.97,
        ]);

        // Create Sample Booking
        Booking::create([
            'user_id' => $customer->id,
            'booking_number' => 'BKG-' . strtoupper(uniqid()),
            'type' => 'tour',
            'booking_date' => now()->addDays(7),
            'booking_time' => '10:00:00',
            'number_of_people' => 4,
            'status' => 'pending',
            'special_requests' => 'Interested in organic farming techniques',
            'total_price' => 40.00,
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin: admin@freshfarms.com / password');
        $this->command->info('Customer: customer@example.com / password');
    }
}
