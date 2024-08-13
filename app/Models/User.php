<?php

namespace App\Models;

use App\Helpers\ApiResponse;
use App\Helpers\Constants;
use App\Helpers\ModelValidation;
use App\Helpers\SysUtils;
use App\Helpers\ValidatePassword;
use App\Mail\ResetPassword;
use App\Models\Client;
use App\Models\Job;
use App\Models\Quote;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Image;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use \App\Traits\BaseModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'active' => true,
    ];

    protected $appends = [
        'codedId',
    ];

    // relations
    // =========

    // class functions
    /**
     * https://laravel.com/docs/8.x/validation#available-validation-rules
     */
    public function validateModel(): ApiResponse
    {
        $validation = new ModelValidation($this->toArray());
        $validation->addIdField(self::class, 'Usuário', 'id', 'ID');
        $validation->addEmailField('email', 'E-mail', ['required', 'string', 'min:3', 'max:255']);
        $validation->addField('password', ['required', 'string', 'min:8', 'max:255', function ($attribute, $value, $fail) {
            $ValidadePwd = new ValidatePassword($value);
            $retValidate = $ValidadePwd->validate();
            if (true === $retValidate->isError()) {
                $fail($retValidate->getMessage());
            }
        }], 'Senha');

        return $validation->validate();
    }

    public function checkPassword(string $password): bool
    {
        return Hash::check($password, $this->password);
    }

    public function changePassword(
        string $newPassword,
        string $newPasswordRetype,
        ?string $currentPassword = null
    ): ApiResponse {
        if (null !== $currentPassword) {
            if (false === $this->checkPassword($currentPassword)) {
                return new ApiResponse(true, 'Senha atual não confere!');
            }
        }

        if ($newPassword !== $newPasswordRetype) {
            return new ApiResponse(true, 'Senha não conferem com a redigitada!');
        }

        $ValidadePwd = new ValidatePassword($newPassword);
        $retValidate = $ValidadePwd->validate();
        if (true === $retValidate->isError()) {
            return $retValidate;
        }

        // all good, change it
        $this->password_reset_token = null;
        $this->password = User::fPasswordHash($newPassword);
        $this->update();
        $this->refresh();

        return new ApiResponse(false, 'Senha alterada com sucesso!', [
            'User' => $this
        ]);
    }
    // ===============

    // static functions
    public static function fPasswordHash(string $password): string
    {
        // return bcrypt($password);
        return Hash::make($password);
    }

    public static function fLogin(string $email, string $password): ApiResponse
    {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new ApiResponse(true, 'Informe um e-mail válido!');
        }

        if (empty($password)) {
            return new ApiResponse(true, 'Preencha a senha!');
        }

        $User = User::where('email', $email)
            ->where('active', true)
            ->first();
        if (!$User) {
            return new ApiResponse(true, 'Usuário não encontrado ou inativo!');
        }

        if (false === $User->checkPassword($password)) {
            return new ApiResponse(true, 'Usuário ou senha inválido(s)!');
        }

        // all good, register everything
        if (false === SysUtils::loginUser($User)) {
            return new ApiResponse(true, 'Erro ao registrar usuário! Tente novamente.');
        }

        return new ApiResponse(false, 'Login efetuado com sucesso!', [
            'User' => $User
        ]);
    }

    // TODO: review this method
    /*
    public static function fRecoverPwd(string $email): ApiResponse
    {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new ApiResponse(true, 'Informe um e-mail válido!');
        }

        $User = User::where('email', $email)
            ->where('active', true)
            ->first();
        if (!$User) {
            return new ApiResponse(true, 'Usuário não encontrado ou inativo!');
        }

        // generate and save token
        $token = $User->generateResetPassToken();
        $User->refresh();

        // send mail
        Mail::to($User->email)
            ->send(
                new ResetPassword([
                    'EMAIL_TITLE' => 'Você acaba de pedir para alterar sua senha',
                    'TITLE' => 'Você acaba de pedir para alterar sua senha',
                    'HEADER_IMG_FULL_URL' => (env('APP_ENV') === 'local') ? 'https://i.imgur.com/SzkGU2o.png': asset('/img/resetPassword.png'),
                    'ARR_TEXT_LINES' => [
                        'Esqueceu a sua senha?',
                        'Nós vimos que você solicitou alteração de senha da sua conta.',
                        'Caso não tenha sido você, ignore esse e-mail. Mas fique tranquilo, a sua conta está segura com a gente!'
                    ],
                    'ACTION_BUTTON_URL' => route('site.changeNewPwd', ['idKey' => $token]),
                    'ACTION_BUTTON_TEXT' => 'Escolha sua nova senha',
                ])
            );

        return new ApiResponse(false, 'Solicitação de alteração de senha concluído! Acesse seu e-mail para ver as instruções para recuperar a senha.', [
            'token' => $token,
            'User' => $User,
        ]);
    }

    public static function fResetPasswordByToken(
        string $token,
        string $newPassword,
        string $newPasswordRetype
    ): ApiResponse {
        $User = User::where('password_reset_token', $token)
            ->where('active', true)
            ->first();
        if (!$User) {
            return new ApiResponse(true, 'Usuário não encontrado ou inativo!');
        }

        return $User->changePassword($newPassword, $newPasswordRetype);
    }
    */
    // ================
}
