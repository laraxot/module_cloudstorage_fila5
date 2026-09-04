---
title: "CloudStorage Module Test Coverage"
module: "CloudStorage"
type: concept
tags: [coverage, phpstan, mixed-type]
created: 2026-09-04
updated: 2026-09-04
qmd: "coverage"
---

# CloudStorage Module Test Coverage

## 2026-09-04 — `mixed` type reduction audit (BMAD: refactor/quality)

**Task**: reduce use of the PHP `mixed` type where a more specific type is actually
knowable, per project convention ("cerchiamo di non usare mixed, quando lo troviamo
cerchiamo di sostituirlo con qualcosa di adeguato").

**Scope**: `grep -rnE '\bmixed\b' Modules/CloudStorage --include="*.php"` found 21
occurrences across 10 files.

**Outcome**: **0 changed, 21 reviewed and left as-is** — every occurrence, on
inspection, falls into a documented exception rather than a fixable gap:

| File | Occurrences | Reason left as `mixed` |
|---|---|---|
| `app/Filament/Pages/GDriveFileListPage.php` | 1 | `formatStateUsing(fn (mixed $state) ...)` — Filament column closure convention, state genuinely comes from an unresolved table wiring (`getTableRecords()` is commented out in this page); no stable source type to narrow to. |
| `app/Filament/Pages/GoogleDriveFileListPage.php` | 4 | `$files` property, `getFilesQuery()` return, and two Filament closures (`formatStateUsing`, `Action::url`) all consume the array returned by `GetGoogleDriveFilesAction::execute()`, which is honestly `mixed` (see below) — narrowing here would just be an unchecked assertion propagated one hop further. |
| `app/Actions/GoogleDrive/GetGoogleDriveFilesAction.php` | 2 | `Google\Service\Resource::call()` (vendor, `google/apiclient`) has no return type or `@return` docblock, so `$result` is unknown to PHPStan; the action already defends with `is_object()` / `method_exists()` / `is_array()` before returning. The array is genuinely of unknown shape to static analysis — this is the "vendor library the codebase cannot control" exception, not a case of laziness. Confirmed by reading `vendor/google/apiclient/src/Service/Resource.php:91` and `vendor/google/apiclient-services/src/Drive/Resource/Files.php:393`. |
| `app/Models/CloudStorageFile.php` | 2 | `@property array<string, mixed> $metadata` / `$settings` — genuine polymorphic JSON columns (no migration/consumer in this module constrains their shape further; verified via `grep -rn "->metadata\|->settings"` — no narrowing usage found). |
| `database/factories/CloudStorageFileFactory.php`, `CloudStorageProviderFactory.php`, `CloudStorageQuotaFactory.php`, `CloudStorageFolderFactory.php`, `CloudStorageShareFactory.php` | 1 each (5 total) | `@return array<string, mixed>` on `definition()` — matches the abstract vendor contract in `Illuminate\Database\Eloquent\Factories\Factory::definition()` verbatim (`vendor/laravel/framework/src/Illuminate/Database/Eloquent/Factories/Factory.php:204`). Attribute values genuinely span many types (string, int, bool, Carbon, null) so a narrower generic would be false. |
| `database/factories/CloudStorageUploadFactory.php` | 7 | `definition()` return (vendor contract, as above) + `safeMetadata(mixed $metadata)` / `safeSettings(mixed $settings)` private helpers whose entire purpose is to accept a value of unknown shape (`$attributes['metadata'] ?? []` from an untyped Factory state closure) and normalize it — an intentionally "accept anything" boundary, plus their internal `@var array<string, mixed> $result` casts. |

No `@phpstan-ignore` added, no `phpstan.neon` change, no widening of any existing
narrower type back to `mixed`.

**PHPStan**: `./vendor/bin/phpstan analyse Modules/CloudStorage --no-progress
--error-format=table` → **0 errors before, 0 errors after** (no code changed).

**PHPMD**: `./tools/phpmd.sh Modules/CloudStorage text ../docs/phpmd.ruleset.xml` ran
without crashing. All findings are pre-existing and unrelated to `mixed`
(`UnusedFormalParameter` on unused `$attributes` in factory state closures,
`ExcessiveClassComplexity` on `CloudStorageQuotaFactory`, `ExcessivePublicCount` /
`TooManyMethods` on `CloudStorageShareFactory`). Not touched — out of scope for this
task and pre-existing debt.

**Pest**: **not verifiable**. `Modules/CloudStorage/phpunit.xml` does not exist, and
`Modules/CloudStorage/tests/` only contains `TestCase.php` and `Pest.php` (no
`Feature`/`Unit` test files). No suite to run for this module.

**Git**: no application code touched, so no functional diff to commit beyond this
file and the accompanying story file.
