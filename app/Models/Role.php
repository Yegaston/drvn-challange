<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory;

    protected $fillable = ['key', 'name'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public static function getUserRoleId(): int
    {
        return Role::where('key', 'user')->first()->id;
    }

    public static function getAdminRoleId(): int
    {
        return Role::where('key', 'admin')->first()->id;
    }
}
