<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Constants\UserGroupStatusConstant;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGroups extends Model
{
    use HasFactory, SoftDeletes;
}
