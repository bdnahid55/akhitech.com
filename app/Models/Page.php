<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    /** @use HasFactory<PageFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'banner_image',
        'show_in_header',
        'header_parent_id',
        'show_in_footer',
        'footer_column',
        'order',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'og_image',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'show_in_header' => 'boolean',
            'show_in_footer' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }

    /**
     * Sub-pages for dropdown menu.
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'header_parent_id')->orderBy('order');
    }

    /**
     * Parent menu item if this is a dropdown sub-item.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'header_parent_id');
    }

    /**
     * Scope for active pages.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for header top-level items.
     */
    public function scopeHeaderMenu(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where('show_in_header', true)
            ->whereNull('header_parent_id')
            ->with(['children' => fn ($q) => $q->where('is_active', true)->orderBy('order')])
            ->orderBy('order');
    }

    /**
     * Scope for footer items.
     */
    public function scopeFooterMenu(Builder $query, ?string $column = null): Builder
    {
        $q = $query->where('is_active', true)->where('show_in_footer', true);

        if ($column !== null) {
            $q->where('footer_column', $column);
        }

        return $q->orderBy('order');
    }
}
