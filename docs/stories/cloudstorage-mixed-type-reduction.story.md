---
title: "CloudStorage — mixed type reduction audit"
status: done
module: CloudStorage
---

# Story: CloudStorage — `mixed` type reduction audit

**Fase BMAD**: Refactor / qualita (type-safety). Nessuna pagina legal, nessun User 10.4.

**Contesto**: convenzione di progetto — "cerchiamo di non usare mixed, quando lo
troviamo cerchiamo di sostituirlo con qualcosa di adeguato" — applicata a
`Modules/CloudStorage`, scope `app/` (ultima spiaggia = JSON / metadata / config)
+ `declare(strict_types=1)` su ogni `.php` / `.blade.php` sprovvisto (prime 25 righe).

**Perche'**: `GetGoogleDriveFilesAction` chiedeva gia' un set chiuso di campi Drive
(`id`, `name`, `mimeType`, `modifiedTime`, `size`) e la pagina consuma anche
`webViewLink`. Restituire `array<int, mixed>` nascondeva uno shape file evidente.
Le colonne JSON `metadata`/`settings` restano polimorfe: li `mixed` e' onesto.

**Modifiche applicate**:
- `app/Actions/GoogleDrive/GetGoogleDriveFilesAction.php`: dopo `Assert` su
  `DriveFilesResource` / `FileList`, ogni `DriveFile` e' mappato a
  `GoogleDriveFileRow` (`id`/`name`/`mimeType` string obbligatori;
  `modifiedTime`/`size`/`webViewLink` string|null — size assente su cartelle/Docs).
  `fields` include `webViewLink` perche' la pagina lo usa gia'.
- `app/Filament/Pages/GoogleDriveFileListPage.php`: `$files`, `getFilesQuery()` e
  la closure `Action::url` usano lo stesso shape invece di `mixed`.
- Blade senza strict types: `resources/views/filament/pages/google-drive-files.blade.php`,
  `resources/views/index.blade.php`, `resources/views/layouts/master.blade.php`.

**Lasciato `mixed` (motivato)**:
- `app/Models/CloudStorageFile.php` (`metadata`, `settings`): JSON polimorfo,
  nessun consumer nel modulo ne vincola la forma (stesso criterio "Backup/metadata").
- Factory in `database/factories/`: fuori da `app/`; `definition()` segue il
  contratto vendor `array<string, mixed>`; `safeMetadata`/`safeSettings` restano
  normalizzatori "accetta qualunque cosa".

Nessun `@phpstan-ignore`, nessun tocco a `phpstan.neon`, nessun PrivacyPolicyWidget.

**Verifica**: PHPStan senza `--level` (livello da `phpstan.neon`) e PHPMD sul modulo.

**Dettaglio**: [coverage.md](../coverage.md).
