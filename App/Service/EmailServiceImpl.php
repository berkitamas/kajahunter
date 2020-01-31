<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 29.
 * Time: 2:43
 */

namespace App\Service;


use App\Settings;

class EmailServiceImpl implements EmailService {
    private $receiver,
        $subject,
        $content,
        $sender,
        $name;

    public function __construct($sender, $receiver) {
        $this->receiver = $receiver;
        $this->sender = $sender . "@kajahunter.hu";
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function addSubject($subject) {
        $this->subject = $subject;
    }

    public function prepareContent($reason) {
        $url = Settings::get("url");
        $this->content = <<<"EOD"
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:Settings="http://www.w3.org/1999/xhtml" lang="hu">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>KajaHunter</title>
<style>
body { margin: 0; padding: 0; }
@media only screen and (max-device-width: 480px) {
table {
width: 320px !important;
}
td[class="border"] {
text-align:center;
}
}
</style>
</head>
<body bgcolor="#eaeaea">
<table cellspacing="0" cellpadding="0" border="0" width="100%" style="width: 100%;" style="border-collapse: collapse; text-align:center;" align="center"><tbody><tr><td bgcolor="#eaeaea">
<table style="width: 700px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td>
<table width="700" border="0" cellspacing="0" cellpadding="0"><tbody><tr><td align="left" bgcolor="#ffffff" style="padding: 15px 0px 15px 10px; font-family: Arial, sans-serif;color: #666666;font-size: 12px;-webkit-text-size-adjust: none;">
Ezt a levelet azért küldtük, mert $reason Amennyiben ez az üzenet nem érinti, nyugodtan hagyja figyelmen kívül.</td></tr></tbody></table>
</td></tr>
<tr><td>
<table width="700" border="0" cellspacing="0" cellpadding="0"><tbody><tr><td align="left" class="border" style="padding: 20px 0px 20px 0px;font-family: Arial, sans-serif;color: #666666;font-size: 12px;-webkit-text-size-adjust: none;">
<img src="$url/assets/img/maillogo.jpg" alt="KajaHunter" height="100" width="414">
</td></tr></tbody></table>
</td></tr>
<tr><td>
<table width="700" border="0" cellspacing="0" cellpadding="0"><tbody>
EOD;
    }

    public function finishContent() {
        $this->content .= <<<EOD
<td bgcolor="#ffffff" align="left" style="padding: 20px 20px 10px 20px;font-family: Arial, sans-serif;color: #666666;font-size: 15px;-webkit-text-size-adjust: none;">
<p style="margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px;">
Tisztelettel,
</p>
<p style="margin: 0px 0px 0px 0px; padding: 5px 0px 0px 10px;">
KajaHunter Kft.
</p>
</td></tr></tbody></table>
</td></tr>
<tr><td>
<table width="700" border="0" cellspacing="0" cellpadding="0"><tbody><tr><td align="left" class="border" style="padding: 15px 0px 15px 0px;font-family: Arial, sans-serif;color: #000000;font-size: 11px;-webkit-text-size-adjust: none;">
2018&nbsp;&nbsp;&nbsp;KajaHunter Kft. - Minden jog fenntartva!
</td></tr></tbody></table>
</td></tr></tbody></table>
</td></tr></tbody></table></body></html>
EOD;
    }

    public function addText($content) {
        $this->content .= '<tr><td bgcolor="#ffffff" align="left" style="padding: 0px 20px 10px 20px;font-family: Arial, sans-serif;color: #666666;font-size: 15px;-webkit-text-size-adjust: none;"><p>' . $content . '</p></td></tr>';
    }

    public function addHeading($heading) {
        $this->content .= '<tr><td bgcolor="#ffffff" align="left" style="padding: 20px 20px 	0px 20px;font-family: Arial, sans-serif;color: #666666;font-size: 15px;-webkit-text-size-adjust: none;"><h1 style="font-family: Arial, sans-serif;color: #666666;font-size: 22px;-webkit-text-size-adjust: none;margin:0px 0px 0px 0px;">' . $heading . '</h1></td></tr>';
    }

    public function addButton($url, $img) {
        $this->content .= '<tr><td align="left" width="200" bgcolor="#ffffff" style="padding: 0px 0px 10px 20px;"><a href="' . $url . '"><img src="' . $img . '" border="0" width="200" height="50"></a></td></tr>';
    }

    public function send() {
        file_put_contents(__DIR__ . "/../../mail/" . DateService::getCurrentTimestamp() . "_" . str_replace("@", "_", $this->receiver) . ".html", $this->content);
        /*$headers = "From: " . $this->name . " <" . $this->sender . "> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        mail($this->receiver, '=?utf-8?B?'.base64_encode($this->subject).'?=', $this->content, $headers);
        */
    }
}