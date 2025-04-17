<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\SocialProviderResource\Pages;

use Filament\Actions;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Modules\User\Filament\Resources\SocialProviderResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use function Safe\json_encode;

class ViewSocialProvider extends \Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord
{
    protected static string $resource = SocialProviderResource::class;

    /**
     * @return array<\Filament\Infolists\Components\Component>
     */
    protected function getInfolistSchema(): array
    {
        return [
            Section::make()
                ->schema([
                    TextEntry::make('id'),
                    TextEntry::make('name'),
                    TextEntry::make('scopes')
                        ->formatStateUsing(function ($state): string {
                            if (is_array($state)) {
                                return json_encode($state);
                            }
                            return (string) $state;
                        }),
                    TextEntry::make('parameters')
                        ->formatStateUsing(function ($state): string {
                            if (is_array($state)) {
                                return json_encode($state);
                            }
                            return (string) $state;
                        }),
                    TextEntry::make('stateless')
                        ->badge()
                        ->color(fn (bool $state): string => $state ? 'success' : 'danger'),
                    TextEntry::make('active')
                        ->badge()
                        ->color(fn (bool $state): string => $state ? 'success' : 'danger'),
                    TextEntry::make('socialite')
                        ->badge()
                        ->color(fn (bool $state): string => $state ? 'success' : 'danger'),
                    TextEntry::make('svg')
                        ->html(),
                    TextEntry::make('created_at'),
                    TextEntry::make('updated_at'),
                ])
        ];
    }

    
}
