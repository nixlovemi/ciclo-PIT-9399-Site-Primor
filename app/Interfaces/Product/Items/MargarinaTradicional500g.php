<?php

namespace App\Interfaces\Product\Items;

class MargarinaTradicional500g extends MargarinaTradicional
{
    public const FAMILY_ORDER = 2;
    public const SLUG = 'margarina-original-sal-primor-pote-500g';

    public function getFamilySize(): ?string
    {
        return '500g';
    }

    public function getTitle(): ?string
    {
        return 'Margarina Original com Sal Primor Pote 500g';
    }

    public function getTitleShort(): ?string
    {
        return 'Margarina Primor 500g';
    }

    public function getImageUrl(): ?string
    {
        return url('/') . '/templates/primor-v1/images/product-margarina-original-sal-primor-pote-500g.png';
    }
}