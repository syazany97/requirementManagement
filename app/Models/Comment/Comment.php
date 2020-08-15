<?php

namespace App\Models\Comment;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Comment extends Model
{
    use LogsActivity;

    protected $fillable = ['details', 'user_id'];

    protected static $logFillable = true;

    protected static $logOnlyDirty = true;

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeShow($query, Model $model)
    {
        return $query->where('commentable_type', get_class($model))
            ->where('commentable_id', $model->id)->with(['user']);
    }
}
