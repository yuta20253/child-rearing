<?php

namespace App\Filament\Resources\FacilityClosuresResource\RelationManagers;

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
                    // ->options([
                    //     0 => '日曜日',
                    //     1 => '月曜日',
                    //     2 => '火曜日',
                    //     3 => '水曜日',
                    //     4 => '木曜日',
                    //     5 => '金曜日',
                    //     6 => '土曜日',
                    // ])
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
