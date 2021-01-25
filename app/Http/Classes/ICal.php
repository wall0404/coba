<?php


namespace App\Http\Classes;



use App\Http\Controllers\ICALController;
use Illuminate\Http\Response;

class ICal
{
    protected static $CLASS = "PUBLIC";
    protected static $PRODID = "Bookings@Coba";
    protected static $METHOD = "PUBLISH";

    protected static $lineBreak = "\r\n";

    private $events = [];

    public function addEvent($id, $start, $end, $location, $summary, $updated_at) {
        $this->events[] = (object) [
            "id" => $id,
            "start" => $start,
            "end" => $end,
            "location" => $location,
            "summary" => $summary,
            "stamp" => $updated_at
        ];
    }
    public function toString() {
        $str = "BEGIN:VCALENDAR" . ICal::$lineBreak .
            "VERSION:2.0" . ICal::$lineBreak .
            "PRODID:" . ICAL::$PRODID . ICal::$lineBreak .
            "METHOD:" . ICAL::$METHOD . ICal::$lineBreak;

        foreach ($this->events as $event) {
            $str .= "BEGIN:VEVENT" . ICal::$lineBreak .
                "UID:" . "COBA".$event->id . ICal::$lineBreak .
                "LOCATION:" . $event->location . ICal::$lineBreak .
                "SUMMARY:" . $event->summary . ICal::$lineBreak .
                "CLASS:" . ICAL::$CLASS . ICal::$lineBreak .
                "DTSTART;TZID=" . config('app.timezone') . ":" . $event->start . ICal::$lineBreak .
                "DTEND;TZID=" . config('app.timezone') . ":" . $event->end . ICal::$lineBreak .
                "DTSTAMP:" . $event->stamp . ICal::$lineBreak .
                "END:VEVENT" . ICal::$lineBreak;
        }

        $str .= "END:VCALENDAR";

        return $str;

    }

    public function publish() {
        $str = $this->toString();

        $headers = [
            'Content-type'        => 'text/calendar',
            'Content-Disposition' => 'attachment; filename="coba.ical"',
        ];

        return \Illuminate\Support\Facades\Response::make($str, 200, $headers);
    }
}
