<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->refer_code = self::generateUniqueReferralCode();
        });
    }

    public static function generateUniqueReferralCode()
    {
        do {
            $code = Str::upper(Str::random(8)); // Generates a random 10-character uppercase code
        } while (User::where('refer_code', $code)->exists());

        return $code;
    }

    public function delivered_orders()
    {
        return $this->hasMany(Order::class)->where('status', 'Delivered');
    }

    public function refers()
    {
        return $this->hasMany(User::class, 'refer_by', 'id');
    }

    /*public function referBonusTransactions()
    {
        return $this->hasMany(Transaction::class, 'main_user', 'id')
            ->where('tran_type', 'refer_bonus');
    }*/

}
