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
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                IconColumn::make('is_favorite')
                    ->label('Favorite')
                    ->boolean()
                    ->sortable(),

                IconColumn::make('viewed_at')
                    ->label('Viewed')
                    ->boolean()
                    ->getStateUsing(
                        static fn(RemoteSalesApplication $record): bool => $record->viewed_at !== null
                    )
                    ->sortable(),

                TextColumn::make('telegram_username')
                    ->label('Telegram')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('english_level')
                    ->label('English')
                    ->badge()
                    ->sortable(),

                TextColumn::make('sales_experience')
                    ->label('Experience')
                    ->limit(80)
                    ->wrap()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('unread_only')
                    ->label('Unread only')
                    ->query(
                        static fn(Builder $query): Builder => $query->whereNull('viewed_at')
                    ),

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
                                static fn(Builder $query, string $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'] ?? null,
                                static fn(Builder $query, string $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->recordActions([
                ViewAction::make(),

                Action::make('toggle_favorite')
                    ->label(
                        static fn(RemoteSalesApplication $record): string => $record->is_favorite
                            ? 'Unfavorite'
                            : 'Favorite'
                    )
                    ->icon('heroicon-o-star')
                    ->color(
                        static fn(RemoteSalesApplication $record): string => $record->is_favorite
                            ? 'gray'
                            : 'warning'
                    )
                    ->action(static function (RemoteSalesApplication $record): void {
                        $record->toggleFavorite();
                    }),

                Action::make('mark_unread')
                    ->label('Mark unread')
                    ->icon('heroicon-o-eye-slash')
                    ->color('gray')
                    ->visible(
                        static fn(RemoteSalesApplication $record): bool => $record->viewed_at !== null
                    )
                    ->action(static function (RemoteSalesApplication $record): void {
                        $record->markAsUnread();
                    }),
            ]);
    }

    /**
     * @return array<string, \Filament\Resources\Pages\PageRegistration>
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
