<?php
/**
 * Created by IntelliJ IDEA.
 * User: Lukas Wolfsteiner
 * Date: 04.10.2015
 * Time: 17:19
 */

date_default_timezone_set('Europe/Berlin');

include_once('lib/html_dom.php');

force_download();
$crawler = new crawler();
$crawler->echo_events();

class crawler
{
    public static $events_url = 'http://www.fosbos.net/service/termine/';
    public static $events_url_sec = 'http://www.fosbos.net/service/termine.html?tx_wmitnmveranstaltungen_pi2%5Bpointer%5D=1';

    public function echo_events()
    {

        // CSV header
        $header = "Subject,Start Date,End Date,All Day Event,Location,";

        // predefined variables
        $alldayevent = "true";
        $location = 'Kerschensteinerstraße 7, 92318 Neumarkt in der Oberpfalz';

        // undefined variables for events
        $subject = null;
        $startdate = null;
        $enddate = null;

        echo $header;
        $this->echo_break();

        foreach (crawler::get_events_dom()->find('ul.veranstaltungen_uebersicht li') as $event) {
            $this->handle_event($event);

            $this->echo_variable($alldayevent);
            $this->echo_variable($location);

            $this->echo_break();
        }

        foreach (crawler::get_events_dom_sec()->find('ul.veranstaltungen_uebersicht li') as $event) {
            $this->handle_event($event);

            $this->echo_variable($alldayevent);
            $this->echo_variable($location);

            $this->echo_break();
        }
    }

    public function echo_break()
    {
        echo "\n";
    }

    static function get_events_dom()
    {
        return file_get_html(crawler::$events_url);
    }

    public function handle_event($event)
    {
        $subject = $event->find('.veranstaltungen_name a', 0)->plaintext;
        $this->echo_variable($subject);

        $raw_date = $event->find('.veranstaltungen_info strong', 0)->plaintext;
        $startdate = $this->format_raw_date($raw_date);
        $this->echo_variable($startdate);

        $enddate = $this->format_raw_date($raw_date);
        $this->echo_variable($enddate);
    }

    public function echo_variable($var)
    {
        echo '"' . $var . '",';
    }

    public function format_raw_date($raw_date)
    {

        // get the first 10 chars of the extracted date string
        $raw_date = substr($raw_date, 0, 10);

        return date("m/d/Y", date_create_from_format("d.m.Y", $raw_date)->getTimestamp());
    }

    static function get_events_dom_sec()
    {
        return file_get_html(crawler::$events_url_sec);
    }
}

function force_download()
{
    header('Content-disposition: attachment; filename="calendar.csv"');
    header('Content-type: "text/csv"; charset="utf8"');
    header("Expires: 0");
}