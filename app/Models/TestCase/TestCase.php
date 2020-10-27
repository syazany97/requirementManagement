<?php

namespace App\Models\TestCase;

use App\Models\Comment\Comment;
use App\Models\Requirement\Requirement;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class TestCase extends Model
{
    use LogsActivity;

    protected $fillable = ['user_id', 'title', 'title', 'description',
        'preconditions', 'priority_id'];

    protected static $logOnlyDirty = true;

    protected static $logFillable = true;

    public const relationships = ['requirement', 'steps', 'user'];

    public function requirement()
    {
        return $this->belongsTo(Requirement::class);
    }

    public function steps()
    {
        return $this->hasMany(TestCaseStep::class, 'test_case_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
