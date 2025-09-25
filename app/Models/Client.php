<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Client extends User {
    protected $table = 'users';
    protected static function boot() {
        parent::boot();
        static::addGlobalScope('client', function ($query) {
            $query->where('role', 'client');
        });
    }
}
