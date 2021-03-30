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
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */

    public $timeout = 120;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */

    public $tries = 5;
    /**
     * The maximum number of unhandled exceptions to allow before failing.
     *
     * @var int
     */
    public $maxExceptions = 3;

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
     * Determine the time at which the job should timeout.
     *
     * @return \DateTime
     */
    public function retryUntil()
    {
        return now()->addMinutes(5);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

      
/*         $transport = (new \Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
              ->setUsername('robaraneda@gmail.com')
              ->setPassword('05080Uni'); */

        $transport = (new \Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
              ->setUsername($this->details['emailCourse'])
              ->setPassword($this->details['passCourse']);


        $gmail = new \Swift_Mailer($transport);

        Mail::setSwiftMailer($gmail);

        $data = $this->details;
        $files = $this->details['files'];

        $primaryEmails =$this->details['primaryMail'];
        $ccEmails = $this->details['carbonCopyMail'];


        Mail::send('ticket', compact('data'), function ($message) use ($files, $primaryEmails, $ccEmails, $data) {
            $message->from($data['emailCourse']);
            $message->to($primaryEmails);
            
            if (count($ccEmails) !== 0) {
                $message->cc($ccEmails);
            }

            $message->subject($data['subject']);

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

        if (Mail::failures()) {
            $this->release(10);
        }

        //Mail::to(['calarconlazo@gmail.com', 'robaraneda@gmail.com'])->send(new \App\Mail\Ticket($this->details));
    }
}
