<?php declare(strict_types=1);

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Template extends Model
{
    use HasFactory, Uuids, SoftDeletes, Searchable, HasTimestamps;

    // Fields
    protected $fillable = [
        'id',
        'title',
        'content',
        'category',
        'updated_at',
        'created_at',
    ];

    public function toSearchableArray()
    {
        return [
            ...$this->toArray(),
        ];
    }

    public $searchable = [
        'title',
        'content',
    ];

    public $filterable = [
        'id',
        'user_id',
        'deleted_at',
    ];

    public $sortable = [
        'updated_at',
        'created_at',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Methods
}
