<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_login',
        'documento',
        'cidade',
        'estado',
        'banco',
        'chave_pix',
        'is_admin',
        'is_blocked',
        'modal_start',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
    
    public function adminlte_image()
    {
        $foto = $this->profile_photo_url; 
        return  $foto; 
    }

    public function adminlte_desc()
    {
        $email = $this->email;
        return $email;
    }

    public function adminlte_profile_url()
    {
        return 'user/profile';
    }

    //Relação um a muitos
    public function operations(){
        return $this->hasMany(Operation::class);
    }

    public function categories(){
        return $this->hasMany(Category::class);
    }
    //Relação um a muitos
    public function shortcuts(){
        return $this->hasMany(Shortcut::class);
    }
    //Relação um a muitos
    public function tasks(){
        return $this->hasMany(Task::class);
    }
    //Relação um a muitos
    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function comissions(){
        return $this->hasMany(Comission::class);
    }

    public function notifications(){
        return $this->hasMany(Notification::class);
    }

    public function secrets(){
        return $this->hasMany(Secret::class);
    }

}
