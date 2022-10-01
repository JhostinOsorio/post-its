<?php

namespace App\Jobs;

use App\Mail\NotifyCallReceived;
use App\Models\Note;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $note;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Note $note)
    {
        $this->user = $user;
        $this->note = $note;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notify = new NotifyCallReceived($this->user, $this->note);
        Mail::to($this->user->email)->send($notify);
    }
}
