<?php

namespace App\Models\Requirement;

use Illuminate\Database\Eloquent\Model;

class RequirementPriority extends Model
{
    protected $fillable = ['name'];
    public const HIGHEST = 1;
    public const HIGH = 2;
    public const LOW = 3;
    public const LOWEST = 4;
}
