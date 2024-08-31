<?php

namespace App\Interfaces\Product\Items;

class MargarinaTradicional1kg extends MargarinaTradicional
{
    public const FAMILY_ORDER = 3;
    public const SLUG = 'margarina-original-sal-primor-pote-1kg';

    public function getFamilySize(): ?string
    {
        return '1kg';
    }

    public function getTitle(): ?string
    {
        return 'Margarina Original com Sal Primor Pote 1kg';
    }

    public function getTitleShort(): ?string
    {
        return 'Margarina Primor 1kg';
    }

    public function getImageUrl(): ?string
    {
        return url('/') . '/templates/primor-v1/images/product-margarina-original-sal-primor-pote-1kg.png';
    }
}