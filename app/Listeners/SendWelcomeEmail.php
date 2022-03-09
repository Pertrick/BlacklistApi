<?php

namespace App\Listeners;

use App\Events\NewUserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Mail;

class SendWelcomeEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewUserRegistered  $event
     * @return void
     */
    public function handle(NewUserRegistered $event)
    {
        //send the NewUserRegistered $event
        $data = array('name' => $event->user->name, 'email' => $event->user->email, 'body' => 'Welcome to Our Website');
        Mail::send('emails.welcome', $data, function($message) use ($data){
            $message->from('Blacklist@co.uk', 'Patrick Udoh');
            $message->subject('Welcome Aboard '.$data['name'].'!' );
            $message->to($data['email']);
            
        });
    }
}
