<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
class Section extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    protected $fillable=['name','description'];

    public $translatedAttributes = ['name','description'];

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}
