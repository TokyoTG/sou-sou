<?php

namespace App\Listeners;

use App\Providers\AddedToGroupMailEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Mail\GroupMail;

class AddedToGroupMailListener
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
     * @param  AddedToGroupMailEvent  $event
     * @return void
     */
    public function handle(AddedToGroupMailEvent $event)
    {
        //
        $emails = $event->emails;
        //send email
        try{
            foreach($emails as $email){
                Mail::to($email)->send(new GroupMail());
            } 
        }catch(\Exception $e){

        }
        
       
    }
}
