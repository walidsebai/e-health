<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Patient extends Model
{
  protected $fillable = [
      'doctor_id', 'birthday', 'd_type'
  ];
    public function users ()
    {

      return $this->morphOne('App\User', 'owners');
    }
}
