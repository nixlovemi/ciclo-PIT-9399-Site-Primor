<?php

namespace App\Interfaces\Product\Items;

class MargarinaTradicional250g extends MargarinaTradicional
{
    public const FAMILY_ORDER = 1;
    public const SLUG = 'margarina-original-sal-primor-pote-250g';

    public function getFamilySize(): ?string
    {
        return '250g';
    }

    public function getTitle(): ?string
    {
        return 'Margarina Original com Sal Primor Pote 250g';
    }

    public function getTitleShort(): ?string
    {
        return 'Margarina Primor 250g';
    }

    public function getImageUrl(): ?string
    {
        return url('/') . '/templates/primor-v1/images/product-margarina-original-sal-primor-pote-250g.png';
    }
}