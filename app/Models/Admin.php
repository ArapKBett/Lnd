<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Admin extends User {
    protected $table = 'users';
    protected static function boot() {
        parent::boot();
        static::addGlobalScope('admin', function ($query) {
            $query->where('role', 'admin');
        });
    }
}
