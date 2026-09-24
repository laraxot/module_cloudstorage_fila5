---
title: "CloudStorageFolderFactory — stub morto rimosso (PHPStan cleanup)"
status: done
module: CloudStorage
data: 2026-09-21
---

# Story: CloudStorageFolderFactory, stub morto rimosso

**Fase BMAD**: Fix (PHPStan). Trigger: utente, "sistema tutte le segnalazioni di
phpstan con bmad + second brain", a seguito di un paste con 40 errori
`./vendor/bin/phpstan analyse Modules/` (poi ridotti a 5, tutti in questo file,
dopo che una sessione concorrente aveva gia' sistemato gli altri 35 nel
frattempo — vedi [[misurare-mentre-un-altro-scrive]]).

## Analisi

`Modules/CloudStorage/database/factories/CloudStorageFolderFactory.php`:
factory con `protected $model = \stdClass::class;` e commento
`@TODO: Implementare il modello CloudStorageFolder - attualmente usa stdClass`.
5 errori PHPStan, tutti conseguenza dello stesso problema strutturale:

1. `missingType.generics` — `extends Factory` senza `@extends Factory<TModel>`.
2. `property.defaultValue` — `$model` tipizzato `class-string<Model>` dal
   parent, `stdClass` non estende `Model`.
3. `parameter.notOptional` — `definition(Faker $faker)`: la firma del parent
   `Factory::definition(): array` non ha parametri; Laravel inietta `$this->faker`
   nel costruttore, non come argomento.
4-5. `method.notFound` — `$faker->optional()->json()`: `Faker\Generator` non ha
   mai avuto un metodo `json()` nativo (fakerphp/faker non include un provider
   JSON out of the box).

Verificato **zero chiamanti in tutto il repo** (`grep -rn
"CloudStorageFolderFactory\|CloudStorageFolder::factory\|CloudStorageFolder("`
su `*.php`): nessun modello `CloudStorageFolder` esiste, nessun test, nessun
seeder la usa.

## Perche' non e' "aggiustabile" senza inventare scope

Una `Factory` Laravel e' strutturalmente vincolata a un `Model` Eloquent reale
(`Factory<TModel of Model>`). Non esiste modo di soddisfare i tipi con
`stdClass` come target: dichiarare `@extends Factory<\stdClass>` sposta
l'errore (viola il bound generico `TModel extends Model` del parent) invece di
risolverlo. L'unica correzione onesta senza inventare un Model+migration mai
richiesti (vietato da `.claude/CLAUDE.md`: "se devi creare nuove tabelle,
chiedi prima") e' rimuovere lo stub: codice morto, mai finibile nello stato
attuale, zero blast radius.

## Fix

`git rm Modules/CloudStorage/database/factories/CloudStorageFolderFactory.php`.

## Verifica

- `grep` pre-rimozione: zero riferimenti residui dopo la rimozione (nessun
  altro file la nomina).
- `./vendor/bin/phpstan clear-result-cache && ./vendor/bin/phpstan analyse
  Modules/`: **0 errori repo-wide** (non solo sul file), confermato 2 volte
  di seguito per escludere un falso zero da cache — vedi
  [[phpstan-result-cache-gate-muto]].

## Follow-up

Se in futuro serve davvero un `CloudStorageFolder` Eloquent (tabella,
migration, relazione `belongsTo(Provider)`/`hasMany(File)`), va chiesto
esplicitamente prima di creare tabelle nuove per poi far rinascere la factory
con `$model` reale.
