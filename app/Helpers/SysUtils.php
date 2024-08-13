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

    public static function getRecipes(): \Illuminate\Database\Eloquent\Collection
    {
        return \App\Models\Recipe::where('active', 1)->get();
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
                    'title' => 'Quantidade por porção:',
                    'items' => [
                        [
                            'description' => 'Valor energético',
                            'value_10g' => '54 kcal',
                            'value_100g' => '540 kcal',
                            'percentage' => '3%'
                        ],
                        [
                            'description' => 'Carboidratos',
                            'value_10g' => '0g',
                            'value_100g' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Açucares Totais',
                            'value_10g' => '0g',
                            'value_100g' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Açucares Adicionados',
                            'value_10g' => '0g',
                            'value_100g' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Proteínas',
                            'value_10g' => '0g',
                            'value_100g' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Gorduras totais',
                            'value_10g' => '6g',
                            'value_100g' => '60g',
                            'percentage' => '9%'
                        ],
                        [
                            'description' => 'Gorduras saturadas',
                            'value_10g' => '2,1g',
                            'value_100g' => '21g',
                            'percentage' => '11%'
                        ],
                        [
                            'description' => 'Gorduras trans',
                            'value_10g' => '0,1g',
                            'value_100g' => '0,5g',
                            'percentage' => '5%'
                        ],
                        [
                            'description' => 'Fibra alimentar',
                            'value_10g' => '0g',
                            'value_100g' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Sódio',
                            'value_10g' => '6mg',
                            'value_100g' => '660',
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
                    'title' => 'Quantidade por porção:',
                    'items' => [
                        [
                            'description' => 'Valor energético',
                            'value_10g' => '54 kcal',
                            'value_100g' => '540 kcal',
                            'percentage' => '3%'
                        ],
                        [
                            'description' => 'Gorduras totais',
                            'value_10g' => '6g',
                            'value_100g' => '60g',
                            'percentage' => '9%'
                        ],
                        [
                            'description' => 'Gorduras saturadas',
                            'value_10g' => '2,1g',
                            'value_100g' => '21g',
                            'percentage' => '11%'
                        ],
                        [
                            'description' => 'Gorduras trans',
                            'value_10g' => '0,1g',
                            'value_100g' => '0,5g',
                            'percentage' => '5%'
                        ],
                        [
                            'description' => 'Sódio',
                            'value_10g' => '66mg',
                            'value_100g' => '660mg',
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
                    'title' => 'Quantidade por porção:',
                    'items' => [
                        [
                            'description' => 'Valor energético',
                            'value_10g' => '54 kcal',
                            'value_100g' => '540 kcal',
                            'percentage' => '3%'
                        ],
                        [
                            'description' => 'Gorduras totais',
                            'value_10g' => '6g',
                            'value_100g' => '60g',
                            'percentage' => '9%'
                        ],
                        [
                            'description' => 'Gorduras saturadas',
                            'value_10g' => '2,1g',
                            'value_100g' => '21g',
                            'percentage' => '11%'
                        ],
                        [
                            'description' => 'Gorduras trans',
                            'value_10g' => '0,1g',
                            'value_100g' => '0,5g',
                            'percentage' => '5%'
                        ],
                        [
                            'description' => 'Sódio',
                            'value_10g' => '66mg',
                            'value_100g' => '660mg',
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
                    'title' => 'Quantidade por porção:',
                    'items' => [
                        [
                            'description' => 'Valor energético',
                            'value_10g' => '54 kcal',
                            'value_100g' => '540 kcal',
                            'percentage' => '3%'
                        ],
                        [
                            'description' => 'Carboidratos',
                            'value_10g' => '0g',
                            'value_100g' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Açucares Totais',
                            'value_10g' => '0g',
                            'value_100g' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Açucares Adicionados',
                            'value_10g' => '0g',
                            'value_100g' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Proteínas',
                            'value_10g' => '0g',
                            'value_100g' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Gorduras Totais',
                            'value_10g' => '6g',
                            'value_100g' => '60g',
                            'percentage' => '9%'
                        ],
                        [
                            'description' => 'Gorduras saturadas',
                            'value_10g' => '2,2g',
                            'value_100g' => '22g',
                            'percentage' => '11%'
                        ],
                        [
                            'description' => 'Gorduras trans',
                            'value_10g' => '0,1g',
                            'value_100g' => '0,5g',
                            'percentage' => '5%'
                        ],
                        [
                            'description' => 'Fibra Alimentar',
                            'value_10g' => '0g',
                            'value_100g' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Sódio',
                            'value_10g' => '60mg',
                            'value_100g' => '660mg',
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
                    'title' => 'Quantidade por porção:',
                    'items' => [
                        [
                            'description' => 'Valor energético',
                            'value_10g' => '68 kcal',
                            'value_100g' => '675 kcal',
                            'percentage' => '3%'
                        ],
                        [
                            'description' => 'Carboidratos',
                            'value_10g' => '0g',
                            'value_100g' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Açucares Totais',
                            'value_10g' => '0g',
                            'value_100g' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Açucares Adicionados',
                            'value_10g' => '0g',
                            'value_100g' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Proteínas',
                            'value_10g' => '0g',
                            'value_100g' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Gorduras Totais',
                            'value_10g' => '7,5g',
                            'value_100g' => '75g',
                            'percentage' => '12%'
                        ],
                        [
                            'description' => 'Gorduras saturadas',
                            'value_10g' => '4g',
                            'value_100g' => '40g',
                            'percentage' => '20%'
                        ],
                        [
                            'description' => 'Gorduras trans',
                            'value_10g' => '0,1g',
                            'value_100g' => '0,7g',
                            'percentage' => '5%'
                        ],
                        [
                            'description' => 'Fibra Alimentar',
                            'value_10g' => '0g',
                            'value_100g' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Sódio',
                            'value_10g' => '68mg',
                            'value_100g' => '680mg',
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
                    'title' => 'Quantidade por porção:',
                    'items' => [
                        [
                            'description' => 'Valor energético',
                            'value_10g' => '90 kcal',
                            'value_100g' => 'Não informado',
                            'percentage' => '5%'
                        ],
                        [
                            'description' => 'Valor energético',
                            'value_10g' => '378 kJ',
                            'value_100g' => 'Não informado',
                            'percentage' => ''
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
                    'title' => 'Quantidade por porção:',
                    'items' => [
                        [
                            'description' => 'Valor energético',
                            'value_10g' => '63 kcal',
                            'value_100g' => 'Não informado',
                            'percentage' => '3%'
                        ],
                        [
                            'description' => 'Valor energético',
                            'value_10g' => '265 kJ',
                            'value_100g' => 'Não informado',
                            'percentage' => ''
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