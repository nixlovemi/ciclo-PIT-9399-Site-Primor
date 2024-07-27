<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class doFaleConosco extends FormRequest
{
    public const ARR_GENERO = [
        'Homem',
        'Mulher',
        'Homem Trans',
        'Mulher Trans',
        'Não Binário',
    ];

    public const ARR_ASSUNTO = [
        'Elogio',
        'Sugestão',
        'Informações',
        'Dúvidas',
        'Reclamação',
        'Solicitação LGPD'
    ];

    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = false;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'f-nome' => '"Nome"',
            'f-email' => '"E-mail"',
            'f-telefone' => '"Telefone"',
            'f-celular' => '"Celular"',
            'f-nascimento' => '"Data de Nascimento"',
            'f-genero' => '"Gênero"',
            'f-assunto' => '"Assunto"',
            'f-mensagem' => '"Mensagem"',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'f-nome' => ['required', 'string', 'min:1', 'max:255'],
            'f-email' => ['required', 'email:rfc,dns'],
            'f-telefone' => ['required', 'string', 'min:8'],
            'f-celular' => ['required', 'string', 'min:8'],
            'f-nascimento' => ['required', 'date_format:d/m/Y'],
            'f-genero' => [function ($attribute, $value, $fail) {
                if (false === array_search($value, self::ARR_GENERO)) {
                    $fail('Selecione um gênero da lista!');
                }
            }],
            'f-assunto' => [function ($attribute, $value, $fail) {
                if (false === array_search($value, self::ARR_ASSUNTO)) {
                    $fail('Selecione um assunto da lista!');
                }
            }],
            'f-mensagem' => ['filled'],
            'f-check-privacy' => ['required'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'f-check-privacy.required' => 'Você precisa aceitar a Política de Privacidade',
            'f-mensagem.filled' => 'O campo "Mensagem" está em branco',
        ];
    }
}
