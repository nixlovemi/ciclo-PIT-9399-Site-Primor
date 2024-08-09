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
                'ingredients' => 'Óleos vegetais líquidos e interesterificados (contém óleo de soja*), água, sal, cloreto de potássio, emulsificantes mono e diglicerídeos de ácidos graxos, ésteres de poliglicerol de ácidos graxos e lecitina de soja*, aromatizantes, conservador benzoato de sódio, corante natural de urucum e cúrcuma, antioxidantes EDTA cálcio dissódico, BHT e ácido cítrico e acidulante ácido láctico. *Geneticamente modificado a partir de streptomyces viridochromogenes e/ou agrobacterium tumefaciens e/ou bacillus thuringiensis. NÃO CONTÉM GLÚTEN. ALÉRGICOS: CONTÉM DERIVADOS DE SOJA. PODE CONTER LEITE.',
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
                            'description' => '*Percentual de valores diários fornecidos pela porção.'
                        ]
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
                'ingredients' => 'Óleos vegetais líquidos e interesterificados (contém óleo de soja*), água, sal, cloreto de potássio, emulsificantes: mono e diglicerídeos de ácidos graxos, lecitina de soja* e ésteres de poliglicerol de ácidos graxos, aromatizantes, conservador benzoato de sódio, corante natural de urucum e cúrcuma, antioxidantes: EDTA cálcio dissódico, BHT e ácido cítrico e acidulante ácido láctico. *(Geneticamente modificado a partir de Streptomyces viridochromogenes e/ou Agrobacterium tumefaciens e/ou Bacillus thuringiensis). NÃO CONTÉM GLÚTEN. ALÉRGICOS: CONTÉM DERIVADOS DE SOJA. PODE CONTER LEITE.',
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
                            'description' => 'Proteínas',
                            'value' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Gorduras totais',
                            'value' => '6g',
                            'percentage' => '11%'
                        ],
                        [
                            'description' => 'Gorduras saturadas',
                            'value' => '1,9g',
                            'percentage' => '9%'
                        ],
                        [
                            'description' => 'Gorduras trans',
                            'value' => '0g',
                            'percentage' => '**'
                        ],
                        [
                            'description' => 'Fibra alimentar',
                            'value' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Sódio',
                            'value' => '64mg',
                            'percentage' => '3%'
                        ],
                    ],
                    'obs' => [
                        [
                            'description' => '* % Valores Diários de Referência com base em uma dieta de 2.000 kcal ou 8.400 kJ. Seus valores diários podem ser maiores ou menores dependendo de suas necessidades energéticas.'
                        ],
                        [
                            'description' => '** VD não estabelecido'
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
                'ingredients' => 'Óleos vegetais líquidos e interesterificados (contém óleo de soja*), água, sal, cloreto de potássio, emulsificantes mono e diglicerídeos de ácidos graxos, ésteres de poliglicerol de ácidos graxos e lecitina de soja*, aromatizantes, conservador benzoato de sódio, corante natural de urucum e cúrcuma, antioxidantes EDTA cálcio dissódico, BHT e ácido cítrico e acidulante ácido láctico. *Geneticamente modificado a partir de streptomyces viridochromogenes e/ou agrobacterium tumefaciens e/ou bacillus thuringiensis. NÃO CONTÉM GLÚTEN. ALÉRGICOS: CONTÉM DERIVADOS DE SOJA. PODE CONTER LEITE.',
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
                            'description' => '*Percentual de valores diários fornecidos pela porção. Não contém quantidades significativas de carboidratos, açúcares totais, açúcares adicionados, proteínas e fibras alimentares.'
                        ],
                        [
                            'description' => '** VD não estabelecido'
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
                'ingredients' => 'Óleos vegetais líquidos e interesterificados (contém óleo de soja*), água, sal, emulsificantes mono e diglicerídeos de ácidos graxos, ésteres de poliglicerol de ácidos graxos e lecitina de soja*, aromatizantes, conservador benzoato de sódio, corante natural de urucum e cúrcuma, antioxidantes EDTA cálcio dissódico, BHT e ácido cítrico e acidulante ácido láctico. *Geneticamente modificado a partir de streptomyces viridochromogenes e/ou agrobacterium tumefaciens e/ou bacillus thuringiensis. NÃO CONTÉM GLÚTEN. ALÉRGICOS: CONTÉM DERIVADOS DE SOJA. PODE CONTER LEITE.',
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
                            'description' => '* Percentual de valores diários fornecidos pela porção.'
                        ]
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
                'ingredients' => 'Óleos vegetais líquidos e interesterificados (contém óleo de soja*), água, sal, emulsificantes lecitina de soja*, mono e diglicerídeos de ácidos graxos e ésteres de poliglicerol de ácidos graxos, conservador benzoato de sódio, aromatizante, acidulante ácido láctico, antioxidantes EDTA cálcio dissódico, BHT e ácido cítrico e corante natural de urucum e cúrcuma. *(Geneticamente modificado a partir de streptomyces viridochromogenes e/ou agrobacterium tumefaciens e/ou bacillus thuringiensis). NÃO CONTÉM GLÚTEN. ALÉRGICOS: CONTÉM DERIVADOS DE SOJA. PODE CONTER LEITE.',
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
                            'description' => '* Percentual de valores diários fornecidos pela porção.'
                        ]
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
                'ingredients' => 'Gordura de palma e antioxidantes: BHT e ácido cítrico. NÃO CONTÉM GLÚTEN. ALÉRGICOS: CONTÉM DERIVADOS DE SOJA. PODE CONTER LEITE.',
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
                            'description' => '* %Valores Diários de referência com base em uma dieta de 2.000kcal ou 8.400kj. Seus valores diários podem ser maiores ou menores dependendo de suas necessidades energéticas.'
                        ]
                    ]
                ],
            ],
        ];
    }
}