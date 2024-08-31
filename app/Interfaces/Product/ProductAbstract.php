<?php

namespace App\Interfaces\Product;

abstract class ProductAbstract implements ProductInterface
{
    public const FAMILY = '';
    public const FAMILY_ORDER = 0;
    public const SLUG = '';
    
    protected function getIconAssarUrl(): string
    {
        return url('/') . '/templates/primor-v1/images/product-icon-assar.png';
    }

    protected function getIconCozinharUrl(): string
    {
        return url('/') . '/templates/primor-v1/images/product-icon-cozinhar.png';
    }

    protected function getIconServirUrl(): string
    {
        return url('/') . '/templates/primor-v1/images/product-icon-servir.png';
    }

    public function getFamily(): ?string
    {
        return $this::FAMILY;
    }

    public function getUrl(): ?string
    {
        return route('site.produtosSingle', ['slug' => $this::SLUG]);
    }

    /** @return App\Interfaces\Product\ProductAbstract[] */
    public function getFamilyProdItems(): ?array
    {
        $arrRet = [];
        $products = \App\Helpers\SysUtils::getProducts();
        foreach ($products as $product) {
            if ($product::FAMILY === $this::FAMILY) {
                $arrRet[] = $product;
            }
        }

        // ordem them by the class property $_family
        usort($arrRet, function ($a, $b) {
            return strcmp($a::FAMILY_ORDER, $b::FAMILY_ORDER);
        });

        return $arrRet;
    }

    public function getIconChoices(): ?array
    {
        return [
            $this->getIconAssarUrl(),
            $this->getIconCozinharUrl(),
            $this->getIconServirUrl(),
        ];
    }
}