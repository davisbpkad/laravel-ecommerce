<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSettingRequest;
use App\Models\StoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class StoreSettingController extends Controller
{
    /**
     * Display store settings page
     */
    public function index()
    {
        $settings = StoreSetting::getAllGrouped();
        
        return Inertia::render('Admin/Settings/Store', [
            'settings' => $settings
        ]);
    }

    /**
     * Update store settings
     */
    public function update(StoreSettingRequest $request)
    {
        try {
            $data = $request->validated();
            
            foreach ($data['settings'] as $key => $value) {
                $setting = StoreSetting::where('key', $key)->first();
                
                if ($setting) {
                    // Handle image uploads
                    if ($setting->type === 'image' && $request->hasFile("settings.{$key}")) {
                        // Delete old image if exists
                        if ($setting->value) {
                            Storage::disk('public')->delete($setting->value);
                        }
                        
                        // Store new image
                        $path = $request->file("settings.{$key}")->store('settings', 'public');
                        $value = $path;
                    }
                    
                    // Cast boolean values
                    if ($setting->type === 'boolean') {
                        $value = $value ? '1' : '0';
                    }
                    
                    $setting->update(['value' => $value]);
                }
            }

            return redirect()->back()->with('success', 'Store settings updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update store settings: ' . $e->getMessage());
        }
    }

    /**
     * Get public settings for frontend
     */
    public function getPublicSettings()
    {
        return response()->json(StoreSetting::getPublic());
    }

    /**
     * Upload image for settings
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'key' => 'required|string'
        ]);

        try {
            $setting = StoreSetting::where('key', $request->key)->first();
            
            if (!$setting || $setting->type !== 'image') {
                return response()->json(['error' => 'Invalid setting key'], 400);
            }

            // Delete old image if exists
            if ($setting->value) {
                Storage::disk('public')->delete($setting->value);
            }

            // Store new image
            $path = $request->file('image')->store('settings', 'public');
            $setting->update(['value' => $path]);

            return response()->json([
                'success' => true,
                'path' => $path,
                'url' => Storage::url($path)
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to upload image: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Reset settings to default
     */
    public function reset(Request $request)
    {
        $request->validate([
            'group' => 'required|string'
        ]);

        try {
            $group = $request->group;
            
            // Get default settings for the group
            $defaultSettings = $this->getDefaultSettings()[$group] ?? [];
            
            foreach ($defaultSettings as $setting) {
                StoreSetting::updateOrCreate(
                    ['key' => $setting['key']],
                    $setting
                );
            }

            return redirect()->back()->with('success', ucfirst($group) . ' settings have been reset to default.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to reset settings: ' . $e->getMessage());
        }
    }

    /**
     * Get default settings grouped by category
     */
    private function getDefaultSettings()
    {
        // This would typically come from a config file or database
        // For now, we'll return the same structure as the seeder
        return [
            'general' => [
                ['key' => 'store_name', 'value' => 'E-Shop', 'type' => 'text', 'group' => 'general', 'label' => 'Store Name', 'description' => 'The name of your online store', 'is_public' => true],
                // ... other general settings
            ],
            // ... other groups
        ];
    }
}
