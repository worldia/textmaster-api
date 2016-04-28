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
use Textmaster\Exception\InvalidArgumentException;
use Textmaster\Model\Document;
use Textmaster\Model\Project;

class Handler
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
     * Constructor.
     *
     * @param EventDispatcherInterface $dispatcher
     * @param Client                   $client
     */
    public function __construct(EventDispatcherInterface $dispatcher, Client $client)
    {
        $this->dispatcher = $dispatcher;
        $this->client = $client;
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
     * @param Request $request
     */
    public function handleWebHook(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (false === $eventName = $this->guessEventName($data)) {
            return;
        }

        if (in_array($eventName, Events::getDocumentEvents(), true)) {
            $event = new Event\DocumentEvent(new Document($this->client, $data), $data);
        } elseif (in_array($eventName, Events::getProjectEvents(), true)) {
            $event = new Event\ProjectEvent(new Project($this->client, $data), $data);
        }

        if (!isset($event)) {
            throw new InvalidArgumentException(sprintf(
                'Unknown event "%s" occurred with following data: "%s".',
                $eventName,
                serialize($data)
            ));
        }

        $this->dispatcher->dispatch($eventName, $event);
    }

    /**
     * Guess event name from API result.
     *
     * @param array $data
     *
     * @return string
     */
    private function guessEventName(array $data)
    {
        if (array_key_exists('name', $data)) {
            return 'textmaster.project.'.$data['status'];
        } elseif (array_key_exists('original_content', $data)) {
            return 'textmaster.document.'.$data['status'];
        }

        return false;
    }
}
