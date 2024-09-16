<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->label('Proyecto:')
                    ->required(),
                Forms\Components\Select::make('client_id')
                    ->label('Cliente:')
                    ->relationship('clients', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Section::make()
                        ->schema([
                            Forms\Components\TextInput::make('name')
                            ->label('Nombre Cliente:')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('id_type')
                            ->label('Tipo de identificación:')
                            ->options([
                                'ci' => 'Cedula de Identidad',
                                'ruc' => 'R.U.C',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('number')
                            ->label('Numero:')
                            ->placeholder('Número de RUC o CI'),
                        Forms\Components\TextInput::make('email')
                            ->label('Correo Electrónico:')
                            ->email(),
                        Forms\Components\TextInput::make('phone')
                            ->label('Tel:')
                            ->tel()
                            ->placeholder('0975555555')
                            ->required(),
                        Forms\Components\TextInput::make('address')
                            ->label('Dirección')
                            ->required(),
                        ])->columns(2),
                    ]),
                Section::make()->schema([
                    Forms\Components\Select::make('status')
                        ->label('Estado:')
                        ->options([
                            'on_hold' => 'En Espera',
                            'budget' => 'Presupuesto',
                            'pending' => 'Pendiente',
                            'in_proces' => 'En Proceso',
                            'completed' => 'Terminado'
                        ])
                        ->default('pending'),
                    Forms\Components\DatePicker::make('start_date')
                    ->label('Fecha Inicio:'),
                    Forms\Components\DatePicker::make('end_date')
                    ->label('Fecha de entrega:'),
                    Forms\Components\TextInput::make('price')
                        ->label('Precio')
                        ->placeholder(0)
                        ->prefix('₲'),
                ])->columns(4),

                Forms\Components\TextInput::make('url')
                    ->label('URL proyecto:')
                    ->placeholder('https://ejemplo.com')
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('description')
                    ->label('Descripcion:')
                    ->columnSpanFull(),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('client_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('url')
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'view' => Pages\ViewProject::route('/{record}'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
