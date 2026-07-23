<?php

declare(strict_types=1);

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Textarea::make('body')
                    ->rows(5)
                    ->columnSpanFull(),
            ]);
    }
}
