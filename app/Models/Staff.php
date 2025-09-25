<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Staff extends User {
    protected $table = 'users';
    protected static function boot() {
        parent::boot();
        static::addGlobalScope('staff', function ($query) {
            $query->where('role', 'staff');
        });
    }
}
