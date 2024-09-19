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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre Cliente:')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('id_type')
                    ->label('Tipo de identificación:')
                    ->options([
                        'ruc' => 'R.U.C',
                        'ci' => 'Cedula de Identidad',
                    ])
                    ->default('ci')
                    ->required(),
                Forms\Components\TextInput::make('id_number')
                    ->label('Número:')
                    ->inputMode('numeric')
                    ->placeholder('RUC o C.I.')
                    ->mask('9999999-9')
                    ->extraInputAttributes(['pattern' => '[0-9\-]*'])
                    ->maxLength(11),
                Forms\Components\TextInput::make('email')
                    ->label('Correo Electrónico:')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->label('Tel:')
                    ->tel()
                    ->prefix(+595)
                    ->mask('999999999')
                    ->placeholder('Ej: 975555555')
                    ->maxLength(9)
                    ->required(),
                Forms\Components\TextInput::make('address')
                    ->label('Dirección')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre Cliente')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Cel')
                    ->searchable()
                    ->url(fn($record) => 'https://wa.me/' . preg_replace('/[^0-9]/', '', $record->phone), true)
                    ->openUrlInNewTab()
                    ->color('success')
                    ->width('bold'),
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'view' => Pages\ViewClient::route('/{record}'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
