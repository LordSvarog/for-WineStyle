<?php

/**
 * Получаем курс валюты с ЦБ
 * Class Currency
 */
class Currency
{
    public static function getCurrency($currency_code, $format)
    {
        $date = date("d/m/Y"); // Текущая дата
        $cache_time_out = "3600"; // Время жизни кеша в секундах

        $file_currency_cache = __DIR__."/XML_daily.asp";

        if(!is_file($file_currency_cache) || filemtime($file_currency_cache) < time() - $cache_time_out) {

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://www.cbr.ru/scripts/XML_daily.asp?date_req=".$date);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            $out = curl_exec($ch);

            curl_close($ch);

            $fp = fopen($file_currency_cache, "w");

            fwrite($fp, $out);
            fclose($fp);
        }

        $content_currency = simplexml_load_file($file_currency_cache);

        return number_format(str_replace(",", ".", $content_currency->xpath('Valute[CharCode="'.$currency_code.'"]')[0]->Value), $format);
    }
}