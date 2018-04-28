<?php

namespace App;

use Mail;
use Request;

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
        'name', 'email', 'password', 'confirm_token',
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
        
        Mail::send('emails.password', $data, function($message) use ($data)
        {
            $message -> from(env('ADMIN_EMAIL'), env('ADMIN_NAME'))
                     -> to($data['email'], $data['name'])
                     -> subject('パスワードリセット用リンク');
            //$message->attach($pathToFile);
        });
    }
}
