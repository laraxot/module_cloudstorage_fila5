<?php

declare(strict_types=1);
// File: Laravel/Modules/CloudStorage/Filament/Pages/GDriveFileListPage.php

namespace Modules\CloudStorage\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

class GDriveFileListPage extends XotBasePage implements HasTable
{
    use InteractsWithTable;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cloud';

    protected static ?string $navigationLabel = 'File di Google Drive';

<<<<<<< HEAD
   /**
=======
    /**
>>>>>>> laraxot/dev
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->label('Nome File')->sortable()->searchable(),
            'mimeType' => TextColumn::make('mimeType')->label('Tipo'),
            'modifiedTime' => TextColumn::make('modifiedTime')->label('Modificato')->dateTime(),
            'size' => TextColumn::make('size')
                ->label('Dimensione')
                ->formatStateUsing(fn ($state) => is_numeric($state) ? number_format((float) $state / 1024, 2).' KB' : 'N/A'),
        ];
    }
    /*
    public function getTableRecords(): LengthAwarePaginator
    {
<<<<<<< HEAD
       $files = collect(app(\Modules\CloudStorage\Actions\GoogleDrive\GetGoogleDriveFilesAction::class)->execute());
=======
        $files = collect(app(\Modules\CloudStorage\Actions\GoogleDrive\GetGoogleDriveFilesAction::class)->execute());
>>>>>>> laraxot/dev

        // Paginazione manuale (10 risultati per pagina)
        $perPage = 10;
        $currentPage = request()->input('page', 1);

        // Creazione di un paginatore manuale
        return new LengthAwarePaginator(
            $files->forPage($currentPage, $perPage),
            $files->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    public function getTable(): Tables\Table
    {
        // Passiamo `$this` come argomento a `Table::make()`
        return Tables\Table::make($this)
            ->columns($getTableColumns(
            ->query(fn () => $this->getTableRecords()); // Impostiamo la query per la tabella
    }
    */
}
