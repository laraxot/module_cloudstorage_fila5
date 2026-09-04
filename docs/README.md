---
title: "CloudStorage — documentazione del modulo"
description: "Documentazione del modulo CloudStorage: integrazione storage remoto."
module: CloudStorage
tags: [cloudstorage, documentazione, modulo, laraxot]
status: active
repository: https://github.com/laraxot/module_cloudstorage_fila5
related:
  - ./00-index.md
  - ./index.md
  - ../../../../docs/wiki/audits/docs-redundancy-audit.md
issues: https://github.com/laraxot/module_cloudstorage_fila5/issues
discussions: https://github.com/laraxot/module_cloudstorage_fila5/discussions
---

# CloudStorage Module

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)

> Modulo **CloudStorage**: attualmente uno scaffold per l'integrazione con Google Drive. Non è (ancora) l'astrazione multi-provider descritta nelle versioni precedenti di questa doc.

## Stato reale del codice (verificato nel codice, non nella roadmap)

- **Provider integrato**: solo Google Drive, tramite `google/apiclient` (`Google\Client`, `Google\Service\Drive`).
- **Azioni**: una sola Action reale, `Modules\CloudStorage\Actions\GoogleDrive\GetGoogleDriveFilesAction` (QueueableAction, vedi sotto). Non esistono `UploadToCloudAction`, `CloudStorageService`, `FileUploader`/`FileDownloader`: sono nomi di classi mai implementate, citati per errore nelle versioni precedenti di questa documentazione.
- **Modelli**: `CloudStorageFile`, `CloudStorageProvider`, `CloudStorageUpload`, `CloudStorageQuota`, `CloudStorageShare` esistono in `app/Models/` con `$fillable`/`casts()` completi, ma **non hanno migrazioni** (`database/migrations/` è vuota). Sono modelli pronti-per-tabelle-non-ancora-create: non usarli in produzione finché non esiste la migrazione corrispondente.
- **Filament**: `Dashboard` (estende `Filament\Pages\Dashboard`, vuota) e due pagine per l'elenco file di Google Drive:
  - `GoogleDriveFileListPage` — versione attiva, ma contiene chiamate di debug `dddx(...)` in `setUp()`/`mount()` non rimosse (dump-and-die): la pagina non è utilizzabile così com'è in produzione.
  - `GDriveFileListPage` — versione precedente/alternativa, con gran parte della logica di tabella commentata; sembra un tentativo abbandonato prima di `GoogleDriveFileListPage`.
- **Repositories/tests**: le cartelle `app/Repositories/` e `tests/{Feature,Unit}/` contengono solo `.gitkeep`: nessuna implementazione, nessun test automatico presente.

## QueueableAction — pattern del modulo

Ogni Action reale (attualmente solo `GetGoogleDriveFilesAction`) segue la convenzione Spatie: `use Spatie\QueueableAction\QueueableAction;` + singolo metodo `execute()`, invocata via `app(GetGoogleDriveFilesAction::class)->execute()`. Nessuna Facade nella cartella Actions.

## Credenziali Google

Le credenziali OAuth (client id/secret/redirect/scopes) sono lette da `config('services.google.*')` — quindi dal `config/services.php` dell'app host, non da un config del modulo. Il token utente viene letto da `$user->getProviderField('google', 'token')` (se il metodo esiste sul model User). Nessun secret è hardcoded nel modulo. Vedi [gdrive/api.md](gdrive/api.md) per i riferimenti API Google Drive.

## Documentazione

- [roadmap/README.md](roadmap/README.md) — piano evolutivo verso multi-provider e stato reale delle task.
- [tasks/tasks-index.md](tasks/tasks-index.md) — indice delle task del modulo.
- [gdrive/](gdrive/) — riferimenti e tutorial sull'integrazione Google Drive.
- [wiki/concepts/no-services-no-support-queueable-actions.md](wiki/concepts/no-services-no-support-queueable-actions.md) — perché `app/Services/` è stato sostituito da `app/Actions/`.
