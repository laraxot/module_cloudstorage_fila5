---
title: "CloudStorage — Indice canonico docs"
status: canonical
module: CloudStorage
updated: 2026-10-20
---

> Indice canonico. Indici storici alternativi: `00-index.md`, `README.md`, `wiki/index.md`, `tasks/tasks-index.md`, `outputs/README.md`, `raw/README.md`. Nessun file storico cancellato.

> Convenzione: [Docs Organization — Modules & Themes](../../Xot/docs/conventions/docs-organization.md)

# CloudStorage — Indice docs

Modulo CloudStorage (integrazioni Google: Drive, Docs, Sheets, Photos).

## Panoramica
- [README.md](./README.md) — presentazione
- [00-index.md](./00-index.md) — indice storico del modulo
- [COVERAGE.md / coverage.md](./coverage.md) — copertura
- [DECISION-LOG.md / decision-log.md](./decision-log.md) — decisioni

## Architettura
- [performance/](./performance/) — analisi prestazioni (bottlenecks)
- [PERFORMANCE.md / performance](./performance/) — ottimizzazione
- [git-conflict-resolution.md](./git-conflict-resolution.md) — risoluzione conflitti

## PHPStan
- Report PHPStan e qualità: [coverage.md](./coverage.md), [decision-log.md](./decision-log.md), [stories/](./stories/)

## BMAD / Stories
- [bmad/](./bmad/) — dossier BMAD (decision-log, tech-spec, prd, ux, architecture)
- [stories/](./stories/) — storie feature (es. `cloudstorage-mixed-type-reduction.story.md`)

## Testing
- [tasks/](./tasks/) — task e checklist (es. `cloudstorage-filament-v5.md`)
- [roadmap/README.md](./roadmap/README.md) — stato avanzamento

## API / Guide
- [gdrive/api.md](./gdrive/api.md) — API Google Drive
- [gdoc/api.md](./gdoc/api.md) — API Google Docs
- [gdrive/spatie.md](./gdrive/spatie.md) — integrazione spatie
- [gdoc/tutorial.md](./gdoc/tutorial.md) · [gsheet/tutorial.md](./gsheet/tutorial.md) — tutorial
- [gdrive/clone.md](./gdrive/clone.md) — clonazione file
- [gphoto/kawax.md](./gphoto/kawax.md) · [gsheet/kawax.md](./gsheet/kawax.md) — esempi
- [roadmap/tasks/](./roadmap/tasks/) — task di roadmap

## Struttura
- `bmad/` — dossier BMAD (10 file: `livewire-widget-*.md`)
- `stories/` — storie feature (2 file)
- `wiki/` — wiki (`index.md`, `commands/`, `concepts/`, `memories/`, `rules/`, `skills/`)
- `gdrive/`, `gdoc/`, `gsheet/`, `gphoto/` — documentazione per provider Google
- `performance/` — analisi prestazioni
- `tasks/`, `roadmap/` — pianificazione e task
- `raw/`, `outputs/` — archivi e output

---
*Aggiornato: 2026-10-20 — conforme a `docs-organization.md`; `00-index.md` mantenuto in posto.
