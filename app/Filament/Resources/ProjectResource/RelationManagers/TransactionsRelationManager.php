<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'transactions';

    protected static ?string $recordTitleAttribute = 'id';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255)
                    ->label('Descripción'),
                Forms\Components\DatePicker::make('date')
                    ->required()
                    ->label('Fecha'),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->label('Monto (en Guaraníes)')
                    ->prefix('₲')
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
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
                Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'income' => 'Ingreso',
                        'expense' => 'Gasto',
                    ])
                    ->label('Tipo'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción'),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable()
                    ->label('Fecha'),
                Tables\Columns\TextColumn::make('amount')
                    ->money('PYG')
                    ->sortable()
                    ->label('Monto'),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->colors([
                        'success' => 'income',
                        'danger' => 'expense',
                    ])
                    ->enum([
                        'income' => 'Ingreso',
                        'expense' => 'Gasto',
                    ])
                    ->label('Tipo'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
