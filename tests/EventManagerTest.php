<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace tests;

use PHPUnit\Framework\TestCase;
use felicity\events\EventManager;
use felicity\events\models\EventModel;

/**
 * Class EventManagerTest
 */
class EventManagerTest extends TestCase
{
    /**
     * Tests the event manager
     */
    public function testEventManger()
    {
        $testFunction = function (EventModel $model) {
            $model->eventData[] = 'testFunctionHasRun';
        };

        $eventModel = new EventModel();

        EventManager::call('testEvent', $eventModel);
        self::assertEmpty($eventModel->eventData);

        EventManager::on('testEvent', $testFunction);
        EventManager::on('testEvent', [$this, 'customMethod']);
        EventManager::call('testEvent', $eventModel);
        self::assertEquals(
            [
                'testFunctionHasRun',
                'testMethodHasRun',
            ],
            $eventModel->eventData
        );

        $newTestFunction = function (EventModel $model) {
            $model->stopEventProcessing = true;
            $model->eventData[] = 'newTestFunctionRun';
        };

        EventManager::on('testEvent2', $newTestFunction);
        EventManager::on('testEvent2', $testFunction);
        EventManager::on('testEvent2', [$this, 'customMethod']);
        $eventModel = new EventModel();
        EventManager::call('testEvent2', $eventModel);
        self::assertEquals(
            [
                'newTestFunctionRun',
            ],
            $eventModel->eventData
        );
    }

    /**
     * A test method
     * @param EventModel $model
     */
    public function customMethod(EventModel $model)
    {
        $model->eventData[] = 'testMethodHasRun';
    }
}
