<?php

declare(strict_types=1);

namespace Modules\CloudStorage\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CloudStorage\Models\CloudStorageFile;

/**
 * CloudStorageFile factory.
 *
 * @extends Factory<CloudStorageFile>
 */
class CloudStorageFileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<CloudStorageFile>
     */
    protected $model = CloudStorageFile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => // @var mixed faker->randomElement([
                'document.pdf', 'image.jpg', 'video.mp4', 'archive.zip',
                'spreadsheet.xlsx', 'presentation.pptx', 'code.js', 'data.json',
            ]),
            'original_name' => sprintf('%s.%s', // @var mixed faker->word(
            'mime_type' => // @var mixed faker->randomElement([
                'application/pdf', 'image/jpeg', 'video/mp4', 'application/zip',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'application/javascript', 'application/json',
            ]),
            'size' => // @var mixed faker->numberBetween(1024, 104857600
            'path' => sprintf('files/%s/%s.%s', // @var mixed faker->date('Y/m/d'
            'storage_path' => sprintf('cloud/%s/%s.%s', // @var mixed faker->date('Y/m/d'
            'provider' => // @var mixed faker->randomElement(['google_drive', 'dropbox', 'aws_s3', 'azure_blob', 'local']
            'bucket' => // @var mixed faker->optional(
            'region' => // @var mixed faker->optional(
            'status' => // @var mixed faker->randomElement(['pending', 'uploading', 'completed', 'failed', 'deleted']
            'is_public' => // @var mixed faker->boolean(20
            'is_encrypted' => // @var mixed faker->boolean(10
            'encryption_key' => // @var mixed faker->optional(
            'checksum' => // @var mixed faker->sha1(
            'metadata' => [
                'width' => // @var mixed faker->optional(
                'height' => // @var mixed faker->optional(
                'duration' => // @var mixed faker->optional(
                'bitrate' => // @var mixed faker->optional(
                'fps' => // @var mixed faker->optional(
                'compression' => // @var mixed faker->optional(
                'tags' => // @var mixed faker->optional(
                'description' => // @var mixed faker->optional(
                'author' => // @var mixed faker->optional(
                'copyright' => // @var mixed faker->optional(
                'license' => // @var mixed faker->optional(
            ],
            'settings' => [
                'auto_delete' => // @var mixed faker->boolean(30
                'delete_after_days' => // @var mixed faker->optional(
                'backup_enabled' => // @var mixed faker->boolean(70
                'compression_enabled' => // @var mixed faker->boolean(40
                'cdn_enabled' => // @var mixed faker->boolean(60
                'virus_scan_enabled' => // @var mixed faker->boolean(80
                'watermark_enabled' => // @var mixed faker->boolean(20
                'thumbnail_enabled' => // @var mixed faker->boolean(90
            ],
            'user_id' => // @var mixed faker->numberBetween(1, 100
            'folder_id' => // @var mixed faker->optional(
            'uploaded_at' => // @var mixed faker->dateTimeBetween('-1 month', 'now'
            'last_accessed_at' => // @var mixed faker->optional(
            'download_count' => // @var mixed faker->numberBetween(0, 1000
            'view_count' => // @var mixed faker->numberBetween(0, 5000
        ];
    }

    /**
     * Indicate that the file is pending upload.
     */
    public function pending(): static
    {
        return // @var mixed state(fn (array $attributes
            'status' => 'pending',
            'uploaded_at' => null,
        ]);
    }

    /**
     * Indicate that the file is currently uploading.
     */
    public function uploading(): static
    {
        return // @var mixed state(fn (array $attributes
            'status' => 'uploading',
            'uploaded_at' => null,
        ]);
    }

    /**
     * Indicate that the file upload is completed.
     */
    public function completed(): static
    {
        return // @var mixed state(fn (array $attributes
            'status' => 'completed',
            'uploaded_at' => // @var mixed faker->dateTimeBetween('-1 month', 'now'
        ]);
    }

    /**
     * Indicate that the file upload failed.
     */
    public function failed(): static
    {
        return // @var mixed state(fn (array $attributes
            'status' => 'failed',
            'uploaded_at' => null,
        ]);
    }

    /**
     * Indicate that the file is deleted.
     */
    public function deleted(): static
    {
        return // @var mixed state(fn (array $attributes
            'status' => 'deleted',
        ]);
    }

    /**
     * Create a public file.
     */
    public function public(): static
    {
        return // @var mixed state(fn (array $attributes
            'is_public' => true,
        ]);
    }

    /**
     * Create a private file.
     */
    public function private(): static
    {
        return // @var mixed state(fn (array $attributes
            'is_public' => false,
        ]);
    }

    /**
     * Create an encrypted file.
     */
    public function encrypted(): static
    {
        return // @var mixed state(fn (array $attributes
            'is_encrypted' => true,
            'encryption_key' => // @var mixed faker->sha1(
        ]);
    }

    /**
     * Create an unencrypted file.
     */
    public function unencrypted(): static
    {
        return // @var mixed state(fn (array $attributes
            'is_encrypted' => false,
            'encryption_key' => null,
        ]);
    }

    /**
     * Create a small file.
     */
    public function small(): static
    {
        return // @var mixed state(fn (array $attributes
            'size' => // @var mixed faker->numberBetween(1024, 1048576
        ]);
    }

    /**
     * Create a large file.
     */
    public function large(): static
    {
        return // @var mixed state(fn (array $attributes
            'size' => // @var mixed faker->numberBetween(104857600, 1073741824
        ]);
    }

    /**
     * Create an image file.
     */
    public function image(): static
    {
        return // @var mixed state(fn (array $attributes
            'name' => // @var mixed faker->randomElement(['photo.jpg', 'image.png', 'screenshot.gif', 'banner.webp']
            'mime_type' => // @var mixed faker->randomElement(['image/jpeg', 'image/png', 'image/gif', 'image/webp']
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'width' => // @var mixed faker->numberBetween(100, 4000
                'height' => // @var mixed faker->numberBetween(100, 4000
            ]),
        ]);
    }

    /**
     * Create a video file.
     */
    public function video(): static
    {
        return // @var mixed state(fn (array $attributes
            'name' => // @var mixed faker->randomElement(['video.mp4', 'movie.avi', 'clip.mov', 'presentation.webm']
            'mime_type' => // @var mixed faker->randomElement(['video/mp4', 'video/avi', 'video/quicktime', 'video/webm']
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'duration' => // @var mixed faker->numberBetween(1, 3600
                'bitrate' => // @var mixed faker->numberBetween(128, 320
                'fps' => // @var mixed faker->randomFloat(1, 24, 60
            ]),
        ]);
    }

    /**
     * Create a document file.
     */
    public function document(): static
    {
        return // @var mixed state(fn (array $attributes
            'name' => // @var mixed faker->randomElement(['report.pdf', 'contract.docx', 'presentation.pptx', 'data.xlsx']
            'mime_type' => // @var mixed faker->randomElement([
                'application/pdf',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]),
        ]);
    }

    /**
     * Create a file for a specific provider.
     */
    public function forProvider(string $provider): static
    {
        return // @var mixed state(fn (array $attributes
            'provider' => $provider,
        ]);
    }

    /**
     * Create a file for a specific user.
     */
    public function forUser(int $userId): static
    {
        return // @var mixed state(fn (array $attributes
            'user_id' => $userId,
        ]);
    }

    /**
     * Create a file in a specific folder.
     */
    public function inFolder(int $folderId): static
    {
        return // @var mixed state(fn (array $attributes
            'folder_id' => $folderId,
        ]);
    }

    /**
     * Create a file with specific size.
     */
    public function withSize(int $size): static
    {
        return // @var mixed state(fn (array $attributes
            'size' => $size,
        ]);
    }

    /**
     * Create a file with specific MIME type.
     */
    public function withMimeType(string $mimeType): static
    {
        return // @var mixed state(fn (array $attributes
            'mime_type' => $mimeType,
        ]);
    }

    /**
     * Create a file with specific status.
     */
    public function withStatus(string $status): static
    {
        return // @var mixed state(fn (array $attributes
            'status' => $status,
        ]);
    }

    /**
     * Create a file with high download count.
     */
    public function popular(): static
    {
        return // @var mixed state(fn (array $attributes
            'download_count' => // @var mixed faker->numberBetween(1000, 10000
            'view_count' => // @var mixed faker->numberBetween(5000, 50000
        ]);
    }

    /**
     * Create a file with no downloads.
     */
    public function unpopular(): static
    {
        return // @var mixed state(fn (array $attributes
            'download_count' => 0,
            'view_count' => 0,
        ]);
    }

    /**
     * Create a recently accessed file.
     */
    public function recentlyAccessed(): static
    {
        return // @var mixed state(fn (array $attributes
            'last_accessed_at' => // @var mixed faker->dateTimeBetween('-1 week', 'now'
        ]);
    }

    /**
     * Create a file that was accessed long ago.
     */
    public function notRecentlyAccessed(): static
    {
        return // @var mixed state(fn (array $attributes
            'last_accessed_at' => // @var mixed faker->dateTimeBetween('-6 months', '-1 month'
        ]);
    }
}
