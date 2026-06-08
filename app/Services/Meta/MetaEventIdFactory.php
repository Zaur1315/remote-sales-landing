<?php

declare(strict_types=1);

namespace App\Services\Meta;

use Illuminate\Support\Str;

final class MetaEventIdFactory
{
    public function makeLeadEventId(): string
    {
        return 'lead_' . Str::uuid()->toString();
    }
}
