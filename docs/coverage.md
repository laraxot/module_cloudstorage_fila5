---
title: "CloudStorage Module Test Coverage"
module: "CloudStorage"
type: concept
tags: [coverage, phpstan, mixed-type, composer, symplify]
created: 2026-09-04
updated: 2026-09-24
qmd: "coverage"
related:
  - ../../Xot/docs/phpstan-status.md
  - ../../../../bashscripts/ai/wiki/second-brain/phpstan-journey.md
  - ../../../../bashscripts/ai/wiki/memories/contract-suffix-no-interfaces-folder.md
  - ./README.md
---

# CloudStorage Module Test Coverage

## 2026-09-24 — `symplify/phpstan-rules` in require-dev (zero-gate)

**Perché:** Laraxot non usa le convenzioni Symplify naming (`*Interface`, `Abstract*`,
`*Trait`). Canon: `*Contract`, `BaseModel`/`XotBase*`/`TestCase`, `Has*` —
[contract-suffix memory](../../../../bashscripts/ai/wiki/memories/contract-suffix-no-interfaces-folder.md).

**Cosa:** `composer.json` del modulo ha aggiunto in require-dev
`symplify/phpstan-rules ^14.10`. `phpstan/extension-installer` auto-carica
`naming-rules.neon` (`symplify.naming=true`) su tutto `Modules/`. Misura fresca
dopo cache clear: 571 poi 394 `file_errors` su `analyse Modules` (~393 naming;
~148 `class.notFound` da helper Xot coverage assenti, non da questo modulo).
`phpstan.neon` root resta immutabile: non spegnere Symplify con ignore/baseline.

**Remediation:** rimuovere `symplify/phpstan-rules` da questo `require-dev`;
ripristinare gli helper in `Modules/Xot/tests/` se `git D`. Non rinominare il
codebase verso Symplify.

**Verifica** (cwd `laravel/`):

```bash
rm -rf /tmp/phpstan && mkdir -p /tmp/phpstan
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules --memory-limit=2G
```

Gate SSoT: [phpstan-status.md](../../Xot/docs/phpstan-status.md) ·
[phpstan-journey.md](../../../../bashscripts/ai/wiki/second-brain/phpstan-journey.md).

## 2026-09-04 — `mixed` type reduction audit (BMAD: refactor/quality)

**Task**: reduce use of the PHP `mixed` type where a more specific type is actually
knowable, per project convention ("cerchiamo di non usare mixed, quando lo troviamo
cerchiamo di sostituirlo con qualcosa di adeguato").

**Scope**: `grep -rnE '\bmixed\b' Modules/CloudStorage --include="*.php"` found 21
occurrences across 10 files.

**Outcome (aggiornato)**: lo shape file Drive e' evidente e viene mappato.
`metadata`/`settings` e le factory restano `mixed` (JSON/config polimorfo, fuori da `app/`
per le factory).

| File | Occurrences | Decision |
|---|---|---|
| `app/Actions/GoogleDrive/GetGoogleDriveFilesAction.php` | 0 `mixed` | `listFiles` e' `FileList`; ogni `DriveFile` diventa `GoogleDriveFileRow` (`id`/`name`/`mimeType` string; `modifiedTime`/`size`/`webViewLink` string\|null). |
| `app/Filament/Pages/GoogleDriveFileListPage.php` | 0 `mixed` | `$files`, `getFilesQuery()`, `Action::url` usano lo stesso shape. |
| `app/Filament/Pages/GDriveFileListPage.php` | 0 `mixed` | la closure `formatStateUsing(mixed)` citata in precedenza non e' piu' nel file (logica tabella commentata). |
| `app/Models/CloudStorageFile.php` | 2 nested `mixed` | JSON `metadata`/`settings` polimorfi — ultima spiaggia, invariati. |
| factory `definition()` / `safeMetadata` / `safeSettings` | invariate | fuori da `app/`; contratto vendor + payload JSON. |

No `@phpstan-ignore` added, no `phpstan.neon` change, no widening of any existing
narrower type back to `mixed`.

**PHPStan**: `./vendor/bin/phpstan analyse Modules/CloudStorage` (senza `--level`).
**PHPMD**: `./tools/phpmd.sh Modules/CloudStorage text ../docs/phpmd.ruleset.xml`.
Findings pre-esistenti sulle factory non toccati.

**Pest**: **not verifiable**. `Modules/CloudStorage/phpunit.xml` does not exist, and
`Modules/CloudStorage/tests/` only contains `TestCase.php` and `Pest.php`.

## 2026-09-04 — connessione DB errata

`BaseModel.php` dichiarava `protected $connection = 'cloudstorage'`
(senza underscore); `TenantServiceProvider` deriva la connessione reale
da `Module::getSnakeName()`, che per "CloudStorage" produce
`'cloud_storage'` (verificato via tinker). Mismatch: tutti i model
(CloudStorageFile/Share/Upload/Quota/Provider) fallivano con "Database
connection [cloudstorage] not configured." al primo utilizzo (trovato
con `php artisan ide-helper:models --nowrite`). Corretto in
`app/Models/BaseModel.php`.
