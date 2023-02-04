<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Device extends Model
{
    use HasFactory;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<string>
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * @param string $ip
     *
     * @return string
     */
    final public function getIpAttribute(string $ip): string
    {
        return decrypt($ip);
    }

    /**
     * @param string $ip
     */
    final public function setIpAttribute(string $ip): void
    {
        $this->attributes['ip'] = encrypt($ip);
    }

    /**
     * ==========================================================
     * Eloquent Relationships
     * ==========================================================
     */

    /**
     * @return BelongsTo
     */
    final public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
