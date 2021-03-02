<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ProcessMailTicket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private $details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $transport = (new \Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
              ->setUsername('robaraneda@gmail.com')
              ->setPassword('05080Uni');

        $gmail = new \Swift_Mailer($transport);

        Mail::setSwiftMailer($gmail);

        $data = $this->details;
        $files = $this->details['files'];

        $emails = array_map('trim', ['robaraneda@gmail.com', 'calarconlazo@gmail.com']);

        Mail::send('ticket', compact('data'), function ($message) use ($files, $emails, $data) {
            $message->from('robaraneda@gmail.com');
            $message->to($emails)->subject($data['subject']);

            if (count($files) > 0) {
                foreach ($files as $file) {
                    $message->attach(
                        storage_path('app/'.$file['nameStore']),
                        array(
                    'as' => $file['originalName'], // If you want you can chnage original name to custom name
                    'mime' => $file['mime'])
                    );
                }
            }
        });

        //Mail::to(['calarconlazo@gmail.com', 'robaraneda@gmail.com'])->send(new \App\Mail\Ticket($this->details));
    }
}
