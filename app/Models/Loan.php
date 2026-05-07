<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Loan extends Model {
    protected $fillable = [
        'client_id', 'staff_id', 'amount', 'remaining_balance', 
        'term_months', 'interest_rate', 'limit_boost', 'status',
        'disbursement_date', 'next_payment_date', 'final_due_date',
        'disbursement_method', 'disbursement_reference', 'monthly_payment',
        'payments_made', 'payments_total'
    ];
    
    protected $casts = [
        'disbursement_date' => 'date',
        'next_payment_date' => 'date',
        'final_due_date' => 'date',
        'amount' => 'decimal:2',
        'remaining_balance' => 'decimal:2',
        'monthly_payment' => 'decimal:2',
    ];
    
    public function client() { 
        return $this->belongsTo(User::class, 'client_id'); 
    }
    
    public function staff() { 
        return $this->belongsTo(User::class, 'staff_id'); 
    }
    
    public function payments() { 
        return $this->hasMany(LoanPayment::class); 
    }

    public function completedPayments()
    {
        return $this->hasMany(LoanPayment::class)->where('status', 'completed');
    }

    public function pendingPayments()
    {
        return $this->hasMany(LoanPayment::class)->whereIn('status', ['pending', 'overdue']);
    }
    
    public function calculateMonthlyPayment()
    {
        $principal = $this->amount;
        $monthlyRate = ($this->interest_rate / 100) / 12;
        $term = $this->term_months;
        
        if ($monthlyRate > 0) {
            $this->monthly_payment = $principal * $monthlyRate * pow(1 + $monthlyRate, $term) / (pow(1 + $monthlyRate, $term) - 1);
        } else {
            $this->monthly_payment = $principal / $term;
        }
        
        $this->payments_total = $term;
        $this->remaining_balance = $principal;
        $this->save();
        
        return $this->monthly_payment;
    }

    public function generatePaymentSchedule()
    {
        $payments = [];
        $balance = $this->amount;
        $monthlyPayment = $this->monthly_payment;
        $monthlyRate = ($this->interest_rate / 100) / 12;
        $currentDate = $this->disbursement_date ? Carbon::parse($this->disbursement_date) : now();

        for ($i = 1; $i <= $this->term_months; $i++) {
            $interest = $balance * $monthlyRate;
            $principal = $monthlyPayment - $interest;
            $balance -= $principal;

            $payments[] = [
                'loan_id' => $this->id,
                'amount' => $monthlyPayment,
                'remaining_balance' => max(0, $balance),
                'payment_date' => null,
                'due_date' => $currentDate->copy()->addMonths($i)->format('Y-m-d'),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        LoanPayment::insert($payments);
        $this->next_payment_date = $currentDate->addMonth()->format('Y-m-d');
        $this->final_due_date = $currentDate->addMonths($this->term_months - 1)->format('Y-m-d');
        $this->save();
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->payments_total == 0) return 0;
        return round(($this->payments_made / $this->payments_total) * 100, 2);
    }

    public function getDaysUntilDueAttribute()
    {
        if (!$this->next_payment_date) return null;
        return Carbon::parse($this->next_payment_date)->diffInDays(now(), false) * -1;
    }

    public function isOverdue()
    {
        return $this->next_payment_date && Carbon::parse($this->next_payment_date)->isPast();
    }

    public function getStatusBadgeAttribute()
    {
        $statuses = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-blue-100 text-blue-800',
            'disbursed' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            'completed' => 'bg-gray-100 text-gray-800',
        ];
        
        return $statuses[$this->status] ?? 'bg-gray-100 text-gray-800';
    }
}
