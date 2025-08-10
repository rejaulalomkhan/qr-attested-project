<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attestation extends Model
{
    protected $fillable = [
        'transaction_number',
        'payment_id',
        'total_payment',
        'transaction_date',
        'document_type',
        'applicant_name',
        'email',
        'phone',
        'verifier_name',
        'verification_status',
        'verification_datetime',
        'approver_name',
        'original_document_path',
        'hash',
    ];

    // Automatically generate a unique hash on creation
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->hash)) {
                $model->hash = bin2hex(random_bytes(16));
            }
        });
    }
}
