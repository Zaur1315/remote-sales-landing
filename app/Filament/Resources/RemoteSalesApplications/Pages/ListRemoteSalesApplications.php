<?php

declare(strict_types=1);

namespace App\Filament\Resources\RemoteSalesApplications\Pages;

use App\Filament\Resources\RemoteSalesApplications\RemoteSalesApplicationResource;
use App\Models\RemoteSalesApplication;
use Filament\Resources\Pages\ListRecords;

final class ListRemoteSalesApplications extends ListRecords
{
    protected static string $resource = RemoteSalesApplicationResource::class;

    /**
     * @var array<int, int>
     */
    public array $newApplicationIds = [];

    public function mount(): void
    {
        $this->newApplicationIds = RemoteSalesApplication::query()
            ->whereNull('viewed_at')
            ->pluck('id')
            ->map(static fn($id): int => (int) $id)
            ->all();

        if ($this->newApplicationIds === []) {
            return;
        }

        RemoteSalesApplication::query()
            ->whereIn('id', $this->newApplicationIds)
            ->whereNull('viewed_at')
            ->update([
                'viewed_at' => now(),
                'updated_at' => now(),
            ]);
    }

    public function isNewApplication(int $applicationId): bool
    {
        return in_array($applicationId, $this->newApplicationIds, true);
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
