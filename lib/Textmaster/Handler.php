<?php

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

        $eventName = $this->guessEventName($data);
        if (false === $eventName) {
            return;
        }

        switch ($eventName) {
            case Events::DOCUMENT_CANCELED:
            case Events::DOCUMENT_CHECK_PLAGIARISM:
            case Events::DOCUMENT_CHECK_QUALITY:
            case Events::DOCUMENT_CHECK_WORDS:
            case Events::DOCUMENT_COMPLETED:
            case Events::DOCUMENT_IN_CREATION:
            case Events::DOCUMENT_IN_PROGRESS:
            case Events::DOCUMENT_IN_REVIEW:
            case Events::DOCUMENT_INCOMPLETE:
            case Events::DOCUMENT_PAUSED:
            case Events::DOCUMENT_WAITING_ASSIGNMENT:
            case Events::DOCUMENT_WORDS_COUNTED:
                $event = new Event\DocumentEvent(new Document($this->client, $data), $data);
                break;
            case Events::PROJECT_IN_PROGRESS:
                $event = new Event\ProjectEvent(new Project($this->client, $data), $data);
                break;
            default:
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
