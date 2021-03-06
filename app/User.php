<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Mail\EmailVerification;
use App\Notifications\User\VerifyEmailQueued;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, SoftDeletes;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function transaction_details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isRole($role)
    {
        return $this->role->title == $role;
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function sms_token()
    {
        return $this->hasOne(SmsToken::class);
    }

    public function sendEmailVerification($oldEmail)
    {
        Mail::to($this->email)->send(new EmailVerification($this, $oldEmail));
    }

    public function handleUpdatedEmail($oldEmail)
    {
        // if user update an email
        if ($this->email != $oldEmail){

            $this->update(['email_verified_at' => null]);
            $this->sendEmailVerification($oldEmail);

            return true;
        }
        return false;
    }

    public function emailChangedMessage()
    {
        return "We've been sending a link verification to <b>{$this->email}</b> please verify for further action";
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailQueued());
    }
}
