<?php

namespace App\Dto;

class CalendarEventDataDto
{
    private $userId;
    private $calendarEventId;
    private $fullName;
    private $eventDateKey;
    private $eventType;

    const CALENDAR_EVENT_ID = 'id';
    const USER_ID = 'userId';
    const FULL_NAME = 'fullName';
    const EVENT_TYPE = 'eventType';

    /**
     * @return mixed
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     * @return CalendarEventDataDto
     */
    public function setUserId($userId): CalendarEventDataDto
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCalendarEventId(): int
    {
        return $this->calendarEventId;
    }

    /**
     * @param mixed $calendarEventId
     * @return CalendarEventDataDto
     */
    public function setCalendarEventId($calendarEventId): CalendarEventDataDto
    {
        $this->calendarEventId = $calendarEventId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @param mixed $fullName
     * @return CalendarEventDataDto
     */
    public function setFullName($fullName): CalendarEventDataDto
    {
        $this->fullName = $fullName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEventDateKey(): int
    {
        return $this->eventDateKey;
    }

    /**
     * @param mixed $eventDateKey
     * @return CalendarEventDataDto
     */
    public function setEventDateKey($eventDateKey): CalendarEventDataDto
    {
        $this->eventDateKey = $eventDateKey;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEventType(): string
    {
        return $this->eventType;
    }

    /**
     * @param mixed $eventType
     * @return CalendarEventDataDto
     */
    public function setEventType($eventType): CalendarEventDataDto
    {
        $this->eventType = $eventType;
        return $this;
    }

    /**
     * @return mixed
     */

    public function serializeRenderObject(): array
    {
        return [
            self::USER_ID => $this->userId,
            self::FULL_NAME => $this->fullName,
            date('d-m-Y',$this->eventDateKey) => "<div class='edit' id=$this->calendarEventId>".$this->eventType."</div>"
        ];
    }
}