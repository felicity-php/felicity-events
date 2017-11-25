<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace felicity\events\models;

use felicity\datamodel\Model;
use felicity\datamodel\services\datahandlers\BoolHandler;
use felicity\datamodel\services\datahandlers\ArrayHandler;

/**
 * Class EventModel
 */
class EventModel extends Model
{
    /** @var bool $performAction */
    public $performAction = true;

    /** @var $sender */
    public $sender;

    /** @var bool $stopEventProcessing */
    public $stopEventProcessing = false;

    /** @var array $params */
    public $params = [];

    /** @var mixed $eventData */
    public $eventData;

    /**
     * @inheritdoc
     */
    protected function defineHandlers(): array
    {
        return [
            'performAction' => [
                'class' => BoolHandler::class,
            ],
            'stopEventProcessing' => [
                'class' => BoolHandler::class,
            ],
            'params' => [
                'class' => ArrayHandler::class,
            ],
        ];
    }
}
