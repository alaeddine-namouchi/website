<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class FilterExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('intro', [$this, 'introText']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('intro', [$this, 'firstNWord']),
        ];
    }
    public function firstNWord(String $sentence, int $rankWord, $end = " ...")
    {
        $str = trim(strip_tags($sentence));

    return implode(' ', array_slice(explode(' ', $str), 0, $rankWord)) .  $end ;

    }
    public function introText(String $sentence)
    {
        $rankWord = 20;
        $str = trim(strip_tags($sentence));

    return implode(' ', array_slice(explode(' ', $str), 0, $rankWord)) .  " ...";

    }
}