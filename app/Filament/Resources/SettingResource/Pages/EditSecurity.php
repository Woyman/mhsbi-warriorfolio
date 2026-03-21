<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Hash;

class EditSecurity extends EditRecord
{
    protected static string $resource = SettingResource::class;

    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';

    public static function getNavigationLabel(): string
    {
        return __('Account');
    }

    public function getTitle(): string | Htmlable
    {
        return __('Account');
    }

    public function getSubheading(): string | Htmlable | null
    {
        return __('Here you can change your password and or login email address.');
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make('E-mail')
                ->relationship('user')
                ->description('This section is used to manage your account e-mail. This affects your login e-mail next time you login.')
                ->icon('heroicon-o-lock-closed')
                ->schema([
                    TextInput::make('email')
                        ->email()
                        ->confirmed()
                        ->regex('/^\S+$/')
                        ->validationMessages([
                            'confirmed' => 'The e-mail confirmation does not match.',
                            'regex'     => 'The e-mail must not contain any whitespace.',
                        ])
                        ->label('E-mail')
                        ->minLength(3)
                        ->maxLength(50)
                        ->helperText('E-mail must be at least 3 characters long and no more than 50 characters long.'),
                    TextInput::make('email_confirmation')
                        ->label('Confirm E-mail')
                        ->helperText('Please confirm your e-mail')
                        ->minLength(3)
                        ->maxLength(50),
                ])->columns(2),
            Section::make('Password')
                ->relationship('user')
                ->description('This section is used to manage your account password. This affects your login password after reload the page.')
                ->icon('heroicon-o-lock-closed')
                ->schema([
                    TextInput::make('current_password')
                        ->password()
                        ->required()
                        ->label('Current Password')
                        ->revealable()
                        ->helperText('Please enter your current password.')
                        ->rules(['current_password']),
                    TextInput::make('password')
                        ->password()
                        ->confirmed()
                        ->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9])\S{8,64}$/')
                        ->validationMessages([
                            'confirmed' => 'The password confirmation does not match.',
                            'regex'     => 'Use 8-64 non-space characters with uppercase, lowercase, a number, and at least one symbol. A symbol is any character that is not A-Z, a-z, or 0-9 (e.g. _ ! @ # $ % ^ & * ( ) - + = [ ] { } | : ; , . < > / ? ~ `).',
                        ])
                        ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                        ->dehydrated(fn (?string $state): bool => filled($state))
                        ->label('New Password')
                        ->minLength(8)
                        ->maxLength(64)
                        ->revealable()
                        ->helperText('8-64 characters, no spaces. Include uppercase, lowercase, a number, and at least one symbol. Symbols: any character that is not a letter or digit (e.g. _ ! @ # $ % ^ & * ( ) - + = [ ] { } | : ; , . < > / ? ~ `). Other punctuation is allowed; spaces are not.'),
                    TextInput::make('password_confirmation')
                        ->password()
                        ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                        ->dehydrated(fn (?string $state): bool => filled($state))
                        ->label('Confirm New Password')
                        ->revealable()
                        ->helperText('Please confirm your new password.')
                        ->minLength(8)
                        ->maxLength(64),
                ])->columns(2),
        ]);
    }
}
