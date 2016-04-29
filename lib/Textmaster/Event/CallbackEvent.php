<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Event;

use Symfony\Component\EventDispatcher\GenericEvent;

class CallbackEvent extends GenericEvent
{
    private $eventName;

    public function __construct($eventName, $subject, $data)
    {
        parent::__construct($subject, $data);

        $this->eventName = $eventName;
    }

    public function getName()
    {
        return $this->eventName;
    }
}
