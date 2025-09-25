<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model {
    protected $fillable = ['client_id', 'amount', 'term_months', 'interest_rate', 'limit_boost', 'status'];
    public function client() { return $this->belongsTo(User::class); }
    public function payments() { return $this->hasMany(Payment::class); }
}
