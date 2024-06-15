<?php

namespace App\Models;

use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    use HasFactory;
    use WithHashId;
}
