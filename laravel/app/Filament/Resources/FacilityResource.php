<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FacilityHoursResource\RelationManagers\HoursRelationManager;
use App\Filament\Resources\FacilityClosuresResource\RelationManagers\ClosuresRelationManager;
use App\Filament\Resources\FacilityResource\Pages;
use App\Filament\Resources\FacilityResource\RelationManagers;
use App\Models\Facility;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FacilityResource extends Resource
{
    protected static ?string $model = Facility::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('施設名')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->label('画像')
                    ->image(),
                Forms\Components\TextInput::make('latitude')
                    ->label('緯度')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('longitude')
                    ->label('経度')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('equipment')
                    ->label('設備・備品')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description')
                    ->label('紹介')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('address_id')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('施設名')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')->label('画像'),
                Tables\Columns\TextColumn::make('latitude')
                    ->label('緯度')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->label('経度')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('address_id')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            HoursRelationManager::class,
            ClosuresRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFacilities::route('/'),
            'create' => Pages\CreateFacility::route('/create'),
            'edit' => Pages\EditFacility::route('/{record}/edit'),
        ];
    }
}
