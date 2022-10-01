<?php

namespace App\Mail;

use App\Models\Note;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class NotifyCallReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $note;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Note $note)
    {
        $this->user = $user;
        $this->note = $note;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->view('mails.Notify')->subject('Se creo una nota en tu grupo');
        if ($this->note->path_image) {
            $this->attachData(Storage::disk('public')->get($this->note->filename), $this->note->filename);
        }
        return $this;
    }
}
