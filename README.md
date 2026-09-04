# CloudStorage Module

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Filament 5.x](https://img.shields.io/badge/Filament-5.x-blue.svg)](https://filamentphp.com/)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![PHP 8.3+](https://img.shields.io/badge/PHP-8.3+-blue.svg)](https://php.net)

> **Cloud storage multi-provider**: astrazione unificata per Google Drive, AWS S3 e Dropbox. Gestione lifecycle file, encryption, quote, condivisione con token sicuri.

---

## Cosa fa

Il modulo CloudStorage fornisce un'interfaccia unificata per interagire con diversi provider di storage cloud. Gestisce il ciclo di vita completo dei file (upload, download, condivisione, eliminazione), supporta la crittografia per file sensibili, monitora le quote di spazio e permette la condivisione sicura tramite token temporanei.

```php
// Upload su qualsiasi provider con la stessa API
$file = CloudStorageFile::upload(
    provider: 'google-drive',
    path: 'surveys/report-2026.pdf',
    content: $pdfBinary,
    encrypt: true, // Crittografia automatica
);

// Condivisione con token temporaneo
$share = $file->createShare(
    expires_at: now()->addDays(7),
    max_downloads: 5,
);
// -> $share->url (link sicuro con scadenza)
```

---

## Modelli (5)

| Modello | Funzione |
|---------|----------|
| **CloudStorageFile** | File con metadati, provider, stato lifecycle |
| **CloudStorageUpload** | Operazione di upload con progresso |
| **CloudStorageProvider** | Configurazione provider (S3, GDrive, Dropbox) |
| **CloudStorageQuota** | Monitoraggio spazio per provider |
| **CloudStorageShare** | Condivisione con token e scadenza |

---

## Provider supportati

| Provider | Package | Feature |
|----------|---------|---------|
| **Google Drive** | Spatie Google Cloud Storage | Team Drive, folder sync |
| **AWS S3** | Laravel Filesystem (built-in) | Bucket policies, versioning |
| **Dropbox** | Spatie Dropbox API | Shared links, paper |

---

## Funzionalita

### Lifecycle file

```
Pending → Uploading → Completed → (Shared) → (Archived) → (Deleted)
                   ↘ Failed (retry automatico)
```

### Encryption

```php
// I file sensibili vengono crittografati prima dell'upload
// La decrittazione avviene al download
$file = CloudStorageFile::upload(
    path: 'private/gdpr-data.json',
    content: $sensitiveData,
    encrypt: true,
);
```

### Quote

```php
// Monitoraggio spazio per ogni provider
$quota = CloudStorageQuota::forProvider('google-drive');
$quota->used;      // 2.5 GB
$quota->available;  // 12.5 GB
$quota->percentage; // 16.7%
```

### Condivisione sicura

```php
// Token-based sharing con scadenza
$share = CloudStorageShare::create([
    'file_id' => $file->id,
    'token' => Str::random(64),
    'expires_at' => now()->addHours(24),
    'max_downloads' => 3,
]);
```

---

## Integrazione con altri moduli

```
CloudStorage <── Quaeris    (PDF report su cloud)
CloudStorage <── Media      (backup media files)
CloudStorage <── Notify     (allegati email da cloud)
CloudStorage <── Tenant     (storage per tenant)
```

---

## Quick Start

```bash
php artisan module:enable CloudStorage
php artisan migrate

# Configura il provider in .env
# CLOUD_STORAGE_PROVIDER=google-drive
# GOOGLE_CLOUD_STORAGE_BUCKET=my-bucket
```

---

## Metriche

| Metrica | Valore |
|---------|--------|
| **Modelli** | 5 |
| **Provider** | 3 (Google Drive, S3, Dropbox) |
| **PHPStan Level** | 10 |

---

**Module Type**: Cloud Storage Abstraction
**Architecture**: Multi-provider, encryption-ready, token-based sharing
**Quality**: PHPStan Level 10

*Storage cloud unificato: un'interfaccia per tutti i provider, con crittografia e condivisione sicura.*
