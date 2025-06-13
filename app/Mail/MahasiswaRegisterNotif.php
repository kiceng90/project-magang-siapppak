<?php

namespace App\Mail;

use App\Models\DMahasiswa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class MahasiswaRegisterNotif extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $mahasiswa;
    public function __construct(DMahasiswa $mahasiswa)
    {
        $this->mahasiswa = $mahasiswa;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        $html = view('pdf.cetakPernyataanMahasiswa', ['mahasiswa' => $this->mahasiswa]);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        return $this->view('email.mahasiswa.registernotif')
                ->attachData($pdf->output(), 'Surat Pernyataan.pdf', [
                    'mime' => 'application/pdf',
                ]);
    }
}
