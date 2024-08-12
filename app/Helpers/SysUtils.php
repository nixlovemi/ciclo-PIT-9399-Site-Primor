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
        $typeAlmoço = 'Almoço';
        $typeSobremesa = 'Sobremesa';
        $typeLanche = 'Lanche';
        $typeJantar = 'Jantar';

        return [
            [
                'type' => $typeAlmoço,
                'title' => 'Arroz de Cuxá',
                'image' => url('/') . '/templates/primor-v1/images/receitas-arroz-de-cuxa-single.jpg',
                'bannerSingle' => url('/') . '/templates/primor-v1/images/receitas-arroz-de-cuxa-banner.jpg',
                'details' => null,
                'timeStr' => '60 min',
                'portionsStr' => '6 porções',
                'difficultyStr' => 'Fácil',
                'url' => route('site.receitaSingle', ['slug' => 'almoco-arroz-de-cuxa']),
                'ingredients' => [
                    [
                        'qty' => '2',
                        'item' => 'xícaras de arroz'
                    ],
                    [
                        'qty' => '1',
                        'item' => 'maço de vinagreira (ou hibisco) picada'
                    ],
                    [
                        'qty' => 2,
                        'item' => 'colheres de sopa de Margarina Primor'
                    ],
                    [
                        'qty' => 1,
                        'item' => 'cebola grande picada'
                    ],
                    [
                        'qty' => 3,
                        'item' => 'dentes de alho picados'
                    ],
                    [
                        'qty' => 2,
                        'item' => 'xícaras de camarão seco'
                    ],
                    [
                        'qty' => 1,
                        'item' => 'xícara de gergelim torrado e triturado'
                    ],
                    [
                        'qty' => null,
                        'item' => 'Sal a gosto'
                    ],
                    [
                        'qty' => null,
                        'item' => 'Água suficiente para cozinhar o arroz'
                    ],
                ],
                'steps' => [
                    [
                        'title' => null,
                        'desc' => 'Em uma panela, derreta a Margarina Primor e refogue a cebola e o alho até dourarem.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Adicione a vinagreira e refogue até que murche.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Acrescente o arroz e misture bem.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Adicione água suficiente para cozinhar o arroz e tempere com sal a gosto.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Quando o arroz estiver quase cozido, adicione o camarão seco e o gergelim torrado.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Misture bem e termine o cozimento do arroz.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Sirva quente.'
                    ],
                ]
            ],

            [
                'type' => $typeSobremesa,
                'title' => 'Arroz Doce',
                'image' => url('/') . '/templates/primor-v1/images/receitas-arroz-doce-single.jpg',
                'bannerSingle' => url('/') . '/templates/primor-v1/images/receitas-arroz-doce-banner.jpg',
                'details' => null,
                'timeStr' => '20 min',
                'portionsStr' => '4 porções',
                'difficultyStr' => 'Fácil',
                'url' => route('site.receitaSingle', ['slug' => 'sobremesa-arroz-doce']),
                'ingredients' => [
                    [
                        'qty' => '1',
                        'item' => 'xícara de arroz'
                    ],
                    [
                        'qty' => '1',
                        'item' => 'litro de leite'
                    ],
                    [
                        'qty' => 1,
                        'item' => 'lata de leite condensado'
                    ],
                    [
                        'qty' => 1,
                        'item' => 'vidro de leite de coco (200ml)'
                    ],
                    [
                        'qty' => 1,
                        'item' => 'xícara de açúcar'
                    ],
                    [
                        'qty' => 1,
                        'item' => 'pau de canela'
                    ],
                    [
                        'qty' => 3,
                        'item' => 'cravos-da-índia'
                    ],
                    [
                        'qty' => 2,
                        'item' => 'colheres de sopa de Margarina Primor'
                    ],
                    [
                        'qty' => null,
                        'item' => 'Canela em pó para polvilhar'
                    ],
                ],
                'steps' => [
                    [
                        'title' => null,
                        'desc' => 'Em uma panela grande, cozinhe o arroz em 2 xícaras de água até que esteja macio.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Adicione o leite, o leite condensado, o leite de coco, o açúcar, o pau de canela e os cravos-da-índia.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Cozinhe em fogo baixo, mexendo sempre, até que o arroz esteja bem cremoso.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Acrescente a Margarina Primor e misture bem.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Retire os cravos e o pau de canela.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Despeje o arroz doce em uma travessa e polvilhe com canela em pó.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Sirva quente ou frio.'
                    ],
                ]
            ],

            [
                'type' => $typeJantar,
                'title' => 'Pato no Tucupi',
                'image' => url('/') . '/templates/primor-v1/images/receitas-pato-no-tucupi-single.jpg',
                'bannerSingle' => url('/') . '/templates/primor-v1/images/receitas-pato-no-tucupi-banner.jpg',
                'details' => null,
                'timeStr' => '180 min',
                'portionsStr' => '4 porções',
                'difficultyStr' => 'Difícil',
                'url' => route('site.receitaSingle', ['slug' => 'jantar-pato-no-tucupi']),
                'ingredients' => [
                    [
                        'qty' => '1',
                        'item' => 'pato inteiro (cerca de 2kg) cortado em pedaços'
                    ],
                    [
                        'qty' => '2',
                        'item' => 'limões'
                    ],
                    [
                        'qty' => null,
                        'item' => 'Sal e pimenta-do-reino a gosto'
                    ],
                    [
                        'qty' => '3',
                        'item' => 'colheres de sopa de Margarina Primor'
                    ],
                    [
                        'qty' => '1',
                        'item' => 'cebola grande picada'
                    ],
                    [
                        'qty' => '4',
                        'item' => 'dentes de alho picados'
                    ],
                    [
                        'qty' => '2',
                        'item' => 'litros de tucupi'
                    ],
                    [
                        'qty' => '1',
                        'item' => 'maço de jambu'
                    ],
                    [
                        'qty' => '3',
                        'item' => 'folhas de chicória (ou alfavaca)'
                    ],
                    [
                        'qty' => null,
                        'item' => 'Pimenta-de-cheiro a gosto'
                    ],
                ],
                'steps' => [
                    [
                        'title' => null,
                        'desc' => 'Tempere os pedaços de pato com sal, pimenta-do-reino e suco de limão. Deixe marinar por pelo menos 1 hora.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Em uma panela grande, derreta a Margarina Primor e frite os pedaços de pato até dourarem.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Acrescente a cebola e o alho e refogue até dourarem.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Adicione o tucupi, a chicória e a pimenta-de-cheiro. Cozinhe em fogo baixo por cerca de 2 horas, ou até que o pato esteja bem macio.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Enquanto isso, cozinhe o jambu em água fervente até que esteja macio. Escorra e reserve.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Adicione o jambu ao pato e deixe cozinhar por mais 10 minutos.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Ajuste o sal e a pimenta-do-reino.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Sirva quente com arroz branco.'
                    ],
                ]
            ],

            [
                'type' => $typeLanche,
                'title' => 'Cuscuz',
                'image' => url('/') . '/templates/primor-v1/images/receitas-cuscuz-single.jpg',
                'bannerSingle' => url('/') . '/templates/primor-v1/images/receitas-cuscuz-banner.jpg',
                'details' => null,
                'timeStr' => '15 min',
                'portionsStr' => '5 porções',
                'difficultyStr' => 'Fácil',
                'url' => route('site.receitaSingle', ['slug' => 'lanche-cuscuz']),
                'ingredients' => [
                    [
                        'qty' => '2',
                        'item' => 'xícaras de farinha de milho flocada'
                    ],
                    [
                        'qty' => '1/2',
                        'item' => 'xícara de água'
                    ],
                    [
                        'qty' => '1',
                        'item' => 'colher de chá de sal'
                    ],
                    [
                        'qty' => '2',
                        'item' => 'colheres de sopa de Margarina Primor'
                    ],
                ],
                'steps' => [
                    [
                        'title' => null,
                        'desc' => 'Em uma tigela, misture a farinha de milho, a água e o sal. Deixe descansar por 10 minutos.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Coloque a mistura de farinha de milho em uma cuscuzeira.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Cozinhe em banho-maria por cerca de 15 minutos ou até que o cuscuz esteja cozido.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Retire o cuscuz da cuscuzeira e transfira para um prato.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Derreta a Margarina Primor e regue sobre o cuscuz.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Sirva quente.'
                    ],
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                ]
            ],

            [
                'type' => $typeAlmoço,
                'title' => 'Baião de Dois',
                'image' => url('/') . '/templates/primor-v1/images/receitas-baiao-de-dois-single.jpg',
                'bannerSingle' => url('/') . '/templates/primor-v1/images/receitas-baiao-de-dois-banner.jpg',
                'details' => null,
                'timeStr' => '30 min',
                'portionsStr' => '6 porções',
                'difficultyStr' => 'Moderado',
                'url' => route('site.receitaSingle', ['slug' => 'almoco-baiao-de-dois']),
                'ingredients' => [
                    [
                        'qty' => '1',
                        'item' => 'xícara de arroz'
                    ],
                    [
                        'qty' => '1',
                        'item' => 'xícara de feijão verde (ou feijão fradinho) cozido'
                    ],
                    [
                        'qty' => '200g',
                        'item' => 'de carne seca dessalgada e desfiada'
                    ],
                    [
                        'qty' => '150g',
                        'item' => 'de bacon picado'
                    ],
                    [
                        'qty' => '200g',
                        'item' => 'de queijo coalho em cubos'
                    ],
                    [
                        'qty' => '2',
                        'item' => 'colheres de sopa de Margarina Primor'
                    ],
                    [
                        'qty' => '1',
                        'item' => 'cebola grande picada'
                    ],
                    [
                        'qty' => '3',
                        'item' => 'dentes de alho picados'
                    ],
                    [
                        'qty' => '1',
                        'item' => 'pimentão verde picado'
                    ],
                    [
                        'qty' => null,
                        'item' => 'Sal e pimenta-do-reino a gosto'
                    ],
                    [
                        'qty' => null,
                        'item' => 'Coentro picado a gosto'
                    ],
                ],
                'steps' => [
                    [
                        'title' => null,
                        'desc' => 'Em uma panela, derreta a Margarina Primor e frite o bacon até dourar.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Acrescente a cebola, o alho e o pimentão e refogue até dourarem.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Adicione a carne seca e refogue por mais alguns minutos.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Acrescente o arroz e misture bem.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Adicione o feijão cozido e o caldo do cozimento do feijão suficiente para cozinhar o arroz.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Tempere com sal e pimenta-do-reino a gosto.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Quando o arroz estiver quase cozido, adicione o queijo coalho e misture delicadamente.'
                    ],
                    [
                        'title' => null,
                        'desc' => 'Finalize com coentro picado e sirva quente.'
                    ],
                ]
            ],

            /*
            [
                'type' => $typeSobremesa|$typeAlmoço|$typeLanche|$typeJantar,
                'title' => '',
                'image' => url('/') . '/templates/primor-v1/images/receitas-arroz-doce-single.jpg',
                'bannerSingle' => url('/') . '/templates/primor-v1/images/receitas-arroz-doce-banner.jpg',
                'details' => null,
                'timeStr' => 'XXX min',
                'portionsStr' => 'YYY porções',
                'difficultyStr' => 'Fácil|Moderado|Difícil',
                'url' => route('site.receitaSingle', ['slug' => '']),
                'ingredients' => [
                    [
                        'qty' => '',
                        'item' => ''
                    ],
                    [
                        'qty' => '',
                        'item' => ''
                    ],
                    [
                        'qty' => '',
                        'item' => ''
                    ],
                    [
                        'qty' => '',
                        'item' => ''
                    ],
                    [
                        'qty' => '',
                        'item' => ''
                    ],
                    [
                        'qty' => '',
                        'item' => ''
                    ],
                    [
                        'qty' => '',
                        'item' => ''
                    ],
                    [
                        'qty' => '',
                        'item' => ''
                    ],
                    [
                        'qty' => '',
                        'item' => ''
                    ],
                    [
                        'qty' => '',
                        'item' => ''
                    ],
                    [
                        'qty' => '',
                        'item' => ''
                    ],
                    [
                        'qty' => '',
                        'item' => ''
                    ],
                    [
                        'qty' => '',
                        'item' => ''
                    ],
                    [
                        'qty' => '',
                        'item' => ''
                    ],
                    [
                        'qty' => '',
                        'item' => ''
                    ],
                ],
                'steps' => [
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                    [
                        'title' => null,
                        'desc' => ''
                    ],
                ]
            ],
            */

            /*
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
                'details' => null,
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
            */
        ];
    }

    public static function getProducts(): array
    {
        $iconAssar = url('/') . '/templates/primor-v1/images/product-icon-assar.png';
        $iconCozinhar = url('/') . '/templates/primor-v1/images/product-icon-cozinhar.png';
        $iconServir = url('/') . '/templates/primor-v1/images/product-icon-servir.png';

        return [
            [
                'family' => 'margarina-tradicional',
                'familySize' => '250g',
                'familyOrder' => 1,
                'title' => 'Margarina Original com Sal Primor Pote 250g',
                'titleShort' => 'Margarina Primor 250g',
                'url' => route('site.produtosSingle', ['slug' => 'margarina-original-sal-primor-pote-250g']),
                'description' => 'Seja no forno, preparando seu bolo preferido ou no toque final daquele cuscuz quentinho, a margarina Primor é a escolha certa para quem cozinha com amor. Tenha sempre em casa!',
                'image' => url('/') . '/templates/primor-v1/images/product-margarina-original-sal-primor-pote-250g.png',
                'iconChoices' => [
                    $iconAssar,
                    $iconCozinhar,
                    $iconServir
                ],
                'ingredients' => 'Óleos vegetais líquidos e interesterificados (contém óleo de soja*), água, sal, cloreto de potássio,
                        emulsificantes mono e diglicerídeos de ácidos graxos, ésteres de poliglicerol de ácidos graxos e lecitina
                        de soja*, aromatizantes, conservador benzoato de sódio, corante natural de urucum e cúrcuma,
                        antioxidantes EDTA cálcio dissódico, BHT e ácido cítrico e acidulante ácido láctico. *Geneticamente
                        modificado a partir de streptomyces viridochromogenes e/ou agrobacterium tumefaciens e/ou bacillus
                        thuringiensis.
                        <br /><br />
                        <strong>Alérgicos:</strong>
                        <br />
                        Contém Glúten*: Não Contém
                        <br />
                        Aromatizante*: Sintético Idêntico ao Natural
                        <br />
                        Contém Lactose*: Contém
                        <br />
                        Contém Leite: Pode Conter<br />
                        Contém Soja - Derivados: Contém',
                'nutritionalInfo' => [
                    'title' => 'Quantidade por porção de 10g',
                    'items' => [
                        [
                            'description' => 'Valor energético',
                            'value' => '54 kcal = 227kJ',
                            'percentage' => '3%'
                        ],
                        [
                            'description' => 'Carboidratos',
                            'value' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Açucares Totais',
                            'value' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Proteínas',
                            'value' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Gorduras totais',
                            'value' => '6g',
                            'percentage' => '9%'
                        ],
                        [
                            'description' => 'Gorduras saturadas',
                            'value' => '2,1g',
                            'percentage' => '11%'
                        ],
                        [
                            'description' => 'Gorduras trans',
                            'value' => '0,1g',
                            'percentage' => '5%'
                        ],
                        [
                            'description' => 'Fibra alimentar',
                            'value' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Sódio',
                            'value' => '6mg',
                            'percentage' => '3%'
                        ],
                    ],
                    'obs' => [
                        [
                            'description' => 'Referência para Valores Diários:'
                        ],
                        [
                            'description' => '*Percentual de valores diários fornecidos pela porção.'
                        ],
                        [
                            'description' => 'Informação Complementar Nutricional: 60% de gordura.'
                        ],
                        [
                            'description' => 'Tabela Nutricional - RDC 429: Conforme'
                        ],
                    ]
                ],
            ],
            [
                'family' => 'margarina-tradicional',
                'familySize' => '500g',
                'familyOrder' => 2,
                'title' => 'Margarina Original com Sal Primor Pote 500g',
                'titleShort' => 'Margarina Primor 500g',
                'url' => route('site.produtosSingle', ['slug' => 'margarina-original-sal-primor-pote-500g']),
                'description' => 'Seja no forno, preparando seu bolo preferido ou no toque final daquele cuscuz quentinho, a margarina Primor é a escolha certa para quem cozinha com amor. Tenha sempre em casa!',
                'image' => url('/') . '/templates/primor-v1/images/product-margarina-original-sal-primor-pote-500g.png',
                'iconChoices' => [
                    $iconAssar,
                    $iconCozinhar,
                    $iconServir
                ],
                'ingredients' => 'Óleos vegetais líquidos e interesterificados (contém óleo de soja*), água, sal, cloreto de potássio,
                    emulsificantes mono e diglicerídeos de ácidos graxos, ésteres de poliglicerol de ácidos graxos e lecitina
                    de soja*, aromatizantes, conservador benzoato de sódio, corante natural de urucum e cúrcuma,
                    antioxidantes EDTA cálcio dissódico, BHT e ácido cítrico e acidulante ácido láctico. *Geneticamente
                    modificado a partir de streptomyces viridochromogenes e/ou agrobacterium tumefaciens e/ou bacillus
                    thuringiensis.
                    <br /><br />
                    <strong>Alérgicos:</strong>
                    <br />
                    Contém Glúten*: Não Contém
                    <br />
                    Aromatizante*: Sintético Idêntico ao Natural
                    <br />
                    Contém Lactose*: Contém
                    <br />
                    Contém Leite: Pode Conter
                    <br />
                    Contém Soja - Derivados: Contém',
                'nutritionalInfo' => [
                    'title' => 'Quantidade por porção de 10g',
                    'items' => [
                        [
                            'description' => 'Valor energético',
                            'value' => '54 kcal = 227kJ',
                            'percentage' => '3%'
                        ],
                        [
                            'description' => 'Gorduras totais',
                            'value' => '6g',
                            'percentage' => '9%'
                        ],
                        [
                            'description' => 'Gorduras saturadas',
                            'value' => '2,1g',
                            'percentage' => '11%'
                        ],
                        [
                            'description' => 'Gorduras trans',
                            'value' => '0,1g',
                            'percentage' => '5%'
                        ],
                        [
                            'description' => 'Sódio',
                            'value' => '66mg',
                            'percentage' => '3%'
                        ],
                    ],
                    'obs' => [
                        [
                            'description' => 'Referência para Valores Diários:'
                        ],
                        [
                            'description' => '*Percentual de valores diários fornecidos pela porção. Não contém quantidades significativas de
                                carboidratos, açúcares totais, açúcares adicionados, proteínas e fibras alimentares.'
                        ],
                        [
                            'description' => 'Informação Complementar Nutricional: 60% de gordura.'
                        ],
                        [
                            'description' => 'Tabela Nutricional - RDC 429: Conforme'
                        ],
                    ]
                ],
            ],
            [
                'family' => 'margarina-tradicional',
                'familySize' => '1kg',
                'familyOrder' => 3,
                'title' => 'Margarina Original com Sal Primor Pote 1kg',
                'titleShort' => 'Margarina Primor 1kg',
                'url' => route('site.produtosSingle', ['slug' => 'margarina-original-sal-primor-pote-1kg']),
                'description' => 'Seja no forno, preparando seu bolo preferido ou no toque final daquele cuscuz quentinho, a margarina Primor é a escolha certa para quem cozinha com amor. Tenha sempre em casa!',
                'image' => url('/') . '/templates/primor-v1/images/product-margarina-original-sal-primor-pote-1kg.png',
                'iconChoices' => [
                    $iconAssar,
                    $iconCozinhar,
                    $iconServir
                ],
                'ingredients' => 'Óleos vegetais líquidos e interesterificados (contém óleo de soja*), água, sal, cloreto de potássio,
                    emulsificantes mono e diglicerídeos de ácidos graxos, ésteres de poliglicerol de ácidos graxos e lecitina
                    de soja*, aromatizantes, conservador benzoato de sódio, corante natural de urucum e cúrcuma,
                    antioxidantes EDTA cálcio dissódico, BHT e ácido cítrico e acidulante ácido láctico. *Geneticamente
                    modificado a partir de streptomyces viridochromogenes e/ou agrobacterium tumefaciens e/ou bacillus
                    thuringiensis.
                    <br /><br />
                    <strong>Alérgicos:</strong>
                    <br />
                    Contém Glúten*:Não Contém
                    <br />
                    Aromatizante*: Sintético Idêntico ao Natural
                    <br />
                    Contém Lactose*: Contém
                    <br />
                    Contém Leite: Pode Conter
                    <br />
                    Contém Soja - Derivados: Contém',
                'nutritionalInfo' => [
                    'title' => 'Quantidade por porção de 10g',
                    'items' => [
                        [
                            'description' => 'Valor energético',
                            'value' => '54 kcal = 227kJ',
                            'percentage' => '3%'
                        ],
                        [
                            'description' => 'Gorduras totais',
                            'value' => '6g',
                            'percentage' => '9%'
                        ],
                        [
                            'description' => 'Gorduras saturadas',
                            'value' => '2,1g',
                            'percentage' => '11%'
                        ],
                        [
                            'description' => 'Gorduras trans',
                            'value' => '0,1g',
                            'percentage' => '5%'
                        ],
                        [
                            'description' => 'Sódio',
                            'value' => '66mg',
                            'percentage' => '3%'
                        ],
                    ],
                    'obs' => [
                        [
                            'description' => 'Referência para Valores Diários:'
                        ],
                        [
                            'description' => '*Percentual de valores diários fornecidos pela porção. Não contém quantidades significativas de carboidratos, açúcares totais, açúcares adicionados, proteínas e fibras alimentares.'
                        ],
                        [
                            'description' => '** VD não estabelecido'
                        ],
                        [
                            'description' => 'Informação Complementar Nutricional: 60% de gordura.'
                        ],
                        [
                            'description' => 'Tabela Nutricional - RDC 429: Conforme'
                        ],
                    ]
                ],
            ],

            [
                'family' => 'margarina-balde',
                'familySize' => '3kg',
                'familyOrder' => 1,
                'title' => 'Margarina Amanteigada com Sal Primor Balde 3kg',
                'titleShort' => 'Margarina Balde 3kg',
                'url' => route('site.produtosSingle', ['slug' => 'margarina-amanteigada-sal-primor-balde-3kg']),
                'description' => 'Seja no forno, preparando seu bolo preferido ou no toque final daquele cuscuz quentinho, a margarina Primor é a escolha certa para quem cozinha com amor. Tenha sempre em casa!',
                'image' => url('/') . '/templates/primor-v1/images/margarina-amanteigada-sal-primor-balde-3kg.png',
                'iconChoices' => [
                    $iconAssar,
                    $iconCozinhar,
                    $iconServir
                ],
                'ingredients' => 'Óleos vegetais líquidos e interesterificados (contém óleo de soja*), água, sal, emulsificantes mono e
                    diglicerídeos de ácidos graxos, ésteres de poliglicerol de ácidos graxos e lecitina de soja*, aromatizantes,
                    conservador benzoato de sódio, corante natural de urucum e cúrcuma, antioxidantes EDTA cálcio
                    dissódico, BHT e ácido cítrico e acidulante ácido láctico. *Geneticamente modificado a partir de
                    streptomyces viridochromogenes e/ou agrobacterium tumefaciens e/ou bacillus thuringiensis.
                    <br /><br />
                    <strong>Alérgicos</strong>
                    <br />
                    Contém Glúten*: Não Contém
                    <br />
                    Aromatizante*: Sintético Idêntico ao Natural
                    <br />
                    Contém Lactose*: Pode Conter
                    <br />
                    Contém Leite: Pode Conter
                    <br />
                    Contém Soja - Derivados: Contém',
                'nutritionalInfo' => [
                    'title' => 'Quantidade por porção de 10g',
                    'items' => [
                        [
                            'description' => 'Valor energético',
                            'value' => '54 kcal = 225kJ',
                            'percentage' => '3%'
                        ],
                        [
                            'description' => 'Carboidratos',
                            'value' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Açucares Totais',
                            'value' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Açucares Adicionados',
                            'value' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Proteínas',
                            'value' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Gorduras Totais',
                            'value' => '6g',
                            'percentage' => '9%'
                        ],
                        [
                            'description' => 'Gorduras saturadas',
                            'value' => '2,2g',
                            'percentage' => '11%'
                        ],
                        [
                            'description' => 'Gorduras trans',
                            'value' => '0,1g',
                            'percentage' => '5%'
                        ],
                        [
                            'description' => 'Fibra Alimentar',
                            'value' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Sódio',
                            'value' => '60mg',
                            'percentage' => '3%'
                        ],
                    ],
                    'obs' => [
                        [
                            'description' => 'Referência para Valores Diários:'
                        ],
                        [
                            'description' => '* Percentual de valores diários fornecidos pela porção.'
                        ],
                        [
                            'description' => 'Informação Complementar Nutricional: 60% de gordura.'
                        ],
                        [
                            'description' => 'Tabela Nutricional - RDC 429: Conforme'
                        ],
                    ]
                ],
            ],
            [
                'family' => 'margarina-balde',
                'familySize' => '15kg',
                'familyOrder' => 2,
                'title' => 'Margarina Amanteigada com Sal Primor Balde 15kg',
                'titleShort' => 'Margarina Balde 15kg',
                'url' => route('site.produtosSingle', ['slug' => 'margarina-amanteigada-sal-primor-balde-15kg']),
                'description' => 'Seja no forno, preparando seu bolo preferido ou no toque final daquele cuscuz quentinho, a margarina Primor é a escolha certa para quem cozinha com amor. Tenha sempre em casa!',
                'image' => url('/') . '/templates/primor-v1/images/margarina-amanteigada-sal-primor-balde-15kg.png',
                'iconChoices' => [
                    $iconAssar,
                    $iconCozinhar,
                    $iconServir
                ],
                'ingredients' => 'Óleos vegetais líquidos e interesterificados (contém óleo de soja*), água, sal, emulsificantes lecitina de
                    soja*, mono e diglicerídeos de ácidos graxos e ésteres de poliglicerol de ácidos graxos, conservador
                    benzoato de sódio, aromatizante, acidulante ácido láctico, antioxidantes EDTA cálcio dissódico, BHT e
                    ácido cítrico e corante natural de urucum e cúrcuma. *(Geneticamente modificado a partir de
                    streptomyces viridochromogenes e/ou agrobacterium tumefaciens e/ou bacillus thuringiensis).
                    <br /><br />
                    <strong>Alérgicos:</strong>`
                    <br />
                    Contém Glúten*: Não Contém
                    <br />
                    Aromatizante*: Sintético Idêntico ao Natural
                    <br />
                    Contém Lactose*: Contém
                    <br />
                    Contém Leite: Pode Conter
                    <br />
                    Contém Soja - Derivados: Contém',
                'nutritionalInfo' => [
                    'title' => 'Quantidade por porção de 10g',
                    'items' => [
                        [
                            'description' => 'Valor energético',
                            'value' => '68 kcal = 284kJ',
                            'percentage' => '3%'
                        ],
                        [
                            'description' => 'Carboidratos',
                            'value' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Açucares Totais',
                            'value' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Açucares Adicionados',
                            'value' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Proteínas',
                            'value' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Gorduras Totais',
                            'value' => '7,5g',
                            'percentage' => '12%'
                        ],
                        [
                            'description' => 'Gorduras saturadas',
                            'value' => '4g',
                            'percentage' => '20%'
                        ],
                        [
                            'description' => 'Gorduras trans',
                            'value' => '0,1g',
                            'percentage' => '5%'
                        ],
                        [
                            'description' => 'Fibra Alimentar',
                            'value' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Sódio',
                            'value' => '68mg',
                            'percentage' => '3%'
                        ],
                    ],
                    'obs' => [
                        [
                            'description' => 'Referência para Valores Diários:'
                        ],
                        [
                            'description' => '* Percentual de valores diários fornecidos pela porção.'
                        ],
                        [
                            'description' => 'Informação Complementar Nutricional: 75% de gorduras.'
                        ],
                        [
                            'description' => 'Tabela Nutricional - RDC 429: Conforme'
                        ],
                    ]
                ],
            ],

            [
                'family' => 'gordura-vegetal',
                'familySize' => '500g',
                'familyOrder' => 1,
                'title' => 'Gordura Vegetal Primor Pacote 500g',
                'titleShort' => 'Gordura Vegetal 500g',
                'url' => route('site.produtosSingle', ['slug' => 'gordura-vegetal-primor-pacote-500g']),
                'description' => 'Seja no forno, preparando seu bolo preferido ou no toque final daquele cuscuz quentinho, a margarina Primor é a escolha certa para quem cozinha com amor. Tenha sempre em casa!',
                'image' => url('/') . '/templates/primor-v1/images/gordura-vegetal-primor-pacote-500g.png',
                'iconChoices' => [
                    $iconAssar,
                    $iconCozinhar,
                    $iconServir
                ],
                'ingredients' => 'Gordura de palma e antioxidantes: BHT e ácido cítrico.
                    <br /><br />
                    <strong>Alérgicos:</strong>
                    <br />
                    Contém Glúten*: Não Contém
                    <br />
                    Aromatizante*: Não Contém
                    <br />
                    Contém Lactose*: Não Contém
                    <br />
                    Aromatizante Artificial: Não Contém',
                'nutritionalInfo' => [
                    'title' => 'Quantidade por porção de 10g',
                    'items' => [
                        [
                            'description' => 'Valor energético',
                            'value' => '90 kcal = 376kJ',
                            'percentage' => '5%'
                        ],
                    ],
                    'obs' => [
                        [
                            'description' => 'Referência para Valores Diários:'
                        ],
                        [
                            'description' => '* %Valores Diários de referência com base em uma dieta de 2.000kcal ou 8.400kj. Seus
                                valores diários podem ser maiores ou menores dependendo de suas necessidades
                                energéticas.'
                        ],
                        [
                            'description' => 'Informação Complementar Nutricional:'
                        ],
                        [
                            'description' => 'Tabela Nutricional - RDC 429:'
                        ],
                        [
                            'description' => ''
                        ],
                        [
                            'description' => ''
                        ],
                    ]
                ],
            ],

            [
                'family' => 'margarina-tablete',
                'familySize' => '100g',
                'familyOrder' => 1,
                'title' => 'Margarina Primor Forno e Fogão Pacote 4 Unidades 100g',
                'titleShort' => 'Margarina Tablete 4 Unidades 100g',
                'url' => route('site.produtosSingle', ['slug' => 'margarina-primor-forno-fogão-pacote-100g']),
                'description' => 'Seja no forno, preparando seu bolo preferido ou no toque final daquele cuscuz quentinho, a margarina Primor é a escolha certa para quem cozinha com amor. Tenha sempre em casa!',
                'image' => null,
                'iconChoices' => [
                    $iconAssar,
                    $iconCozinhar,
                    $iconServir
                ],
                'ingredients' => 'Óleos vegetais líquidos e totalmente hidrogenados (contém óleo de soja), água, sal, emulsificantes: mono e diglicerídeos de ácidos graxos e lecitina de soja, conservador benzoato de sódio, aromatizantes, antioxidantes: EDTA cálcio dissódico, BHT e ácido cítrico, acidulante ácido láctico e corante idêntico ao natural betacaroteno. NÃO CONTÉM GLÚTEN. ALÉRGICOS: CONTÉM DERIVADOS DE SOJA. PODE CONTER LEITE.',
                'nutritionalInfo' => [
                    'title' => 'Quantidade por porção de 10g',
                    'items' => [
                        [
                            'description' => 'Valor energético',
                            'value' => '63 kcal = 265kJ',
                            'percentage' => '3%'
                        ],
                    ],
                    'obs' => [
                        [
                            'description' => '* %Valores Diários de referência com base em uma dieta de 2.000kcal ou 8.400kj. Seus valores diários podem ser maiores ou menores dependendo de suas necessidades energéticas.'
                        ],
                        [
                            'description' => '** VD não estabelecido.'
                        ]
                    ]
                ],
            ],
        ];
    }
}