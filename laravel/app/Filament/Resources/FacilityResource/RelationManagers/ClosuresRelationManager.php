<?php

namespace App\Filament\Resources\FacilityResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClosuresRelationManager extends RelationManager
{
    protected static string $relationship = 'closures';

    protected static ?string $title = '定休日';

    protected static ?string $pluralModelLabel = '定休日一覧';

    protected static ?string $modelLabel = '定休日';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('closed_date')
                    ->label('定休日')
                    ->required(),

                Forms\Components\TextInput::make('reason')
                    ->label('定休理由')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('closed_date')
            ->columns([
                Tables\Columns\TextColumn::make('closed_date')->label('定休日')->formatStateUsing(fn ($state) => [
                    0 => '日',
                    1 => '月',
                    2 => '火',
                    3 => '水',
                    4 => '木',
                    5 => '金',
                    6 => '土',
                ][$state] ?? $state),
                Tables\Columns\TextColumn::make('reason')->label('定休理由')->wrap(),
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
