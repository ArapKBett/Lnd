<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Savings extends Model {
    protected $fillable = ['client_id', 'balance'];
    public function getBoostAttribute() {
        return $this->balance * 0.5;  // Unique feature logic
    }
}
