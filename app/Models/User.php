<?php declare(strict_types=1);

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Scout\Searchable;

class User extends Model implements AuthorizableContract
{
    use Authorizable, HasFactory, HasTimestamps, Uuids, Searchable;

    protected $fillable = ['email'];

    // Relationships
    public function templates()
    {
        return $this->hasMany(Template::class);
    }
}
