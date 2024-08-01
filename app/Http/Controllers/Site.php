<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Helpers\ModelValidation;
use App\Helpers\ApiResponse;
use App\Http\Requests\doFaleConosco;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;

class Site extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function home()
    {
        return view('site-home');
    }

    public function nossaHistoria()
    {
        return view('site-nossa-historia');
    }

    public function faleConosco()
    {
        return view('site-fale-conosco', [
            'ARR_GENERO' => doFaleConosco::ARR_GENERO,
            'ARR_ASSUNTO' => doFaleConosco::ARR_ASSUNTO,
        ]);
    }

    public function doFaleConosco(doFaleConosco $request)
    {
        $form = $request->only(['f-nome', 'f-email', 'f-telefone', 'f-celular', 'f-nascimento', 'f-genero', 'f-assunto', 'f-mensagem', 'f-check-newsletter', 'f-check-privacy']);

        try {
            Mail::to(ENV('CONTACT_FORM_MAIL_TO'))->send(new ContactForm($form));
            return redirect()->route('site.faleConosco')->withSuccess('Contato enviado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('site.faleConosco')->withErrors(['msg' => 'Erro ao enviar contato. Tente novamente mais tarde.']);
        }
    }

    public function receitas()
    {
        return view('site-receitas');
    }
}