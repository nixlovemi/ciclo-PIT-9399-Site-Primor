<?php

namespace App\Interfaces\Product\Items;

use App\Interfaces\Product\ProductAbstract;
use App\Interfaces\Product\NutritionalInfo;

class MargarinaBalde3kg extends ProductAbstract
{
    public const FAMILY = 'margarina-balde';
    public const FAMILY_ORDER = 1;
    public const SLUG = 'margarina-amanteigada-sal-primor-balde-3kg';

    public function getFamilySize(): ?string
    {
        return '3kg';
    }

    public function getTitle(): ?string
    {
        return 'Margarina Amanteigada com Sal Primor Balde 3kg';
    }

    public function getTitleShort(): ?string
    {
        return 'Margarina Balde 3kg';
    }

    final public function getDescription(): ?string
    {
        return 'Seja no forno, preparando seu bolo preferido ou no toque final daquele cuscuz quentinho, a margarina Primor é a escolha certa para quem cozinha com amor. Tenha sempre em casa!';
    }

    public function getImageUrl(): ?string
    {
        return url('/') . '/templates/primor-v1/images/margarina-amanteigada-sal-primor-balde-3kg.png';
    }

    final public function getIngredients(): ?string
    {
        return <<<HTML
            Óleos vegetais líquidos e interesterificados (contém
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
        HTML;
    }

    final public function getNutritionalInfo(): ?NutritionalInfo
    {
        $NutritionalInfo = new NutritionalInfo();
        $NutritionalInfo->setTitle('Porções por embalagem: 300<br />Porção de 10g (1 colher de sopa)');

        $NutritionalInfo->addItem('Valor energético (kcal)', '3%', '54', '540');
        $NutritionalInfo->addItem('Carboidratos (g)', '0', '0', '0');
        $NutritionalInfo->addItem('Açúcares totais (g)', '', '0', '0');
        $NutritionalInfo->addItem('&emsp;Açúcares adicionados (g)', '0', '0', '0');
        $NutritionalInfo->addItem('Proteínas (g)', '0', '0', '0');
        $NutritionalInfo->addItem('Gorduras totais (g)', '9', '6', '60');
        $NutritionalInfo->addItem('&emsp;Gorduras saturadas (g)', '11', '2,2', '22');
        $NutritionalInfo->addItem('&emsp;Gorduras trans (g)', '5', '0,1', '0,5');
        $NutritionalInfo->addItem('Fibras alimentares (g)', '0', '0', '0');
        $NutritionalInfo->addItem('Sódio (mg)', '3', '60', '660');

        $NutritionalInfo->addObs(<<<HTML
            <p style="font-size:0.8em" class="text-clear">* Percentual de valores diários fornecidos pela porção.</p>
        HTML);
        $NutritionalInfo->addObs(<<<HTML
            <h4 class="text-clear">Embalagem</h4>
            <p class="text-clear">Balde plástico com tampa contendo 3 kg
            acondicionados em caixas de papelão (6 baldes cada
            caixa).</p>
        HTML);
        $NutritionalInfo->addObs(<<<HTML
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
        HTML);

        return $NutritionalInfo;
    }
}