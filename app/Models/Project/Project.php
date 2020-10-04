<?php

namespace App\Models\Project;

use App\Models\Module;
use App\Models\Requirement\Requirement;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $availableRelations = ['requirements', 'modules', 'user'];

    protected $fillable = ['name', 'description', 'project_status_id', 'uuid'];

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function requirements()
    {
        return $this->hasManyThrough(Requirement::class, Module::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function collaborators()
    {
//        return $this->belongsToMany(User::class, 'user_id', ProjectUserRole::class);
    }

    public function scopeIndex($query, $search = null)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        })->withCount(['modules'])->with(['user:id,name']);
    }
}
