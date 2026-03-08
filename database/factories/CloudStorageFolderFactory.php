declare(strict_types=1);

namespace Modules\CloudStorage\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Xot\Actions\Cast\SafeArrayCastAction;

/**
 * CloudStorageFolder factory.
 *
 * @TODO: Implementare il modello CloudStorageFolder - attualmente usa stdClass
 */
class CloudStorageFolderFactory extends Factory
{
    protected $model = \stdClass::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => // @var mixed faker->randomElement([
                'Documents', 'Images', 'Videos', 'Music', 'Downloads',
                'Work', 'Personal', 'Projects', 'Backups', 'Templates',
                'Reports', 'Presentations', 'Contracts', 'Invoices', 'Receipts'
            ]),
            'path' => 'folders/' . // @var mixed faker->date('Y/m/d/'
            'storage_path' => 'cloud/folders/' . // @var mixed faker->date('Y/m/d/'
            'provider' => // @var mixed faker->randomElement(['google_drive', 'dropbox', 'aws_s3', 'azure_blob', 'local']
            'bucket' => // @var mixed faker->optional(
            'region' => // @var mixed faker->optional(
            'parent_id' => // @var mixed faker->optional(
            'is_public' => // @var mixed faker->boolean(20
            'is_encrypted' => // @var mixed faker->boolean(10
            'encryption_key' => // @var mixed faker->optional(
            'status' => // @var mixed faker->randomElement(['active', 'inactive', 'archived', 'deleted']
            'metadata' => [
                'description' => // @var mixed faker->optional(
                'tags' => // @var mixed faker->optional(
                'color' => // @var mixed faker->optional(
                'icon' => // @var mixed faker->optional(
                'permissions' => // @var mixed faker->optional(
                'sync_enabled' => // @var mixed faker->boolean(70
                'auto_backup' => // @var mixed faker->boolean(60
                'compression_enabled' => // @var mixed faker->boolean(40
                'virus_scan_enabled' => // @var mixed faker->boolean(80
                'watermark_enabled' => // @var mixed faker->boolean(20
                'thumbnail_enabled' => // @var mixed faker->boolean(90
            ],
            'settings' => [
                'auto_delete' => // @var mixed faker->boolean(30
                'delete_after_days' => // @var mixed faker->optional(
                'max_file_size' => // @var mixed faker->optional(
                'allowed_file_types' => // @var mixed faker->optional(
                'max_files_count' => // @var mixed faker->optional(
                'sync_interval' => // @var mixed faker->optional(
                'backup_retention_days' => // @var mixed faker->optional(
                'compression_level' => // @var mixed faker->optional(
                'encryption_algorithm' => // @var mixed faker->optional(
                'cdn_enabled' => // @var mixed faker->boolean(60
                'versioning_enabled' => // @var mixed faker->boolean(50
                'lifecycle_policy' => // @var mixed faker->optional(
            ],
            'user_id' => // @var mixed faker->numberBetween(1, 100
            'created_at' => // @var mixed faker->dateTimeBetween('-1 year', 'now'
            'updated_at' => // @var mixed faker->dateTimeBetween('-6 months', 'now'
            'last_accessed_at' => // @var mixed faker->optional(
            'file_count' => // @var mixed faker->numberBetween(0, 1000
            'total_size' => // @var mixed faker->numberBetween(0, 10737418240
            'subfolder_count' => // @var mixed faker->numberBetween(0, 50
        ];
    }

    /**
     * Indicate that the folder is active.
     *
     * @return static
     */
    public function active(): static
    {
        return // @var mixed state(fn (array $attributes
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the folder is inactive.
     *
     * @return static
     */
    public function inactive(): static
    {
        return // @var mixed state(fn (array $attributes
            'status' => 'inactive',
        ]);
    }

    /**
     * Indicate that the folder is archived.
     *
     * @return static
     */
    public function archived(): static
    {
        return // @var mixed state(fn (array $attributes
            'status' => 'archived',
        ]);
    }

    /**
     * Indicate that the folder is deleted.
     *
     * @return static
     */
    public function deleted(): static
    {
        return // @var mixed state(fn (array $attributes
            'status' => 'deleted',
        ]);
    }

    /**
     * Create a public folder.
     *
     * @return static
     */
    public function public(): static
    {
        return // @var mixed state(fn (array $attributes
            'is_public' => true,
        ]);
    }

    /**
     * Create a private folder.
     *
     * @return static
     */
    public function private(): static
    {
        return // @var mixed state(fn (array $attributes
            'is_public' => false,
        ]);
    }

    /**
     * Create an encrypted folder.
     *
     * @return static
     */
    public function encrypted(): static
    {
        return // @var mixed state(fn (array $attributes
            'is_encrypted' => true,
            'encryption_key' => // @var mixed faker->sha1(
        ]);
    }

    /**
     * Create an unencrypted folder.
     *
     * @return static
     */
    public function unencrypted(): static
    {
        return // @var mixed state(fn (array $attributes
            'is_encrypted' => false,
            'encryption_key' => null,
        ]);
    }

    /**
     * Create a root folder (no parent).
     *
     * @return static
     */
    public function root(): static
    {
        return // @var mixed state(fn (array $attributes
            'parent_id' => null,
            'path' => 'folders/' . // @var mixed faker->slug(
            'storage_path' => 'cloud/folders/' . // @var mixed faker->slug(
        ]);
    }

    /**
     * Create a subfolder.
     *
     * @param int $parentId
     * @return static
     */
    public function subfolder(int $parentId): static
    {
        return // @var mixed state(fn (array $attributes
            'parent_id' => $parentId,
        ]);
    }

    /**
     * Create a folder with many files.
     *
     * @return static
     */
    public function withManyFiles(): static
    {
        return // @var mixed state(fn (array $attributes
            'file_count' => // @var mixed faker->numberBetween(100, 10000
            'total_size' => // @var mixed faker->numberBetween(1073741824, 107374182400
        ]);
    }

    /**
     * Create a folder with few files.
     *
     * @return static
     */
    public function withFewFiles(): static
    {
        return // @var mixed state(fn (array $attributes
            'file_count' => // @var mixed faker->numberBetween(0, 10
            'total_size' => // @var mixed faker->numberBetween(0, 104857600
        ]);
    }

    /**
     * Create a folder with many subfolders.
     *
     * @return static
     */
    public function withManySubfolders(): static
    {
        return // @var mixed state(fn (array $attributes
            'subfolder_count' => // @var mixed faker->numberBetween(10, 100
        ]);
    }

    /**
     * Create a folder with no subfolders.
     *
     * @return static
     */
    public function withNoSubfolders(): static
    {
        return // @var mixed state(fn (array $attributes
            'subfolder_count' => 0,
        ]);
    }

    /**
     * Create a large folder.
     *
     * @return static
     */
    public function large(): static
    {
        return // @var mixed state(fn (array $attributes
            'file_count' => // @var mixed faker->numberBetween(1000, 100000
            'total_size' => // @var mixed faker->numberBetween(107374182400, 1073741824000
        ]);
    }

    /**
     * Create a small folder.
     *
     * @return static
     */
    public function small(): static
    {
        return // @var mixed state(fn (array $attributes
            'file_count' => // @var mixed faker->numberBetween(0, 100
            'total_size' => // @var mixed faker->numberBetween(0, 104857600
        ]);
    }

    /**
     * Create a documents folder.
     *
     * @return static
     */
    public function documents(): static
    {
        return // @var mixed state(fn (array $attributes
            'name' => // @var mixed faker->randomElement(['Documents', 'Reports', 'Contracts', 'Invoices', 'Receipts']
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'icon' => 'folder-special',
                'color' => '#2196F3',
                'description' => 'Document storage folder',
            ]),
        ]);
    }

    /**
     * Create a media folder.
     *
     * @return static
     */
    public function media(): static
    {
        return // @var mixed state(fn (array $attributes
            'name' => // @var mixed faker->randomElement(['Images', 'Videos', 'Music', 'Photos', 'Media']
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'icon' => 'folder-shared',
                'color' => '#4CAF50',
                'description' => 'Media storage folder',
            ]),
        ]);
    }

    /**
     * Create a work folder.
     *
     * @return static
     */
    public function work(): static
    {
        return // @var mixed state(fn (array $attributes
            'name' => // @var mixed faker->randomElement(['Work', 'Projects', 'Business', 'Company', 'Office']
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'icon' => 'folder-special',
                'color' => '#FF9800',
                'description' => 'Work-related files',
            ]),
        ]);
    }

    /**
     * Create a personal folder.
     *
     * @return static
     */
    public function personal(): static
    {
        return // @var mixed state(fn (array $attributes
            'name' => // @var mixed faker->randomElement(['Personal', 'Private', 'Home', 'Family', 'Personal']
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'icon' => 'folder',
                'color' => '#9C27B0',
                'description' => 'Personal files',
            ]),
        ]);
    }

    /**
     * Create a folder for a specific provider.
     *
     * @param string $provider
     * @return static
     */
    public function forProvider(string $provider): static
    {
        return // @var mixed state(fn (array $attributes
            'provider' => $provider,
        ]);
    }

    /**
     * Create a folder for a specific user.
     *
     * @param int $userId
     * @return static
     */
    public function forUser(int $userId): static
    {
        return // @var mixed state(fn (array $attributes
            'user_id' => $userId,
        ]);
    }

    /**
     * Create a folder with specific file count.
     *
     * @param int $fileCount
     * @return static
     */
    public function withFileCount(int $fileCount): static
    {
        return // @var mixed state(fn (array $attributes
            'file_count' => $fileCount,
        ]);
    }

    /**
     * Create a folder with specific total size.
     *
     * @param int $totalSize
     * @return static
     */
    public function withTotalSize(int $totalSize): static
    {
        return // @var mixed state(fn (array $attributes
            'total_size' => $totalSize,
        ]);
    }

    /**
     * Create a folder with specific subfolder count.
     *
     * @param int $subfolderCount
     * @return static
     */
    public function withSubfolderCount(int $subfolderCount): static
    {
        return // @var mixed state(fn (array $attributes
            'subfolder_count' => $subfolderCount,
        ]);
    }

    /**
     * Create a recently accessed folder.
     *
     * @return static
     */
    public function recentlyAccessed(): static
    {
        return // @var mixed state(fn (array $attributes
            'last_accessed_at' => // @var mixed faker->dateTimeBetween('-1 week', 'now'
        ]);
    }

    /**
     * Create a folder that was accessed long ago.
     *
     * @return static
     */
    public function notRecentlyAccessed(): static
    {
        return // @var mixed state(fn (array $attributes
            'last_accessed_at' => // @var mixed faker->dateTimeBetween('-6 months', '-1 month'
        ]);
    }

    /**
     * Create a folder with sync enabled.
     *
     * @return static
     */
    public function withSync(): static
    {
        return // @var mixed state(fn (array $attributes
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'sync_enabled' => true,
            ]),
        ]);
    }

    /**
     * Create a folder without sync.
     *
     * @return static
     */
    public function withoutSync(): static
    {
        return // @var mixed state(fn (array $attributes
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'sync_enabled' => false,
            ]),
        ]);
    }

    /**
     * Create a folder with auto backup.
     *
     * @return static
     */
    public function withAutoBackup(): static
    {
        return // @var mixed state(fn (array $attributes
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'auto_backup' => true,
            ]),
        ]);
    }

    /**
     * Create a folder without auto backup.
     *
     * @return static
     */
    public function withoutAutoBackup(): static
    {
        return // @var mixed state(fn (array $attributes
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'auto_backup' => false,
            ]),
        ]);
    }
}
