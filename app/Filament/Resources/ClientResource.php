<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    // Cambia el nombre en la navegación
    protected static ?string $navigationLabel = 'Clientes';

    // Cambia el nombre en plural
    protected static ?string $pluralModelLabel = 'Clientes';

    // Cambia el nombre en singular
    protected static ?string $modelLabel = 'Cliente';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')   
                    ->required(),
                Forms\Components\TextInput::make('last_name')
                    ->label('Apellido'),
                Forms\Components\TextInput::make('business_name')
                    ->label('Razón Social'),
                Forms\Components\TextInput::make('ruc')
                    ->label('RUC'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->label('Email'),
                Forms\Components\TextInput::make('phone')
                    ->label('Teléfono')
                    ->numeric()
                    ->inputMode('numeric')
                    ->placeholder('Ej: 0981123456')
                    ->mask('9999999999')
                    ->extraInputAttributes(['pattern' => '[0-9]*'])
                    ->maxLength(10),
                Forms\Components\Textarea::make('address')
                    ->label('Dirección'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Apellido')
                    ->searchable(),
                Tables\Columns\TextColumn::make('business_name')
                    ->label('Razón Social')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ruc')
                    ->label('RUC')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Teléfono')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'view' => Pages\ViewClient::route('/{record}'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }

    // Personaliza los títulos de las acciones
    public static function getModelLabel(): string
    {
        return 'Cliente';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Clientes';
    }

    public static function getNavigationLabel(): string
    {
        return 'Clientes';
    }

    public static function getCreateButtonLabel(): string
    {
        return 'Nuevo Cliente';
    }

    public static function getEditButtonLabel(): string
    {
        return 'Editar Cliente';
    }

    public static function getDeleteButtonLabel(): string
    {
        return 'Eliminar Cliente';
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
