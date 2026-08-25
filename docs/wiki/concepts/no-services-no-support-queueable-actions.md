---
title: No Services/No Support — QueueableAction
---

# Regola

`app/Services/` e `app/Support/` non esistono in questo modulo. Ogni logica di dominio vive in `app/Actions/{Contesto}/FooAction.php`, con `use Spatie\QueueableAction\QueueableAction;` e unico metodo pubblico `execute()`.

## Conversione 2026-07-20

- `app/Services/GoogleDriveService.php` → `app/Actions/GoogleDrive/GetGoogleDriveFilesAction.php` (`.bak` mantenuto per storia).
- Costruzione del client Google Drive spostata in un metodo privato `makeClient()` dell'Action (nessuna injection nel costruttore: l'Action non ha stato, tutto avviene in `execute()`).
- Caller aggiornati: `GoogleDriveFileListPage`, `GDriveFileListPage` → `app(GetGoogleDriveFilesAction::class)->execute()`.

## Perché

Coerenza con la policy Laraxot: nessun layer Service, azioni singole responsabilità, chiamabili via `app()->execute()` ovunque (controller, job, comandi) senza bisogno di autowiring speciale.
