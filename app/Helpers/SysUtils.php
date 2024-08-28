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

        $arrProducts = [
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
                'ingredients' => '
                    Óleos vegetais líquidos e interesterificados (contém
                    óleo de soja*), água, sal, cloreto de potássio,
                    emulsificantes: mono e diglicerídeos de ácidos graxos,
                    lecitina de soja* e ésteres de poliglicerol de ácidos
                    graxos, aromatizantes, conservador benzoato de sódio,
                    corante natural de urucum e cúrcuma, antioxidantes:
                    EDTA cálcio dissódico, BHT e ácido cítrico e
                    acidulante ácido láctico. *(geneticamente modificado a
                    partir de Streptomyces viridochromogenes e/ou
                    Agrobacterium tumefaciens e/ou Bacillus
                    thuringiensis).
                    <br />
                    <strong>NÃO CONTÉM GLÚTEN.<br />ALÉRGICOS: CONTÉM DERIVADOS DE SOJA. PODE CONTER LEITE.</strong>
                    <br /><br />
                    <h4 class="text-clear">Especificações</h4>
                    <span class="text-clear">
                        Teor de Gorduras (%): Mín. 60<br />
                        Teor de Umidade (%): Máx. 38<br />
                        Cloretos (%) (NaCl + KCl): 1,8 - 2,2<br />
                        Ponto de Gotejamento - Mettler (&#176;C): 44 - 48<br />
                        Sabor / odor: Amanteigado característico<br />
                        Cor: Amarelo
                    </span>
                    <br /><br />
                    <h4 class="text-clear">Vida Útil</h4>
                    <span class="text-clear">
                        MI - 06 meses / EXP - 270 dias<br />
                        A partir da data de fabricação, sob condições adequadas de
                        armazenagem. Após aberto, consumir em até 1 mês.
                    </span>
                    <br /><br />
                    <p class="text-clear">ADB/kp - 0813/0721<br />
                    Este produto atende a regulamentação aplicável na condição em que se apresenta. Informações detalhadas sobre o atendimento às
                    regulamentações, estão disponíveis, se requisitadas. De acordo com seu uso, outras regulamentações podem ser aplicáveis, cabendo
                    ao usuário a responsabilidade de identificá-las e atendê-las. A Seara Alimentos reserva-se ao direito de modificar as especificações do
                    produto.</p>
                ',
                'nutritionalInfo' => [
                    'title' => 'Quantidade por porção:',
                    'items' => [
                        [
                            'description' => 'Valor energético',
                            'value_10g' => '54 kcal = 227 kJ',
                            'percentage' => '3%'
                        ],
                        [
                            'description' => 'Carboidratos',
                            'value_10g' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Proteínas',
                            'value_10g' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Gorduras totais',
                            'value_10g' => '6,0g',
                            'percentage' => '11%'
                        ],
                        [
                            'description' => 'Gorduras saturadas',
                            'value_10g' => '1,9g',
                            'percentage' => '9%'
                        ],
                        [
                            'description' => 'Gorduras trans',
                            'value_10g' => '0g',
                            'percentage' => '**'
                        ],
                        [
                            'description' => 'Fibra alimentar',
                            'value_10g' => '0g',
                            'percentage' => '0%'
                        ],
                        [
                            'description' => 'Sódio',
                            'value_10g' => '65mg',
                            'percentage' => '3%'
                        ],
                    ],
                    'obs' => [
                        [
                            'description' => '<p style="font-size:0.8em" class="text-clear">
                                * % Valores Diários de Referência com base em uma dieta
                                de 2.000 kcal ou 8.400 kJ. Seus valores diários podem ser
                                maiores ou menores dependendo de suas necessidades
                                energéticas.
                            </p>'
                        ],
                        [
                            'description' => '<p style="font-size:0.8em" class="text-clear">** VD não estabelecido.</p>'
                        ],
                        [
                            'description' => '
                                <h4 class="text-clear">Embalagem</h4>
                                <p class="text-clear">
                                    - Pote plástico com tampa plástica, contendo 250g, 500g e 1kg acondicionados em caixas de papelão.<br />
                                    - Caixa de papelão contendo 12 unidades de 500g<br />
                                    - Caixa de papelão contendo 24 unidades de 250g<br />
                                    - Caixa de papelão contendo 12 unidades de 1kg
                                </p>
                            '
                        ],
                        [
                            'description' => '
                                <h4 class="text-clear">Conservação e Estocagem</h4>
                                <p class="text-clear">
                                    Manter resfriado entre 5&#176;C e 16&#176;C.<br />
                                    Estocar e transportar longe de produtos tóxicos ou que
                                    exalem odores fortes.
                                    <br /><br />
                                    Empilhamento máximo:
                                    <br />
                                    500g - 10 caixas<br />
                                    250g - 10 caixas<br />
                                    1kg - 10 caixas
                                </p>
                            '
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
                'ingredients' => '', // same as 250g
                'nutritionalInfo' => [], // same as 250g
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
                'ingredients' => '', // same as 250g
                'nutritionalInfo' => [], // same as 250g
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
                'ingredients' => 'Óleos vegetais líquidos e interesterificados (contém
                    óleo de soja*), água , sal, emulsificantes: mono e
                    diglicerídeos de ácidos graxos, ésteres de poliglicerol de
                    ácidos graxos e lecitina de soja*, aromatizantes,
                    conservador benzoato de sódio, corante natural de
                    urucum e cúrcuma, antioxidantes: EDTA cálcio
                    dissódico, BHT e ácido cítrico e acidulante ácido
                    láctico. *(geneticamente modificado a partir de
                    Streptomyces viridochromogenes e/ou Agrobacterium
                    tumefaciens e/ou Bacillus thuringiensis).
                    <br />
                    <strong>ALÉRGICOS: CONTÉM DERIVADOS DE SOJA. PODE CONTER LEITE. NÃO CONTÉM  GLÚTEN.</strong>
                    <br />
                    <h4 class="text-clear">Aplicação</h4>
                    <span class="text-clear">Indicada para refogados, recheios, bolos, massas cozidas (coxinhas e rissoles), petit four e biscoitos.</span>
                    <br /><br />
                    <h4 class="text-clear">Especificações</h4>
                    <span class="text-clear">
                        Teor de Gorduras (%): Mín. 60<br />
                        Teor de Umidade (%): Máx. 38,5<br />
                        Cloretos (%) (NaCl): 1,55 - 1,75<br />
                        Sabor / odor: Amanteigado característico<br />
                        Cor: Amarelo
                    </span>
                    <br /><br />
                    <h4 class="text-clear">Vida Útil</h4>
                    <span class="text-clear">
                        270 dias (09 meses)
                        <br />
                        A partir da data de fabricação, sob condições adequadas de
                        armazenagem. Após aberto, consumir em até 1 mês.
                    </span>
                    <br /><br />
                    <p class="text-clear">KP/kp - 0922/0823<br />
                    Este produto atende a regulamentação aplicável na condição em que se apresenta. Informações detalhadas sobre o atendimento às
                    regulamentações, estão disponíveis, se requisitadas. De acordo com seu uso, outras regulamentações podem ser aplicáveis, cabendo
                    ao usuário a responsabilidade de identificá-las e atendê-las. A Seara Alimentos reserva-se ao direito de modificar as especificações do
                    produto.</p>
                    ',
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
                            'description' => 'Fibras Alimentares',
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
                            'description' => '<p style="font-size:0.8em" class="text-clear">* Percentual de valores diários fornecidos pela porção.</p>'
                        ],
                        [
                            'description' => '
                                <h4 class="text-clear">Embalagem</h4>
                                <p class="text-clear">Balde plástico com tampa contendo 3 kg
                                acondicionados em caixas de papelão (6 baldes cada
                                caixa).</p>
                            '
                        ],
                        [
                            'description' => '
                                <h4 class="text-clear">Conservação e Estocagem</h4>
                                <p class="text-clear">Estocar e transportar longe de produtos tóxicos ou que
                                exalem odores fortes.</p>
                                <p class="text-clear">Manter em local seco e fresco (máx. 30oC).
                                Após aberto, conservar sob refrigeração entre 5°C a
                                16°C, por no máximo 30 dias, dentro do prazo de
                                validade.</p>
                                <p class="text-clear">Manter a embalagem bem fechada. Manusear sempre
                                com utensílios limpos.</p>
                                <p class="text-clear">Empilhamento máximo: Balde 3 kg: 10 caixas</p>
                            '
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
                            'description' => '<p style="font-size:0.8em" class="text-clear">Referência para Valores Diários:</p>'
                        ],
                        [
                            'description' => '<p style="font-size:0.8em" class="text-clear">* Percentual de valores diários fornecidos pela porção.</p>'
                        ],
                        [
                            'description' => '<p style="font-size:0.8em" class="text-clear">Informação Complementar Nutricional: 75% de gorduras.</p>'
                        ],
                        [
                            'description' => '<p style="font-size:0.8em" class="text-clear">Tabela Nutricional - RDC 429: Conforme</p>'
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
                'ingredients' => '
                    Gordura de palma e antioxidantes BHT e ácido cítrico.
                    <br />
                    <strong>ALÉRGICOS: PODE CONTER SOJA. NÃO CONTÉM GLÚTEN.</strong>
                    <h4 class="text-clear">Aplicação</h4>
                    <span class="text-clear">Indicada para o preparo de sorvetes, coberturas, recheios, tortas, biscoitos, pães e fritura em geral.</span>
                    <br /><br />
                    <h4 class="text-clear">Especificações</h4>
                    <span class="text-clear">
                        Índice de Acidez (mg KOH/g): Máx. 0,20<br />
                        Índice de Peróxido (meq/kg): Máx. 0,5<br />
                        Cor Vermelho - (Lovibond 5 1/4”): Máx. 4,0<br />
                        Ponto de Gotejamento Mettler (°C):35 - 41<br />
                        SFC (%) 10°C: 45 - 55<br />
                        &emsp;&emsp;&emsp;&emsp;33,3°C: 5 - 9<br />
                        &emsp;&emsp;&emsp;&emsp;37,8°C: Máx. 5<br />
                        Sabor / odor (escala 1 - 10): Mín. 8 - Suave<br />
                        Aspecto a 45°C (escala 1 - 5): Mín. 5 - Sem impurezas
                    </span>
                    <br /><br />
                    <h4 class="text-clear">Valores Típicos</h4>
                    <span class="text-clear">
                        Ácidos Graxos Trans (%): 0 - 1
                    </span>
                    <br /><br />
                    <h4 class="text-clear">Embalagem</h4>
                    <span class="text-clear">
                        Saco de filme plástico de 500g em caixa de papelão de 12kg (24x500g).
                    </span>
                    <br /><br />
                    <p class="text-clear">KP/vt 0521/0624<br />
                    Este produto atende a regulamentação aplicável na condição em que se apresenta. Informações detalhadas sobre o atendimento às
                    regulamentações, estão disponíveis, se requisitadas. De acordo com seu uso, outras regulamentações podem ser aplicáveis, cabendo ao
                    usuário a responsabilidade de identificá-las e atendê-las. A Seara Alimentos reserva-se ao direito de modificar as especificações do
                    produto.</p>
                ',
                'nutritionalInfo' => [
                    'title' => 'Quantidade por porção:',
                    'hide_100g' => true,
                    'items' => [
                        [
                            'description' => 'Valor energético (kcal)',
                            'value_10g' => '90',
                            'value_100g' => '900',
                            'percentage' => '5%'
                        ],
                        [
                            'description' => 'Carboidratos (g)',
                            'value_10g' => '0',
                            'value_100g' => '0',
                            'percentage' => '0'
                        ],
                        [
                            'description' => 'Açúcares totais (g)',
                            'value_10g' => '0',
                            'value_100g' => '0',
                            'percentage' => ''
                        ],
                        [
                            'description' => 'Açúcares adicionados (g)',
                            'value_10g' => '0',
                            'value_100g' => '0',
                            'percentage' => '0'
                        ],
                        [
                            'description' => 'Proteínas (g)',
                            'value_10g' => '0',
                            'value_100g' => '0',
                            'percentage' => '0'
                        ],
                        [
                            'description' => 'Gorduras totais (g)',
                            'value_10g' => '10',
                            'value_100g' => '100',
                            'percentage' => '15%'
                        ],
                        [
                            'description' => 'Gorduras saturadas (g)',
                            'value_10g' => '5,1',
                            'value_100g' => '51',
                            'percentage' => '26%'
                        ],
                        [
                            'description' => 'Gorduras trans (g)',
                            'value_10g' => '0,1',
                            'value_100g' => '0,6',
                            'percentage' => '5%'
                        ],
                        [
                            'description' => 'Fibras alimentares (g)',
                            'value_10g' => '0',
                            'value_100g' => '0',
                            'percentage' => '0'
                        ],
                        [
                            'description' => 'Sódio (mg)',
                            'value_10g' => '0',
                            'value_100g' => '0',
                            'percentage' => '0'
                        ],
                    ],
                    'obs' => [
                        [
                            'description' => '<p style="font-size:0.8em" class="text-clear">* Percentual de valores diários fornecidos pela porção.</p>'
                        ],
                        [
                            'description' => '
                                <h4 class="text-clear">Conservação e Estocagem</h4>
                                <p class="text-clear">
                                    Manter em local seco e fresco (máx 30°C).<br />
                                    Após aberto, conservar sob refrigeração entre 5°C a
                                    16°C, por no máximo 30 dias, dentro do prazo de
                                    validade.
                                </p>
                            '
                        ],
                        [
                            'description' => '
                                <h4 class="text-clear">Transporte</h4>
                                <p class="text-clear">Caminhão refrigerado.</p>
                            '
                        ],
                        [
                            'description' => '
                                <h4 class="text-clear">Vida Útil</h4>
                                <p class="text-clear">270 dias a partir da data de fabricação, sob condições adequadas de armazenagem.</p>
                            '
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
                    'hide_100g' => true,
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
                            'description' => '<p style="font-size:0.8em" class="text-clear">* %Valores Diários de referência com base em uma dieta de 2.000kcal ou 8.400kj. Seus valores diários podem ser maiores ou menores dependendo de suas necessidades energéticas.</p>'
                        ],
                        [
                            'description' => '<p style="font-size:0.8em" class="text-clear">** VD não estabelecido.</p>'
                        ]
                    ]
                ],
            ],
        ];

        // get item with family = margarina-tradicional and familySize = 250g
        $margarinaTrad250 = array_filter($arrProducts, function($item) {
            return $item['family'] == 'margarina-tradicional' && $item['familySize'] == '250g';
        });

        // set ingredients and nutritionalInfo from items with family = margarina-tradicional and familySize = 500g and 1kg equals to 250g
        foreach ($arrProducts as &$prod) {
            if ($prod['family'] == 'margarina-tradicional' && in_array($prod['familySize'], ['500g', '1kg'])) {
                $prod['ingredients'] = $margarinaTrad250[0]['ingredients'];
                $prod['nutritionalInfo'] = $margarinaTrad250[0]['nutritionalInfo'];
            }
        }

        return $arrProducts;
    }
}