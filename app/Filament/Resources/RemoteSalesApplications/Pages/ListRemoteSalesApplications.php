<?php

declare(strict_types=1);

namespace App\Filament\Resources\RemoteSalesApplications\Pages;

use App\Filament\Resources\RemoteSalesApplications\RemoteSalesApplicationResource;
use Filament\Resources\Pages\ListRecords;

final class ListRemoteSalesApplications extends ListRecords
{
    protected static string $resource = RemoteSalesApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
