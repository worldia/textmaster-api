<?php

namespace Textmaster\Event;

use Symfony\Component\EventDispatcher\GenericEvent;
use Textmaster\Model\DocumentInterface;

class DocumentEvent extends GenericEvent
{
    /**
     * @return DocumentInterface
     */
    public function getDocument()
    {
        return $this->subject;
    }
}
