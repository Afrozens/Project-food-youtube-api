<?php

namespace App\Models;

use App\Observers\CreateByObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    public $guarded = [];
    public $dates = [
        'deleted_at'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:00',
        'updated_at' => 'datetime:Y-m-d H:00'
    ];

    protected static function boot()
    {
        parent::boot();
        self::observe(new CreateByObserver());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
