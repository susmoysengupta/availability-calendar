<?php
namespace App\Http\Services;

class IcsEvent
{
    /**
     * @var mixed
     */
    public $uid,
    $organizer = 'MAILTO:info@availability.com',
    $dtStamp,
    $dtStart,
    $dtEnd,
    $description = '',
    $status = 'CONFIRMED',
    $summary = 'Event',
    $transp = 'TRANSPARENT';

    /**
     * @param $uid
     * @param $dtStamp
     * @param $dtStart
     * @param $dtEnd
     * @param $description
     */
    public function __construct($uid, $dtStamp, $dtStart, $dtEnd)
    {
        $this->uid = $uid;
        $this->dtStamp = $dtStamp;
        $this->dtStart = $dtStart;
        $this->dtEnd = $dtEnd;
    }

    /**
     * @return string
     */
    public function getIcsContent(): string
    {
        $event = "BEGIN:VEVENT\r\n";
        $event .= "UID:{$this->uid}\r\n";
        $event .= "ORGANIZER:{$this->organizer}\r\n";
        $event .= "DTSTAMP:{$this->dtStamp}\r\n";
        $event .= "DTSTART;VALUE=DATE:{$this->dtStart}\r\n";
        $event .= "DTEND;VALUE=DATE:{$this->dtEnd}\r\n";
        $event .= "CLASS:PUBLIC\r\n";
        $event .= ($this->description != '' ? "DESCRIPTION:{$this->description}\r\n" : '');
        $event .= "STATUS:{$this->status}\r\n";
        $event .= "SUMMARY:{$this->summary}\r\n";
        $event .= "TRANSP:{$this->transp}\r\n";
        $event .= "END:VEVENT\r\n";

        return $event;
    }

    /**
     * Set the event organizer.
     *
     * @param $organizer
     * @return $this
     */
    public function setOrganizer($organizer): self
    {
        $this->organizer = $organizer;

        return $this;
    }

    /**
     * Set the event description.
     *
     * @param $description
     * @return $this
     */
    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Set the event status.
     *
     * @param $status
     * @return $this
     */
    public function setStatus($status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Set the event summary.
     *
     * @param $summary
     * @return $this
     */
    public function setSummary($summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Set the event transparency.
     *
     * @param $transp
     * @return $this
     */
    public function setTransp($transp): self
    {
        $this->transp = $transp;

        return $this;
    }
}
