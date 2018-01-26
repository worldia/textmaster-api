<?php
$header = <<<EOF
This file is part of the Textmaster Api v1 client package.

(c) Christian Daguerre <christian@daguer.re>

This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOF;

// PhpCsFixer\CS\Fixer\Contrib\HeaderCommentFixer::setHeader($header);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
        'header_comment',
        'ordered_use',
        'php_unit_construct',
        'php_unit_strict',
        'strict',
        'strict_param',
    ])
    ->setFinder($finder)
;
