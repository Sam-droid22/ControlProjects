<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectsResource\Pages;
use App\Filament\Resources\ProjectsResource\RelationManagers;
use App\Models\Project;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ClientResource;
use App\Filament\Resources\ProjectResource\RelationManagers\ImportantDatesRelationManager;
use App\Filament\Resources\ProjectResource\RelationManagers\TransactionsRelationManager;

class ProjectsResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre del Proyecto')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Group::make([
                    Select::make('client_id')
                        ->relationship('client', 'name')
                        ->label('Cliente')
                        ->required(),
                    Actions::make([
                        Action::make('create_client')
                            ->label('Crear nuevo cliente')
                            ->icon('heroicon-m-plus')
                            ->url(fn (): string => ClientResource::getUrl('create'))
                            ->openUrlInNewTab(),
                    ]),
                ])->columns(2),
                Forms\Components\Select::make('status')
                    ->label('Estado del Proyecto')
                    ->options([
                        'new' => 'Presupuesto',
                        'pending' => 'Pendiente',
                        'in_progress' => 'En Proceso',
                        'on_hold' => 'En Pausa',
                        'completed' => 'Completado',
                        'cancelled' => 'Cancelado',
                    ])
                    ->required(),
                Forms\Components\DatePicker::make('start_date')
                    ->label('Fecha de Inicio'),
                Forms\Components\DatePicker::make('review_date')
                    ->label('Fecha de Revisión'),
                Forms\Components\DatePicker::make('delivery_date')
                    ->label('Fecha de Entrega'),
                Forms\Components\TextInput::make('total_price')
                    ->label('Precio Total')
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
                Forms\Components\RichEditor::make('description')
                    ->label('Descripción')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre del Proyecto'),
                Tables\Columns\TextColumn::make('client.name')
                    ->label('Cliente'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado del Proyecto'),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Fecha de Inicio'),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('client_id')
                    ->relationship('client', 'name')
                    ->label('Cliente'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'Presupuesto',
                        'pending' => 'Pendiente',
                        'in_progress' => 'En Progreso',
                        'on_hold' => 'En Pausa',
                        'completed' => 'Completado',
                        'cancelled' => 'Cancelado',
                    ])
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
            ImportantDatesRelationManager::class,
            TransactionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProjects::route('/create'),
            'view' => Pages\ViewProjects::route('/{record}'),
            'edit' => Pages\EditProjects::route('/{record}/edit'),
        ];
    }
    // Personaliza los títulos de las acciones
    public static function getModelLabel(): string
    {
        return 'Proyecto';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Proyectos';
    }

    public static function getNavigationLabel(): string
    {
        return 'Proyectos';
    }

    public static function getCreateButtonLabel(): string
    {
        return 'Nuevo Proyecto';
    }

    public static function getEditButtonLabel(): string
    {
        return 'Editar Proyecto';
    }

    public static function getDeleteButtonLabel(): string
    {
        return 'Eliminar Proyecto';
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
