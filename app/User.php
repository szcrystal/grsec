<?php

namespace App;

use Mail;
use Request;
use App\Setting;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'confirm_token',
        
        'hurigana',
        'gender',

        'birth_year',
        'birth_month',
        'birth_day',
        
        'post_num',
        'prefecture',
        'address_1',
        'address_2',
        'address_3',
        
        'tel_num',
        
        'magazine',
        'user_register',
        
        'point',
        
        'destination',
        
        'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'confirm_token',
    ];
    
    
    public function sendPasswordResetNotification($token)
    {
        //$this->notify(new ResetPasswordNotification($token));

        $email = Request::input('email');
        $user = User::where('email', $email)->first();
        
        $data['email'] = $email;
        $data['name'] = $user->name;
        $data['token'] = $token;
        
        $setting = Setting::get()->first();
        
        Mail::send('emails.password', $data, function($message) use ($data, $setting)
        {
            $message -> from($setting->admin_email, $setting->admin_name)
                     -> to($data['email'], $data['name'])
                     -> subject('パスワードリセット用リンク -グリーンロケット-');
            //$message->attach($pathToFile);
        });
    }
}
