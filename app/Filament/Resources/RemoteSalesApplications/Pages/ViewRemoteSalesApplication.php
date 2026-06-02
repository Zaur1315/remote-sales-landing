<?php

declare(strict_types=1);

namespace App\Filament\Resources\RemoteSalesApplications\Pages;

use App\Filament\Resources\RemoteSalesApplications\RemoteSalesApplicationResource;
use App\Models\RemoteSalesApplication;
use Filament\Resources\Pages\ViewRecord;

final class ViewRemoteSalesApplication extends ViewRecord
{
    protected static string $resource = RemoteSalesApplicationResource::class;

    protected function afterMount(): void
    {
        $record = $this->getRecord();

        if (!$record instanceof RemoteSalesApplication) {
            return;
        }

        $record->markAsViewed();
    }
}
