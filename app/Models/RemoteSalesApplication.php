<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $telegram_username
 * @property string $english_level
 * @property string $sales_experience
 * @property bool $is_favorite
 * @property Carbon|null $viewed_at
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
final class RemoteSalesApplication extends Model
{
    public const ENGLISH_LEVEL_C1 = 'C1';
    public const ENGLISH_LEVEL_C2 = 'C2';
    public const ENGLISH_LEVEL_NATIVE = 'Native';

    protected $fillable = [
        'telegram_username',
        'english_level',
        'sales_experience',
        'is_favorite',
        'viewed_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'is_favorite' => 'boolean',
        'viewed_at' => 'datetime',
    ];

    /**
     * @return array<int, string>
     */
    public static function englishLevels(): array
    {
        return [
            self::ENGLISH_LEVEL_C1,
            self::ENGLISH_LEVEL_C2,
            self::ENGLISH_LEVEL_NATIVE,
        ];
    }

    public function isViewed(): bool
    {
        return $this->viewed_at !== null;
    }

    public function markAsViewed(): void
    {
        if ($this->viewed_at !== null) {
            return;
        }

        $this->forceFill([
            'viewed_at' => now(),
        ])->save();
    }

    public function markAsUnread(): void
    {
        $this->forceFill([
            'viewed_at' => null,
        ])->save();
    }

    public function toggleFavorite(): void
    {
        $this->forceFill([
            'is_favorite' => ! $this->is_favorite,
        ])->save();
    }
}
