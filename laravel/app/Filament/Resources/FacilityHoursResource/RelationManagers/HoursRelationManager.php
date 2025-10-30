<?php

namespace App\Filament\Resources\FacilityHoursResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HoursRelationManager extends RelationManager
{
    protected static string $relationship = 'hours';

    protected static ?string $title = '営業日';

    protected static ?string $pluralModelLabel = '営業日一覧';

    protected static ?string $modelLabel = '営業日';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('day_of_week')
                    ->label('曜日')
                    ->options([
                        0 => '日曜日',
                        1 => '月曜日',
                        2 => '火曜日',
                        3 => '水曜日',
                        4 => '木曜日',
                        5 => '金曜日',
                        6 => '土曜日',
                    ])
                    ->required(),

                Forms\Components\TimePicker::make('open_time')
                    ->label('開始時間')
                    ->seconds(false)
                    ->required(),

                Forms\Components\TimePicker::make('close_time')
                    ->label('終了時間')
                    ->seconds(false)
                    ->required(),

                Forms\Components\TextInput::make('note')
                    ->label('備考')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('day_of_week')
            ->columns([
                Tables\Columns\TextColumn::make('day_of_week')->label('開始時間')->formatStateUsing(fn ($state) => [
                    0 => '日',
                    1 => '月',
                    2 => '火',
                    3 => '水',
                    4 => '木',
                    5 => '金',
                    6 => '土',
                ][$state] ?? $state),
                Tables\Columns\TextColumn::make('open_time')->label('開店時間'),
                Tables\Columns\TextColumn::make('close_time')->label('終了時間'),
                Tables\Columns\TextColumn::make('note')->label('備考')->wrap(),
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
