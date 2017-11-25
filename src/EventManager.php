<?php

namespace felicity\events;

use ReflectionException;
use felicity\events\models\EventModel;

/**
 * Class EventManager
 */
class EventManager
{
    /** @var EventManager $instance */
    public static $instance;

    /** @var array $events */
    private $events = [];

    /**
     * Gets the config class instance
     * @return EventManager Singleton
     */
    public static function getInstance() : EventManager
    {
        if (! self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Registers an event listener
     * @param string $event
     * @param callable $handler
     * @return EventManager
     */
    public static function on(string $event, callable $handler) : EventManager
    {
        return self::getInstance()->onEvent($event, $handler);
    }

    /**
     * Registers an event listener
     * @param string $event
     * @param callable $handler
     * @return EventManager
     */
    public function onEvent(string $event, callable $handler) : EventManager
    {
        if (! isset($this->events[$event])) {
            $this->events[$event] = [];
        }

        $this->events[$event][] = $handler;

        return $this;
    }

    /**
     * Calls an event
     * @param string $event
     * @param EventModel $model
     * @return EventManager
     * @throws ReflectionException
     */
    public static function call(string $event, EventModel $model) : EventManager
    {
        return self::getInstance()->callEvent($event, $model);
    }

    /**
     * Calls an event
     * @param string $event
     * @param EventModel $model
     * @return EventManager
     * @throws ReflectionException
     */
    public function callEvent(string $event, EventModel $model) : EventManager
    {
        if (! isset($this->events[$event])) {
            return $this;
        }

        $eventArray = $this->events[$event] ?: [];

        foreach ($eventArray as $eventCallable) {
            $eventCallable($model);

            $model->castValues();

            if ($model->stopEventProcessing) {
                break;
            }
        }

        $model->castValues();

        return $this;
    }
}
