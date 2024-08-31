<?php

namespace App\Interfaces\Product\Items;

use App\Interfaces\Product\ProductAbstract;
use App\Interfaces\Product\NutritionalInfo;

abstract class MargarinaTradicional extends ProductAbstract
{
    public const FAMILY = 'margarina-tradicional';
    public const SLUG = '';

    public function getFamilySize(): ?string
    {
        return null;
    }

    public function getTitle(): ?string
    {
        return null;
    }

    public function getTitleShort(): ?string
    {
        return null;
    }

    final public function getDescription(): ?string
    {
        return 'Seja no forno, preparando seu bolo preferido ou no toque final daquele cuscuz quentinho, a margarina Primor é a escolha certa para quem cozinha com amor. Tenha sempre em casa!';
    }

    public function getImageUrl(): ?string
    {
        return null;
    }

    public function getIconChoices(): ?array
    {
        return null;
    }

    final public function getIngredients(): ?string
    {
        return <<<HTML
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
        HTML;
    }

    final public function getNutritionalInfo(): ?NutritionalInfo
    {
        $NutritionalInfo = new NutritionalInfo();
        $NutritionalInfo->setTitle('Porção de 10g (1 colher de sopa)<br />Quantidade por porção:');
        $NutritionalInfo->hide100g();

        $NutritionalInfo->addItem('Valor energético', '3%', '54 kcal = 227 kJ');
        $NutritionalInfo->addItem('Carboidratos', '0%', '0g');
        $NutritionalInfo->addItem('Proteínas', '0%', '0g');
        $NutritionalInfo->addItem('Gorduras totais', '11%', '6g');
        $NutritionalInfo->addItem('&emsp;Gorduras saturadas', '9%', '1,9g');
        $NutritionalInfo->addItem('&emsp;Gorduras trans', '**', '0g');
        $NutritionalInfo->addItem('Fibra alimentar', '0%', '0g');
        $NutritionalInfo->addItem('Sódio', '3%', '65mg');

        $NutritionalInfo->addObs(<<<HTML
            <p style="font-size:0.8em" class="text-clear">
                * % Valores Diários de Referência com base em uma dieta
                de 2.000 kcal ou 8.400 kJ. Seus valores diários podem ser
                maiores ou menores dependendo de suas necessidades
                energéticas.
            </p>
        HTML);
        $NutritionalInfo->addObs(<<<HTML
            <p style="font-size:0.8em" class="text-clear">** VD não estabelecido.</p>
        HTML);
        $NutritionalInfo->addObs(<<<HTML
            <h4 class="text-clear">Embalagem</h4>
            <p class="text-clear">
                - Pote plástico com tampa plástica, contendo 250g, 500g e 1kg acondicionados em caixas de papelão.<br />
                - Caixa de papelão contendo 12 unidades de 500g<br />
                - Caixa de papelão contendo 24 unidades de 250g<br />
                - Caixa de papelão contendo 12 unidades de 1kg
            </p>
        HTML);
        $NutritionalInfo->addObs(<<<HTML
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
        HTML);

        return $NutritionalInfo;
    }
}