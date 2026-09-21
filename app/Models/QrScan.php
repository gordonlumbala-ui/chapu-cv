<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QrScan extends Model
{
    use HasFactory;

    protected $fillable = [
        'qrcode_id',
        'user_id',
        'ip_address',
        'user_agent',
        'device_type',
        'browser',
        'platform',
        'scanned_at',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    public function qrCode(): BelongsTo
    {
        return $this->belongsTo(QRCode::class, 'qrcode_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}