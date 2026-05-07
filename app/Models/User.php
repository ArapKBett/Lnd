<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasRoles, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'address',
        'id_number', 'id_document', 'credit_score', 'savings_balance', 'loan_limit',
        'mpesa_number', 'crypto_address', 'preferred_payment_method',
        'last_login_ip', 'last_login_at', 'device_info', 'is_active'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class, 'client_id');
    }

    public function approvedLoans()
    {
        return $this->hasMany(Loan::class, 'staff_id');
    }

    public function savings()
    {
        return $this->hasOne(Savings::class, 'client_id');
    }

    public function payments()
    {
        return $this->hasManyThrough(LoanPayment::class, Loan::class, 'client_id');
    }

    public function sessions()
    {
        return $this->hasMany(UserSession::class);
    }

    public function activeLoan()
    {
        return $this->hasOne(Loan::class, 'client_id')
            ->whereIn('status', ['approved', 'disbursed'])
            ->where('remaining_balance', '>', 0)
            ->latest();
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function isClient()
    {
        return $this->role === 'client';
    }

    public function calculateLoanLimit()
    {
        $base_limit = 50000;
        $savings_multiplier = 5;
        
        $this->loan_limit = $base_limit + ($this->savings_balance * $savings_multiplier);
        $this->save();
        
        return $this->loan_limit;
    }

    public function getAvatarColorAttribute()
    {
        $colors = ['#3B82F6', '#10B981', '#8B5CF6', '#F59E0B', '#EF4444', '#EC4899', '#6366F1', '#14B8A6'];
        return $colors[$this->id % count($colors)];
    }

    public function getAvailableCreditAttribute()
    {
        $total_borrowed = $this->loans()->whereIn('status', ['approved', 'disbursed'])->sum('amount');
        return max(0, $this->loan_limit - $total_borrowed);
    }

    public function getTotalPaidAttribute()
    {
        return $this->loans()->with('payments')->get()->sum(function($loan) {
            return $loan->payments->where('status', 'completed')->sum('amount');
        });
    }

    public function getTotalDueAttribute()
    {
        return $this->loans()->with('payments')->get()->sum(function($loan) {
            return $loan->payments->whereIn('status', ['pending', 'overdue'])->sum('amount');
        });
    }
}
