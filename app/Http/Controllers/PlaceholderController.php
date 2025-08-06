<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlaceholderController extends Controller
{
    /**
     * Generate placeholder image
     */
    public function image($width = 300, $height = null)
    {
        // Set default height to width if not provided (square)
        $height = $height ?: $width;
        
        // Validate dimensions
        $width = max(1, min(2000, (int)$width));
        $height = max(1, min(2000, (int)$height));
        
        // Create image
        $image = imagecreate($width, $height);
        
        // Set colors
        $background = imagecolorallocate($image, 240, 240, 240); // Light gray
        $textColor = imagecolorallocate($image, 120, 120, 120);   // Dark gray
        
        // Fill background
        imagefill($image, 0, 0, $background);
        
        // Add text
        $text = "{$width}x{$height}";
        $fontSize = max(10, min($width, $height) / 10);
        
        // Calculate text position (center)
        $textBox = imagettfbbox($fontSize, 0, $this->getFont(), $text);
        $textWidth = $textBox[4] - $textBox[0];
        $textHeight = $textBox[1] - $textBox[7];
        
        $x = ($width - $textWidth) / 2;
        $y = ($height - $textHeight) / 2 + $textHeight;
        
        // Add text to image
        imagettftext($image, $fontSize, 0, $x, $y, $textColor, $this->getFont(), $text);
        
        // Output image
        header('Content-Type: image/png');
        header('Cache-Control: public, max-age=31536000'); // Cache for 1 year
        
        imagepng($image);
        imagedestroy($image);
        
        return response('', 200, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'public, max-age=31536000'
        ]);
    }
    
    /**
     * Get font path (fallback to built-in)
     */
    private function getFont()
    {
        // Use built-in font if TTF not available
        return 5; // Built-in font
    }
    
    /**
     * SVG placeholder (alternative method)
     */
    public function svg($width = 300, $height = null)
    {
        $height = $height ?: $width;
        
        $width = max(1, min(2000, (int)$width));
        $height = max(1, min(2000, (int)$height));
        
        $svg = '<?xml version="1.0" encoding="UTF-8"?>
        <svg width="' . $width . '" height="' . $height . '" xmlns="http://www.w3.org/2000/svg">
            <rect width="100%" height="100%" fill="#f0f0f0"/>
            <text x="50%" y="50%" font-family="Arial, sans-serif" font-size="' . max(10, min($width, $height) / 10) . '" fill="#999" text-anchor="middle" dy="0.3em">' . $width . 'x' . $height . '</text>
        </svg>';
        
        return response($svg, 200, [
            'Content-Type' => 'image/svg+xml',
            'Cache-Control' => 'public, max-age=31536000'
        ]);
    }
}
