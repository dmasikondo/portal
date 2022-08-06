<?php
/**
 * Created by PhpStorm.
 * User: Tapiwanashe
 * Date: 14/06/2018
 * Time: 13:44
 */

namespace App\Domain;


use Illuminate\Support\Facades\Log;

class SMSService
{

    private $apiUrl = "http://portal.bulksmsweb.com/index.php?app=ws";
    private $username = "Hararepoly001";
    private $token = "2080228a06afbf126e3013b856857027";

    public function send($message, $recipients)
    {
        $ws_str = $this->apiUrl . '&u=' . $this->username . '&h=' . $this->token . '&op=pv';
        $ws_str .= '&to=' . urlencode($this->recipients($recipients)) . '&msg=' . urlencode($message);
        $ws_response = @file_get_contents($ws_str);

        Log::info($ws_response);
    }

    private function recipients($recipients)
    {
        $str = "";

        if (is_array($recipients)) {
            $count = count($recipients);
            $i = 1;
            foreach ($recipients as $recipient) {
                $str .= "{$recipient}";
                if ($i < $count) {
                    $str .= ",";
                }
                $i++;
            }
        } else {
            $str .= $recipients;
        }

        return $str;
    }
}
