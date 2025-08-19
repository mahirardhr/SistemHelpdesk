<?php

namespace App\Mail;

use App\Models\Laporan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LaporanSelesaiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $laporan;

    public function __construct(Laporan $laporan)
    {
        $this->laporan = $laporan;
    }

    public function build()
    {
        return $this->subject('Laporan Anda Telah Selesai Ditangani')
            ->view('emails.laporan_selesai');
    }
}
