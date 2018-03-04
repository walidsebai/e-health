<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Doctor extends Model
{
  protected $fillable = [
      'addresse', 'birthday', 'public'
  ];

  public function users ()
  {
    return $this->morphOne('App\User', 'owners');
  }
}
