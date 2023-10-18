<?php

declare(strict_types=1);

namespace Rinvex\Subscriptions\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Rinvex\Support\Traits\ValidatingTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlanSubscriptionUsage extends Model
{
    use HasFactory;
    use SoftDeletes;
    use ValidatingTrait;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'subscription_id',
        'feature_id',
        'used',
        'valid_until',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'subscription_id' => 'integer',
        'feature_id' => 'integer',
        'used' => 'integer',
        'valid_until' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * {@inheritdoc}
     */
    protected $observables = [
        'validating',
        'validated',
    ];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Whether the model should throw a
     * ValidationException if it fails validation.
     *
     * @var bool
     */
    protected $throwValidationExceptions = true;

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setTable(config('rinvex.subscriptions.tables.plan_subscription_usage'));
        $this->mergeRules([
            'subscription_id' => 'required|integer|exists:'.config('rinvex.subscriptions.tables.plan_subscriptions').',id',
            'feature_id' => 'required|integer|exists:'.config('rinvex.subscriptions.tables.plan_features').',id',
            'used' => 'required|integer',
            'valid_until' => 'nullable|date',
        ]);

        parent::__construct($attributes);
    }

    /**
     * Subscription usage always belongs to a plan feature.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function feature(): BelongsTo
    {
        return $this->belongsTo(config('rinvex.subscriptions.models.plan_feature'), 'feature_id', 'id', 'feature');
    }

    /**
     * Subscription usage always belongs to a plan subscription.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(config('rinvex.subscriptions.models.plan_subscription'), 'subscription_id', 'id', 'subscription');
    }

    /**
     * Scope subscription usage by feature slug.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param string                                $featureSlug
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByFeatureSlug(Builder $builder, string $featureSlug): Builder
    {
        $feature = app('rinvex.subscriptions.plan_feature')->where('slug', $featureSlug)->first();

        return $builder->where('feature_id', $feature ? $feature->getKey() : null);
    }

    /**
     * Check whether usage has been expired or not.
     *
     * @return bool
     */
    public function expired(): bool
    {
        if (null === $this->valid_until) {
            return false;
        }

        return Carbon::now()->gte($this->valid_until);
    }
}
