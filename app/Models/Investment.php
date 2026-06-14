<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model {
    protected $fillable = [
        'user_id',
        'project_id',
        'amount',
        'payment_method',
        'payment_account_number',
        'payment_bank_name',
        'payment_reference',
        'payment_date',
        'expected_return',
        'invested_at',
        'matured_at',
        'status',
        'approved_by',
        'approval_date',
        'note',
    ];

    protected function casts(): array {
        return [
            'amount'          => 'decimal:2',
            'expected_return' => 'decimal:2',
            'payment_date'    => 'date',
            'approval_date'   => 'date',
            'invested_at'     => 'datetime',
            'matured_at'      => 'date',
        ];
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function approvedBy() {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }
}
