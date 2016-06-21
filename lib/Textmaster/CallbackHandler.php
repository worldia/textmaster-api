<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Textmaster\Event\CallbackEvent;
use Textmaster\Exception\InvalidArgumentException;

class CallbackHandler
{
    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $classes = [
        'document' => 'Textmaster\Model\Document',
        'project' => 'Textmaster\Model\Project',
    ];

    /**
     * Constructor.
     *
     * @param EventDispatcherInterface $dispatcher
     * @param Client                   $client
     * @param array                    $classes
     */
    public function __construct(EventDispatcherInterface $dispatcher, Client $client, array $classes = [])
    {
        $this->dispatcher = $dispatcher;
        $this->client = $client;
        $this->classes = array_merge($this->classes, $classes);
    }

    /**
     * Attach an event listener.
     *
     * @param string   $eventName @see Events for name constants
     * @param callable $listener  The listener
     * @param int      $priority  The higher this value, the earlier an event
     *                            listener will be triggered in the chain (defaults to 0)
     */
    public function addListener($eventName, $listener, $priority = 0)
    {
        $this->dispatcher->addListener($eventName, $listener, $priority);
    }

    /**
     * Attach an event subscriber.
     *
     * @param EventSubscriberInterface $subscriber The subscriber
     */
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->dispatcher->addSubscriber($subscriber);
    }

    /**
     * Raise the appropriate event @see Events.
     *
     * @param Request|null $request
     */
    public function handleWebHook(Request $request = null)
    {
        if (null === $request) {
            $request = Request::createFromGlobals();
        }

        $data = json_decode($request->getContent(), true);
        $event = $this->getEvent($data);

        $this->dispatcher->dispatch($event->getName(), $event);
    }

    /**
     * Get event name and object from request data.
     *
     * @param array $data
     *
     * @return CallbackEvent
     */
    private function getEvent(array $data)
    {
        if (array_key_exists('name', $data)) {
            $type = 'project';
        } elseif (array_key_exists('original_content', $data)) {
            $type = 'document';
        }

        if (!isset($type)) {
            throw new InvalidArgumentException(sprintf('Couldnt determine callback type from "%s".', serialize($data)));
        }

        $name = sprintf('textmaster.%s.%s', $type, $data['status']);
        $resource = new $this->classes[$type]($this->client, $data);

        return new CallbackEvent($name, $resource, $data);
    }
}
