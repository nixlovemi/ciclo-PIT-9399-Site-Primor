<?php

namespace App\Interfaces\Product;

class NutritionalInfo
{
    private string $_title;
    private bool $_hide_100g = false;
    private $_items = [];
    private $_obs = [];

    public const ITEM_DESCRIPTION = 'description';
    public const ITEM_VALUE_10G = 'value_10g';
    public const ITEM_VALUE_100G = 'value_100g';
    public const ITEM_PERCENTAGE = 'percentage';

    public const OBS_DESCRIPTION = 'description';

    public function setTitle(string $title): void
    {
        $this->_title = $title;
    }

    public function getTitle(): string
    {
        return $this->_title;
    }

    public function hide100g(): void
    {
        $this->_hide_100g = true;
    }

    public function is100gHidden(): bool
    {
        return $this->_hide_100g;
    }

    public function addItem(
        string $description,
        string $percentage,
        string $value_10g,
        string $value_100g = null
    ): void {
        $this->_items[] = [
            self::ITEM_DESCRIPTION => $description,
            self::ITEM_PERCENTAGE => $percentage,
            self::ITEM_VALUE_10G => $value_10g,
            self::ITEM_VALUE_100G => $value_100g,
        ];
    }

    public function getItems(): array
    {
        return $this->_items;
    }

    public function addObs(string $description): void
    {
        $this->_obs[] = [
            self::OBS_DESCRIPTION => $description,
        ];
    }

    public function getObs(): array
    {
        return $this->_obs;
    }
}