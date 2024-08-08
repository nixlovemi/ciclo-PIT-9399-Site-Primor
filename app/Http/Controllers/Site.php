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

    public function receitaSingle(string $slug)
    {
        return view('site-receitas-single', [
            'RECEITA' => $this->getReceitaBySlug($slug)
        ]);
    }

    private function getReceitaBySlug(string $slug): array
    {
        $receitas = \App\Helpers\SysUtils::getRecipes();
        $receita = array_filter($receitas, function($v, $k) use ($slug) {
            return ($v['url'] ?? '') === route('site.receitaSingle', ['slug' => $slug]);
        }, ARRAY_FILTER_USE_BOTH);

        // returning first element or blank array
        return (!is_array($receita) || empty($receita)) ? []: reset($receita);
    }

    public function campanha()
    {
        return view('site-campanha');
    }

    public function produtos()
    {
        return view('site-produtos');
    }

    public function produtosSingle(string $slug)
    {
        return view('site-produtos-single', [
            'PRODUCT' => $this->getProductBySlug($slug)
        ]);
    }

    private function getProductBySlug(string $slug): array
    {
        $products = \App\Helpers\SysUtils::getProducts();
        $product = array_filter($products, function($v, $k) use ($slug) {
            return ($v['url'] ?? '') === route('site.produtosSingle', ['slug' => $slug]);
        }, ARRAY_FILTER_USE_BOTH);

        // returning first element or blank array
        return (!is_array($product) || empty($product)) ? []: reset($product);
    }

    public function bannerMesDoNordestino()
    {
        return view('site-banner-mesDoNordestino');
    }

    public function bannerTopOfMind()
    {
        return view('site-banner-topOfMind');
    }

    public function cirioDeNazare()
    {
        return view('site-banner-cirioDeNazare');
    }

    public function primor60()
    {
        return view('site-banner-primor60');
    }

    public function saborQueConta()
    {
        return view('site-banner-saborQueConta');
    }
}