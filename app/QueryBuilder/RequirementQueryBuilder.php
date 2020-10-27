<?php


namespace App\QueryBuilder;


use App\Models\Requirement\RequirementPriority;
use Illuminate\Database\Eloquent\Builder;

class RequirementQueryBuilder extends Builder
{
    public function whereHighestPriority() : self
    {
        return $this->where('requirement_priority_id', RequirementPriority::HIGHEST);
    }

    public function whereHighPriority() : self
    {
        return $this->where('requirement_priority_id', RequirementPriority::HIGH);
    }

    public function whereLowPriority() : self
    {
        return $this->where('requirement_priority_id', RequirementPriority::LOW);
    }

    public function whereLowestPriority() : self
    {
        return $this->where('requirement_priority_id', RequirementPriority::LOWEST);
    }
}
