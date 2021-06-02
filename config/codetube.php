<?php

return [
    'buckets' => [
        'videos' => env('AWS_URL') . env('AWS_BUCKET_VIDEOS'),
        'images' => env('AWS_URL') . env('AWS_BUCKET')
    ]
];