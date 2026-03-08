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
            'name' => $faker->randomElement([
                'Documents', 'Images', 'Videos', 'Music', 'Downloads',
                'Work', 'Personal', 'Projects', 'Backups', 'Templates',
                'Reports', 'Presentations', 'Contracts', 'Invoices', 'Receipts'
            ]),
            'path' => 'folders/' . $faker->date('Y/m/d/'
            'storage_path' => 'cloud/folders/' . $faker->date('Y/m/d/'
            'provider' => $faker->randomElement(['google_drive', 'dropbox', 'aws_s3', 'azure_blob', 'local']
            'bucket' => $faker->optional(
            'region' => $faker->optional(
            'parent_id' => $faker->optional(
            'is_public' => $faker->boolean(20
            'is_encrypted' => $faker->boolean(10
            'encryption_key' => $faker->optional(
            'status' => $faker->randomElement(['active', 'inactive', 'archived', 'deleted']
            'metadata' => [
                'description' => $faker->optional(
                'tags' => $faker->optional(
                'color' => $faker->optional(
                'icon' => $faker->optional(
                'permissions' => $faker->optional(
                'sync_enabled' => $faker->boolean(70
                'auto_backup' => $faker->boolean(60
                'compression_enabled' => $faker->boolean(40
                'virus_scan_enabled' => $faker->boolean(80
                'watermark_enabled' => $faker->boolean(20
                'thumbnail_enabled' => $faker->boolean(90
            ],
            'settings' => [
                'auto_delete' => $faker->boolean(30
                'delete_after_days' => $faker->optional(
                'max_file_size' => $faker->optional(
                'allowed_file_types' => $faker->optional(
                'max_files_count' => $faker->optional(
                'sync_interval' => $faker->optional(
                'backup_retention_days' => $faker->optional(
                'compression_level' => $faker->optional(
                'encryption_algorithm' => $faker->optional(
                'cdn_enabled' => $faker->boolean(60
                'versioning_enabled' => $faker->boolean(50
                'lifecycle_policy' => $faker->optional(
            ],
            'user_id' => $faker->numberBetween(1, 100
            'created_at' => $faker->dateTimeBetween('-1 year', 'now'
            'updated_at' => $faker->dateTimeBetween('-6 months', 'now'
            'last_accessed_at' => $faker->optional(
            'file_count' => $faker->numberBetween(0, 1000
            'total_size' => $faker->numberBetween(0, 10737418240
            'subfolder_count' => $faker->numberBetween(0, 50
        ];
    }

    /**
     * Indicate that the folder is active.
     *
     * @return static
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes
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
        return $this->state(fn (array $attributes
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
        return $this->state(fn (array $attributes
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
        return $this->state(fn (array $attributes
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
        return $this->state(fn (array $attributes
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
        return $this->state(fn (array $attributes
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
        return $this->state(fn (array $attributes
            'is_encrypted' => true,
            'encryption_key' => $faker->sha1(
        ]);
    }

    /**
     * Create an unencrypted folder.
     *
     * @return static
     */
    public function unencrypted(): static
    {
        return $this->state(fn (array $attributes
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
        return $this->state(fn (array $attributes
            'parent_id' => null,
            'path' => 'folders/' . $faker->slug(
            'storage_path' => 'cloud/folders/' . $faker->slug(
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
        return $this->state(fn (array $attributes
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
        return $this->state(fn (array $attributes
            'file_count' => $faker->numberBetween(100, 10000
            'total_size' => $faker->numberBetween(1073741824, 107374182400
        ]);
    }

    /**
     * Create a folder with few files.
     *
     * @return static
     */
    public function withFewFiles(): static
    {
        return $this->state(fn (array $attributes
            'file_count' => $faker->numberBetween(0, 10
            'total_size' => $faker->numberBetween(0, 104857600
        ]);
    }

    /**
     * Create a folder with many subfolders.
     *
     * @return static
     */
    public function withManySubfolders(): static
    {
        return $this->state(fn (array $attributes
            'subfolder_count' => $faker->numberBetween(10, 100
        ]);
    }

    /**
     * Create a folder with no subfolders.
     *
     * @return static
     */
    public function withNoSubfolders(): static
    {
        return $this->state(fn (array $attributes
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
        return $this->state(fn (array $attributes
            'file_count' => $faker->numberBetween(1000, 100000
            'total_size' => $faker->numberBetween(107374182400, 1073741824000
        ]);
    }

    /**
     * Create a small folder.
     *
     * @return static
     */
    public function small(): static
    {
        return $this->state(fn (array $attributes
            'file_count' => $faker->numberBetween(0, 100
            'total_size' => $faker->numberBetween(0, 104857600
        ]);
    }

    /**
     * Create a documents folder.
     *
     * @return static
     */
    public function documents(): static
    {
        return $this->state(fn (array $attributes
            'name' => $faker->randomElement(['Documents', 'Reports', 'Contracts', 'Invoices', 'Receipts']
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
        return $this->state(fn (array $attributes
            'name' => $faker->randomElement(['Images', 'Videos', 'Music', 'Photos', 'Media']
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
        return $this->state(fn (array $attributes
            'name' => $faker->randomElement(['Work', 'Projects', 'Business', 'Company', 'Office']
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
        return $this->state(fn (array $attributes
            'name' => $faker->randomElement(['Personal', 'Private', 'Home', 'Family', 'Personal']
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
        return $this->state(fn (array $attributes
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
        return $this->state(fn (array $attributes
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
        return $this->state(fn (array $attributes
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
        return $this->state(fn (array $attributes
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
        return $this->state(fn (array $attributes
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
        return $this->state(fn (array $attributes
            'last_accessed_at' => $faker->dateTimeBetween('-1 week', 'now'
        ]);
    }

    /**
     * Create a folder that was accessed long ago.
     *
     * @return static
     */
    public function notRecentlyAccessed(): static
    {
        return $this->state(fn (array $attributes
            'last_accessed_at' => $faker->dateTimeBetween('-6 months', '-1 month'
        ]);
    }

    /**
     * Create a folder with sync enabled.
     *
     * @return static
     */
    public function withSync(): static
    {
        return $this->state(fn (array $attributes
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
        return $this->state(fn (array $attributes
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
        return $this->state(fn (array $attributes
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
        return $this->state(fn (array $attributes
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'auto_backup' => false,
            ]),
        ]);
    }
}
