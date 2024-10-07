<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = Category::inRandomOrder()->first();

        return [
            'name' => $this->generateUniqueProductName($category->name),
            'category' => $category->name,
            'description' => $this->faker->sentence(),
          'date_time' => now()->format('Y-m-d'), 
            'stock' => $this->faker->numberBetween(1, 100), 
        ];
    }

    private function generateUniqueProductName($category)
    {
        $baseName = $this->faker->randomElement($this->getProductNamesByCategory($category));
        return $baseName . ' ' . $this->faker->unique()->numberBetween(1000, 9999); // Appends a unique 4-digit number
    }

    private function getProductNamesByCategory($category)
    {
        switch ($category) {
            case 'Electronics':
                return ['Smartphone Pro', 'Wireless Headphones', '4K Smart TV', 'Bluetooth Speaker', 'Gaming Laptop'];
            case 'Fashion':
                return ['Leather Jacket', 'Slim Fit Jeans', 'Designer Handbag', 'Sneakers', 'Silk Scarf'];
            case 'Health & Beauty':
                return ['Vitamin C Serum', 'Hydrating Face Mask', 'Organic Shampoo', 'Aloe Vera Gel', 'Rosewater Toner'];
            case 'Home & Kitchen':
                return ['Stainless Steel Cookware Set', 'Electric Kettle', 'Sofa Set', 'Memory Foam Mattress', 'Blender'];
            case 'Sports & Outdoors':
                return ['Mountain Bike', 'Yoga Mat', 'Running Shoes', 'Camping Tent', 'Fitness Tracker'];
            case 'Books & Media':
                return ['The Great Adventure', 'Mystery of the Lost City', 'Modern Philosophy', 'History of Science', 'Travel Guide'];
            case 'Automotive':
                return ['All-Weather Car Mats', 'LED Headlights', 'Motorcycle Helmet', 'Car Vacuum Cleaner', 'Engine Oil'];
            case 'Toys & Games':
                return ['Action Figure Set', 'Board Game', 'Puzzle for Kids', 'Remote Control Car', 'Building Blocks'];
            case 'Groceries':
                return ['Organic Apples', 'Whole Wheat Bread', 'Almond Milk', 'Granola Bars', 'Free-Range Eggs'];
            case 'Office Supplies':
                return ['Ergonomic Office Chair', 'Wireless Mouse', 'Notebook Planner', 'Gel Pens', 'Desk Organizer'];
            default:
                return $this->faker->words(3, true); 
        }
    }
}