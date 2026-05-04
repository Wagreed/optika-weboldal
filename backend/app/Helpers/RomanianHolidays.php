<?php

namespace App\Helpers;

use Carbon\Carbon;

class RomanianHolidays
{
    /**
     * Visszaadja az adott év összes romániai munkaszüneti napját (YYYY-MM-DD => leírás).
     */
    public static function forYear(int $year): array
    {
        $easter = self::orthodoxEaster($year);

        $holidays = [
            // Rögzített ünnepnapok
            "$year-01-01" => 'Új év (1)',
            "$year-01-02" => 'Új év (2)',
            "$year-01-24" => 'Román Fejedelemségek Egyesülésének Napja',
            "$year-05-01" => 'A Munka Ünnepe',
            "$year-06-01" => 'Gyermeknap',
            "$year-08-15" => 'Nagyboldogasszony',
            "$year-11-30" => 'Szent András',
            "$year-12-01" => 'Románia Nemzeti Ünnepe',
            "$year-12-25" => 'Karácsony (1)',
            "$year-12-26" => 'Karácsony (2)',

            // Húsvét alapú ünnepnapok (ortodox naptár szerint)
            $easter->clone()->subDays(2)->format('Y-m-d') => 'Nagypéntek',
            $easter->format('Y-m-d')                      => 'Ortodox Húsvét',
            $easter->clone()->addDay()->format('Y-m-d')   => 'Ortodox Húsvét (2)',
            $easter->clone()->addDays(39)->format('Y-m-d') => 'Áldozócsütörtök',
            $easter->clone()->addDays(49)->format('Y-m-d') => 'Pünkösd',
            $easter->clone()->addDays(50)->format('Y-m-d') => 'Pünkösd (2)',
        ];

        ksort($holidays);

        return $holidays;
    }

    /**
     * Ortodox húsvét dátuma Gergely-naptár szerint.
     * Az algoritmus a Julián-naptáros dátumot számítja ki, majd +13 nappal
     * konvertálja Gergely-naptárra (20-21. századi korrekció).
     */
    private static function orthodoxEaster(int $year): Carbon
    {
        $a = $year % 4;
        $b = $year % 7;
        $c = $year % 19;
        $d = (19 * $c + 15) % 30;
        $e = (2 * $a + 4 * $b - $d + 34) % 7;
        $month = intdiv($d + $e + 114, 31);
        $day   = ($d + $e + 114) % 31 + 1;

        return Carbon::createFromDate($year, $month, $day)->addDays(13);
    }
}
