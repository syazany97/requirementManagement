<?php

namespace App\Models\TestCase;

use App\Models\Requirement\Requirement;
use App\User;
use Illuminate\Database\Eloquent\Model;

class TestCase extends Model
{
    protected $fillable = ['user_id', 'title', 'title', 'description',
        'preconditions', 'priority_id'];

    public const relationships = ['requirement', 'steps', 'user'];

    public function requirement()
    {
        return $this->belongsTo(Requirement::class);
    }

    public function steps()
    {
        return $this->hasMany(TestCaseSteps::class, 'test_case_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
