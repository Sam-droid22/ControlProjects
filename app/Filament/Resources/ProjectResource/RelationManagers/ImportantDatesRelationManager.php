<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ImportantDatesRelationManager extends RelationManager
{
    protected static string $relationship = 'importantDates';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(6),
                Forms\Components\DatePicker::make('date')
                    ->required()
                    ->columnSpan(6),
                Forms\Components\DatePicker::make('reminder_date')
                    ->label('Fecha de recordatorio')
                    ->nullable()
                    ->beforeOrEqual('date')
                    ->columnSpan(6),
                Forms\Components\Select::make('type')
                    ->options([
                        'general' => 'General',
                        'payment' => 'Pago',
                        'collection' => 'Cobro',
                    ])
                    ->required()
                    ->columnSpan(6),
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
                Forms\Components\Textarea::make('description')
                    ->columnSpan(12),
            ])
            ->columns(12);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('date')
                    ->date(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('amount')
                    ->money('PYG')
                    ->label('Monto'),
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
