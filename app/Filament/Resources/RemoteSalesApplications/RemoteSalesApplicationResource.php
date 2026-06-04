<?php

declare(strict_types=1);

namespace App\Filament\Resources\RemoteSalesApplications;

use App\Filament\Resources\RemoteSalesApplications\Pages\ListRemoteSalesApplications;
use App\Filament\Resources\RemoteSalesApplications\Pages\ViewRemoteSalesApplication;
use App\Models\RemoteSalesApplication;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

final class RemoteSalesApplicationResource extends Resource
{
    protected static ?string $model = RemoteSalesApplication::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-phone-arrow-up-right';

    protected static ?string $navigationLabel = 'Applications';

    protected static ?string $modelLabel = 'Application';

    protected static ?string $pluralModelLabel = 'Applications';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Application')
                    ->schema([
                        TextInput::make('telegram_username')
                            ->label('Telegram Username')
                            ->disabled(),

                        TextInput::make('english_level')
                            ->label('English Level')
                            ->disabled(),

                        Textarea::make('sales_experience')
                            ->label('Sales Experience')
                            ->rows(8)
                            ->disabled()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Admin')
                    ->schema([
                        Toggle::make('is_favorite')
                            ->label('Favorite'),

                        DateTimePicker::make('viewed_at')
                            ->label('Viewed At')
                            ->disabled(),
                    ])
                    ->columns(2),

                Section::make('Technical')
                    ->schema([
                        TextInput::make('ip_address')
                            ->label('IP Address')
                            ->disabled(),

                        Textarea::make('user_agent')
                            ->label('User Agent')
                            ->disabled()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('telegram_username')
                    ->label('Telegram')
                    ->html()
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(
                        static function (
                            string $state,
                            RemoteSalesApplication $record,
                            ListRemoteSalesApplications $livewire,
                        ): HtmlString {
                            $telegram = e($state);

                            if (!$livewire->isNewApplication((int) $record->id)) {
                                return new HtmlString(
                                    '<span style="font-weight: 700;">' . $telegram . '</span>'
                                );
                            }

                            return new HtmlString(
                                '<div style="display: inline-flex; align-items: center; gap: 8px;">'
                                . '<span style="font-weight: 700;">' . $telegram . '</span>'
                                . '<span style="
                        display: inline-flex;
                        align-items: center;
                        padding: 3px 8px;
                        border-radius: 999px;
                        background: #dc2626;
                        color: #ffffff;
                        font-size: 11px;
                        font-weight: 800;
                        line-height: 1;
                        text-transform: uppercase;
                        letter-spacing: 0.04em;
                    ">New</span>'
                                . '</div>'
                            );
                        }
                    ),

                TextColumn::make('english_level')
                    ->label('English')
                    ->badge()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),

                IconColumn::make('is_favorite')
                    ->label('')
                    ->alignCenter()
                    ->state(static fn(RemoteSalesApplication $record): bool => $record->is_favorite)
                    ->icon(
                        static fn(bool $state): string => $state
                            ? 'heroicon-s-star'
                            : 'heroicon-o-star'
                    )
                    ->color(
                        static fn(bool $state): string => $state
                            ? 'warning'
                            : 'gray'
                    )
                    ->tooltip(
                        static fn(RemoteSalesApplication $record): string => $record->is_favorite
                            ? 'Remove from favorites'
                            : 'Add to favorites'
                    )
                    ->action(static function (RemoteSalesApplication $record): void {
                        $record->toggleFavorite();
                    }),
            ])
            ->filters([

                Filter::make('favorite_only')
                    ->label('Favorite only')
                    ->query(
                        static fn(Builder $query): Builder => $query->where('is_favorite', true)
                    ),

                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('Created from'),

                        DatePicker::make('created_until')
                            ->label('Created until'),
                    ])
                    ->query(static function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'] ?? null,
                                static fn(Builder $query, string $date): Builder => $query->whereDate(
                                    'created_at',
                                    '>=',
                                    $date
                                ),
                            )
                            ->when(
                                $data['created_until'] ?? null,
                                static fn(Builder $query, string $date): Builder => $query->whereDate(
                                    'created_at',
                                    '<=',
                                    $date
                                ),
                            );
                    }),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('View')
                    ->icon('heroicon-o-eye'),
            ]);
    }

    /**
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => ListRemoteSalesApplications::route('/'),
            'view' => ViewRemoteSalesApplication::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }
}
