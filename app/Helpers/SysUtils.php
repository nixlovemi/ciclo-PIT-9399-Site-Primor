<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\SessionGuard;
use App\View\Components\MainMenu;
use App\Models\User;

final class SysUtils {

    private const ENCODE_FROM_CHARS = '+/=';
    private const ENCODE_TO_CHARS = '-;$';

    public static function getWebAuth(): SessionGuard
    {
        return Auth::guard('web');
    }

    public static function getLoggedInUser(): ?User
    {
        $userId = SysUtils::getWebAuth()->id() ?? 0;
        if ($userId == 0) {
            $User = auth()->user();
            $userId = $User->id ?? 0;
        }
        return User::find($userId);
    }

    public static function loginUser(User $User): bool
    {
        $Auth = SysUtils::getWebAuth();
        if (false === $Auth->loginUsingId($User->id)) {
            return false;
        }

        return true;
    }

    public static function logout(bool $flushSession=true): void
    {
        $User = SysUtils::getLoggedInUser();
        if ($User) {
            try {
                SysUtils::getWebAuth()->logout();
            } catch (\Throwable $th) { dd($th); }
        }

        if ($flushSession) {
            // flushing the session will remove CSRF Token's value
            session()->flush();
        }
    }

    public static function applyTimezone($date)
    {
        return \Carbon\Carbon::parse($date)->timezone(getenv('APP_TIME_ZONE'));
    }

    public static function timezoneDate($date, $format): string
    {
        if (empty($date)) {
            return '';
        }
        return \Carbon\Carbon::parse($date)->setTimezone(env('APP_TIME_ZONE'))->format($format);
    }

    public static function encodeStr(string $text): string
    {
        $base64 = base64_encode($text);
        $replacedB64 = strtr($base64, self::ENCODE_FROM_CHARS, self::ENCODE_TO_CHARS);
        $rotStr = str_rot13($replacedB64);

        return $rotStr;
    }

    public static function decodeStr(string $encodedId): ?string
    {
        $unRot = str_rot13($encodedId);
        $unreplaceB64 = strtr($unRot, self::ENCODE_TO_CHARS, self::ENCODE_FROM_CHARS);
        $originalStr = base64_decode($unreplaceB64);
        $originalWithoutSpecial = preg_replace ('/[^\p{L}\p{N}]/u', '@', $originalStr);
        
        return $originalWithoutSpecial;
    }

    public static function sanitizeFileNameForUpload(string $fileName): string
    {
        $fileName = str_replace(
            ['Ã', 'ã', 'Á', 'á', 'Â', 'â', 'À', 'à', 'É', 'é', 'Ê', 'ê', 'Í', 'í', 'Ó', 'ó', 'Ô', 'ô', 'Õ', 'õ', 'Ú', 'ú', 'Ç', 'ç'],
            ['A', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'E', 'e', 'E', 'e', 'I', 'i', 'O', 'o', 'O', 'o', 'o', 'o', 'u', 'u', 'C', 'c'],
            $fileName,
        );
        $fileName = preg_replace('/[^a-zA-Z0-9\.\-]/', '_', $fileName);
        return $fileName;
    }

    public static function getArrayOnlyKeys(array $array, array $keys): array
    {
        if (!count($keys) > 0) {
            return [];
        }

        return array_filter($array, function($key) use ($keys) {
            return false !== array_search($key, $keys);
        }, ARRAY_FILTER_USE_KEY);
    }

    public static function formatNumberToDb(string $number, int $decimals): float
    {
        $newNumber = str_replace(['R$', '$', '.'], '', $number);
        $newNumber = trim($newNumber);
        $newNumber = str_replace(',', '.', $newNumber);

        return (float) number_format((float) $newNumber, $decimals, '.', '');
    }

    public static function formatCurrencyBr(float $value, int $decimals=2, string $currency=''): string
    {
        $result = $currency . ' ' . number_format($value, $decimals, ',', '.');
        return trim($result);
    }

    public static function getRecipes(): array
    {
        return [
            [
                'type' => 'Lanche',
                'title' => 'Salgadinho de Queijo',
                'image' => 'templates/primor-v1/images/receitas-item-01.jpg',
                'details' => null,
                'timeStr' => '90 min',
                'portionsStr' => '10 porções',
                'url' => ''
            ],
            [
                'type' => 'Sobremesa',
                'title' => 'Bolo de Mandioca',
                'image' => 'templates/primor-v1/images/receitas-item-02.jpg',
                'details' => null,
                'timeStr' => '60 min',
                'portionsStr' => '8 porções',
                'url' => ''
            ],
            [
                'type' => 'Jantar',
                'title' => 'Arrumadinho de Carne Seca',
                'image' => 'templates/primor-v1/images/receitas-item-03.jpg',
                'details' => 'Deixe qualquer dia<br />com cara de domingo!',
                'timeStr' => '45 min',
                'portionsStr' => '3 porções',
                'url' => ''
            ],
            [
                'type' => 'Almoço',
                'title' => 'Arroz Maria Isabel',
                'image' => 'templates/primor-v1/images/receitas-item-04.jpg',
                'details' => null,
                'timeStr' => '60 min',
                'portionsStr' => '10 porções',
                'url' => ''
            ],
            [
                'type' => 'Lanche',
                'title' => 'Bolo Pé de Moloque',
                'image' => 'templates/primor-v1/images/receitas-item-05.jpg',
                'details' => null,
                'timeStr' => '60 min',
                'portionsStr' => '12 porções',
                'url' => ''
            ],
            [
                'type' => 'Sobremesa',
                'title' => 'Sorvete Caseiro',
                'image' => 'templates/primor-v1/images/receitas-item-06.jpg',
                'details' => null,
                'timeStr' => '45 min',
                'portionsStr' => '10 porções',
                'url' => ''
            ],
        ];
    }
}