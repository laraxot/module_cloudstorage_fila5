<?php

declare(strict_types=1);

namespace Modules\CloudStorage\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CloudStorage\Models\CloudStorageUpload;

/**
 * CloudStorageUpload factory.
 *
 * @extends Factory<CloudStorageUpload>
 */
class CloudStorageUploadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<CloudStorageUpload>
     */
    protected $model = CloudStorageUpload::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => // @var mixed faker->numberBetween(1, 1000
            'file_id' => // @var mixed faker->numberBetween(1, 10000
            'provider_id' => // @var mixed faker->numberBetween(1, 100
            'folder_id' => // @var mixed faker->optional(
            'original_filename' => sprintf('%s.%s', (string) // @var mixed faker->word(
            'temp_filename' => // @var mixed faker->uuid(
            'file_size' => // @var mixed faker->numberBetween(1024, 1073741824
            'mime_type' => // @var mixed faker->randomElement(['image/jpeg', 'image/png', 'application/pdf', 'text/plain', 'video/mp4']
            'upload_status' => // @var mixed faker->randomElement(['pending', 'uploading', 'completed', 'failed', 'cancelled']
            'progress_percentage' => // @var mixed faker->numberBetween(0, 100
            'upload_speed' => // @var mixed faker->randomFloat(2, 0.1, 100
            'estimated_time_remaining' => // @var mixed faker->optional(
            'started_at' => // @var mixed faker->optional(
            'completed_at' => // @var mixed faker->optional(
            'failed_at' => // @var mixed faker->optional(
            'cancelled_at' => // @var mixed faker->optional(
            'retry_count' => // @var mixed faker->numberBetween(0, 5
            'max_retries' => // @var mixed faker->numberBetween(3, 10
            'error_message' => // @var mixed faker->optional(
            'error_code' => // @var mixed faker->optional(
            'is_resumable' => // @var mixed faker->boolean(70
            'resume_position' => // @var mixed faker->optional(
            'chunk_size' => // @var mixed faker->numberBetween(1048576, 104857600
            'total_chunks' => // @var mixed faker->numberBetween(1, 100
            'uploaded_chunks' => // @var mixed faker->numberBetween(0, 100
            'checksum' => // @var mixed faker->sha1(
            'checksum_algorithm' => // @var mixed faker->randomElement(['md5', 'sha1', 'sha256', 'sha512']
            'is_encrypted' => // @var mixed faker->boolean(60
            'encryption_key' => // @var mixed faker->optional(
            'encryption_algorithm' => // @var mixed faker->optional(
            'is_compressed' => // @var mixed faker->boolean(40
            'compression_ratio' => // @var mixed faker->optional(
            'original_size' => // @var mixed faker->optional(
            'compressed_size' => // @var mixed faker->optional(
            'ip_address' => // @var mixed faker->ipv4(
            'user_agent' => // @var mixed faker->userAgent(
            'session_id' => // @var mixed faker->uuid(
            'request_id' => // @var mixed faker->uuid(
            'priority' => // @var mixed faker->numberBetween(1, 10
            'is_background' => // @var mixed faker->boolean(30
            'notify_on_completion' => // @var mixed faker->boolean(80
            'notify_on_failure' => // @var mixed faker->boolean(90
            'webhook_url' => // @var mixed faker->optional(
            'callback_data' => // @var mixed faker->optional(
            'settings' => [
                'auto_compress' => // @var mixed faker->boolean(50
                'auto_encrypt' => // @var mixed faker->boolean(70
                'overwrite_existing' => // @var mixed faker->boolean(20
                'create_backup' => // @var mixed faker->boolean(60
                'validate_checksum' => // @var mixed faker->boolean(90
                'scan_virus' => // @var mixed faker->boolean(80
                'generate_thumbnail' => // @var mixed faker->boolean(70
                'extract_metadata' => // @var mixed faker->boolean(85
                'optimize_image' => // @var mixed faker->boolean(40
                'convert_format' => // @var mixed faker->boolean(30
                'watermark' => // @var mixed faker->boolean(20
                'resize_image' => // @var mixed faker->boolean(35
                'quality' => // @var mixed faker->numberBetween(50, 100
                'max_width' => // @var mixed faker->optional(
                'max_height' => // @var mixed faker->optional(
                'preserve_exif' => // @var mixed faker->boolean(60
                'strip_metadata' => // @var mixed faker->boolean(30
            ],
            'metadata' => [
                'upload_source' => // @var mixed faker->randomElement(['web', 'mobile_app', 'api', 'desktop_app', 'cli']
                'upload_method' => // @var mixed faker->randomElement(['single', 'chunked', 'streaming', 'multipart']
                'browser_info' => // @var mixed faker->optional(
                'device_info' => // @var mixed faker->optional(
                'location' => // @var mixed faker->optional(
                'timezone' => // @var mixed faker->optional(
                'language' => // @var mixed faker->optional(
                'referrer' => // @var mixed faker->optional(
                'campaign' => // @var mixed faker->optional(
                'tags' => // @var mixed faker->optional(
                'category' => // @var mixed faker->optional(
                'description' => // @var mixed faker->optional(
                'keywords' => // @var mixed faker->optional(
                'author' => // @var mixed faker->optional(
                'copyright' => // @var mixed faker->optional(
                'license' => // @var mixed faker->optional(
                'rating' => // @var mixed faker->optional(
                'views' => // @var mixed faker->optional(
                'downloads' => // @var mixed faker->optional(
                'favorites' => // @var mixed faker->optional(
                'comments' => // @var mixed faker->optional(
                'shares' => // @var mixed faker->optional(
            ],
        ];
    }

    /**
     * Safely cast metadata to array.
     *
     * @return array<string, mixed>
     */
    private function safeMetadata(mixed $metadata): array
    {
        /** @var array<string, mixed> $result */
        $result = is_array($metadata) ? $metadata : [];

        return $result;
    }

    /**
     * Safely cast settings to array.
     *
     * @return array<string, mixed>
     */
    private function safeSettings(mixed $settings): array
    {
        /** @var array<string, mixed> $result */
        $result = is_array($settings) ? $settings : [];

        return $result;
    }

    /**
     * Indicate that the upload is pending.
     */
    public function pending(): static
    {
        return // @var mixed state(fn (array $attributes
            'upload_status' => 'pending',
            'progress_percentage' => 0,
            'started_at' => null,
            'completed_at' => null,
            'failed_at' => null,
            'cancelled_at' => null,
        ]);
    }

    /**
     * Indicate that the upload is in progress.
     */
    public function uploading(): static
    {
        return // @var mixed state(fn (array $attributes
            'upload_status' => 'uploading',
            'progress_percentage' => // @var mixed faker->numberBetween(1, 99
            'started_at' => // @var mixed faker->dateTimeBetween('-1 hour', 'now'
            'completed_at' => null,
            'failed_at' => null,
            'cancelled_at' => null,
        ]);
    }

    /**
     * Indicate that the upload is completed.
     */
    public function completed(): static
    {
        return // @var mixed state(fn (array $attributes
            'upload_status' => 'completed',
            'progress_percentage' => 100,
            'started_at' => // @var mixed faker->dateTimeBetween('-1 hour', '-30 minutes'
            'completed_at' => // @var mixed faker->dateTimeBetween('-30 minutes', 'now'
            'failed_at' => null,
            'cancelled_at' => null,
            'uploaded_chunks' => $attributes['total_chunks'],
        ]);
    }

    /**
     * Indicate that the upload failed.
     */
    public function failed(): static
    {
        return // @var mixed state(fn (array $attributes
            'upload_status' => 'failed',
            'progress_percentage' => // @var mixed faker->numberBetween(0, 99
            'started_at' => // @var mixed faker->dateTimeBetween('-1 hour', '-30 minutes'
            'completed_at' => null,
            'failed_at' => // @var mixed faker->dateTimeBetween('-30 minutes', 'now'
            'cancelled_at' => null,
            'error_message' => // @var mixed faker->sentence(
            'error_code' => // @var mixed faker->randomElement(['NETWORK_ERROR', 'QUOTA_EXCEEDED', 'INVALID_FILE', 'PROVIDER_ERROR']
        ]);
    }

    /**
     * Indicate that the upload was cancelled.
     */
    public function cancelled(): static
    {
        return // @var mixed state(fn (array $attributes
            'upload_status' => 'cancelled',
            'progress_percentage' => // @var mixed faker->numberBetween(0, 99
            'started_at' => // @var mixed faker->dateTimeBetween('-1 hour', '-30 minutes'
            'completed_at' => null,
            'failed_at' => null,
            'cancelled_at' => // @var mixed faker->dateTimeBetween('-30 minutes', 'now'
        ]);
    }

    /**
     * Create a small file upload.
     */
    public function small(): static
    {
        return // @var mixed state(fn (array $attributes
            'file_size' => // @var mixed faker->numberBetween(1024, 1048576
            'total_chunks' => 1,
            'chunk_size' => 1048576, // 1MB
        ]);
    }

    /**
     * Create a large file upload.
     */
    public function large(): static
    {
        return // @var mixed state(fn (array $attributes
            'file_size' => // @var mixed faker->numberBetween(104857600, 1073741824
            'total_chunks' => // @var mixed faker->numberBetween(10, 100
            'chunk_size' => 10485760, // 10MB
        ]);
    }

    /**
     * Create an image upload.
     */
    public function image(): static
    {
        return // @var mixed state(fn (array $attributes
            'mime_type' => // @var mixed faker->randomElement(['image/jpeg', 'image/png', 'image/gif', 'image/webp']
            'original_filename' => // @var mixed faker->randomElement(['photo.jpg', 'image.png', 'screenshot.gif', 'picture.webp']
            'settings' => array_merge(// @var mixed safeSettings($attributes['settings'] ?? []
                'generate_thumbnail' => true,
                'optimize_image' => true,
                'preserve_exif' => true,
            ]),
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'category' => 'image',
            ]),
        ]);
    }

    /**
     * Create a document upload.
     */
    public function document(): static
    {
        return // @var mixed state(fn (array $attributes
            'mime_type' => // @var mixed faker->randomElement(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/plain']
            'original_filename' => // @var mixed faker->randomElement(['document.pdf', 'report.docx', 'notes.txt', 'presentation.pptx']
            'settings' => array_merge(// @var mixed safeSettings($attributes['settings'] ?? []
                'extract_metadata' => true,
                'scan_virus' => true,
            ]),
            'metadata' => array_merge(// @var mixed safeMetadata($attributes['metadata'] ?? []
                'category' => 'document',
            ]),
        ]);
    }

    /**
     * Create a video upload.
     */
    public function video(): static
    {
        return // @var mixed state(fn (array $attributes
            'mime_type' => // @var mixed faker->randomElement(['video/mp4', 'video/avi', 'video/mov', 'video/wmv']
            'original_filename' => // @var mixed faker->randomElement(['video.mp4', 'movie.avi', 'clip.mov', 'recording.wmv']
            'file_size' => // @var mixed faker->numberBetween(10485760, 1073741824
            'settings' => array_merge(// @var mixed safeSettings($attributes['settings'] ?? []
                'extract_metadata' => true,
                'generate_thumbnail' => true,
            ]),
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'category' => 'video',
            ]),
        ]);
    }

    /**
     * Create an audio upload.
     */
    public function audio(): static
    {
        return // @var mixed state(fn (array $attributes
            'mime_type' => // @var mixed faker->randomElement(['audio/mpeg', 'audio/wav', 'audio/flac', 'audio/ogg']
            'original_filename' => // @var mixed faker->randomElement(['song.mp3', 'recording.wav', 'music.flac', 'podcast.ogg']
            'settings' => array_merge(// @var mixed safeSettings($attributes['settings'] ?? []
                'extract_metadata' => true,
            ]),
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'category' => 'audio',
            ]),
        ]);
    }

    /**
     * Create an archive upload.
     */
    public function archive(): static
    {
        return // @var mixed state(fn (array $attributes
            'mime_type' => // @var mixed faker->randomElement(['application/zip', 'application/x-rar-compressed', 'application/x-7z-compressed', 'application/x-tar']
            'original_filename' => // @var mixed faker->randomElement(['archive.zip', 'files.rar', 'backup.7z', 'data.tar']
            'settings' => array_merge(// @var mixed safeSettings($attributes['settings'] ?? []
                'scan_virus' => true,
                'extract_metadata' => true,
            ]),
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'category' => 'archive',
            ]),
        ]);
    }

    /**
     * Create a high priority upload.
     */
    public function highPriority(): static
    {
        return // @var mixed state(fn (array $attributes
            'priority' => // @var mixed faker->numberBetween(1, 3
            'is_background' => false,
        ]);
    }

    /**
     * Create a low priority upload.
     */
    public function lowPriority(): static
    {
        return // @var mixed state(fn (array $attributes
            'priority' => // @var mixed faker->numberBetween(8, 10
            'is_background' => true,
        ]);
    }

    /**
     * Create a background upload.
     */
    public function background(): static
    {
        return // @var mixed state(fn (array $attributes
            'is_background' => true,
            'priority' => // @var mixed faker->numberBetween(5, 10
        ]);
    }

    /**
     * Create a foreground upload.
     */
    public function foreground(): static
    {
        return // @var mixed state(fn (array $attributes
            'is_background' => false,
            'priority' => // @var mixed faker->numberBetween(1, 5
        ]);
    }

    /**
     * Create a resumable upload.
     */
    public function resumable(): static
    {
        return // @var mixed state(fn (array $attributes
            'is_resumable' => true,
            'chunk_size' => 10485760, // 10MB
            'total_chunks' => // @var mixed faker->numberBetween(5, 50
        ]);
    }

    /**
     * Create a non-resumable upload.
     */
    public function nonResumable(): static
    {
        return // @var mixed state(fn (array $attributes
            'is_resumable' => false,
            'chunk_size' => $attributes['file_size'],
            'total_chunks' => 1,
        ]);
    }

    /**
     * Create an encrypted upload.
     */
    public function encrypted(): static
    {
        return // @var mixed state(fn (array $attributes
            'is_encrypted' => true,
            'encryption_key' => // @var mixed faker->sha1(
            'encryption_algorithm' => // @var mixed faker->randomElement(['AES-256', 'ChaCha20', 'Twofish']
        ]);
    }

    /**
     * Create a non-encrypted upload.
     */
    public function nonEncrypted(): static
    {
        return // @var mixed state(fn (array $attributes
            'is_encrypted' => false,
            'encryption_key' => null,
            'encryption_algorithm' => null,
        ]);
    }

    /**
     * Create a compressed upload.
     */
    public function compressed(): static
    {
        return // @var mixed state(fn (array $attributes
            'is_compressed' => true,
            'compression_ratio' => // @var mixed faker->randomFloat(2, 0.1, 0.9
            'original_size' => // @var mixed faker->numberBetween(1048576, 1073741824
            'compressed_size' => // @var mixed faker->numberBetween(1048576, 1073741824
        ]);
    }

    /**
     * Create a non-compressed upload.
     */
    public function nonCompressed(): static
    {
        return // @var mixed state(fn (array $attributes
            'is_compressed' => false,
            'compression_ratio' => null,
            'original_size' => null,
            'compressed_size' => null,
        ]);
    }

    /**
     * Create an upload with notifications.
     */
    public function withNotifications(): static
    {
        return // @var mixed state(fn (array $attributes
            'notify_on_completion' => true,
            'notify_on_failure' => true,
        ]);
    }

    /**
     * Create an upload without notifications.
     */
    public function withoutNotifications(): static
    {
        return // @var mixed state(fn (array $attributes
            'notify_on_completion' => false,
            'notify_on_failure' => false,
        ]);
    }

    /**
     * Create an upload with webhook.
     */
    public function withWebhook(): static
    {
        return // @var mixed state(fn (array $attributes
            'webhook_url' => // @var mixed faker->url(
            'callback_data' => // @var mixed faker->text(
        ]);
    }

    /**
     * Create an upload without webhook.
     */
    public function withoutWebhook(): static
    {
        return // @var mixed state(fn (array $attributes
            'webhook_url' => null,
            'callback_data' => null,
        ]);
    }

    /**
     * Create an upload with retries.
     */
    public function withRetries(): static
    {
        return // @var mixed state(fn (array $attributes
            'retry_count' => // @var mixed faker->numberBetween(1, 5
            'max_retries' => // @var mixed faker->numberBetween(3, 10
        ]);
    }

    /**
     * Create an upload without retries.
     */
    public function withoutRetries(): static
    {
        return // @var mixed state(fn (array $attributes
            'retry_count' => 0,
            'max_retries' => 0,
        ]);
    }

    /**
     * Create a fast upload.
     */
    public function fast(): static
    {
        return // @var mixed state(fn (array $attributes
            'upload_speed' => // @var mixed faker->randomFloat(2, 10, 100
            'estimated_time_remaining' => // @var mixed faker->numberBetween(1, 300
        ]);
    }

    /**
     * Create a slow upload.
     */
    public function slow(): static
    {
        return // @var mixed state(fn (array $attributes
            'upload_speed' => // @var mixed faker->randomFloat(2, 0.1, 5
            'estimated_time_remaining' => // @var mixed faker->numberBetween(600, 3600
        ]);
    }

    /**
     * Create an upload from web.
     */
    public function fromWeb(): static
    {
        return // @var mixed state(fn (array $attributes
            'metadata' => array_merge(// @var mixed safeMetadata($attributes['metadata'] ?? []
                'upload_source' => 'web',
                'browser_info' => // @var mixed faker->userAgent(
            ]),
        ]);
    }

    /**
     * Create an upload from mobile app.
     */
    public function fromMobileApp(): static
    {
        return // @var mixed state(fn (array $attributes
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'upload_source' => 'mobile_app',
                'device_info' => // @var mixed faker->randomElement(['iOS 15.0', 'Android 12.0', 'iOS 16.0', 'Android 13.0']
            ]),
        ]);
    }

    /**
     * Create an upload from API.
     */
    public function fromApi(): static
    {
        return // @var mixed state(fn (array $attributes
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'upload_source' => 'api',
                'referrer' => // @var mixed faker->url(
            ]),
        ]);
    }
}
