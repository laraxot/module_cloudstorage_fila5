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
            'user_id' => // @var mixed faker->numberBetween(1, 1000
            'file_id' => // @var mixed faker->numberBetween(1, 10000
            'folder_id' => // @var mixed faker->optional(
            'share_type' => // @var mixed faker->randomElement(['public', 'private', 'restricted', 'temporary', 'password_protected']
            'share_token' => // @var mixed faker->uuid(
            'share_url' => // @var mixed faker->url(
            'password' => // @var mixed faker->optional(
            'password_hash' => // @var mixed faker->optional(
            'expires_at' => // @var mixed faker->optional(
            'max_downloads' => // @var mixed faker->optional(
            'download_count' => // @var mixed faker->numberBetween(0, 100
            'max_views' => // @var mixed faker->optional(
            'view_count' => // @var mixed faker->numberBetween(0, 1000
            'is_active' => // @var mixed faker->boolean(80
            'is_password_protected' => // @var mixed faker->boolean(30
            'is_expired' => // @var mixed faker->boolean(20
            'is_download_limit_reached' => // @var mixed faker->boolean(10
            'is_view_limit_reached' => // @var mixed faker->boolean(15
            'allow_download' => // @var mixed faker->boolean(90
            'allow_preview' => // @var mixed faker->boolean(85
            'allow_edit' => // @var mixed faker->boolean(20
            'allow_comment' => // @var mixed faker->boolean(60
            'allow_share' => // @var mixed faker->boolean(40
            'notify_on_download' => // @var mixed faker->boolean(70
            'notify_on_view' => // @var mixed faker->boolean(50
            'notify_on_expiry' => // @var mixed faker->boolean(80
            'last_accessed_at' => // @var mixed faker->optional(
            'last_downloaded_at' => // @var mixed faker->optional(
            'last_viewed_at' => // @var mixed faker->optional(
            'ip_address' => // @var mixed faker->ipv4(
            'user_agent' => // @var mixed faker->userAgent(
            'session_id' => // @var mixed faker->uuid(
            'request_id' => // @var mixed faker->uuid(
            'settings' => [
                'watermark_enabled' => // @var mixed faker->boolean(40
                'watermark_text' => // @var mixed faker->optional(
                'watermark_position' => // @var mixed faker->optional(
                'watermark_opacity' => // @var mixed faker->optional(
                'tracking_enabled' => // @var mixed faker->boolean(80
                'analytics_enabled' => // @var mixed faker->boolean(70
                'preview_quality' => // @var mixed faker->randomElement(['low', 'medium', 'high', 'original']
                'download_quality' => // @var mixed faker->randomElement(['low', 'medium', 'high', 'original']
                'max_preview_size' => // @var mixed faker->optional(
                'max_download_size' => // @var mixed faker->optional(
                'auto_delete' => // @var mixed faker->boolean(30
                'auto_delete_days' => // @var mixed faker->optional(
                'require_login' => // @var mixed faker->boolean(20
                'require_approval' => // @var mixed faker->boolean(15
                'approval_status' => // @var mixed faker->optional(
                'approved_by' => // @var mixed faker->optional(
                'approved_at' => // @var mixed faker->optional(
                'rejection_reason' => // @var mixed faker->optional(
            ],
            'metadata' => [
                'share_purpose' => // @var mixed faker->randomElement(['collaboration', 'presentation', 'backup', 'distribution', 'archival', 'temporary']
                'target_audience' => // @var mixed faker->randomElement(['public', 'team', 'clients', 'partners', 'family', 'friends']
                'content_type' => // @var mixed faker->randomElement(['document', 'image', 'video', 'audio', 'archive', 'presentation']
                'sensitivity_level' => // @var mixed faker->randomElement(['public', 'internal', 'confidential', 'restricted', 'secret']
                'business_unit' => // @var mixed faker->optional(
                'project_name' => // @var mixed faker->optional(
                'campaign_name' => // @var mixed faker->optional(
                'tags' => // @var mixed faker->optional(
                'description' => // @var mixed faker->optional(
                'keywords' => // @var mixed faker->optional(
                'category' => // @var mixed faker->randomElement(['work', 'personal', 'business', 'education', 'entertainment', 'other']
                'priority' => // @var mixed faker->randomElement(['low', 'medium', 'high', 'urgent']
                'status' => // @var mixed faker->randomElement(['active', 'inactive', 'suspended', 'archived']
                'rating' => // @var mixed faker->optional(
                'favorites' => // @var mixed faker->optional(
                'comments' => // @var mixed faker->optional(
                'shares' => // @var mixed faker->optional(
                'views_today' => // @var mixed faker->optional(
                'views_this_week' => // @var mixed faker->optional(
                'views_this_month' => // @var mixed faker->optional(
                'downloads_today' => // @var mixed faker->optional(
                'downloads_this_week' => // @var mixed faker->optional(
                'downloads_this_month' => // @var mixed faker->optional(
            ],
        ];
    }

    /**
     * Indicate that the share is public.
     */
    public function public(): static
    {
        return // @var mixed state(fn (array $attributes
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
        return // @var mixed state(fn (array $attributes
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
        return // @var mixed state(fn (array $attributes
            'share_type' => 'restricted',
            'is_password_protected' => true,
            'password' => // @var mixed faker->password(
            'password_hash' => // @var mixed faker->sha1(
            'allow_download' => false,
            'allow_preview' => true,
        ]);
    }

    /**
     * Indicate that the share is temporary.
     */
    public function temporary(): static
    {
        return // @var mixed state(fn (array $attributes
            'share_type' => 'temporary',
            'expires_at' => // @var mixed faker->dateTimeBetween('now', '+1 month'
            'auto_delete' => true,
            'auto_delete_days' => // @var mixed faker->numberBetween(1, 30
        ]);
    }

    /**
     * Indicate that the share is password protected.
     */
    public function passwordProtected(): static
    {
        return // @var mixed state(fn (array $attributes
            'share_type' => 'password_protected',
            'is_password_protected' => true,
            'password' => // @var mixed faker->password(
            'password_hash' => // @var mixed faker->sha1(
        ]);
    }

    /**
     * Indicate that the share is active.
     */
    public function active(): static
    {
        return // @var mixed state(fn (array $attributes
            'is_active' => true,
            'is_expired' => false,
        ]);
    }

    /**
     * Indicate that the share is inactive.
     */
    public function inactive(): static
    {
        return // @var mixed state(fn (array $attributes
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the share is expired.
     */
    public function expired(): static
    {
        return // @var mixed state(fn (array $attributes
            'is_expired' => true,
            'expires_at' => // @var mixed faker->dateTimeBetween('-1 month', 'now'
        ]);
    }

    /**
     * Indicate that the share allows download.
     */
    public function downloadable(): static
    {
        return // @var mixed state(fn (array $attributes
            'allow_download' => true,
        ]);
    }

    /**
     * Indicate that the share does not allow download.
     */
    public function nonDownloadable(): static
    {
        return // @var mixed state(fn (array $attributes
            'allow_download' => false,
        ]);
    }

    /**
     * Indicate that the share allows preview.
     */
    public function previewable(): static
    {
        return // @var mixed state(fn (array $attributes
            'allow_preview' => true,
        ]);
    }

    /**
     * Indicate that the share does not allow preview.
     */
    public function nonPreviewable(): static
    {
        return // @var mixed state(fn (array $attributes
            'allow_preview' => false,
        ]);
    }

    /**
     * Indicate that the share allows editing.
     */
    public function editable(): static
    {
        return // @var mixed state(fn (array $attributes
            'allow_edit' => true,
        ]);
    }

    /**
     * Indicate that the share does not allow editing.
     */
    public function nonEditable(): static
    {
        return // @var mixed state(fn (array $attributes
            'allow_edit' => false,
        ]);
    }

    /**
     * Indicate that the share allows comments.
     */
    public function commentable(): static
    {
        return // @var mixed state(fn (array $attributes
            'allow_comment' => true,
        ]);
    }

    /**
     * Indicate that the share does not allow comments.
     */
    public function nonCommentable(): static
    {
        return // @var mixed state(fn (array $attributes
            'allow_comment' => false,
        ]);
    }

    /**
     * Indicate that the share allows resharing.
     */
    public function reshareable(): static
    {
        return // @var mixed state(fn (array $attributes
            'allow_share' => true,
        ]);
    }

    /**
     * Indicate that the share does not allow resharing.
     */
    public function nonReshareable(): static
    {
        return // @var mixed state(fn (array $attributes
            'allow_share' => false,
        ]);
    }

    /**
     * Create a share with download limit.
     */
    public function withDownloadLimit(): static
    {
        return // @var mixed state(fn (array $attributes
            'max_downloads' => // @var mixed faker->numberBetween(1, 100
        ]);
    }

    /**
     * Create a share without download limit.
     */
    public function withoutDownloadLimit(): static
    {
        return // @var mixed state(fn (array $attributes
            'max_downloads' => null,
        ]);
    }

    /**
     * Create a share with view limit.
     */
    public function withViewLimit(): static
    {
        return // @var mixed state(fn (array $attributes
            'max_views' => // @var mixed faker->numberBetween(1, 1000
        ]);
    }

    /**
     * Create a share without view limit.
     */
    public function withoutViewLimit(): static
    {
        return // @var mixed state(fn (array $attributes
            'max_views' => null,
        ]);
    }

    /**
     * Create a share with high download count.
     */
    public function highDownloads(): static
    {
        return // @var mixed state(fn (array $attributes
            'download_count' => // @var mixed faker->numberBetween(100, 1000
        ]);
    }

    /**
     * Create a share with low download count.
     */
    public function lowDownloads(): static
    {
        return // @var mixed state(fn (array $attributes
            'download_count' => // @var mixed faker->numberBetween(0, 10
        ]);
    }

    /**
     * Create a share with high view count.
     */
    public function highViews(): static
    {
        return // @var mixed state(fn (array $attributes
            'view_count' => // @var mixed faker->numberBetween(1000, 10000
        ]);
    }

    /**
     * Create a share with low view count.
     */
    public function lowViews(): static
    {
        return // @var mixed state(fn (array $attributes
            'view_count' => // @var mixed faker->numberBetween(0, 100
        ]);
    }

    /**
     * Create a share with notifications enabled.
     */
    public function withNotifications(): static
    {
        return // @var mixed state(fn (array $attributes
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
        return // @var mixed state(fn (array $attributes
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
        return // @var mixed state(fn (array $attributes
            'settings' => array_merge(
                SafeArrayCastAction::cast($attributes['settings'] ?? null, []),
                [
                    'watermark_enabled' => true,
                    'watermark_text' => // @var mixed faker->company(
                    'watermark_position' => // @var mixed faker->randomElement(['top-left', 'top-right', 'bottom-left', 'bottom-right', 'center']
                    'watermark_opacity' => // @var mixed faker->randomFloat(2, 0.1, 1.0
                ]
            ),
        ]);
    }

    /**
     * Create a share without watermark.
     */
    public function withoutWatermark(): static
    {
        return // @var mixed state(fn (array $attributes
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
        return // @var mixed state(fn (array $attributes
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
        return // @var mixed state(fn (array $attributes
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
        return // @var mixed state(fn (array $attributes
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
        return // @var mixed state(fn (array $attributes
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
        return // @var mixed state(fn (array $attributes
            'settings' => array_merge(
                SafeArrayCastAction::cast($attributes['settings'] ?? null, []),
                [
                    'auto_delete' => true,
                    'auto_delete_days' => // @var mixed faker->numberBetween(1, 365
                ]
            ),
        ]);
    }

    /**
     * Create a share without auto delete.
     */
    public function withoutAutoDelete(): static
    {
        return // @var mixed state(fn (array $attributes
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
        return // @var mixed state(fn (array $attributes
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
        return // @var mixed state(fn (array $attributes
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
        return // @var mixed state(fn (array $attributes
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
        return // @var mixed state(fn (array $attributes
            'settings' => array_merge(
                SafeArrayCastAction::cast($attributes['settings'] ?? null, []),
                [
                    'require_approval' => true,
                    'approval_status' => 'approved',
                    'approved_by' => // @var mixed faker->numberBetween(1, 1000
                    'approved_at' => // @var mixed faker->dateTimeBetween('-1 month', 'now'
                ]
            ),
        ]);
    }

    /**
     * Create a rejected share.
     */
    public function rejected(): static
    {
        return // @var mixed state(fn (array $attributes
            'settings' => array_merge(
                SafeArrayCastAction::cast($attributes['settings'] ?? null, []),
                [
                    'require_approval' => true,
                    'approval_status' => 'rejected',
                    'rejection_reason' => // @var mixed faker->sentence(
                ]
            ),
        ]);
    }

    /**
     * Create a work-related share.
     */
    public function work(): static
    {
        return // @var mixed state(fn (array $attributes
            'metadata' => array_merge(
                SafeArrayCastAction::cast($attributes['metadata'] ?? null, []),
                [
                    'category' => 'work',
                    'business_unit' => // @var mixed faker->randomElement(['marketing', 'sales', 'engineering', 'hr', 'finance', 'operations']
                    'sensitivity_level' => // @var mixed faker->randomElement(['internal', 'confidential', 'restricted']
                ]
            ),
        ]);
    }

    /**
     * Create a personal share.
     */
    public function personal(): static
    {
        return // @var mixed state(fn (array $attributes
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
        return // @var mixed state(fn (array $attributes
            'metadata' => array_merge(
                SafeArrayCastAction::cast($attributes['metadata'] ?? null, []),
                [
                    'category' => 'business',
                    'business_unit' => // @var mixed faker->randomElement(['marketing', 'sales', 'engineering', 'hr', 'finance', 'operations']
                    'sensitivity_level' => // @var mixed faker->randomElement(['internal', 'confidential', 'restricted']
                ]
            ),
        ]);
    }

    /**
     * Create a high priority share.
     */
    public function highPriority(): static
    {
        return // @var mixed state(fn (array $attributes
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
        return // @var mixed state(fn (array $attributes
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
        return // @var mixed state(fn (array $attributes
            'download_count' => // @var mixed faker->numberBetween(500, 5000
            'view_count' => // @var mixed faker->numberBetween(5000, 50000
            'favorites' => // @var mixed faker->numberBetween(50, 500
            'shares' => // @var mixed faker->numberBetween(100, 1000
            'rating' => // @var mixed faker->randomFloat(1, 4, 5
        ]);
    }

    /**
     * Create an unpopular share.
     */
    public function unpopular(): static
    {
        return // @var mixed state(fn (array $attributes
            'download_count' => // @var mixed faker->numberBetween(0, 10
            'view_count' => // @var mixed faker->numberBetween(0, 100
            'favorites' => // @var mixed faker->numberBetween(0, 5
            'shares' => // @var mixed faker->numberBetween(0, 20
            'rating' => // @var mixed faker->randomFloat(1, 1, 3
        ]);
    }
}
