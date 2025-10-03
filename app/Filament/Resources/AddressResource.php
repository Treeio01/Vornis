<?php

namespace App\Filament\Resources;

use App\Enums\AddressStatus;
use App\Filament\Resources\AddressResource\Pages;
use App\Filament\Resources\AddressResource\RelationManagers;
use App\Models\Address;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;

class AddressResource extends Resource
{
    protected static ?string $model = Address::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationLabel = 'Адреса';
    protected static ?string $modelLabel = 'Адрес';
    protected static ?string $pluralModelLabel = 'Адреса';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('address')
                    ->label('Адрес')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->label('Статус')
                    ->options(AddressStatus::options())
                    ->required(),
                Forms\Components\TextInput::make('remark')
                    ->label('Замечание')
                    ->maxLength(255),
                Forms\Components\TextInput::make('reward')
                    ->label('Награда')
                    ->numeric()
                    ->prefix('$VOR'),
                Forms\Components\TextInput::make('token')
                    ->label('Токен')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('user_id')
                    ->label('Пользователь')
                    ->relationship('user', 'email')
                    ->required(),
                Forms\Components\Textarea::make('comment')
                    ->label('Комментарий')
                    ->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('Адрес')
                    ->searchable()
                    ->copyable()
                    ->limit(20),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Статус')
                    ->colors(AddressStatus::colorMap()),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Пользователь')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reward')
                    ->label('Награда')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('remark')
                    ->label('Замечание')
                    ->limit(30),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options(AddressStatus::options()),
            ])
            ->actions([
                Action::make('mark_scam')
                    ->label('SCAM')
                    ->color('danger')
                    ->icon('heroicon-o-x-mark')
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\TextInput::make('remark')
                            ->label('Замечание')
                            ->required(),
                        Forms\Components\TextInput::make('reward')
                            ->label('Награда')
                            ->numeric()
                            ->default(0),
                    ])
                    ->action(function (Address $record, array $data) {
                        $record->update([
                            'status' => AddressStatus::Scam,
                            'remark' => $data['remark'],
                            'reward' => $data['reward'],
                        ]);

                        // Обновляем баланс пользователя
                        $user = User::find($record->user_id);
                        if ($user) {
                            $user->increment('balance', $data['reward']);
                        }

                        Notification::make()
                            ->title('Адрес помечен как SCAM')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Address $record) => $record->status !== AddressStatus::Scam),

                Action::make('mark_verified')
                    ->label('VERIFIED')
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\TextInput::make('remark')
                            ->label('Замечание')
                            ->required(),
                        Forms\Components\TextInput::make('reward')
                            ->label('Награда')
                            ->numeric()
                            ->default(0),
                    ])
                    ->action(function (Address $record, array $data) {
                        $record->update([
                            'status' => AddressStatus::Verified,
                            'remark' => $data['remark'],
                            'reward' => $data['reward'],
                        ]);

                        // Обновляем баланс пользователя
                        $user = User::find($record->user_id);
                        if ($user) {
                            $user->increment('balance', $data['reward']);
                        }

                        Notification::make()
                            ->title('Адрес помечен как VERIFIED')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Address $record) => $record->status !== AddressStatus::Verified),

                Action::make('mark_pending')
                    ->label('PENDING')
                    ->color('warning')
                    ->icon('heroicon-o-clock')
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\TextInput::make('remark')
                            ->label('Замечание')
                            ->required(),
                        Forms\Components\TextInput::make('reward')
                            ->label('Награда')
                            ->numeric()
                            ->default(0),
                    ])
                    ->action(function (Address $record, array $data) {
                        $record->update([
                            'status' => AddressStatus::Pending,
                            'remark' => $data['remark'],
                            'reward' => $data['reward'],
                        ]);

                        // Обновляем баланс пользователя
                        $user = User::find($record->user_id);
                        if ($user) {
                            $user->increment('balance', $data['reward']);
                        }

                        Notification::make()
                            ->title('Адрес помечен как PENDING')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Address $record) => $record->status !== AddressStatus::Pending),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListAddresses::route('/'),
            'create' => Pages\CreateAddress::route('/create'),
            'edit' => Pages\EditAddress::route('/{record}/edit'),
        ];
    }
}
