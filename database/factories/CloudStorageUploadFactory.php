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
            'user_id' => $faker->numberBetween(1, 1000
            'file_id' => $faker->numberBetween(1, 10000
            'provider_id' => $faker->numberBetween(1, 100
            'folder_id' => $faker->optional(
            'original_filename' => sprintf('%s.%s', (string) $faker->word(
            'temp_filename' => $faker->uuid(
            'file_size' => $faker->numberBetween(1024, 1073741824
            'mime_type' => $faker->randomElement(['image/jpeg', 'image/png', 'application/pdf', 'text/plain', 'video/mp4']
            'upload_status' => $faker->randomElement(['pending', 'uploading', 'completed', 'failed', 'cancelled']
            'progress_percentage' => $faker->numberBetween(0, 100
            'upload_speed' => $faker->randomFloat(2, 0.1, 100
            'estimated_time_remaining' => $faker->optional(
            'started_at' => $faker->optional(
            'completed_at' => $faker->optional(
            'failed_at' => $faker->optional(
            'cancelled_at' => $faker->optional(
            'retry_count' => $faker->numberBetween(0, 5
            'max_retries' => $faker->numberBetween(3, 10
            'error_message' => $faker->optional(
            'error_code' => $faker->optional(
            'is_resumable' => $faker->boolean(70
            'resume_position' => $faker->optional(
            'chunk_size' => $faker->numberBetween(1048576, 104857600
            'total_chunks' => $faker->numberBetween(1, 100
            'uploaded_chunks' => $faker->numberBetween(0, 100
            'checksum' => $faker->sha1(
            'checksum_algorithm' => $faker->randomElement(['md5', 'sha1', 'sha256', 'sha512']
            'is_encrypted' => $faker->boolean(60
            'encryption_key' => $faker->optional(
            'encryption_algorithm' => $faker->optional(
            'is_compressed' => $faker->boolean(40
            'compression_ratio' => $faker->optional(
            'original_size' => $faker->optional(
            'compressed_size' => $faker->optional(
            'ip_address' => $faker->ipv4(
            'user_agent' => $faker->userAgent(
            'session_id' => $faker->uuid(
            'request_id' => $faker->uuid(
            'priority' => $faker->numberBetween(1, 10
            'is_background' => $faker->boolean(30
            'notify_on_completion' => $faker->boolean(80
            'notify_on_failure' => $faker->boolean(90
            'webhook_url' => $faker->optional(
            'callback_data' => $faker->optional(
            'settings' => [
                'auto_compress' => $faker->boolean(50
                'auto_encrypt' => $faker->boolean(70
                'overwrite_existing' => $faker->boolean(20
                'create_backup' => $faker->boolean(60
                'validate_checksum' => $faker->boolean(90
                'scan_virus' => $faker->boolean(80
                'generate_thumbnail' => $faker->boolean(70
                'extract_metadata' => $faker->boolean(85
                'optimize_image' => $faker->boolean(40
                'convert_format' => $faker->boolean(30
                'watermark' => $faker->boolean(20
                'resize_image' => $faker->boolean(35
                'quality' => $faker->numberBetween(50, 100
                'max_width' => $faker->optional(
                'max_height' => $faker->optional(
                'preserve_exif' => $faker->boolean(60
                'strip_metadata' => $faker->boolean(30)
            ],
            'metadata' => [
                'upload_source' => $faker->randomElement(['web', 'mobile_app', 'api', 'desktop_app', 'cli']
                'upload_method' => $faker->randomElement(['single', 'chunked', 'streaming', 'multipart']
                'browser_info' => $faker->optional(
                'device_info' => $faker->optional(
                'location' => $faker->optional(
                'timezone' => $faker->optional(
                'language' => $faker->optional(
                'referrer' => $faker->optional(
                'campaign' => $faker->optional(
                'tags' => $faker->optional(
                'category' => $faker->optional(
                'description' => $faker->optional(
                'keywords' => $faker->optional(
                'author' => $faker->optional(
                'copyright' => $faker->optional(
                'license' => $faker->optional(
                'rating' => $faker->optional(
                'views' => $faker->optional(
                'downloads' => $faker->optional(
                'favorites' => $faker->optional(
                'comments' => $faker->optional(
                'shares' => $faker->optional()
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
        return $this->state(fn (array $attributes
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
        return $this->state(fn (array $attributes
            'upload_status' => 'uploading',
            'progress_percentage' => $faker->numberBetween(1, 99
            'started_at' => $faker->dateTimeBetween('-1 hour', 'now'
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
        return $this->state(fn (array $attributes
            'upload_status' => 'completed',
            'progress_percentage' => 100,
            'started_at' => $faker->dateTimeBetween('-1 hour', '-30 minutes'
            'completed_at' => $faker->dateTimeBetween('-30 minutes', 'now'
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
        return $this->state(fn (array $attributes
            'upload_status' => 'failed',
            'progress_percentage' => $faker->numberBetween(0, 99
            'started_at' => $faker->dateTimeBetween('-1 hour', '-30 minutes'
            'completed_at' => null,
            'failed_at' => $faker->dateTimeBetween('-30 minutes', 'now'
            'cancelled_at' => null,
            'error_message' => $faker->sentence(
            'error_code' => $faker->randomElement(['NETWORK_ERROR', 'QUOTA_EXCEEDED', 'INVALID_FILE', 'PROVIDER_ERROR'])
        ]);
    }

    /**
     * Indicate that the upload was cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes
            'upload_status' => 'cancelled',
            'progress_percentage' => $faker->numberBetween(0, 99
            'started_at' => $faker->dateTimeBetween('-1 hour', '-30 minutes'
            'completed_at' => null,
            'failed_at' => null,
            'cancelled_at' => $faker->dateTimeBetween('-30 minutes', 'now')
        ]);
    }

    /**
     * Create a small file upload.
     */
    public function small(): static
    {
        return $this->state(fn (array $attributes
            'file_size' => $faker->numberBetween(1024, 1048576
            'total_chunks' => 1,
            'chunk_size' => 1048576, // 1MB
        ]);
    }

    /**
     * Create a large file upload.
     */
    public function large(): static
    {
        return $this->state(fn (array $attributes
            'file_size' => $faker->numberBetween(104857600, 1073741824
            'total_chunks' => $faker->numberBetween(10, 100
            'chunk_size' => 10485760, // 10MB
        ]);
    }

    /**
     * Create an image upload.
     */
    public function image(): static
    {
        return $this->state(fn (array $attributes
            'mime_type' => $faker->randomElement(['image/jpeg', 'image/png', 'image/gif', 'image/webp']
            'original_filename' => $faker->randomElement(['photo.jpg', 'image.png', 'screenshot.gif', 'picture.webp']
            'settings' => array_merge($safeSettings($attributes['settings'] ?? []
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
        return $this->state(fn (array $attributes
            'mime_type' => $faker->randomElement(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/plain']
            'original_filename' => $faker->randomElement(['document.pdf', 'report.docx', 'notes.txt', 'presentation.pptx']
            'settings' => array_merge($safeSettings($attributes['settings'] ?? []
                'extract_metadata' => true,
                'scan_virus' => true,
            ]),
            'metadata' => array_merge($safeMetadata($attributes['metadata'] ?? []
                'category' => 'document',
            ]),
        ]);
    }

    /**
     * Create a video upload.
     */
    public function video(): static
    {
        return $this->state(fn (array $attributes
            'mime_type' => $faker->randomElement(['video/mp4', 'video/avi', 'video/mov', 'video/wmv']
            'original_filename' => $faker->randomElement(['video.mp4', 'movie.avi', 'clip.mov', 'recording.wmv']
            'file_size' => $faker->numberBetween(10485760, 1073741824
            'settings' => array_merge($safeSettings($attributes['settings'] ?? []
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
        return $this->state(fn (array $attributes
            'mime_type' => $faker->randomElement(['audio/mpeg', 'audio/wav', 'audio/flac', 'audio/ogg']
            'original_filename' => $faker->randomElement(['song.mp3', 'recording.wav', 'music.flac', 'podcast.ogg']
            'settings' => array_merge($safeSettings($attributes['settings'] ?? []
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
        return $this->state(fn (array $attributes
            'mime_type' => $faker->randomElement(['application/zip', 'application/x-rar-compressed', 'application/x-7z-compressed', 'application/x-tar']
            'original_filename' => $faker->randomElement(['archive.zip', 'files.rar', 'backup.7z', 'data.tar']
            'settings' => array_merge($safeSettings($attributes['settings'] ?? []
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
        return $this->state(fn (array $attributes
            'priority' => $faker->numberBetween(1, 3
            'is_background' => false,
        ]);
    }

    /**
     * Create a low priority upload.
     */
    public function lowPriority(): static
    {
        return $this->state(fn (array $attributes
            'priority' => $faker->numberBetween(8, 10
            'is_background' => true,
        ]);
    }

    /**
     * Create a background upload.
     */
    public function background(): static
    {
        return $this->state(fn (array $attributes
            'is_background' => true,
            'priority' => $faker->numberBetween(5, 10)
        ]);
    }

    /**
     * Create a foreground upload.
     */
    public function foreground(): static
    {
        return $this->state(fn (array $attributes
            'is_background' => false,
            'priority' => $faker->numberBetween(1, 5)
        ]);
    }

    /**
     * Create a resumable upload.
     */
    public function resumable(): static
    {
        return $this->state(fn (array $attributes
            'is_resumable' => true,
            'chunk_size' => 10485760, // 10MB
            'total_chunks' => $faker->numberBetween(5, 50)
        ]);
    }

    /**
     * Create a non-resumable upload.
     */
    public function nonResumable(): static
    {
        return $this->state(fn (array $attributes
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
        return $this->state(fn (array $attributes
            'is_encrypted' => true,
            'encryption_key' => $faker->sha1(
            'encryption_algorithm' => $faker->randomElement(['AES-256', 'ChaCha20', 'Twofish'])
        ]);
    }

    /**
     * Create a non-encrypted upload.
     */
    public function nonEncrypted(): static
    {
        return $this->state(fn (array $attributes
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
        return $this->state(fn (array $attributes
            'is_compressed' => true,
            'compression_ratio' => $faker->randomFloat(2, 0.1, 0.9
            'original_size' => $faker->numberBetween(1048576, 1073741824
            'compressed_size' => $faker->numberBetween(1048576, 1073741824)
        ]);
    }

    /**
     * Create a non-compressed upload.
     */
    public function nonCompressed(): static
    {
        return $this->state(fn (array $attributes
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
        return $this->state(fn (array $attributes
            'notify_on_completion' => true,
            'notify_on_failure' => true,
        ]);
    }

    /**
     * Create an upload without notifications.
     */
    public function withoutNotifications(): static
    {
        return $this->state(fn (array $attributes
            'notify_on_completion' => false,
            'notify_on_failure' => false,
        ]);
    }

    /**
     * Create an upload with webhook.
     */
    public function withWebhook(): static
    {
        return $this->state(fn (array $attributes
            'webhook_url' => $faker->url(
            'callback_data' => $faker->text()
        ]);
    }

    /**
     * Create an upload without webhook.
     */
    public function withoutWebhook(): static
    {
        return $this->state(fn (array $attributes
            'webhook_url' => null,
            'callback_data' => null,
        ]);
    }

    /**
     * Create an upload with retries.
     */
    public function withRetries(): static
    {
        return $this->state(fn (array $attributes
            'retry_count' => $faker->numberBetween(1, 5
            'max_retries' => $faker->numberBetween(3, 10)
        ]);
    }

    /**
     * Create an upload without retries.
     */
    public function withoutRetries(): static
    {
        return $this->state(fn (array $attributes
            'retry_count' => 0,
            'max_retries' => 0,
        ]);
    }

    /**
     * Create a fast upload.
     */
    public function fast(): static
    {
        return $this->state(fn (array $attributes
            'upload_speed' => $faker->randomFloat(2, 10, 100
            'estimated_time_remaining' => $faker->numberBetween(1, 300)
        ]);
    }

    /**
     * Create a slow upload.
     */
    public function slow(): static
    {
        return $this->state(fn (array $attributes
            'upload_speed' => $faker->randomFloat(2, 0.1, 5
            'estimated_time_remaining' => $faker->numberBetween(600, 3600)
        ]);
    }

    /**
     * Create an upload from web.
     */
    public function fromWeb(): static
    {
        return $this->state(fn (array $attributes
            'metadata' => array_merge($safeMetadata($attributes['metadata'] ?? []
                'upload_source' => 'web',
                'browser_info' => $faker->userAgent()
            ]),
        ]);
    }

    /**
     * Create an upload from mobile app.
     */
    public function fromMobileApp(): static
    {
        return $this->state(fn (array $attributes
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'upload_source' => 'mobile_app',
                'device_info' => $faker->randomElement(['iOS 15.0', 'Android 12.0', 'iOS 16.0', 'Android 13.0'])
            ]),
        ]);
    }

    /**
     * Create an upload from API.
     */
    public function fromApi(): static
    {
        return $this->state(fn (array $attributes
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'upload_source' => 'api',
                'referrer' => $faker->url()
            ]),
        ]);
    }
}
