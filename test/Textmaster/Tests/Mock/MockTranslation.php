<?php

namespace Textmaster\Tests\Mock;

use Sylius\Component\Resource\Model\AbstractTranslation;
use Sylius\Component\Resource\Model\TranslationInterface;

class MockTranslation extends AbstractTranslation implements TranslationInterface
{
    protected $name;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}
