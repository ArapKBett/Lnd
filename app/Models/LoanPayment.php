<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LoanPayment extends Model
{
    protected $fillable = [
        'loan_id', 'amount', 'remaining_balance', 'payment_date', 
        'due_date', 'status', 'method', 'transaction_id', 'notes'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'due_date' => 'date',
        'amount' => 'decimal:2',
        'remaining_balance' => 'decimal:2',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function markAsCompleted($method = null, $transactionId = null)
    {
        $this->update([
            'status' => 'completed',
            'payment_date' => now(),
            'method' => $method,
            'transaction_id' => $transactionId,
        ]);

        // Update loan remaining balance and payments made
        $loan = $this->loan;
        $loan->remaining_balance = $this->remaining_balance;
        $loan->payments_made += 1;
        
        // Set next payment date
        if ($loan->payments_made < $loan->payments_total) {
            $loan->next_payment_date = Carbon::parse($this->due_date)->addMonth();
        } else {
            $loan->status = 'completed';
            $loan->next_payment_date = null;
        }
        
        $loan->save();
    }

    public function markAsOverdue()
    {
        if ($this->status === 'pending' && Carbon::parse($this->due_date)->isPast()) {
            $this->update(['status' => 'overdue']);
        }
    }

    public function getIsOverdueAttribute()
    {
        return $this->status === 'overdue' || 
               ($this->status === 'pending' && Carbon::parse($this->due_date)->isPast());
    }

    public function getDaysOverdueAttribute()
    {
        if (!$this->is_overdue) return 0;
        return Carbon::parse($this->due_date)->diffInDays(now());
    }
}
