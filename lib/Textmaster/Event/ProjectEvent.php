<?php

namespace Textmaster\Event;

use Symfony\Component\EventDispatcher\GenericEvent;
use Textmaster\Model\ProjectInterface;

class ProjectEvent extends GenericEvent
{
    /**
     * @return ProjectInterface
     */
    public function getProject()
    {
        return $this->subject;
    }
}
