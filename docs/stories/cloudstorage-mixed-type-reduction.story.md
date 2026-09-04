---
title: "CloudStorage — mixed type reduction audit"
status: done
module: CloudStorage
date: 2026-09-04
---

# Story: CloudStorage — `mixed` type reduction audit

**Fase BMAD**: Refactor / qualità (audit + eventuale correzione tipi, nessuna modifica
funzionale).

**Contesto**: convenzione di progetto — "cerchiamo di non usare mixed, quando lo
troviamo cerchiamo di sostituirlo con qualcosa di adeguato" — applicata a
`Modules/CloudStorage`, modulo piccolo (10 file con `mixed`), scelto per un passaggio
completo e accurato.

**Azione**: censiti tutti i 21 usi di `mixed` (nativi e in docblock) su 10 file
tramite `grep -rnE '\bmixed\b' Modules/CloudStorage --include="*.php"`. Ogni
occorrenza è stata letta nel contesto reale (chiamante, tipo di ritorno vendor,
consumer a valle) prima di decidere se sostituirla.

**Esito**: **0 sostituzioni** — tutte le 21 occorrenze rientrano in una delle
eccezioni esplicite del task (dettaglio per-file in `docs/coverage.md`, sezione
2026-09-04):

- 4 closure Filament (`formatStateUsing`, `Action::url`) — convenzione vendor, stato
  di provenienza non tipizzabile con certezza.
- 4 occorrenze legate a `GetGoogleDriveFilesAction` e alla pagina che ne consuma il
  risultato — il tipo di ritorno reale dipende da `Google\Service\Resource::call()`
  (libreria `google/apiclient`), che non ha `@return` né return-type: PHPStan vede
  `mixed` a monte, indipendentemente da cosa scriviamo qui. I controlli difensivi
  (`is_object`, `method_exists`, `is_array`) già presenti confermano che il codice
  originale sapeva di non poter contare su un tipo statico.
- 2 proprietà `@property array<string, mixed>` (`metadata`, `settings` su
  `CloudStorageFile`) — colonne JSON genuinamente polimorfe, nessun consumer nel
  modulo ne vincola la forma.
- 12 occorrenze nelle factory (`definition(): array` con `@return array<string,
  mixed>` su 6 factory, più `safeMetadata`/`safeSettings` in
  `CloudStorageUploadFactory`) — il contratto vendor di
  `Illuminate\Database\Eloquent\Factories\Factory::definition()` è esso stesso
  documentato `@return array<string, mixed>`; le due funzioni helper sono
  normalizzatori "accetta qualunque cosa" per design.

Nessun `@phpstan-ignore` aggiunto, nessuna modifica a `phpstan.neon`, nessun
allargamento di tipi già più stretti.

**Verifica**:
- PHPStan (`./vendor/bin/phpstan analyse Modules/CloudStorage --no-progress
  --error-format=table`): 0 errori prima → 0 errori dopo (nessun codice modificato).
- PHPMD (`./tools/phpmd.sh Modules/CloudStorage text ../docs/phpmd.ruleset.xml`):
  eseguito senza crash; findings pre-esistenti, non correlati a `mixed`, non toccati.
- Pest: non verificabile — `Modules/CloudStorage/phpunit.xml` non esiste e
  `Modules/CloudStorage/tests/` non contiene test (solo `TestCase.php`/`Pest.php`).

**Collisioni**: nessuna. `git status --short` sul modulo era pulito all'avvio;
i file di coordinamento in `docs/chat/cloudstorage-*` risalgono al 20 luglio e
riguardano un lavoro diverso (rimozione `GoogleDriveService`), già concluso.

**Dettaglio completo**: vedi `docs/coverage.md`, sezione "2026-09-04 — mixed type
reduction audit".
