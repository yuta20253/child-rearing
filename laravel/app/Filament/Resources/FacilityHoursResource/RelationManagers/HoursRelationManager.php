<?php

namespace App\Filament\Resources\FacilityHoursResource\RelationManagers;

use Carbon\Carbon;
use Dotenv\Parser\Value;
use Filament\Tables\Actions\Action;
use Filament\Support\Enums\ActionSize;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\ActionSize as EnumsActionSize;
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

    private const DAYS_OF_WEEK = [
        0 => '日曜日',
        1 => '月曜日',
        2 => '火曜日',
        3 => '水曜日',
        4 => '木曜日',
        5 => '金曜日',
        6 => '土曜日',
    ];

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('day_of_week')
                    ->label('曜日')
                    ->options(self::DAYS_OF_WEEK)
                    ->required(),

                Forms\Components\TimePicker::make('open_time')
                    ->label('開館時間')
                    ->seconds(false)
                    ->required(),

                Forms\Components\TimePicker::make('close_time')
                    ->label('閉館時間')
                    ->seconds(false)
                    ->required()
                    ->rule(function (callable $get) {
                        $openTime = $get('open_time');
                        return function (string $attribute, $value, $fail) use ($openTime) {
                            if ($openTime && $value <= $openTime) {
                                $fail('閉館時間は開館時間より後の時間を設定してください。');
                            }
                        };
                    }),

                Forms\Components\TextInput::make('note')
                    ->label('備考')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->orderByRaw("
                    CASE day_of_week
                        WHEN 0 THEN 1
                        WHEN 1 THEN 2
                        WHEN 2 THEN 3
                        WHEN 3 THEN 4
                        WHEN 4 THEN 5
                        WHEN 5 THEN 6
                        WHEN 6 THEN 7
                    END
                ");
            })
            ->recordTitle(fn ($record) => self::DAYS_OF_WEEK[$record->day_of_week] ?? $record->day_of_week)
            ->columns([
                Tables\Columns\TextColumn::make('day_of_week')->label('曜日')->formatStateUsing(fn ($state) => self::DAYS_OF_WEEK[$state] ?? $state),
                Tables\Columns\TextColumn::make('open_time')->label('開館時間')->formatStateUsing(fn ($state) => Carbon::createFromFormat('H:i:s', $state)->format('G:i')),
                Tables\Columns\TextColumn::make('close_time')->label('閉館時間')->formatStateUsing(fn ($state) => Carbon::createFromFormat('H:i:s', $state)->format('G:i')),
                Tables\Columns\TextColumn::make('note')->label('備考')->wrap(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Action::make('createWeekTemplate')
                    ->label('全曜日テンプレ作成')
                    ->size(ActionSize::Small)
                    ->icon('heroicon-m-sparkles')
                    ->modalWidth('xl')
                    ->form([
                        TimePicker::make('default_open')
                            ->label('開館時間')
                            ->seconds(false)
                            ->required()
                            ->default('09:00'),

                        TimePicker::make('default_close')
                            ->label('閉館時間')
                            ->seconds(false)
                            ->required()
                            ->default('17:00')
                            ->rule(function (callable $get) {
                                $openTime = $get('open_time');
                                return function (string $attribute, $value, $fail) use ($openTime) {
                                    if ($openTime && $value <= $openTime) {
                                        $fail('閉館時間は開館時間より後の時間を設定してください。');
                                    }
                                };
                            }),
                        Select::make('workdays')
                            ->label('対象曜日')
                            ->options(self::DAYS_OF_WEEK)
                            ->multiple()
                            ->required()
                            ->default([1, 2, 3, 4, 5])
                            ->hint('既存の曜日はスキップされます')
                            ->placeholder('土日')
                    ])
                    ->action(function (array $data) {
                        $rel = $this->getRelationship();
                        $existing = $rel->pluck('day_of_week')->all();

                        $createdCount = 0;

                        foreach ($data['workdays'] as $dow) {
                            if (in_array((int) $dow, $existing, true)) {
                                continue;
                            }

                            $rel->create([
                                'day_of_week' => $dow,
                                'open_time' => $data['default_open'],
                                'close_time' => $data['default_close'],
                                'note' => null,
                            ]);

                            $createdCount++;
                        }

                        Notification::make()
                            ->title(
                                $createdCount > 0 ? "選択した{$createdCount}件の曜日を作成しました。" : "新しく作成された曜日はありません。"
                            )
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('全曜日テンプレ作成')
                    ->modalDescription('選択した曜日に一括で営業時間を作成します。既に存在する曜日は上書きしません。'),
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
