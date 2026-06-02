<?php

namespace App\Filament\Resources\RemoteSalesApplications\Pages;

use App\Filament\Resources\RemoteSalesApplications\RemoteSalesApplicationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRemoteSalesApplication extends EditRecord
{
    protected static string $resource = RemoteSalesApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
