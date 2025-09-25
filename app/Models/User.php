<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {
    use HasRoles;
    protected $fillable = ['name', 'email', 'password', 'role'];
    public function loans() { return $this->hasMany(Loan::class, 'client_id'); }
    public function savings() { return $this->hasOne(Savings::class); }
}
