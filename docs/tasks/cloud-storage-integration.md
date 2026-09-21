# Task 001: Implement Complete Cloud Storage Integration

## Description
Implement comprehensive cloud storage integration with support for multiple providers (S3, Azure Blob, Google Cloud Storage), file management, and secure access controls.

## Context
The CloudStorage module needs to provide a unified interface for file storage across multiple cloud providers with consistent APIs and security features.

## Requirements

### Functional Requirements
- Multi-provider support (AWS S3, Azure Blob, GCS, MinIO)
- Unified file upload/download API
- File metadata management
- Access control and permissions
- File versioning
- Temporary signed URLs
- Multipart upload for large files
- File preview generation
- Storage statistics and monitoring

### Technical Requirements
- Use PHP 8.3 strict typing
- PHPStan Level 10 compliance
- Laravel Filesystem
- League Flysystem
- Queue-based operations

## Implementation Steps

### 1. Database Schema
- [ ] Create `cloud_storage_files` table
  - id (uuid/ulid)
  - tenant_id
  - storage_provider (enum: 's3', 'azure', 'gcs', 'minio', 'local')
  - file_path (string)
  - file_name (string)
  - file_size (bigint)
  - mime_type (string)
  - file_hash (string, sha256)
  - is_public (boolean, default false)
  - metadata (json, nullable)
  - uploaded_by
  - expires_at (nullable, for temporary files)
  - deleted_at (nullable)
  - timestamps

- [ ] Create `cloud_storage_providers` table
  - id (uuid/ulid)
  - tenant_id
  - name (string)
  - provider_type (enum)
  - configuration (json, encrypted)
  - is_default (boolean, default false)
  - is_active (boolean, default true)
  - priority (int, default 0)
  - timestamps

- [ ] Create `cloud_storage_permissions` table
  - id (uuid/ulid)
  - file_id
  - user_id (nullable)
  - role_id (nullable)
  - permission (enum: 'read', 'write', 'delete', 'admin')
  - granted_by
  - granted_at
  - expires_at (nullable)

### 2. Models
- [ ] Create `CloudStorageFile` model
  - Extends base model
  - BelongsTo Tenant
  - BelongsTo User (uploaded_by)
  - HasMany CloudStoragePermission
  - Strict typing

- [ ] Create `CloudStorageProvider` model
  - Extends base model
  - BelongsTo Tenant
  - HasMany CloudStorageFile
  - Strict typing

- [ ] Create `CloudStoragePermission` model
  - Extends base model
  - BelongsTo CloudStorageFile
  - BelongsTo User
  - BelongsTo Role
  - Strict typing

### 3. Storage Manager Service
- [ ] Create `CloudStorageManager` service
  - `uploadFile(UploadedFile $file, array $options): CloudStorageFile`
  - `downloadFile(string $fileId): BinaryFileResponse`
  - `deleteFile(string $fileId): bool`
  - `getPublicUrl(string $fileId): string`
  - `getSignedUrl(string $fileId, int $expiration): string`
  - `copyFile(string $fileId, string $destination): CloudStorageFile`
  - `moveFile(string $fileId, string $destination): CloudStorageFile`
  - `getFileInfo(string $fileId): array`

### 4. Provider Adapters
- [ ] Create `StorageProviderAdapter` interface
  - `upload(string $path, $content): bool`
  - `download(string $path): string`
  - `delete(string $path): bool`
  - `exists(string $path): bool`
  - `getUrl(string $path): string`
  - `getSignedUrl(string $path, int $expiration): string`

- [ ] Implement S3 adapter
- [ ] Implement Azure Blob adapter
- [ ] Implement GCS adapter
- [ ] Implement MinIO adapter

### 5. File Processing
- [ ] Create `FileProcessorService`
  - `generateThumbnail(string $fileId): string`
  - `optimizeImage(string $fileId): bool`
  - `extractMetadata(string $fileId): array`
  - `validateFileType(UploadedFile $file, array $allowed): bool`
  - `scanForMalware(string $fileId): bool`

- [ ] Implement queue jobs
  - `ProcessThumbnailJob`
  - `OptimizeImageJob`
  - `ExtractMetadataJob`
  - `ScanMalwareJob`

### 6. Access Control
- [ ] Create `StorageAccessControl` service
  - `grantPermission(string $fileId, string $userId, string $permission): bool`
  - `revokePermission(string $fileId, string $userId): bool`
  - `checkPermission(string $fileId, string $userId, string $permission): bool`
  - `getUserFiles(string $userId): Collection`
  - `getSharedFiles(string $userId): Collection`

### 7. Versioning System
- [ ] Create `FileVersion` model
  - id, file_id, version_number, file_path, file_size, created_at

- [ ] Implement version control
  - `createVersion(string $fileId): FileVersion`
  - `restoreVersion(string $fileId, int $version): bool`
  - `listVersions(string $fileId): Collection`
  - `deleteOldVersions(string $fileId, int $keep = 5): int`

### 8. Multipart Upload
- [ ] Create `MultipartUploadService`
  - `initiateUpload(string $fileName, int $totalSize): string` (upload ID)
  - `uploadPart(string $uploadId, int $partNumber, UploadedFile $part): bool`
  - `completeUpload(string $uploadId, array $parts): CloudStorageFile`
  - `abortUpload(string $uploadId): bool`

### 9. Filament Resources
- [ ] Create `CloudStorageFileResource`
  - File browser
  - Upload functionality
  - File details
  - Permission management

- [ ] Create `CloudStorageProviderResource`
  - Provider management
  - Configuration forms
  - Test connection

- [ ] Create `CloudStorageWidget`
  - Storage usage
  - Recent uploads
  - Quick access

### 10. API Endpoints
- [ ] `POST /api/storage/upload` - Upload file
- [ ] `GET /api/storage/files/{id}` - Get file info
- [ ] `GET /api/storage/files/{id}/download` - Download file
- [ ] `DELETE /api/storage/files/{id}` - Delete file
- [ ] `GET /api/storage/files/{id}/url` - Get signed URL
- [ ] `POST /api/storage/files/{id}/share` - Share file
- [ ] `GET /api/storage/providers` - List providers

### 11. Actions
- [ ] Create `UploadFileAction`
- [ ] Create `DeleteFileAction`
- [ ] Create `ShareFileAction`
- [ ] Create `GrantPermissionAction`

### 12. Tests
- [ ] Create `CloudStorageUploadTest`
- [ ] Create `CloudStorageDownloadTest`
- [ ] Create `CloudStoragePermissionTest`
- [ ] Create `MultipartUploadTest`
- [ ] Create `StorageProviderTest`

### 13. Documentation
- [ ] Create storage provider guide
- [ ] Document API endpoints
- [ ] Create security best practices
- [ ] Add troubleshooting guide

## Acceptance Criteria
- [ ] All providers work correctly
- [ ] File upload/download is reliable
- [ ] Access control is enforced
- [ ] Multipart upload works for large files
- [ ] Versioning is functional
- [ ] All tests pass with 85%+ coverage
- [ ] PHPStan Level 10 compliant

## Dependencies
- Xot module (base classes)
- Tenant module (multi-tenancy)
- User module (access control)
- Filament 5.x (admin UI)

## Estimated Time
- Database schema: 3 hours
- Models: 3 hours
- Storage manager: 6 hours
- Provider adapters: 8 hours (4 adapters × 2h)
- File processing: 5 hours
- Access control: 4 hours
- Versioning: 3 hours
- Multipart upload: 4 hours
- Filament integration: 5 hours
- API endpoints: 3 hours
- Actions: 2 hours
- Tests: 8 hours
- Documentation: 3 hours

**Total: 57 hours (7 days)**

## Priority
**High** - Core storage functionality

## Related Tasks
- Task 002: Storage Analytics and Monitoring
- Task 003: Storage Backup and Sync

## Notes
- Use encryption for provider credentials
- Implement rate limiting for API
- Use queues for heavy operations
- Implement CDN integration for public files
- Monitor storage costs per provider

---

**Created**: 2026-01-31
**Status**: Pending
**Assignee**: TBD