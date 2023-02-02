<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ObjectLanguage extends Model
{
    public $table = 'object_language'; //khong ghi de thi auto them s
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable =[
      'object_id',
      'language_id',
      'type',
    ];
}
