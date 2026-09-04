<?php

return [

    'cloud' => env('CLOUDINARY_CLOUD_NAME'),

    'key' => env('CLOUDINARY_KEY'),

    'secret' => env('CLOUDINARY_SECRET'),

    'secure' => env('CLOUDINARY_SECURE', true),

    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL'),

    'cloud_url' => env('CLOUDINARY_URL'),

    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),

    'upload_route' => env('CLOUDINARY_UPLOAD_ROUTE'),

    'upload_action' => env('CLOUDINARY_UPLOAD_ACTION'),

];