<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentTranslation extends Model
{
    //use Translatable;
    use HasFactory;
    protected $fillable = ['name'];
    public $timestamps = false;
}


