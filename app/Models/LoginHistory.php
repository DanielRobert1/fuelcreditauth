<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    use HasFactory, MassPrunable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

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
     * @param int $user_id
     * @param array $data
     *
     * @return Model|LoginHistory
     */
    final public function createLoginHistory(int $user_id, array $data): LoginHistory
    {

        $data['user_id'] = $user_id;
        return $this->newQuery()->create($data);
    }

    /**
     * @param int $user_id
     * @param array $data
     *
     * @return bool
     */
    final public function updateLoginHistory(int $user_id, array $data): bool
    {
        $history = $this->newQuery()->where('user_id', $user_id)
            ->where('device', $data['device'])
            ->whereNull('last_activity_at')
            ->latest()
            ->first();

        if (!$history) {
            return false;
        }

        return (bool) $history->update([
            'last_activity_at' => $data['last_activity_at'],
        ]);
    }

    /**
     * @param int $user_id
     * @param string $last_activity_at
     *
     * @return bool
     */
    final public function updateAllOpenLoginHistory(int $user_id, string $last_activity_at): bool
    {
        return (bool) $this->newQuery()->where('user_id', $user_id)
            ->whereNull('last_activity_at')
            ->update([
                'last_activity_at' => $last_activity_at,
            ]);
    }

    /**
     * @return Builder
     */
    final public function prunable(): Builder
    {
        return static::query()->where('created_at', '<=', now()->subMonths(2));
    }
}
