<?php

namespace App\Interfaces\Product;

interface ProductInterface
{
    public function getFamily(): ?string;
    public function getFamilySize(): ?string;
    /** @return App\Interfaces\Product\ProductAbstract[] */
    public function getFamilyProdItems(): ?array;
    public function getTitle(): ?string;
    public function getTitleShort(): ?string;
    public function getUrl(): ?string;
    public function getDescription(): ?string;
    public function getImageUrl(): ?string;
    public function getIconChoices(): ?array;
    public function getIngredients(): ?string;
    public function getNutritionalInfo(): ?NutritionalInfo;
}