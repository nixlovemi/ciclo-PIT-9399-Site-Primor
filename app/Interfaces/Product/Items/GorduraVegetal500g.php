<?php

namespace App\Interfaces\Product\Items;

use App\Interfaces\Product\ProductAbstract;
use App\Interfaces\Product\NutritionalInfo;

class GorduraVegetal500g extends ProductAbstract
{
    public const FAMILY = 'gordura-vegetal';
    public const FAMILY_ORDER = 1;
    public const SLUG = 'gordura-vegetal-primor-pacote-500g';

    public function getFamilySize(): ?string
    {
        return '500g';
    }

    public function getTitle(): ?string
    {
        return 'Gordura Vegetal Primor Pacote 500g';
    }

    public function getTitleShort(): ?string
    {
        return 'Gordura Vegetal 500g';
    }

    final public function getDescription(): ?string
    {
        return 'Seja no forno, preparando seu bolo preferido ou no toque final daquele cuscuz quentinho, a margarina Primor é a escolha certa para quem cozinha com amor. Tenha sempre em casa!';
    }

    public function getImageUrl(): ?string
    {
        return url('/') . '/templates/primor-v1/images/gordura-vegetal-primor-pacote-500g.png';
    }

    final public function getIngredients(): ?string
    {
        return <<<HTML
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
        HTML;
    }

    final public function getNutritionalInfo(): ?NutritionalInfo
    {
        $NutritionalInfo = new NutritionalInfo();
        $NutritionalInfo->setTitle('Porção: 10g (1 colher de sopa)');

        $NutritionalInfo->addItem('Valor energético (kcal)', '5%', '90', '900');
        $NutritionalInfo->addItem('Carboidratos (g)', '0', '0', '0');
        $NutritionalInfo->addItem('Açúcares totais (g)', '', '0', '0');
        $NutritionalInfo->addItem('&emsp;Açúcares adicionados (g)', '0', '0', '0');
        $NutritionalInfo->addItem('Proteínas (g)', '0', '0', '0');
        $NutritionalInfo->addItem('Gorduras totais (g)', '15%', '10', '100');
        $NutritionalInfo->addItem('&emsp;Gorduras saturadas (g)', '26%', '5,1', '51');
        $NutritionalInfo->addItem('&emsp;Gorduras trans (g)', '5%', '0,1', '0,6');
        $NutritionalInfo->addItem('Fibras alimentares (g)', '0', '0', '0');
        $NutritionalInfo->addItem('Sódio (mg)', '0', '0', '0');

        $NutritionalInfo->addObs(<<<HTML
            <p style="font-size:0.8em" class="text-clear">* Percentual de valores diários fornecidos pela porção.</p>
        HTML);
        $NutritionalInfo->addObs(<<<HTML
            <h4 class="text-clear">Conservação e Estocagem</h4>
            <p class="text-clear">
                Manter em local seco e fresco (máx 30°C).<br />
                Após aberto, conservar sob refrigeração entre 5°C a
                16°C, por no máximo 30 dias, dentro do prazo de
                validade.
            </p>
        HTML);
        $NutritionalInfo->addObs(<<<HTML
            <h4 class="text-clear">Transporte</h4>
            <p class="text-clear">Caminhão refrigerado.</p>
        HTML);
        $NutritionalInfo->addObs(<<<HTML
            <h4 class="text-clear">Vida Útil</h4>
            <p class="text-clear">270 dias a partir da data de fabricação, sob condições adequadas de armazenagem.</p>
        HTML);

        return $NutritionalInfo;
    }
}