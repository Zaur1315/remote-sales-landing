<?php

declare(strict_types=1);

return [
    'pixel_enabled' => filter_var(env('META_PIXEL_ENABLED', false), FILTER_VALIDATE_BOOLEAN),
    'capi_enabled' => filter_var(env('META_CAPI_ENABLED', false), FILTER_VALIDATE_BOOLEAN),

    'pixel_id' => env('META_PIXEL_ID'),
    'pixel_name' => env('META_PIXEL_NAME'),

    'capi_access_token' => env('META_CAPI_ACCESS_TOKEN'),
    'graph_api_version' => env('META_GRAPH_API_VERSION', 'v23.0'),
];
