<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
    protected $fillable = ['loan_id', 'amount', 'method', 'transaction_id'];

    public function loan() {
        return $this->belongsTo(Loan::class);
    }
}
