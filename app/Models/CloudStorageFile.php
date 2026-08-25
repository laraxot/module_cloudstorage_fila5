<?php

declare(strict_types=1);

namespace Modules\CloudStorage\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\CloudStorage\Database\Factories\CloudStorageFileFactory;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;

/**
 * Cloud Storage File Model.
 *
 * @property int $id
 * @property string $name
 * @property string $original_name
 * @property string $mime_type
 * @property int $size
 * @property string $path
 * @property string $storage_path
 * @property string $provider
 * @property string|null $bucket
 * @property string|null $region
 * @property string $status
 * @property bool $is_public
 * @property bool $is_encrypted
 * @property string|null $encryption_key
 * @property string $checksum
 * @property array<string, mixed> $metadata
 * @property array<string, mixed> $settings
 * @property int $user_id
 * @property int|null $folder_id
 * @property Carbon|null $uploaded_at
 * @property Carbon|null $last_accessed_at
 * @property int $download_count
 * @property int $view_count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 *
 * @method static CloudStorageFileFactory factory($count = null, $state = [])
 * @method static Builder|CloudStorageFile newModelQuery()
 * @method static Builder|CloudStorageFile newQuery()
 * @method static Builder|CloudStorageFile query()
 *
 * @mixin \Eloquent
 */
class CloudStorageFile extends BaseModel
{
    protected $table = 'cloud_storage_files';

    protected $fillable = [
        'name', 'original_name', 'mime_type', 'size', 'path', 'storage_path', 'provider', 'bucket', 'region', 'status', 'is_public', 'is_encrypted', 'encryption_key', 'checksum', 'metadata', 'settings', 'user_id', 'folder_id', 'uploaded_at', 'last_accessed_at', 'download_count', 'view_count',
    ];

    protected $hidden = [
        'encryption_key',
    ];

   /**
     * @return BelongsTo<Model&UserContract, $this>
     */
    public function user(): BelongsTo
    {
        $userClass = XotData::make()->getUserClass();
        return $this->belongsTo($userClass);
    }

   /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

   /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeProvider(Builder $query, string $provider): Builder
    {
        return $query->where('provider', $provider);
    }

   /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopePublic(Builder $query): Builder
    {
        return $query->where('is_public', true);
    }

   /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }

    public function getHumanReadableSizeAttribute(): string
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        return round($bytes, 2).' '.$units[$i];
    }

    public function getExtensionAttribute(): string
    {
        return pathinfo($this->name, PATHINFO_EXTENSION);
    }

    public function getIsImageAttribute(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    public function getIsVideoAttribute(): bool
    {
        return str_starts_with($this->mime_type, 'video/');
    }

    public function getIsDocumentAttribute(): bool
    {
        return in_array($this->mime_type, [
            'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        ], true);
    }

    public function markAsAccessed(): void
    {
        $this->increment('view_count');
        $this->update(['last_accessed_at' => now()]);
    }

    public function incrementDownloads(): void
    {
        $this->increment('download_count');
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isUploading(): bool
    {
        return $this->status === 'uploading';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function isDeleted(): bool
    {
        return $this->status === 'deleted';
    }

    protected function casts(): array
    {
        return [
            'size' => 'integer', 'is_public' => 'boolean', 'is_encrypted' => 'boolean', 'metadata' => 'array', 'settings' => 'array', 'user_id' => 'integer', 'folder_id' => 'integer', 'download_count' => 'integer', 'view_count' => 'integer', 'uploaded_at' => 'datetime', 'last_accessed_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime',
        ];
    }
}
