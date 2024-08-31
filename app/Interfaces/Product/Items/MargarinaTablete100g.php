<?php

namespace App\Interfaces\Product\Items;

use App\Interfaces\Product\ProductAbstract;
use App\Interfaces\Product\NutritionalInfo;

class MargarinaTablete100g extends ProductAbstract
{
    public const FAMILY = 'margarina-tablete';
    public const FAMILY_ORDER = 1;
    public const SLUG = 'margarina-primor-forno-fogão-pacote-100g';

    public function getFamilySize(): ?string
    {
        return '100g';
    }

    public function getTitle(): ?string
    {
        return 'Margarina Primor Forno e Fogão Pacote 4 Unidades 100g';
    }

    public function getTitleShort(): ?string
    {
        return 'Margarina Tablete 4 Unidades 100g';
    }

    final public function getDescription(): ?string
    {
        return 'Seja no forno, preparando seu bolo preferido ou no toque final daquele cuscuz quentinho, a margarina Primor é a escolha certa para quem cozinha com amor. Tenha sempre em casa!';
    }

    public function getImageUrl(): ?string
    {
        return null;
    }

    final public function getIngredients(): ?string
    {
        return <<<HTML
            Óleos vegetais líquidos e totalmente hidrogenados (contém óleo de soja), água, sal, emulsificantes: mono e diglicerídeos de ácidos graxos e
            lecitina de soja, conservador benzoato de sódio, aromatizantes, antioxidantes: EDTA cálcio dissódico, BHT e ácido cítrico,
            acidulante ácido láctico e corante idêntico ao natural betacaroteno. NÃO CONTÉM GLÚTEN. ALÉRGICOS: CONTÉM DERIVADOS DE SOJA. PODE CONTER LEITE.
        HTML;
    }

    final public function getNutritionalInfo(): ?NutritionalInfo
    {
        $NutritionalInfo = new NutritionalInfo();
        $NutritionalInfo->setTitle('Quantidade por porção:');

        $NutritionalInfo->addItem('Valor energético', '3%', '63 kcal', 'Não informado');
        $NutritionalInfo->addItem('Valor energético', '', '265 kJ', 'Não informado');

        $NutritionalInfo->addObs(<<<HTML
            <p style="font-size:0.8em" class="text-clear">
                * %Valores Diários de referência com base em uma dieta de 2.000kcal ou 8.400kj.
                Seus valores diários podem ser maiores ou menores dependendo de suas necessidades energéticas.
            </p>
        HTML);
        $NutritionalInfo->addObs(<<<HTML
            <p style="font-size:0.8em" class="text-clear">** VD não estabelecido.</p>
        HTML);

        return $NutritionalInfo;
    }
}