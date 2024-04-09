<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['description', 'title', 'status', 'due_date'];

    function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Interact with the user's first name.
     */
    protected function dueDate(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Carbon::parse($value),
        );
    }
}
