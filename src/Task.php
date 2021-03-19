<?php

namespace TaskForse;

class Task
{

    // Доступные статусы

    const STATUS_NEW = 'new'; // новая
    const STATUS_CANCELED = 'canceled'; // отменена
    const STATUS_WORK = 'work'; // в работе
    const STATUS_DONE = 'done'; // выполнена
    const STATUS_FAILED = 'failed'; // провалена

    // Доступные действия

    const ACTION_CANCEL = 'cancel'; // отменить
    const ACTION_RESPOND = 'respond'; // откликнутся
    const ACTION_REFUSE = 'refuse'; // отказаться
    const ACTION_PERFORMED = 'performed'; // выполнена

    public string $currentStatus = self::STATUS_NEW;

    private int $idPerformer;
    private int $idCustomer;

    public function getIdPerformer()
    {
        return $this->idPerformer;
    }

    public function getIdCustomer()
    {
        return $this->idCustomer;
    }

    public function __construct(int $idPerformer, int $idCustomer)
    {
        $this->idPerformer = $idPerformer;
        $this->idCustomer = $idCustomer;
    }

    private $mapStatus = [
        self::STATUS_NEW => 'Новое',
        self::STATUS_CANCELED => 'Отменено',
        self::STATUS_WORK => 'В работе',
        self::STATUS_DONE => 'Выполнено',
        self::STATUS_FAILED => 'Провалено',
    ];

    private $mapAction = [
        self::ACTION_CANCEL => 'Отменить',
        self::ACTION_PERFORMED => 'Выполнено',
        self::ACTION_RESPOND => 'Откликнуться',
        self::ACTION_REFUSE => 'Отказаться',
    ];

    public function getMapStatus()
    {
        return $this->mapStatus;
    }

    public function getMapAction($action)
    {
        return $this->mapAction[$action];
    }

    public function getNextStatus($action)
    {
        $statusesOfAction = [
            self::ACTION_CANCEL => self::STATUS_CANCELED,
            self::ACTION_PERFORMED => self::STATUS_DONE,
            self::ACTION_RESPOND => self::STATUS_WORK,
            self::ACTION_REFUSE => self::STATUS_FAILED,
        ];
        return $statusesOfAction[$action] ? $statusesOfAction[$action] : $this->currentStatus;
    }

    public function getAvailableAction($currentStatus, $id)
    {
        if ($id === self::getIdPerformer()) {
            switch ($currentStatus) {
                case self::STATUS_NEW:
                    return self::ACTION_RESPOND;
                case self::STATUS_WORK:
                    return self::ACTION_REFUSE;
            }
        } elseif ($id === self::getIdCustomer()) {
            switch ($currentStatus) {
                case self::STATUS_NEW:
                    return self::ACTION_CANCEL;
                case self::STATUS_WORK:
                    return self::ACTION_PERFORMED;
            }
        } else {
            return print('Действие или пользователь не определены');
        }
    }
}
