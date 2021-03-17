<?php
set_include_path('classes');
spl_autoload_register();

$task = new Task(111, 222);

assert($task->getNextStatus('cancel') === Task::STATUS_CANCELED, 'cancel action');
assert($task->getNextStatus('performed') === Task::STATUS_DONE, 'performed action');
assert($task->getNextStatus('respond') === Task::STATUS_WORK, 'respond action');
assert($task->getNextStatus('refuse') === Task::STATUS_FAILED, 'refuse action');

assert($task->getAvailableAction('new', 111) === Task::ACTION_RESPOND, 'progress status');
assert($task->getAvailableAction('work', 111) === Task::ACTION_REFUSE, 'refuse status');
assert($task->getAvailableAction('new', 222) === Task::ACTION_CANCEL, 'respond status');
assert($task->getAvailableAction('work', 222) === Task::ACTION_PERFORMED, 'performed status');
