<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Authenticatable
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['name','appointments'];
    public $fillable= ['email','email_verified_at','password','phone','name','section_id','status'];
    //protected $guarded=[];

    /**
     * Get the Doctor's image.
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function section(){
        return $this->belongsTo(Section::class);
    }

    public function doctorappointments(){
        return $this->belongsToMany(Appointment::class,'appointment_doctor');
    }
}
