<?php

namespace Database\Seeders;

use App\Models\StoreSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'store_name',
                'value' => 'E-Shop',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Store Name',
                'description' => 'The name of your online store',
                'is_public' => true
            ],
            [
                'key' => 'store_description',
                'value' => 'Your Premier Online Shopping Destination',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Store Description',
                'description' => 'A brief description of your store',
                'is_public' => true
            ],
            [
                'key' => 'store_email',
                'value' => 'admin@eshop.com',
                'type' => 'email',
                'group' => 'general',
                'label' => 'Store Email',
                'description' => 'Primary contact email for your store',
                'is_public' => true
            ],
            [
                'key' => 'store_phone',
                'value' => '+62 21 1234 5678',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Store Phone',
                'description' => 'Primary contact phone number',
                'is_public' => true
            ],
            [
                'key' => 'store_address',
                'value' => 'Jl. Sudirman No. 123, Jakarta, Indonesia',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Store Address',
                'description' => 'Physical address of your store',
                'is_public' => true
            ],
            [
                'key' => 'store_logo',
                'value' => null,
                'type' => 'image',
                'group' => 'general',
                'label' => 'Store Logo',
                'description' => 'Upload your store logo',
                'is_public' => true
            ],
            [
                'key' => 'currency',
                'value' => 'IDR',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Currency',
                'description' => 'Store currency',
                'is_public' => true
            ],
            [
                'key' => 'currency_symbol',
                'value' => 'Rp',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Currency Symbol',
                'description' => 'Symbol for currency display',
                'is_public' => true
            ],

            // Shipping Settings
            [
                'key' => 'free_shipping_threshold',
                'value' => '100000',
                'type' => 'number',
                'group' => 'shipping',
                'label' => 'Free Shipping Threshold',
                'description' => 'Minimum order value for free shipping',
                'is_public' => true
            ],
            [
                'key' => 'standard_shipping_cost',
                'value' => '15000',
                'type' => 'number',
                'group' => 'shipping',
                'label' => 'Standard Shipping Cost',
                'description' => 'Cost for standard shipping',
                'is_public' => true
            ],
            [
                'key' => 'express_shipping_cost',
                'value' => '25000',
                'type' => 'number',
                'group' => 'shipping',
                'label' => 'Express Shipping Cost',
                'description' => 'Cost for express shipping',
                'is_public' => true
            ],

            // SEO Settings
            [
                'key' => 'seo_title',
                'value' => 'E-Shop - Your Premier Online Shopping Destination',
                'type' => 'text',
                'group' => 'seo',
                'label' => 'SEO Title',
                'description' => 'Default title for SEO',
                'is_public' => true
            ],
            [
                'key' => 'seo_description',
                'value' => 'Discover amazing products at great prices. Shop with confidence at E-Shop.',
                'type' => 'text',
                'group' => 'seo',
                'label' => 'SEO Description',
                'description' => 'Default meta description for SEO',
                'is_public' => true
            ],
            [
                'key' => 'seo_keywords',
                'value' => 'online shopping, e-commerce, products, deals',
                'type' => 'text',
                'group' => 'seo',
                'label' => 'SEO Keywords',
                'description' => 'Default meta keywords for SEO',
                'is_public' => true
            ],

            // Social Media
            [
                'key' => 'facebook_url',
                'value' => null,
                'type' => 'url',
                'group' => 'social',
                'label' => 'Facebook URL',
                'description' => 'Your Facebook page URL',
                'is_public' => true
            ],
            [
                'key' => 'instagram_url',
                'value' => null,
                'type' => 'url',
                'group' => 'social',
                'label' => 'Instagram URL',
                'description' => 'Your Instagram profile URL',
                'is_public' => true
            ],
            [
                'key' => 'twitter_url',
                'value' => null,
                'type' => 'url',
                'group' => 'social',
                'label' => 'Twitter URL',
                'description' => 'Your Twitter profile URL',
                'is_public' => true
            ],

            // Maintenance
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'maintenance',
                'label' => 'Maintenance Mode',
                'description' => 'Enable maintenance mode to disable public access',
                'is_public' => false
            ],
            [
                'key' => 'maintenance_message',
                'value' => 'We are currently performing maintenance. Please check back soon.',
                'type' => 'text',
                'group' => 'maintenance',
                'label' => 'Maintenance Message',
                'description' => 'Message to display during maintenance',
                'is_public' => false
            ]
        ];

        foreach ($settings as $setting) {
            StoreSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
