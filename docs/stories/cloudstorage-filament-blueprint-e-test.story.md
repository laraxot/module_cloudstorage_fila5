---
title: "Blueprint Filament, basi Xot e primi test per CloudStorage"
type: story
status: ready-for-dev
priority: P2
created: 2026-10-20
updated: 2026-10-20
module: CloudStorage
epic: ../../../Xot/docs/bmad/epic-code-quality-ratchet.md
depends_on: ["decisione dell'utente: modulo vivo o dormiente (sezione Decisioni aperte)", "verdetto Pest P0 dell'utente (solo per la fase 3)", "guardia DB dentro (solo per la fase 3)"]
related: [./cloudstorage-mixed-type-reduction.story.md, ./cloudstoragefolderfactory-dead-stub-removed-2026-09-21.story.md, ../bmad/livewire-inventory.md, ../tasks/cloud-storage-integration.md, ../tasks/cloudstorage-filament-v5.md, ../coverage.md, ../../../User/docs/bmad/filament-blueprint.md]
tags: [bmad, filament, blueprint, test, google-drive, modulo-dormiente]
---

# Blueprint Filament, basi Xot e primi test per CloudStorage

Fase BMAD: Story pronta per lo sviluppo (analisi, nessun codice toccato).

## Richiesta

Come responsabile del repo voglio sapere se `CloudStorage` e' un modulo vivo, e che la sua parte Filament abbia un blueprint, basi `XotBase*`
e almeno un test che non tocchi il database, cosi' che un modulo abilitato non porti pagine che si rompono appena qualcuno le apre.
Oggi il modulo e' abilitato (`modules_statuses.json:15`), ma nulla di cio' che dichiara funziona fino in fondo.

## Scopo

Dichiarato (`docs/tasks/cloud-storage-integration.md`): un'interfaccia unica per file su piu' provider (S3, Azure, GCS), con metadati,
quote, condivisioni e upload. Reale: una sola Action, `Actions/GoogleDrive/GetGoogleDriveFilesAction`, che elenca i file della radice
del Google Drive dell'utente connesso (token preso da `getProviderField('google', 'token')` del trait `HasSocialite` del modulo User), e
tre pagine Filament che la dovrebbero mostrare. Cinque modelli (`CloudStorageFile`, `Provider`, `Quota`, `Share`, `Upload`) e relative
factory sono scheletri. Per chi: un amministratore che vuole vedere i file aziendali su Drive.

## Stato misurato

Misure del 2026-10-20 13:54 UTC, cartella `laravel/`.
- File: `/usr/bin/find Modules/CloudStorage/app/Filament -name '*.php' | wc -l` = 3 (`Pages/Dashboard.php`, `Pages/GDriveFileListPage.php`, `Pages/GoogleDriveFileListPage.php`). Test: `/usr/bin/find Modules/CloudStorage/tests -type f | sort` = `Pest.php`, `TestCase.php` e due `.gitkeep`.
- Test con casi: `rg -l -P -e '^(it|test)\(|function test|#\[Test\]' Modules/CloudStorage/tests` = nessun file (exit 1). Controprova: lo stesso pattern su `Modules/Chart/tests` = 7 file. Secondo metodo: `git -C Modules/CloudStorage grep -n -i -E "function test|^(it|test)\(|class .*Test" -- tests` = solo `TestCase.php:13` (`abstract class TestCase`), nessun caso. `docs/coverage.md` non lo contraddice (parla di PHPStan e `symplify`).
- Blueprint: `/usr/bin/find Modules/CloudStorage/docs -iname 'filament-blueprint*'` = nessun file. Controprova: `Modules/User/docs` ne ha 1.
- `extends` diretti: 1. `rg -n -P "^\s*(abstract\s+|final\s+)*class\s+\w+\s+extends\s+(?!XotBase)\w+" --glob '*.php' Modules/CloudStorage/app/Filament` e `git grep -n -P "extends\s+(Dashboard|BaseDashboard|Page|Resource|Widget)\b" -- app/Filament`: `Pages/Dashboard.php:9` (`extends BaseDashboard`, alias di `Filament\Pages\Dashboard`). Le altre due pagine estendono `XotBasePage`.
- Stringhe UI: `->label('...')` = 0 file (controprova: Quaeris 25). Letterali presenti: `GDriveFileListPage.php:18` (`$navigationLabel = 'File di Google Drive'`), `GoogleDriveFileListPage.php:50` e `:59` (`__('View File')`, `__('Share to Corporate Folder')`, chiavi letterali in inglese, assenti dai file lang), `:85,88,91,94` (unita' `' GB'`, `' MB'`, `' KB'`, `' bytes'`). `lang/it/cloudstorage.php` e `lang/en/cloudstorage.php` hanno `navigation`, `fields`, `actions`, `messages`, ma nessun file PHP del modulo li usa (`rg -n -P "trans\(|cloudstorage::cloudstorage" Modules/CloudStorage/app` = nessuna riga).
- Perche' non funziona: (1) `GoogleDriveFileListPage.php:18` indica la vista `cloudstorage::filament.pages.google-drive-file-list`, che non esiste (`ls resources/views/filament/pages` = `google-drive-files.blade.php`); (2) la pagina ha un metodo `table()` ma non implementa `HasTable` ne' usa `InteractsWithTable`, mentre la vista stampa `{{ $table }}`; (3) `GetGoogleDriveFilesAction::makeClient()` richiede `services.google.client_id|client_secret|redirect|scopes`, assenti in tutti i 14 `config/**/services.php` (`google` ha solo `url_location_api` e `maps_key`; conteggio awk = 0 in tutti), quindi lancia `InvalidArgumentException` alla prima riga; (4) `GDriveFileListPage` e' uno stub con tutto il codice commentato (`implements HasTable` ma senza `table()`).
- Modelli senza base dati: `Models/BaseModel.php:23` fissa `$connection = 'cloud_storage'`, assente da tutti i 14 `config/**/database.php` (`rg -c "cloud_storage" $(/usr/bin/find config -name database.php)` = nessun file; controprova `rg -c "'mysql'"` = 14 file); `database/migrations` contiene solo `.gitkeep`; `cloud_storage_files` compare solo nel modello e in un doc (`git grep -l cloud_storage_files`).
- Uso esterno: `rg -l "CloudStorage" --glob '*.php' Modules/*/app Modules/*/config Modules/*/composer.json config composer.json` fuori dal modulo = nessun file; compare solo in `modules_statuses.json:15` (`true`) e `config/localhost/modules_statuses.json:30`. Dipendenza in uscita: 6 `use Modules\Quaeris\Models\{Profile,User}` nei modelli (un modulo generico che dipende da quello applicativo).
- Livewire: `Http/Livewire` ha solo `.gitkeep` e `_components.json`; inventario approvato in `docs/bmad/livewire-inventory.md`, nessun piano da aprire.
- Ultima modifica al codice: `git -C Modules/CloudStorage log -3 --format='%h %cd' -- app` = 2026-10-08, 2026-10-08, 2026-09-24 (commit con messaggio ".").
- Rumore: `2024_10_21.txt` nella radice del modulo, tracciato; `Providers/Filament/AdminPanelProvider.php` solo con commenti.

## Lavoro

Verdetto di questa analisi: dormiente (nessun chiamante, nessuna tabella, nessuna connessione, nessuna credenziale, vista inesistente). Il lavoro sotto vale per entrambe le scelte della decisione 1, salvo dove indicato.

Fase 1, blueprint. `laravel/Modules/CloudStorage/docs/bmad/filament-blueprint.md` sul modello di `Modules/User/docs/bmad/filament-blueprint.md`: regole non negoziabili; stato del modulo (vivo o dormiente, con la data della decisione); elenco pagine; dove vivono le chiavi lang (`cloudstorage::cloudstorage.*`); come si ottiene il token Google; requisiti di config (`services.google.*`, connessione `cloud_storage`) che devono esistere prima di riattivare.

Fase 2, codice (un agente PHP sul modulo, `php -l` dopo ogni file):
1. `Pages/Dashboard.php:9`: `extends XotBaseDashboard` (`Modules/Xot/app/Filament/Pages/XotBaseDashboard.php`, 20 file la usano).
2. Cancellare `Pages/GDriveFileListPage.php` (stub, codice tutto commentato, nome quasi uguale all'altra pagina): decisione 2.
3. `Pages/GoogleDriveFileListPage.php`: se il modulo e' vivo, allineare `$view` alla vista vera (o rinominare il file blade), fare implementare `HasTable` con `InteractsWithTable` e passare le righe con `->records()`; sostituire `formatFileSize()` con `Illuminate\Support\Number::fileSize($size, 2)` (esiste: `vendor/laravel/framework/src/Illuminate/Support/Number.php:211`); tooltip e label da `lang/it/cloudstorage.php` (`actions.view`, `fields.*`, gia' scritte). Se dormiente: solo la parte lang e `Number::fileSize`, e lasciare la pagina nascosta (`shouldRegisterNavigation(): false`) finche' la config non esiste.
4. `Actions/GoogleDrive/GetGoogleDriveFilesAction.php`: nessuna modifica di logica; nota per chi riattiva: legge il token dall'utente, non da un account di servizio.
5. Modelli e factory: non toccare in questa story (nessuna tabella: serve la decisione 3).

Fase 3, test (dopo guardia e verdetto Pest), senza database: usare `Tests\TestCase` della radice (come `Modules/Setting/tests/Unit/DatabaseConnectionTest.php`) e NON `Modules\CloudStorage\Tests\TestCase`, che ha `DatabaseTransactions` e che `tests/Pest.php` lega a `Unit` e `Feature`.
- `tests/Unit/Actions/GetGoogleDriveFilesActionTest.php`: con `config(['services.google.client_id' => 'x', ...])` e nessun utente, `execute()` lancia `Exception('Utente non autenticato')`; senza config lancia `InvalidArgumentException`. Nessuna chiamata di rete: la `Client` non viene mai usata prima dell'eccezione.
- `tests/Architecture/FilamentBasesTest.php` (senza `TestCase`): ogni classe sotto `Modules\CloudStorage\Filament` ha un antenato `Modules\Xot\Filament\*`.
- Test di `Number::fileSize` via la pagina solo se la pagina resta.

## Acceptance criteria

- [ ] `/usr/bin/find Modules/CloudStorage/docs/bmad -name filament-blueprint.md | wc -l` = 1.
- [ ] `rg -n -P -e "extends (BaseDashboard|Dashboard|Page|Widget)\b" --glob '*.php' Modules/CloudStorage/app/Filament` = nessuna riga (oggi 1).
- [ ] `rg -n -P "__\('(View File|Share to Corporate Folder)'\)|navigationLabel = '" --glob '*.php' Modules/CloudStorage/app` = nessuna riga (oggi 3).
- [ ] `rg -n -P "' (GB|MB|KB)'|' bytes'" --glob '*.php' Modules/CloudStorage/app` = nessuna riga (oggi 4).
- [ ] Se vivo: `ls Modules/CloudStorage/resources/views/filament/pages` contiene il file indicato da `$view` in `GoogleDriveFileListPage.php`.
- [ ] PHPStan gated su `Modules/CloudStorage/app`: exit 0 senza ignore.
- [ ] Fase 3: `rg -l -P -e '^(it|test)\(|function test|#\[Test\]' Modules/CloudStorage/tests` >= 2 file; test verdi senza aprire connessioni al database.

## Verifica

1. Ogni AC deve fallire prima: i `rg` stampano 1, 3 e 4 righe (controprova).
2. `php -l` su ogni file toccato, poi il gate PHPStan del blocco Vincoli su `Modules/CloudStorage/app`.
3. Controprova di "dormiente": `rg -l "CloudStorage" --glob '*.php' Modules/*/app | grep -v '^Modules/CloudStorage/'` deve restare vuoto; se qualcuno comincia a usarlo, aggiornare questa story.

## Vincoli

- PHPStan: unica config `laravel/phpstan.neon`, la modifica solo l'utente; mai altri `.neon`, mai `-c`/`--level`, nessun baseline/ignore. Ogni invocazione passa dal gate condiviso: `cd laravel && flock -w 1500 /tmp/claude-1000/-mnt-nas07-var-www--bases-base-quaeris-fila5/aeabb365-8395-48f4-b7d4-9fbb17ad85d3/scratchpad/phpstan-gate.lock nice -n 10 ./vendor/bin/phpstan analyse <path...> --memory-limit=2G --no-progress --error-format=raw` (max ~8 file o un modulo; `analyse Modules` intero solo dopo il "run completo finito" dell'altra sessione).
- Pest e PHPUnit FERMI: il 2026-10-20 `RefreshDatabase` ha fatto `migrate:fresh` su `quaeris_data_test`. Si riprende solo quando la guardia DB e' dentro (story `laravel/Modules/Xot/docs/stories/test-database-guard.story.md`) e l'utente ha confermato che i DB `*_test` sono usa-e-getta. Fino ad allora la verifica e' PHPStan + `php -l` + lettura.
- Concorrenza: altre sessioni scrivono nello stesso repo. Prima di scrivere un file esistente: `bashscripts/lock/check.sh <f> && [ $(( $(date +%s) - $(stat -c %Y <f>) )) -gt 120 ] && bashscripts/lock/lock.sh <f>`; un solo agente PHP per modulo; niente commit, reset, checkout, stash.
- zsh non divide `$VAR` in argomenti: usa array (`A=(x y); cmd $A`) o `xargs -a`. Un pattern `rg` che inizia con `-` richiede `-e`. Un `0` va sempre controprovato (rg -P piu' un secondo metodo).
- Docs: artefatti BMAD solo in `laravel/Modules/<M>/docs/`; nomi senza date; nessun Service (`app/Services` vietata, logica in Spatie QueueableAction con `execute()`); Filament: solo basi `XotBase*`, logica nelle Actions, nessuna stringa UI hardcoded (chiavi in `lang/`).
- Specifici: nessuna chiamata reale alle API Google nei test; nessuna credenziale in codice, log o docs; non toccare `config/**/services.php` ne' `config/**/database.php` (decide l'utente); nessuna migration scritta senza la decisione 3.

## Decisioni aperte

1. Modulo vivo o dormiente. Raccomandazione: dormiente. Disattivarlo in `modules_statuses.json` (file dell'utente) finche' non c'e' un caso d'uso, perche' un modulo abilitato espone pagine che si rompono.
2. Cancellare `GDriveFileListPage` (stub). Raccomandazione: si.
3. Se si riattiva: dove stanno i dati (`cloud_storage` come connessione propria o la connessione di default) e chi scrive le migration per i 5 modelli. Raccomandazione: non scriverle ora; partire dall'unica funzione che esiste (elenco di Drive) e togliere i modelli se non servono.
4. Rimuovere la dipendenza dai modelli `Modules\Quaeris\Models\*`, usando il contratto `Modules\Xot\Contracts\UserContract` come fa gia' l'Action. Raccomandazione: si, quando si tocca un modello.

## Come ripartire

1. `cd laravel && sed -n 1,30p Modules/CloudStorage/app/Filament/Pages/GoogleDriveFileListPage.php && ls Modules/CloudStorage/resources/views/filament/pages`: rivedere il nodo vista/tabella.
2. Chiedere all'utente la decisione 1; scrivere `Modules/CloudStorage/docs/bmad/filament-blueprint.md` con l'esito.
3. Applicare i passi 1-3 della fase 2, `php -l`, gate PHPStan su `Modules/CloudStorage/app`; annotare qui le cifre con data e ora UTC.
