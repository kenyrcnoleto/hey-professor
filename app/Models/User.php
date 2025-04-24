<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    /**
     * Forma de resolver erro types: TRelatedModel   do phpstan
     * @return HasMany<Vote>
     */

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'created_by');
    }

    public function like(Question $question): void
    {
        //utilizando o método de relacionamento - cria ou atitualiza através do atributo passado no 1° array
        $this->votes()->updateOrCreate(
            ['question_id' => $question->id, ],
            [
                'like'   => 1,
                'unlike' => 0,
            ]
        );

        //Sem utilizar o método de relacionamento
        /*
        Vote::query()->create([
            'question_id' => $question->id,
            'user_id'     => $this->id,
            'like'        => 1,
            'unlike'      => 0,

        ]); */

    }

    public function unlike(Question $question): void
    {
        $this->votes()->updateOrCreate(
            ['question_id' => $question->id, ],
            [
                'like'   => 0,
                'unlike' => 1,
            ]
        );

    }
}
