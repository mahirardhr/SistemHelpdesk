<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifikasiEmail extends Mailable
{
   use Queueable, SerializesModels;

    public $laporan;

    public function __construct($laporan)
    {
        $this->laporan = $laporan;
    }

    public function build()
    {
        return $this->subject('Notifikasi dari Sistem Helpdesk')
                    ->view('emails.notifikasi')
                    ->with(['pesan' => $this->laporan]);
    }}
