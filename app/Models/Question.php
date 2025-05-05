<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Database\Eloquent\{Builder, Model, Prunable, SoftDeletes};

class Question extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Prunable;

    //protected $guarded = [];
    // protected $fillable = ['question'];

    //$cast é um conversor - vai converter aquilo que pega do db para o tipo de dado coloco - DTO
    protected $casts = [

        'draft' => 'boolean',

    ];

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    /*
    public function likes(): Attribute
    {
        return new Attribute(get: fn () => $this->votes->sum('like'));
    }

    public function unlikes(): Attribute
    {
        return new Attribute(get: fn () => $this->votes->sum('unlike'));
    }
    */

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function prunable(): Builder
    {
        return static::where('deleted_at', '<=', now()->subMonth());
    }
}
