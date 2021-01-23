<?php

namespace App;

use App\Models\Comment\Comment;
use App\Models\Project\Project;
use App\Models\Requirement\Requirement;
use App\Models\Requirement\RequirementAssignee;
use App\Models\TestCase\TestCase;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_demo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_demo' => 'boolean'
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function assignedRequirements()
    {
        return $this->belongsToMany(Requirement::class, RequirementAssignee::class,
            'assignee_id', 'requirement_id');
    }

    public function requirements()
    {
        return $this->hasMany(Requirement::class, 'creator_id');
    }

    public function testCases()
    {
        return $this->hasMany(TestCase::class);
    }

    public function scopeDemo(Builder $query)
    {
        return $query->where('is_demo', true);
    }
}
