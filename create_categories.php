<?php

$categories = [
    [
        'name' => 'Electronics',
        'description' => 'Electronic devices, gadgets, and accessories'
    ],
    [
        'name' => 'Clothing',
        'description' => 'Fashion and apparel for men, women, and children'
    ],
    [
        'name' => 'Books',
        'description' => 'Books, magazines, and reading materials'
    ],
    [
        'name' => 'Home & Garden',
        'description' => 'Home improvement, furniture, and garden supplies'
    ],
    [
        'name' => 'Sports & Fitness',
        'description' => 'Sports equipment, fitness gear, and outdoor activities'
    ]
];

foreach ($categories as $category) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/categories');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($category));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "Created category '{$category['name']}' - HTTP {$httpCode}\n";
    if ($httpCode !== 201) {
        echo "Response: {$response}\n";
    }
}

echo "Done creating categories!\n";
