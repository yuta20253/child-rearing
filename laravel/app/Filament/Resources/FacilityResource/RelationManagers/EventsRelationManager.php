<?php

namespace App\Filament\Resources\FacilityResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventsRelationManager extends RelationManager
{
    protected static string $relationship = 'events';

    protected static ?string $title = 'イベント';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('イベント名'),

                Forms\Components\DateTimePicker::make('start_datetime')
                    ->seconds(false)
                    ->required()
                    ->label('開始日時'),

                Forms\Components\DateTimePicker::make('end_datetime')
                    ->seconds(false)
                    ->required()
                    ->label('終了日時'),

                Forms\Components\TextInput::make('capacity')
                    ->numeric()
                    ->required()
                    ->label('定員'),
            ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->modelLabel('イベント')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('start_datetime')
                    ->label('開始日時')
                    ->dateTime('Y-m-d H:i'),
                Tables\Columns\TextColumn::make('end_datetime')
                    ->label('終了日時')
                    ->dateTime('Y-m-d H:i'),

                Tables\Columns\TextColumn::make('capacity')
                    ->label('定員'),
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
