# Task: CloudStorage Filament v5 Alignment (Clusters)

## 📋 Obiettivo
Organizzare le risorse del modulo CloudStorage in Clusters per facilitare la gestione dei file e dei provider in Filament v5.

## 🏗️ Struttura Proposta
- **StorageCluster**: 
    - **CloudFiles**: Lista dei file caricati e stati.
    - **SharedLinks**: Gestione delle condivisioni attive.
- **ProvidersCluster**:
    - **CloudProviders**: Configurazione e autenticazione OAuth.
    - **StorageQuotas**: Monitoraggio limiti di spazio.

## ✅ Checklist
- [ ] Creazione dei Cluster `StorageCluster` e `ProvidersCluster`.
- [ ] Migrazione delle risorse esistenti (Files, Providers).
- [ ] Implementazione di indicatori visuali per lo stato di sincronizzazione (Livewire polling).
- [ ] Aggiornamento dei componenti di upload per supportare le nuove API di Filament v5.

## 🔗 Riferimenti
- [Roadmap CloudStorage](../roadmap.md)
