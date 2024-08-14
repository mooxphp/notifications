<?php

namespace Moox\Notification\Resources;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Moox\Notification\Models\Notification;
use Moox\Notification\Resources\NotificationResource\Pages\CreateNotification;
use Moox\Notification\Resources\NotificationResource\Pages\EditNotification;
use Moox\Notification\Resources\NotificationResource\Pages\ListNotifications;
use Moox\Notification\Resources\NotificationResource\Pages\ViewNotification;
use Moox\Notification\Resources\NotificationResource\Widgets\NotificationWidgets;

class NotificationResource extends Resource
{
    protected static ?string $model = Notification::class;

    protected static ?string $navigationIcon = 'gmdi-notifications';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('type')
                    ->label(__('core::core.type')),
                TextInput::make('notifiable_type')
                    ->label(__('core::notifications.notifiable_type')),
                TextInput::make('notifiable_id')
                    ->label(__('core::notifications.notifiable_id')),
                TextInput::make('data')
                    ->label(__('core::core.data')),
                DatePicker::make('read_at')
                    ->label(__('core::core.read_at')),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->label(__('core::core.type')),
                TextColumn::make('notifiable_type')
                    ->label(__('core::notifications.notifiable_type')),
                TextColumn::make('notifiable_id')
                    ->label(__('core::notifications.notifiable_id'))
                    ->sortable(),
                TextColumn::make('data')
                    ->label(__('core::core.data')),
                TextColumn::make('read_at')
                    ->label(__('core::core.read_at')),

            ])->searchable()
            ->defaultSort('type', 'desc')
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNotifications::route('/'),
            'create' => CreateNotification::route('/create'),
            'view' => ViewNotification::route('/{record}'),
            'edit' => EditNotification::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            NotificationWidgets::class,
        ];
    }

    public static function getModelLabel(): string
    {
        return config('notifications.resources.notifications.single');
    }

    public static function getPluralModelLabel(): string
    {
        return config('notifications.resources.notifications.plural');
    }

    public static function getNavigationLabel(): string
    {
        return config('notifications.resources.notifications.plural');
    }

    public static function getBreadcrumb(): string
    {
        return config('notifications.resources.notifications.single');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function getNavigationBadge(): ?string
    {
        return number_format(static::getModel()::count());
    }

    public static function getNavigationGroup(): ?string
    {
        return config('notifications.navigation_group');
    }

    public static function getNavigationSort(): ?int
    {
        return config('notifications.navigation_sort') + 2;
    }
}
