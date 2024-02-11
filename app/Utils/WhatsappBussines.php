<?php
namespace App\Utils;

use App\Utils\WhatsappNodeJs;
use App\Models\Business;


class WhatsappBussines
{
    private Business  $business;
    private WhatsappNodeJs $whatsappNodeJs;

    const SESSION_NOT_CONNECTED = "session_not_connected";
    const SESSION_NOT_FOUND = "session_not_found";
    //session_connected
    const SESSION_CONNECTED = "session_connected";
    const QR_CODE_NOT_READY = "qr code not ready or already scanned";

    public function __construct(Business $business)
    {
        $this->business = $business;
        $this->business->generateInstanceId();
        $this->whatsappNodeJs = new WhatsappNodeJs($business->whatsapp_instance);
    }

    public function startSession()
    {
        return $this->whatsappNodeJs->startSession();
    }

    public function statusSession()
    {
        return $this->whatsappNodeJs->statusSession();
    }
    public function verifySession()
    {
        $session = $this->statusSession();
        if ($session->message == self::SESSION_CONNECTED) {
            $responseInfo = $this->whatsappNodeJs->getInformation();
            if($responseInfo->success){
                $this->business->phone_number_connected = $responseInfo->sessionInfo->wid->user;
                $this->business->state_connection = true;
                $this->business->update();
                return true;
            }
        }else{
            $this->business->state_connection = false;
            $this->business->phone_number_connected = "";
            $this->business->update();
        }
        return false;
    }

    public function verifySessionV2(){
        $session = $this->statusSession();
        if ($session->message != self::SESSION_CONNECTED) {
            $this->business->state_connection = false;
            $this->business->phone_number_connected = "";
            $this->business->update();
        }
    }

    public function getImageQrBase64()
    {
        $session = $this->statusSession();
        if($session->message == self::SESSION_NOT_FOUND){
            $session = $this->startSession();
        }
        if ($session->message == self::SESSION_NOT_CONNECTED) {
            $response =  $this->whatsappNodeJs->getImageQr();
            $response->qr = "data:image/png;base64," . $response->qr;
            return $response;
        }
        return $session;
    }

    public function getChats()
    {
        return $this->whatsappNodeJs->getChats();
    }

    public function getChatsGroup()
    {
        $responseChats = $this->whatsappNodeJs->getChats();
        $chats = $responseChats->chats->filter(function ($chat) {
            return $chat->isGroup;
        });
        return $chats;
    }

    public function terminateSession()
    {
        $response = $this->whatsappNodeJs->terminateSession();
        $this->business->state_connection = false;
        $this->business->phone_number_connected = "";
        $this->business->update();
        return $response;
    }
    /**
     * Send single text message
     *
     * @param string $chatId
     * @param string $message
     * @param string $file (optional) base64
     * @param string $filename (optional)
     * @param string $mimetype (optional)
     *
     * @return void
     */
    public function sendTextMessage($phone, $message,string $file = null,string $filename="imagen.png",string $mimetype="image/png")
    {
        $options = $file ? [
            "media" => [
                "mimetype" => $mimetype,
                "filename" => str_replace(" ","_",$filename),
                "data" => $file,
            ]
        ] : null;
        $response = $this->whatsappNodeJs->sendTextMessage($phone, $message,$options);
        return $response;
    }
    public function sendMediaMessage($phone, string $filename, string $mimetype, string $data)
    {
        $response = $this->whatsappNodeJs->sendMediaMessage($phone, $filename, $mimetype, $data);
        return $response;
    }

    public function sendMediaFromUrl($phone, string $url)
    {
        $response = $this->whatsappNodeJs->sendMediaFromUrl($phone, $url);
        return $response;
    }

    public function getImageQr() {
        $session = $this->statusSession();
        if($session->message == self::SESSION_NOT_FOUND){
            $session = $this->startSession();
            $session = $this->statusSession();
        }
        if ($session->message == self::SESSION_NOT_CONNECTED) {
            $response = $this->whatsappNodeJs->getImageQr();
            while (isset($response->message) && $response->message == self::QR_CODE_NOT_READY) {
                $response = $this->whatsappNodeJs->getImageQr();
            }
            return $response;
        }
        return $session;
    }
}
