<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreRemoteSalesApplicationRequest;
use App\Models\RemoteSalesApplication;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

final class RemoteSalesApplicationController extends Controller
{
    public function index(): View
    {
        return view('remote-sales.index', [
            'englishLevels' => RemoteSalesApplication::englishLevels(),
        ]);
    }

    public function store(StoreRemoteSalesApplicationRequest $request): RedirectResponse
    {
        RemoteSalesApplication::query()->create([
            'telegram_username' => $request->string('telegram_username')->toString(),
            'english_level' => $request->string('english_level')->toString(),
            'sales_experience' => $request->string('sales_experience')->toString(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()
            ->route('remote-sales.index')
            ->with('success', 'Your application has been submitted successfully.');
    }
}
