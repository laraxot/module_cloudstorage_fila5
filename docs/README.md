# ☁️ **CloudStorage Module** - Astrazione Storage Multi-Provider

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![PHPStan level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![Multi-Provider](https://img.shields.io/badge/Providers-Google%20%7C%20S3%20%7C%20Dropbox-blue.svg)](https://laravel.com/docs/11.x/filesystem)

> **🚀 Modulo CloudStorage**: Un layer di astrazione avanzato per la gestione dei file su cloud. Permette di interagire con diversi provider (Google Drive, AWS S3, Dropbox) attraverso un'interfaccia unificata, garantendo sicurezza, crittografia e tracciabilità.

## 📋 **Panoramica**

Il modulo **CloudStorage** astrae la complessità dei singoli provider cloud, permettendo all'applicazione di gestire il ciclo di vita dei file in modo agnostico rispetto allo storage fisico.

- 🏗️ **Provider Abstraction**: Interfaccia unica per Google Drive, Dropbox, AWS S3, etc.
- 🔄 **Lifecycle Management**: Tracking degli stati (pending, uploading, completed, failed).
- 🔐 **Secure Encryption**: Supporto nativo per la crittografia dei file sensibili.
- 📊 **Quota & Analytics**: Monitoraggio dello spazio utilizzato e conteggio file per utente/tenant.
- 🤝 **Sharing System**: Sistema di condivisione file con token sicuri e scadenze temporali.

## ⚡ **Funzionalità Core**

### 🧩 **Multi-Provider Support**
Integrazione pronta all'uso con l'ecosistema Google (Drive, Sheet, Photo) e predisposizione per i principali servizi di object storage.

### 🧘 **Philosophical Design**
Il modulo segue il principio: "Il file appartiene all'utente nel contesto del Cloud". Ogni operazione è tracciata e autorizzata tramite policy rigorose.

## 🚀 **Quick Start**

### 📦 **Upload via Action**
```php
use Modules\CloudStorage\Actions\UploadToCloudAction;

$cloudFile = app(UploadToCloudAction::class)->execute($localPath, 'google_drive');
```

### 🔗 **Generazione Link Condivisione**
```php
$shareLink = $cloudFile->generateShareLink(expiresAt: now()->addDays(7));
```

## 📚 **Documentazione Centrale**

- 📖 **[Indice Documentazione](./index.md)** - Mappa completa dei componenti.
- 🙏 **[Filosofia](./philosophy.md)** - I 5 comandamenti dello Storage Cloud.
- 🗺️ **[Roadmap](./roadmap.md)** - Evoluzione verso il Multi-Cloud failover.
- 🔑 **[Google Credentials](./google-credentials.md)** - Guida al setup delle API Google.

---

**🔄 Ultimo aggiornamento**: 31 Gennaio 2026
**📦 Versione**: 1.2.0
**✅ PHPStan level 10**: Compliance verificata

## AI Workflows
- [AI Methodologies](./ai-methodologies.md)
