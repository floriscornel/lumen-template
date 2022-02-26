<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PersonalAccessToken extends Model
{
    use HasFactory, HasTimestamps, Uuids;

    private const TOKEN_CACHE_DURATION_SECONDS = 600;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'token', 
        'user_id', 
        'last_used_at',
        'expires_at',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [];

    protected $casts = [
        'last_used_at' => 'datetime:Y-m-d',
        'expires_at' => 'datetime:Y-m-d',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    static function lookup(string $tokenID, string $tokenHash): PersonalAccessToken | null {
        $token = Cache::remember("token_cache::$tokenID", self::TOKEN_CACHE_DURATION_SECONDS, function () use ($tokenID, $tokenHash) {
            $token = PersonalAccessToken::with('user')
                ->where('id', $tokenID)
                ->first();
            if (!empty($token) && $token->token == $tokenHash) {
                return $token;
            }
            return '_null_';
        });
        return ($token === '_null_') ? null : $token;
    }
}