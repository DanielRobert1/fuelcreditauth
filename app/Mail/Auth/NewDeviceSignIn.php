<?php

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewDeviceSignIn extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    public $data;

    /**
     * NewDeviceSignIn constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $appName = config('app.name');

        return $this
            ->subject("[$appName] New Device Sign In")
            ->markdown('emails.new_device');
    }
}
