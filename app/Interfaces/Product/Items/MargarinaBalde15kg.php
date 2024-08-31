<?php

namespace App\Interfaces\Product\Items;

use App\Interfaces\Product\ProductAbstract;
use App\Interfaces\Product\NutritionalInfo;

class MargarinaBalde15kg extends ProductAbstract
{
    public const FAMILY = 'margarina-balde';
    public const FAMILY_ORDER = 2;
    public const SLUG = 'margarina-amanteigada-sal-primor-balde-15kg';

    public function getFamilySize(): ?string
    {
        return '15kg';
    }

    public function getTitle(): ?string
    {
        return 'Margarina Amanteigada com Sal Primor Balde 15kg';
    }

    public function getTitleShort(): ?string
    {
        return 'Margarina Balde 15kg';
    }

    final public function getDescription(): ?string
    {
        return 'Seja no forno, preparando seu bolo preferido ou no toque final daquele cuscuz quentinho, a margarina Primor é a escolha certa para quem cozinha com amor. Tenha sempre em casa!';
    }

    public function getImageUrl(): ?string
    {
        return url('/') . '/templates/primor-v1/images/margarina-amanteigada-sal-primor-balde-15kg.png';
    }

    final public function getIngredients(): ?string
    {
        return <<<HTML
            Óleos vegetais líquidos e interesterificados (contém óleo de soja*), água, sal, emulsificantes lecitina de
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
            Contém Soja - Derivados: Contém
        HTML;
    }

    final public function getNutritionalInfo(): ?NutritionalInfo
    {
        $NutritionalInfo = new NutritionalInfo();
        $NutritionalInfo->setTitle('Quantidade por porção:');

        $NutritionalInfo->addItem('Valor energético', '3%', '68 kcal', '675 kcal');
        $NutritionalInfo->addItem('Carboidratos', '0%', '0g', '0g');
        $NutritionalInfo->addItem('Açucares Totais', '0%', '0g', '0g');
        $NutritionalInfo->addItem('Açucares Adicionados', '0%', '0g', '0g');
        $NutritionalInfo->addItem('Proteínas', '0%', '0g', '0g');
        $NutritionalInfo->addItem('Gorduras Totais', '12%', '7,5g', '75g');
        $NutritionalInfo->addItem('Gorduras saturadas', '20%', '4g', '40g');
        $NutritionalInfo->addItem('Gorduras trans', '5%', '0,1g', '0,7g');
        $NutritionalInfo->addItem('Fibra Alimentar', '0%', '0g', '0g');
        $NutritionalInfo->addItem('Sódio', '3%', '68g', '680g');

        $NutritionalInfo->addObs(<<<HTML
            <p style="font-size:0.8em" class="text-clear">Referência para Valores Diários:</p>
        HTML);
        $NutritionalInfo->addObs(<<<HTML
            <p style="font-size:0.8em" class="text-clear">* Percentual de valores diários fornecidos pela porção.</p>
        HTML);
        $NutritionalInfo->addObs(<<<HTML
            <p style="font-size:0.8em" class="text-clear">Informação Complementar Nutricional: 75% de gorduras.</p>
        HTML);
        $NutritionalInfo->addObs(<<<HTML
            <p style="font-size:0.8em" class="text-clear">Tabela Nutricional - RDC 429: Conforme</p>
        HTML);

        return $NutritionalInfo;
    }
}