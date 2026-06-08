<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreRemoteSalesApplicationRequest;
use App\Mail\NewRemoteSalesApplicationMail;
use App\Models\RemoteSalesApplication;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use App\Services\Meta\MetaConversionsApiService;
use App\Services\Meta\MetaEventIdFactory;

final class RemoteSalesApplicationController extends Controller
{
    public function index(): View
    {
        return view('remote-sales.index', [
            'englishLevels' => RemoteSalesApplication::englishLevels(),
        ]);
    }

    public function store(
        StoreRemoteSalesApplicationRequest $request,
        MetaEventIdFactory $eventIdFactory,
        MetaConversionsApiService $metaConversionsApiService,
    ): RedirectResponse|JsonResponse {
        $application = RemoteSalesApplication::query()->create([
            'telegram_username' => $request->string('telegram_username')->toString(),
            'english_level' => $request->string('english_level')->toString(),
            'sales_experience' => $request->string('sales_experience')->toString(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $eventId = $eventIdFactory->makeLeadEventId();

        $metaConversionsApiService->sendLead(
            application: $application,
            request: $request,
            eventId: $eventId,
        );

        $notificationEmail = config('remote-sales.notification_email');

        if (is_string($notificationEmail) && $notificationEmail !== '') {
            Mail::to($notificationEmail)->send(
                new NewRemoteSalesApplicationMail($application)
            );
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Your application has been submitted successfully. We will review your experience and contact you on Telegram if there is a fit.',
                'meta_event_id' => $eventId,
            ]);
        }

        return redirect()
            ->route('remote-sales.index')
            ->with('success', 'Your application has been submitted successfully.');
    }
}
