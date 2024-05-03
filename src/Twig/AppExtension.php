<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('start_limit', [$this, 'firstNWord']),
        ];
    }

    public function firstNWord(String $sentence, int $rankWord)
    {
        $str = trim(strip_tags($sentence));

    return implode(' ', array_slice(explode(' ', $str), 0, $rankWord)) .  " ...";

    }

    public function formatPrice($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$'.$price;

        return $price;
    }
}