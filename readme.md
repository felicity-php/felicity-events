## About Felicity Events

Felicity events provides a way to register event listeners and trigger events

## Usage

Register events with the static `on` method, or if passing `EventManager::getInstance()` in via dependency injection, use the `onEvent` method.

```php
<?php

use felicity\events\EventManager;
use felicity\events\models\EventModel;

$demoFunction = function (EventModel $model) {
    // ...do stuff

    // Event may send params on $model->params

    // Pass data back on $model->eventData

    // Stop other listeners on this event from running by
    //      setting $model->stopEventProcessing = true

    // If the sender supports it, tell sender whether it should perform
    //      its action with $model->performAction = false
};

EventManager::on('myEvent', $demoFunction); // Supports any callable
```

Call events with the static `call` method, or if passing `EventManager::getInstance()` in via dependency injection, use the `callEvent` method.

```php
<?php

use felicity\events\EventManager;
use felicity\events\models\EventModel;

$eventModel = new EventModel([
    'sender' => $this,
    'params' => [
        'whatever' => 'you want to send',
    ],
]);

EventManager::call('myEvent', $eventModel);
```

## License

Copyright 2017 BuzzingPixel, LLC

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at [http://www.apache.org/licenses/LICENSE-2.0](http://www.apache.org/licenses/LICENSE-2.0).

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
