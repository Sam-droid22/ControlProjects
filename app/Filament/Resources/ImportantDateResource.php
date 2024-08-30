<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImportantDateResource\Pages;
use App\Filament\Resources\ImportantDateResource\RelationManagers;
use App\Models\ImportantDate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Resource;

class ImportantDateResource extends Resource
{
    protected static ?string $model = ImportantDate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->label('Fecha')
                    ->required(),
                Forms\Components\TextInput::make('description')
                    ->label('Descripción')
                    ->required(),
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'name')
                    ->label('Proyecto')
                    ->required(),
                Forms\Components\Select::make('transaction_id')
                    ->relationship('transaction', 'description')
                    ->label('Transacción')
                    ->required(),
                Forms\Components\Select::make('type')
                    ->label('Tipo')
                    ->options([
                        'general' => 'General',
                        'payment' => 'Pago',
                        'collection' => 'Cobro',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->label('Monto (en Guaraníes)')
                    // ->numeric()
                    ->prefix('₲')
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                        if ($state !== null) {
                            $numericValue = (int) preg_replace('/[^0-9]/', '', $state);
                            $formattedValue = number_format($numericValue, 0, '', '.');
                            $set('amount', $formattedValue);
                        }
                    })
                    ->formatStateUsing(function ($state) {
                        return $state ? number_format((int) $state, 0, '', '.') : null;
                    })
                    ->dehydrateStateUsing(fn($state) => preg_replace('/[^0-9]/', '', $state))
                    ->rules(['integer', 'min:0'])
                    ->placeholder('0'),
                // ->columnSpan(6),
                Forms\Components\ToggleButtons::make('is_reminder')
                    ->label('Recordatorio')
                    ->options([
                        'yes' => 'Sí',
                        'no' => 'No',
                    ])
                    ->required(),
                // ->columnSpan(6),
                Forms\Components\DatePicker::make('reminder_date')
                    ->label('Fecha de Recordatorio')
                    // ->columnSpan(1)
                    ->required()
                    ->hidden(fn(Get $get): bool => $get('is_reminder') === 'no'),
            ]);
        // ->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListImportantDates::route('/'),
            'create' => Pages\CreateImportantDate::route('/create'),
            'view' => Pages\ViewImportantDate::route('/{record}'),
            'edit' => Pages\EditImportantDate::route('/{record}/edit'),
        ];
    }
}
