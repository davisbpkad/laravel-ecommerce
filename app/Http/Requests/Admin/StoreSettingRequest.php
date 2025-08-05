<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'settings' => 'required|array',
            'settings.store_name' => 'nullable|string|max:255',
            'settings.store_description' => 'nullable|string|max:500',
            'settings.store_email' => 'nullable|email|max:255',
            'settings.store_phone' => 'nullable|string|max:20',
            'settings.store_address' => 'nullable|string|max:500',
            'settings.currency' => 'nullable|string|max:10',
            'settings.currency_symbol' => 'nullable|string|max:5',
            'settings.free_shipping_threshold' => 'nullable|numeric|min:0',
            'settings.standard_shipping_cost' => 'nullable|numeric|min:0',
            'settings.express_shipping_cost' => 'nullable|numeric|min:0',
            'settings.seo_title' => 'nullable|string|max:255',
            'settings.seo_description' => 'nullable|string|max:500',
            'settings.seo_keywords' => 'nullable|string|max:500',
            'settings.facebook_url' => 'nullable|url|max:255',
            'settings.instagram_url' => 'nullable|url|max:255',
            'settings.twitter_url' => 'nullable|url|max:255',
            'settings.maintenance_mode' => 'nullable|boolean',
            'settings.maintenance_message' => 'nullable|string|max:500',
            'settings.store_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'settings.store_name.required' => 'Store name is required.',
            'settings.store_email.email' => 'Please enter a valid email address.',
            'settings.free_shipping_threshold.numeric' => 'Free shipping threshold must be a number.',
            'settings.standard_shipping_cost.numeric' => 'Standard shipping cost must be a number.',
            'settings.express_shipping_cost.numeric' => 'Express shipping cost must be a number.',
            'settings.facebook_url.url' => 'Please enter a valid Facebook URL.',
            'settings.instagram_url.url' => 'Please enter a valid Instagram URL.',
            'settings.twitter_url.url' => 'Please enter a valid Twitter URL.',
            'settings.store_logo.image' => 'Store logo must be an image file.',
            'settings.store_logo.mimes' => 'Store logo must be a file of type: jpeg, png, jpg, gif.',
            'settings.store_logo.max' => 'Store logo may not be greater than 2MB.',
        ];
    }
}
