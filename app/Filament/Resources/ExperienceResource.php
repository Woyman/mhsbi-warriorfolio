<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExperienceResource\Pages;
use App\Models\Experience;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExperienceResource extends Resource
{
    protected static ?string $model = Experience::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?int $navigationSort = 6;

    public static function getNavigationGroup(): ?string
    {
        return __('Core Features');
    }

    public static function getNavigationParentItem(): ?string
    {
        return __('Profile');
    }

    public static function getNavigationLabel(): string
    {
        return __('Experience');
    }

    public static function getNavigationBadge(): ?string
    {
        if (static::getModel()::count() > 0) {
            return (string) static::getModel()::count();
        }

        return null;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Experience Information')
                ->description('This information will be displayed publicly.')
                ->icon('heroicon-o-briefcase')
                ->columns(2)
                ->schema([
                    TextInput::make('title')
                        ->label('Title')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('company')
                        ->label('Company or Organization')
                        ->required()
                        ->maxLength(255),
                    DatePicker::make('start_date')
                        ->label('Start Date')
                        ->required()
                        ->displayFormat('F Y')
                        ->native(false),
                    DatePicker::make('end_date')
                        ->label('End Date')
                        ->displayFormat('F Y')
                        ->required(fn (callable $get): bool => ! (bool) $get('currently_working'))
                        ->disabled(fn (callable $get): bool => (bool) $get('currently_working'))
                        ->dehydrated(fn (callable $get): bool => ! (bool) $get('currently_working'))
                        ->native(false),
                    Toggle::make('currently_working')
                        ->label('Currently working this role')
                        ->reactive()
                        ->inline(false)
                        ->columnSpanFull(),
                    TextInput::make('skills')
                        ->label('Skills')
                        ->placeholder('Laravel, PHP, REST API')
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Textarea::make('description')
                        ->label('Description')
                        ->rows(4)
                        ->maxLength(2000)
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('company')
                    ->label('Company')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date('M Y')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('End Date')
                    ->formatStateUsing(function ($state, Experience $record): string {
                        if ($record->currently_working) {
                            return __('Present');
                        }

                        return $state ? $record->end_date?->format('M Y') : '-';
                    }),
                IconColumn::make('currently_working')
                    ->label('Current')
                    ->boolean(),
            ])
            ->defaultSort('start_date', 'desc')
            ->actions([
                ActionGroup::make([
                    \Filament\Tables\Actions\EditAction::make(),
                    \Filament\Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    \Filament\Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListExperiences::route('/'),
            'create' => Pages\CreateExperience::route('/create'),
            'edit'   => Pages\EditExperience::route('/{record}/edit'),
        ];
    }
}
