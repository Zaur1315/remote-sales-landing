<?php

declare(strict_types=1);

namespace App\Services\Meta;

use App\Models\RemoteSalesApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class MetaConversionsApiService
{
    public function sendLead(
        RemoteSalesApplication $application,
        Request $request,
        string $eventId,
    ): void {
        if (!config('meta.capi_enabled')) {
            return;
        }

        $pixelId = config('meta.pixel_id');
        $accessToken = config('meta.capi_access_token');
        $apiVersion = config('meta.graph_api_version', 'v23.0');

        if (!is_string($pixelId) || $pixelId === '' || !is_string($accessToken) || $accessToken === '') {
            return;
        }

        $payload = [
            'data' => [
                [
                    'event_name' => 'Lead',
                    'event_time' => time(),
                    'event_id' => $eventId,
                    'action_source' => 'website',
                    'event_source_url' => $request->fullUrl(),
                    'user_data' => array_filter([
                        'client_ip_address' => $request->ip(),
                        'client_user_agent' => $request->userAgent(),
                        'fbp' => $request->cookie('_fbp'),
                        'fbc' => $request->cookie('_fbc'),
                    ]),
                    'custom_data' => [
                        'content_name' => 'Remote Sales Application',
                        'lead_type' => 'remote_sales_application',
                        'english_level' => $application->english_level,
                    ],
                ],
            ],
        ];

        try {
            $response = Http::timeout(8)
                ->asJson()
                ->post(
                    sprintf(
                        'https://graph.facebook.com/%s/%s/events',
                        $apiVersion,
                        $pixelId,
                    ),
                    array_merge($payload, [
                        'access_token' => $accessToken,
                    ]),
                );

            if (!$response->successful()) {
                Log::warning('Meta CAPI Lead event failed.', [
                    'application_id' => $application->id,
                    'status' => $response->status(),
                    'response' => $response->json(),
                ]);

                return;
            }

            Log::info('Meta CAPI Lead event sent.', [
                'application_id' => $application->id,
                'event_id' => $eventId,
                'response' => $response->json(),
            ]);
        } catch (\Throwable $exception) {
            Log::warning('Meta CAPI Lead event exception.', [
                'application_id' => $application->id,
                'event_id' => $eventId,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
