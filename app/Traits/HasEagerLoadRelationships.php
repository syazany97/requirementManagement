<?php


namespace App\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasEagerLoadRelationships
{
    protected $availableRelations = [];

    public static function getValidRelationships(Model $model) : string
    {
        $relationships = request()->get(config('withRelationship.key'));

        if(empty($relationships)) return '';

        $relationships = explode(',', $relationships);

        foreach($relationships as $relationship) {

            if(Str::contains('.', $relationship)) {
                $test = explode('.', $relationship) ;

                foreach($test as $t) {
                    if(method_exists($model, $t)) {

                    }

                }


            }

        }
    }
}
