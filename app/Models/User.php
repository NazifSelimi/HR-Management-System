<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'city',
        'address',
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

    public function role():HasOne
    {
        return $this->hasOne(Role::class);
    }

    public function vacations() : HasMany
    {
        return $this->hasMany(Vacation::class);
    }

    public function projects():BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'positions_projects_users')
            ->withPivot('position_id', 'start_date', 'end_date')
            ->withTimestamps();
    }

    public function positions():BelongsToMany
    {
        return $this->belongsToMany(Position::class, 'positions_projects_users')
            ->withPivot('project_id', 'start_date', 'end_date')
            ->withTimestamps();
    }

    public function departments():BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
