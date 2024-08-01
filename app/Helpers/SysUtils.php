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
                'image' => url('/') . '/templates/primor-v1/images/receitas-item-01.jpg',
                'bannerSingle' => url('/') . '/templates/primor-v1/images/recipes-search-image.jpg',
                'details' => null,
                'timeStr' => '90 min',
                'portionsStr' => '10 porções',
                'difficultyStr' => 'Difícil',
                'url' => route('site.receitaSingle', ['slug' => 'lanche-salgadinho-de-queijo']),
                'ingredients' => [
                    [
                        'qty' => '1/2',
                        'item' => 'cebola picada'
                    ],
                    [
                        'qty' => '1/3',
                        'item' => 'de pimentão amarelo picado'
                    ],
                    [
                        'qty' => null,
                        'item' => 'Sal a gosto'
                    ],
                ],
                'steps' => [
                    [
                        'title' => 'Farinha torrada',
                        'desc' => 'Em uma panela, leve a margarina Primor para aquecer. Junte a farinha e misture bem, adicione sal e frite até que doure. Reserve quente.'
                    ],
                    [
                        'title' => 'Feijão',
                        'desc' => 'Em uma frigideira funda, doure o alho e a cebola na margarina Primor. Junte o pimentão, o colorau, os tomates, o caldo, o feijão e refogue por alguns minutos. Desligue o fogo, adicione o coentro e reserve quente.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Em uma frigideira leve, aqueça a margarina Primor, acrescente a carne e frite até que doure. Junte a cebola, o colorau e deixe a cebola fritar até dourar. Numa travessa, sirva o feijão e a carne separados.'
                    ]
                ]
            ],
            [
                'type' => 'Sobremesa',
                'title' => 'Bolo de Mandioca',
                'image' => url('/') . '/templates/primor-v1/images/receitas-item-02.jpg',
                'bannerSingle' => url('/') . '/templates/primor-v1/images/recipes-search-image.jpg',
                'details' => null,
                'timeStr' => '60 min',
                'portionsStr' => '8 porções',
                'difficultyStr' => 'Médio',
                'url' => route('site.receitaSingle', ['slug' => 'sobremesa-bolo-de-mandioca']),
                'ingredients' => [
                    [
                        'qty' => '1/2',
                        'item' => 'cebola picada'
                    ],
                    [
                        'qty' => '1/3',
                        'item' => 'de pimentão amarelo picado'
                    ],
                    [
                        'qty' => null,
                        'item' => 'Sal a gosto'
                    ],
                ],
                'steps' => [
                    [
                        'title' => 'Farinha torrada',
                        'desc' => 'Em uma panela, leve a margarina Primor para aquecer. Junte a farinha e misture bem, adicione sal e frite até que doure. Reserve quente.'
                    ],
                    [
                        'title' => 'Feijão',
                        'desc' => 'Em uma frigideira funda, doure o alho e a cebola na margarina Primor. Junte o pimentão, o colorau, os tomates, o caldo, o feijão e refogue por alguns minutos. Desligue o fogo, adicione o coentro e reserve quente.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Em uma frigideira leve, aqueça a margarina Primor, acrescente a carne e frite até que doure. Junte a cebola, o colorau e deixe a cebola fritar até dourar. Numa travessa, sirva o feijão e a carne separados.'
                    ]
                ]
            ],
            [
                'type' => 'Jantar',
                'title' => 'Arrumadinho de Carne Seca',
                'image' => url('/') . '/templates/primor-v1/images/receitas-item-03.jpg',
                'bannerSingle' => url('/') . '/templates/primor-v1/images/recipes-search-image.jpg',
                'details' => 'Deixe qualquer dia<br />com cara de domingo!',
                'timeStr' => '45 min',
                'portionsStr' => '3 porções',
                'difficultyStr' => 'Fácil',
                'url' => route('site.receitaSingle', ['slug' => 'jantar-arrumadinho-de-carne-seca']),
                'ingredients' => [
                    [
                        'qty' => '1/2',
                        'item' => 'cebola picada'
                    ],
                    [
                        'qty' => '1/3',
                        'item' => 'de pimentão amarelo picado'
                    ],
                    [
                        'qty' => null,
                        'item' => 'Sal a gosto'
                    ],
                ],
                'steps' => [
                    [
                        'title' => 'Farinha torrada',
                        'desc' => 'Em uma panela, leve a margarina Primor para aquecer. Junte a farinha e misture bem, adicione sal e frite até que doure. Reserve quente.'
                    ],
                    [
                        'title' => 'Feijão',
                        'desc' => 'Em uma frigideira funda, doure o alho e a cebola na margarina Primor. Junte o pimentão, o colorau, os tomates, o caldo, o feijão e refogue por alguns minutos. Desligue o fogo, adicione o coentro e reserve quente.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Em uma frigideira leve, aqueça a margarina Primor, acrescente a carne e frite até que doure. Junte a cebola, o colorau e deixe a cebola fritar até dourar. Numa travessa, sirva o feijão e a carne separados.'
                    ]
                ]
            ],
            [
                'type' => 'Almoço',
                'title' => 'Arroz Maria Isabel',
                'image' => url('/') . '/templates/primor-v1/images/receitas-item-04.jpg',
                'bannerSingle' => url('/') . '/templates/primor-v1/images/recipes-search-image.jpg',
                'details' => null,
                'timeStr' => '60 min',
                'portionsStr' => '10 porções',
                'difficultyStr' => 'Médio',
                'url' => route('site.receitaSingle', ['slug' => 'almoco-arroz-maria-isabel']),
                'ingredients' => [
                    [
                        'qty' => '1/2',
                        'item' => 'cebola picada'
                    ],
                    [
                        'qty' => '1/3',
                        'item' => 'de pimentão amarelo picado'
                    ],
                    [
                        'qty' => null,
                        'item' => 'Sal a gosto'
                    ],
                ],
                'steps' => [
                    [
                        'title' => 'Farinha torrada',
                        'desc' => 'Em uma panela, leve a margarina Primor para aquecer. Junte a farinha e misture bem, adicione sal e frite até que doure. Reserve quente.'
                    ],
                    [
                        'title' => 'Feijão',
                        'desc' => 'Em uma frigideira funda, doure o alho e a cebola na margarina Primor. Junte o pimentão, o colorau, os tomates, o caldo, o feijão e refogue por alguns minutos. Desligue o fogo, adicione o coentro e reserve quente.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Em uma frigideira leve, aqueça a margarina Primor, acrescente a carne e frite até que doure. Junte a cebola, o colorau e deixe a cebola fritar até dourar. Numa travessa, sirva o feijão e a carne separados.'
                    ]
                ]
            ],
            [
                'type' => 'Lanche',
                'title' => 'Bolo Pé de Moleque',
                'image' => url('/') . '/templates/primor-v1/images/receitas-item-05.jpg',
                'bannerSingle' => url('/') . '/templates/primor-v1/images/recipes-search-image.jpg',
                'details' => null,
                'timeStr' => '60 min',
                'portionsStr' => '12 porções',
                'difficultyStr' => 'Médio',
                'url' => route('site.receitaSingle', ['slug' => 'lanche-bolo-pe-de-moleque']),
                'ingredients' => [
                    [
                        'qty' => '1/2',
                        'item' => 'cebola picada'
                    ],
                    [
                        'qty' => '1/3',
                        'item' => 'de pimentão amarelo picado'
                    ],
                    [
                        'qty' => null,
                        'item' => 'Sal a gosto'
                    ],
                ],
                'steps' => [
                    [
                        'title' => 'Farinha torrada',
                        'desc' => 'Em uma panela, leve a margarina Primor para aquecer. Junte a farinha e misture bem, adicione sal e frite até que doure. Reserve quente.'
                    ],
                    [
                        'title' => 'Feijão',
                        'desc' => 'Em uma frigideira funda, doure o alho e a cebola na margarina Primor. Junte o pimentão, o colorau, os tomates, o caldo, o feijão e refogue por alguns minutos. Desligue o fogo, adicione o coentro e reserve quente.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Em uma frigideira leve, aqueça a margarina Primor, acrescente a carne e frite até que doure. Junte a cebola, o colorau e deixe a cebola fritar até dourar. Numa travessa, sirva o feijão e a carne separados.'
                    ]
                ]
            ],
            [
                'type' => 'Sobremesa',
                'title' => 'Sorvete Caseiro',
                'image' => url('/') . '/templates/primor-v1/images/receitas-item-06.jpg',
                'bannerSingle' => url('/') . '/templates/primor-v1/images/recipes-search-image.jpg',
                'details' => null,
                'timeStr' => '45 min',
                'portionsStr' => '10 porções',
                'difficultyStr' => 'Fácil',
                'url' => route('site.receitaSingle', ['slug' => 'sobremesa-sorvete-caseiro']),
                'ingredients' => [
                    [
                        'qty' => '1/2',
                        'item' => 'cebola picada'
                    ],
                    [
                        'qty' => '1/3',
                        'item' => 'de pimentão amarelo picado'
                    ],
                    [
                        'qty' => null,
                        'item' => 'Sal a gosto'
                    ],
                ],
                'steps' => [
                    [
                        'title' => 'Farinha torrada',
                        'desc' => 'Em uma panela, leve a margarina Primor para aquecer. Junte a farinha e misture bem, adicione sal e frite até que doure. Reserve quente.'
                    ],
                    [
                        'title' => 'Feijão',
                        'desc' => 'Em uma frigideira funda, doure o alho e a cebola na margarina Primor. Junte o pimentão, o colorau, os tomates, o caldo, o feijão e refogue por alguns minutos. Desligue o fogo, adicione o coentro e reserve quente.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Em uma frigideira leve, aqueça a margarina Primor, acrescente a carne e frite até que doure. Junte a cebola, o colorau e deixe a cebola fritar até dourar. Numa travessa, sirva o feijão e a carne separados.'
                    ]
                ]
            ],
        ];
    }
}