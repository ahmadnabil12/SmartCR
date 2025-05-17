<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'unit',
        'need_by_date',
        'status',
        'complexity',
        'comment',
        'requestor_id',
        'implementor_id',
    ];

    // Relationships

    // Who submitted the CR
    public function requestor()
    {
        return $this->belongsTo(User::class, 'requestor_id');
    }

    // Who is assigned to handle the CR
    public function implementor()
    {
        return $this->belongsTo(User::class, 'implementor_id');
    }

    // Notifications linked to this CR
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
