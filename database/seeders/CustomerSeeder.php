<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder{
    public function run(): void
    {
        $customers = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '+1 (555) 123-4567',
                'address' => '123 Main St',
                'city' => 'New York',
                'state' => 'NY',
                'zip_code' => '10001',
                'country' => 'USA',
                'company' => 'Tech Corp',
                'status' => 'active',
                'total_spent' => 1250.50,
                'total_orders' => 5
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '+1 (555) 987-6543',
                'address' => '456 Oak Ave',
                'city' => 'Los Angeles',
                'state' => 'CA',
                'zip_code' => '90001',
                'country' => 'USA',
                'company' => 'Design Studio',
                'status' => 'active',
                'total_spent' => 890.75,
                'total_orders' => 3
            ]
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
