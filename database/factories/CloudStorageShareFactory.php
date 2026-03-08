<?php

declare(strict_types=1);

namespace Modules\CloudStorage\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CloudStorage\Models\CloudStorageShare;
use Modules\Xot\Actions\Cast\SafeArrayCastAction;

/**
 * CloudStorageShare factory.
 *
 * @extends Factory<CloudStorageShare>
 */
class CloudStorageShareFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<CloudStorageShare>
     */
    protected $model = CloudStorageShare::class;

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
            'folder_id' => $faker->optional(
            'share_type' => $faker->randomElement(['public', 'private', 'restricted', 'temporary', 'password_protected']
            'share_token' => $faker->uuid(
            'share_url' => $faker->url(
            'password' => $faker->optional(
            'password_hash' => $faker->optional(
            'expires_at' => $faker->optional(
            'max_downloads' => $faker->optional(
            'download_count' => $faker->numberBetween(0, 100
            'max_views' => $faker->optional(
            'view_count' => $faker->numberBetween(0, 1000
            'is_active' => $faker->boolean(80
            'is_password_protected' => $faker->boolean(30
            'is_expired' => $faker->boolean(20
            'is_download_limit_reached' => $faker->boolean(10
            'is_view_limit_reached' => $faker->boolean(15
            'allow_download' => $faker->boolean(90
            'allow_preview' => $faker->boolean(85
            'allow_edit' => $faker->boolean(20
            'allow_comment' => $faker->boolean(60
            'allow_share' => $faker->boolean(40
            'notify_on_download' => $faker->boolean(70
            'notify_on_view' => $faker->boolean(50
            'notify_on_expiry' => $faker->boolean(80
            'last_accessed_at' => $faker->optional(
            'last_downloaded_at' => $faker->optional(
            'last_viewed_at' => $faker->optional(
            'ip_address' => $faker->ipv4(
            'user_agent' => $faker->userAgent(
            'session_id' => $faker->uuid(
            'request_id' => $faker->uuid(
            'settings' => [
                'watermark_enabled' => $faker->boolean(40
                'watermark_text' => $faker->optional(
                'watermark_position' => $faker->optional(
                'watermark_opacity' => $faker->optional(
                'tracking_enabled' => $faker->boolean(80
                'analytics_enabled' => $faker->boolean(70
                'preview_quality' => $faker->randomElement(['low', 'medium', 'high', 'original']
                'download_quality' => $faker->randomElement(['low', 'medium', 'high', 'original']
                'max_preview_size' => $faker->optional(
                'max_download_size' => $faker->optional(
                'auto_delete' => $faker->boolean(30
                'auto_delete_days' => $faker->optional(
                'require_login' => $faker->boolean(20
                'require_approval' => $faker->boolean(15
                'approval_status' => $faker->optional(
                'approved_by' => $faker->optional(
                'approved_at' => $faker->optional(
                'rejection_reason' => $faker->optional(
            ],
            'metadata' => [
                'share_purpose' => $faker->randomElement(['collaboration', 'presentation', 'backup', 'distribution', 'archival', 'temporary']
                'target_audience' => $faker->randomElement(['public', 'team', 'clients', 'partners', 'family', 'friends']
                'content_type' => $faker->randomElement(['document', 'image', 'video', 'audio', 'archive', 'presentation']
                'sensitivity_level' => $faker->randomElement(['public', 'internal', 'confidential', 'restricted', 'secret']
                'business_unit' => $faker->optional(
                'project_name' => $faker->optional(
                'campaign_name' => $faker->optional(
                'tags' => $faker->optional(
                'description' => $faker->optional(
                'keywords' => $faker->optional(
                'category' => $faker->randomElement(['work', 'personal', 'business', 'education', 'entertainment', 'other']
                'priority' => $faker->randomElement(['low', 'medium', 'high', 'urgent']
                'status' => $faker->randomElement(['active', 'inactive', 'suspended', 'archived']
                'rating' => $faker->optional(
                'favorites' => $faker->optional(
                'comments' => $faker->optional(
                'shares' => $faker->optional(
                'views_today' => $faker->optional(
                'views_this_week' => $faker->optional(
                'views_this_month' => $faker->optional(
                'downloads_today' => $faker->optional(
                'downloads_this_week' => $faker->optional(
                'downloads_this_month' => $faker->optional(
            ],
        ];
    }

    /**
     * Indicate that the share is public.
     */
    public function public(): static
    {
        return $this->state(fn (array $attributes
            'share_type' => 'public',
            'is_password_protected' => false,
            'password' => null,
            'password_hash' => null,
            'allow_download' => true,
            'allow_preview' => true,
        ]);
    }

    /**
     * Indicate that the share is private.
     */
    public function private(): static
    {
        return $this->state(fn (array $attributes
            'share_type' => 'private',
            'is_password_protected' => false,
            'password' => null,
            'password_hash' => null,
            'allow_download' => true,
            'allow_preview' => true,
        ]);
    }

    /**
     * Indicate that the share is restricted.
     */
    public function restricted(): static
    {
        return $this->state(fn (array $attributes
            'share_type' => 'restricted',
            'is_password_protected' => true,
            'password' => $faker->password(
            'password_hash' => $faker->sha1(
            'allow_download' => false,
            'allow_preview' => true,
        ]);
    }

    /**
     * Indicate that the share is temporary.
     */
    public function temporary(): static
    {
        return $this->state(fn (array $attributes
            'share_type' => 'temporary',
            'expires_at' => $faker->dateTimeBetween('now', '+1 month'
            'auto_delete' => true,
            'auto_delete_days' => $faker->numberBetween(1, 30
        ]);
    }

    /**
     * Indicate that the share is password protected.
     */
    public function passwordProtected(): static
    {
        return $this->state(fn (array $attributes
            'share_type' => 'password_protected',
            'is_password_protected' => true,
            'password' => $faker->password(
            'password_hash' => $faker->sha1(
        ]);
    }

    /**
     * Indicate that the share is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes
            'is_active' => true,
            'is_expired' => false,
        ]);
    }

    /**
     * Indicate that the share is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the share is expired.
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes
            'is_expired' => true,
            'expires_at' => $faker->dateTimeBetween('-1 month', 'now'
        ]);
    }

    /**
     * Indicate that the share allows download.
     */
    public function downloadable(): static
    {
        return $this->state(fn (array $attributes
            'allow_download' => true,
        ]);
    }

    /**
     * Indicate that the share does not allow download.
     */
    public function nonDownloadable(): static
    {
        return $this->state(fn (array $attributes
            'allow_download' => false,
        ]);
    }

    /**
     * Indicate that the share allows preview.
     */
    public function previewable(): static
    {
        return $this->state(fn (array $attributes
            'allow_preview' => true,
        ]);
    }

    /**
     * Indicate that the share does not allow preview.
     */
    public function nonPreviewable(): static
    {
        return $this->state(fn (array $attributes
            'allow_preview' => false,
        ]);
    }

    /**
     * Indicate that the share allows editing.
     */
    public function editable(): static
    {
        return $this->state(fn (array $attributes
            'allow_edit' => true,
        ]);
    }

    /**
     * Indicate that the share does not allow editing.
     */
    public function nonEditable(): static
    {
        return $this->state(fn (array $attributes
            'allow_edit' => false,
        ]);
    }

    /**
     * Indicate that the share allows comments.
     */
    public function commentable(): static
    {
        return $this->state(fn (array $attributes
            'allow_comment' => true,
        ]);
    }

    /**
     * Indicate that the share does not allow comments.
     */
    public function nonCommentable(): static
    {
        return $this->state(fn (array $attributes
            'allow_comment' => false,
        ]);
    }

    /**
     * Indicate that the share allows resharing.
     */
    public function reshareable(): static
    {
        return $this->state(fn (array $attributes
            'allow_share' => true,
        ]);
    }

    /**
     * Indicate that the share does not allow resharing.
     */
    public function nonReshareable(): static
    {
        return $this->state(fn (array $attributes
            'allow_share' => false,
        ]);
    }

    /**
     * Create a share with download limit.
     */
    public function withDownloadLimit(): static
    {
        return $this->state(fn (array $attributes
            'max_downloads' => $faker->numberBetween(1, 100
        ]);
    }

    /**
     * Create a share without download limit.
     */
    public function withoutDownloadLimit(): static
    {
        return $this->state(fn (array $attributes
            'max_downloads' => null,
        ]);
    }

    /**
     * Create a share with view limit.
     */
    public function withViewLimit(): static
    {
        return $this->state(fn (array $attributes
            'max_views' => $faker->numberBetween(1, 1000
        ]);
    }

    /**
     * Create a share without view limit.
     */
    public function withoutViewLimit(): static
    {
        return $this->state(fn (array $attributes
            'max_views' => null,
        ]);
    }

    /**
     * Create a share with high download count.
     */
    public function highDownloads(): static
    {
        return $this->state(fn (array $attributes
            'download_count' => $faker->numberBetween(100, 1000
        ]);
    }

    /**
     * Create a share with low download count.
     */
    public function lowDownloads(): static
    {
        return $this->state(fn (array $attributes
            'download_count' => $faker->numberBetween(0, 10
        ]);
    }

    /**
     * Create a share with high view count.
     */
    public function highViews(): static
    {
        return $this->state(fn (array $attributes
            'view_count' => $faker->numberBetween(1000, 10000
        ]);
    }

    /**
     * Create a share with low view count.
     */
    public function lowViews(): static
    {
        return $this->state(fn (array $attributes
            'view_count' => $faker->numberBetween(0, 100
        ]);
    }

    /**
     * Create a share with notifications enabled.
     */
    public function withNotifications(): static
    {
        return $this->state(fn (array $attributes
            'notify_on_download' => true,
            'notify_on_view' => true,
            'notify_on_expiry' => true,
        ]);
    }

    /**
     * Create a share without notifications.
     */
    public function withoutNotifications(): static
    {
        return $this->state(fn (array $attributes
            'notify_on_download' => false,
            'notify_on_view' => false,
            'notify_on_expiry' => false,
        ]);
    }

    /**
     * Create a share with watermark enabled.
     */
    public function withWatermark(): static
    {
        return $this->state(fn (array $attributes
            'settings' => array_merge(
                SafeArrayCastAction::cast($attributes['settings'] ?? null, []),
                [
                    'watermark_enabled' => true,
                    'watermark_text' => $faker->company(
                    'watermark_position' => $faker->randomElement(['top-left', 'top-right', 'bottom-left', 'bottom-right', 'center']
                    'watermark_opacity' => $faker->randomFloat(2, 0.1, 1.0
                ]
            ),
        ]);
    }

    /**
     * Create a share without watermark.
     */
    public function withoutWatermark(): static
    {
        return $this->state(fn (array $attributes
            'settings' => array_merge(
                SafeArrayCastAction::cast($attributes['settings'] ?? null, []),
                [
                    'watermark_enabled' => false,
                    'watermark_text' => null,
                    'watermark_position' => null,
                    'watermark_opacity' => null,
                ]
            ),
        ]);
    }

    /**
     * Create a share with tracking enabled.
     */
    public function withTracking(): static
    {
        return $this->state(fn (array $attributes
            'settings' => array_merge(
                SafeArrayCastAction::cast($attributes['settings'] ?? null, []),
                [
                    'tracking_enabled' => true,
                    'analytics_enabled' => true,
                ]
            ),
        ]);
    }

    /**
     * Create a share without tracking.
     */
    public function withoutTracking(): static
    {
        return $this->state(fn (array $attributes
            'settings' => array_merge(
                SafeArrayCastAction::cast($attributes['settings'] ?? null, []),
                [
                    'tracking_enabled' => false,
                    'analytics_enabled' => false,
                ]
            ),
        ]);
    }

    /**
     * Create a share with high quality.
     */
    public function highQuality(): static
    {
        return $this->state(fn (array $attributes
            'settings' => array_merge(
                SafeArrayCastAction::cast($attributes['settings'] ?? null, []),
                [
                    'preview_quality' => 'high',
                    'download_quality' => 'high',
                ]
            ),
        ]);
    }

    /**
     * Create a share with low quality.
     */
    public function lowQuality(): static
    {
        return $this->state(fn (array $attributes
            'settings' => array_merge(
                SafeArrayCastAction::cast($attributes['settings'] ?? null, []),
                [
                    'preview_quality' => 'low',
                    'download_quality' => 'low',
                ]
            ),
        ]);
    }

    /**
     * Create a share with auto delete enabled.
     */
    public function withAutoDelete(): static
    {
        return $this->state(fn (array $attributes
            'settings' => array_merge(
                SafeArrayCastAction::cast($attributes['settings'] ?? null, []),
                [
                    'auto_delete' => true,
                    'auto_delete_days' => $faker->numberBetween(1, 365
                ]
            ),
        ]);
    }

    /**
     * Create a share without auto delete.
     */
    public function withoutAutoDelete(): static
    {
        return $this->state(fn (array $attributes
            'settings' => array_merge(
                SafeArrayCastAction::cast($attributes['settings'] ?? null, []),
                [
                    'auto_delete' => false,
                    'auto_delete_days' => null,
                ]
            ),
        ]);
    }

    /**
     * Create a share requiring login.
     */
    public function requiringLogin(): static
    {
        return $this->state(fn (array $attributes
            'settings' => array_merge(
                SafeArrayCastAction::cast($attributes['settings'] ?? null, []),
                [
                    'require_login' => true,
                ]
            ),
        ]);
    }

    /**
     * Create a share not requiring login.
     */
    public function notRequiringLogin(): static
    {
        return $this->state(fn (array $attributes
            'settings' => array_merge(
                SafeArrayCastAction::cast($attributes['settings'] ?? null, []),
                [
                    'require_login' => false,
                ]
            ),
        ]);
    }

    /**
     * Create a share requiring approval.
     */
    public function requiringApproval(): static
    {
        return $this->state(fn (array $attributes
            'settings' => array_merge(
                SafeArrayCastAction::cast($attributes['settings'] ?? null, []),
                [
                    'require_approval' => true,
                    'approval_status' => 'pending',
                ]
            ),
        ]);
    }

    /**
     * Create an approved share.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes
            'settings' => array_merge(
                SafeArrayCastAction::cast($attributes['settings'] ?? null, []),
                [
                    'require_approval' => true,
                    'approval_status' => 'approved',
                    'approved_by' => $faker->numberBetween(1, 1000
                    'approved_at' => $faker->dateTimeBetween('-1 month', 'now'
                ]
            ),
        ]);
    }

    /**
     * Create a rejected share.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes
            'settings' => array_merge(
                SafeArrayCastAction::cast($attributes['settings'] ?? null, []),
                [
                    'require_approval' => true,
                    'approval_status' => 'rejected',
                    'rejection_reason' => $faker->sentence(
                ]
            ),
        ]);
    }

    /**
     * Create a work-related share.
     */
    public function work(): static
    {
        return $this->state(fn (array $attributes
            'metadata' => array_merge(
                SafeArrayCastAction::cast($attributes['metadata'] ?? null, []),
                [
                    'category' => 'work',
                    'business_unit' => $faker->randomElement(['marketing', 'sales', 'engineering', 'hr', 'finance', 'operations']
                    'sensitivity_level' => $faker->randomElement(['internal', 'confidential', 'restricted']
                ]
            ),
        ]);
    }

    /**
     * Create a personal share.
     */
    public function personal(): static
    {
        return $this->state(fn (array $attributes
            'metadata' => array_merge(
                SafeArrayCastAction::cast($attributes['metadata'] ?? null, []),
                [
                    'category' => 'personal',
                    'sensitivity_level' => 'public',
                    'business_unit' => null,
                ]
            ),
        ]);
    }

    /**
     * Create a business share.
     */
    public function business(): static
    {
        return $this->state(fn (array $attributes
            'metadata' => array_merge(
                SafeArrayCastAction::cast($attributes['metadata'] ?? null, []),
                [
                    'category' => 'business',
                    'business_unit' => $faker->randomElement(['marketing', 'sales', 'engineering', 'hr', 'finance', 'operations']
                    'sensitivity_level' => $faker->randomElement(['internal', 'confidential', 'restricted']
                ]
            ),
        ]);
    }

    /**
     * Create a high priority share.
     */
    public function highPriority(): static
    {
        return $this->state(fn (array $attributes
            'metadata' => array_merge(
                SafeArrayCastAction::cast($attributes['metadata'] ?? null, []),
                [
                    'priority' => 'high',
                ]
            ),
        ]);
    }

    /**
     * Create a low priority share.
     */
    public function lowPriority(): static
    {
        return $this->state(fn (array $attributes
            'metadata' => array_merge(
                SafeArrayCastAction::cast($attributes['metadata'] ?? null, []),
                [
                    'priority' => 'low',
                ]
            ),
        ]);
    }

    /**
     * Create a popular share.
     */
    public function popular(): static
    {
        return $this->state(fn (array $attributes
            'download_count' => $faker->numberBetween(500, 5000
            'view_count' => $faker->numberBetween(5000, 50000
            'favorites' => $faker->numberBetween(50, 500
            'shares' => $faker->numberBetween(100, 1000
            'rating' => $faker->randomFloat(1, 4, 5
        ]);
    }

    /**
     * Create an unpopular share.
     */
    public function unpopular(): static
    {
        return $this->state(fn (array $attributes
            'download_count' => $faker->numberBetween(0, 10
            'view_count' => $faker->numberBetween(0, 100
            'favorites' => $faker->numberBetween(0, 5
            'shares' => $faker->numberBetween(0, 20
            'rating' => $faker->randomFloat(1, 1, 3
        ]);
    }
}
