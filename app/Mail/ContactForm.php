<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactForm extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @var array @data ['f-nome', 'f-email', 'f-telefone', 'f-celular', 'f-nascimento', 'f-genero', 'f-assunto', 'f-mensagem', 'f-check-newsletter', 'f-check-privacy']
     * @return void
     */
    public function __construct(
        public array $_data = []
    ) { }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.contactForm')
            ->subject('Primor - Formulário de Contato Site');
    }
}
