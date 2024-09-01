<?php

namespace App\Filament\Resources\EsTableResource\Widgets;

use App\Models\Project;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestProjects extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Project::query()
            )
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i'),
            ]);
    }
}
