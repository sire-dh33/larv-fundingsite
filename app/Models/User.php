<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\UsesUuid;
use App\Models\OtpCode;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable, UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function get_user_role_id()
     {
         $role = Role::where('name' , 'user')->first();
         return $role->id;
     }

     public static function boot()
     {
       parent::boot();

       static::creating(function ($model) {
           $model->role_id = $model->get_user_role_id();
       });

       static::created(function ($model) {
          $model->generate_otp_code();
       }); 
     }
     
     public function generate_otp_code()
     {
       do {
         $random = mt_rand(100000,999999);
         $check = OtpCode::where('otp', $random)->first();
         
        } while ($check);
        
        $now = Carbon::now();

        // Creating OTP Code
        $otp_code = OtpCode::updateOrCreate(
          ['user_id' => $this->id],
          ['otp' => $random, 'valid_until' => $now->addMinutes(5)]
          
        );
        
      }

      public function isAdminMethod()
      {
        if ($this->role_id === $this->get_user_role_id() ) {
          return false;
        }
  
        return true;
      } 
      
}
