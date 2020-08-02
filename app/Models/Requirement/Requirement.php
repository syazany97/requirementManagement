<?php

namespace App\Models\Requirement;

use App\Models\Comment\Comment;
use App\Models\Module;
use App\Models\TestCase\TestCase;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Requirement extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['name', 'module_id', 'description', 'description',
        'requirement_priority_id', 'requirement_status_id', 'numbering'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function priority()
    {
        return $this->belongsTo(RequirementPriority::class, 'requirement_priority_id');
    }

    public function assignees()
    {
        return $this->belongsToMany(User::class, RequirementAssignee::class,
            'requirement_id', 'assignee_id'
            );
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function testCases()
    {
        return $this->hasMany(TestCase::class);
    }

    public function scopeShow($query)
    {
        return $query->with(['assignees', 'comments', 'priority']);
    }
}
