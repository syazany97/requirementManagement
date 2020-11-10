<?php


namespace App\Traits;


use App\Models\History;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasHistories
{
//    public static function bootHasHistories()
//    {
//        static::creating(function (Model $model) {
//            $model->createHistories();
//        });
//    }
//
//    private function createHistories()
//    {
//        $this->histories()->create([
//           'message' => 'created this ' . Str::lower(get_class($this))
//        ]);
//    }
//
//    public function histories()
//    {
//        return $this->morphMany(History::class, History::MORPH_NAME);
//    }
}
