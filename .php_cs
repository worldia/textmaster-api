<?php

$finder = Symfony\CS\Finder::create()
    ->exclude('somedir')
    ->in(__DIR__)
;

return Symfony\CS\Config::create()
    ->fixers(array('strict_param', 'short_array_syntax'))
    ->finder($finder)
;