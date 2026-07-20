<?php

declare(strict_types=1);

namespace Modules\CloudStorage\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\CloudStorage\Actions\GoogleDrive\GetGoogleDriveFilesAction;

// implements HasTable

class GoogleDriveFileListPage extends Page
{
    // use InteractsWithTable;
    protected string $view = 'cloudstorage::filament.pages.google-drive-file-list';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cloud';

    /** @var array<int, mixed> */
    protected array $files = [];

<<<<<<< HEAD
    public function mount(): void
    {
        $this->files = app(GetGoogleDriveFilesAction::class)->execute();
=======
    public function setUp(): void
    {
        dddx('c');
    }

    public function mount(): void
    {
        $this->files = app(GetGoogleDriveFilesAction::class)->execute();

        dddx([
            'listFiles' => $this->files,
        ]);
>>>>>>> e2078c7 (refactor: migrate GoogleDriveService to GetGoogleDriveFilesAction (QueueableAction))
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')

                    ->searchable(),

                TextColumn::make('mimeType'),

                TextColumn::make('modifiedTime')

                    ->dateTime('Y-m-d H:i:s'),

                TextColumn::make('size')
                    ->formatStateUsing(fn ($state): string => is_numeric($state) ? $this->formatFileSize((int) $state) : ''),
            ])
            ->recordActions([
                Action::make('view')
                    ->icon('heroicon-o-eye')
                    ->tooltip(__('View File'))
                    ->url(fn ($record) => is_array($record) && isset($record['webViewLink']) ? $record['webViewLink'] : '#', true),
                /*
                Action::make('share')
                    ->icon('heroicon-o-share')
                    ->tooltip(__('Share to Corporate Folder'))
                    ->action(fn ($record) => $this->shareFileToCorporate($record['id']
                */
            ]);
    }

    /**
     * @return array<int, mixed>
     */
    protected function getFilesQuery(): array
    {
        return $this->files;
    }

    /*
    protected function shareFileToCorporate(string $fileId): void
    {
        $corporateFolderId = config('cloudstorage.corporate_folder_id'); // Set in config
        $driveService->shareFile($fileId, $corporateFolderId);

        // You can log or notify the user about the sharing status.
    }
    */
    protected function formatFileSize(int $size): string
    {
        if ($size >= 1073741824) {
            return number_format($size / 1073741824, 2).' GB';
        }
        if ($size >= 1048576) {
            return number_format($size / 1048576, 2).' MB';
        }
        if ($size >= 1024) {
            return number_format($size / 1024, 2).' KB';
        }

        return $size.' bytes';
    }
}
