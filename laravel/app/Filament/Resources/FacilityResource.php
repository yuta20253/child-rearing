<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FacilityResource\Pages;
use App\Filament\Resources\FacilityHoursResource\RelationManagers\HoursRelationManager;
use App\Filament\Resources\FacilityClosuresResource\RelationManagers\ClosuresRelationManager;
use App\Models\Address;
use App\Models\Facility;
use App\Models\Municipality;
use App\Models\Prefecture;
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

    protected static ?string $modelLabel = '施設';
    protected static ?string $pluralModelLabel = '施設一覧';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('施設名')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            Forms\Components\FileUpload::make('image')
                ->label('画像')
                ->image(),

            Forms\Components\TextInput::make('latitude')
                ->label('緯度')
                ->required()
                ->numeric()
                ->columnSpanFull(),

            Forms\Components\TextInput::make('longitude')
                ->label('経度')
                ->required()
                ->numeric()
                ->columnSpanFull(),

            Forms\Components\Select::make('prefecture_id')
                ->label('都道府県')
                ->options(fn() => Prefecture::pluck('name', 'id')->toArray())
                ->searchable()
                ->required()
                ->reactive()
                ->afterStateHydrated(function ($set, ?Facility $record) {
                    if ($record && $record->address?->municipality?->prefecture_id) {
                        $set('prefecture_id', $record->address->municipality->prefecture_id);
                    }
                })
                ->afterStateUpdated(fn(callable $set) => $set('municipality_id', null))
                ->columnSpanFull(),

            Forms\Components\Select::make('municipality_id')
                ->label('市区町村')
                ->options(function (callable $get, $state) {
                    $prefectureId = $get('prefecture_id')
                        ?? Municipality::find($state)?->prefecture_id;

                    if (!$prefectureId) {
                        return [];
                    }

                    return Municipality::where('prefecture_id', $prefectureId)
                        ->orderBy('name')
                        ->pluck('name', 'id');
                })
                ->searchable()
                ->required()
                ->reactive()
                ->afterStateHydrated(function ($set, ?Facility $record) {
                    if ($record && $record->address?->municipality_id) {
                        $set('municipality_id', $record->address->municipality_id);
                    }
                })
                ->afterStateUpdated(fn(callable $set) => $set('address_id', null))
                ->columnSpanFull(),

            Forms\Components\Select::make('address_id')
                ->label('町域')
                ->options(function (callable $get, $state) {
                    $municipalityId = $get('municipality_id')
                        ?? Address::find($state)?->municipality_id;

                    if (!$municipalityId) {
                        return [];
                    }

                    return Address::where('municipality_id', $municipalityId)
                        ->orderBy('town')
                        ->pluck('town', 'id');
                })
                ->searchable()
                ->required()
                ->reactive()
                ->afterStateHydrated(function ($set, ?Facility $record) {
                    if ($record && $record->address_id) {
                        $set('address_id', $record->address_id);
                    }
                })
                ->columnSpanFull(),

            Forms\Components\Section::make('電話番号')
                ->relationship('phone')
                ->schema([
                    Forms\Components\TextInput::make('number')
                        ->label('電話番号')
                        ->tel()
                        ->maxLength(15)
                        ->required(),
                ])
                ->columnSpanFull(),

            Forms\Components\Textarea::make('equipment')
                ->label('設備・備品')
                ->columnSpanFull(),

            Forms\Components\Textarea::make('description')
                ->label('概要')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('施設名')
                    ->searchable(),

                Tables\Columns\TextColumn::make('address.municipality.prefecture.name')
                    ->label('都道府県')
                    ->default('-'),

                Tables\Columns\TextColumn::make('address.municipality.name')
                    ->label('市区町村')
                    ->default('-'),

                Tables\Columns\TextColumn::make('address.town')
                    ->label('町域')
                    ->default('-'),

                Tables\Columns\TextColumn::make('phone.number')
                    ->label('電話番号')
                    ->default('-'),

                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('削除日')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('作成日')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('更新日')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class])
            ->with(['address.municipality.prefecture', 'phone']);
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
