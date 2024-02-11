<?php

namespace App\Utils;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Http;

class WhatsappNodeJs
{
    protected $URL;
    protected $APIKEY;
    protected $INSTANCEID;
    protected $RESPONSE;

    public function __construct($instanceId)
    {
        $this->URL = env('WHATSAPP_NODEJS_URL');
        $this->APIKEY = env('WHATSAPP_NODEJS_APIKEY');
        $this->INSTANCEID = $instanceId;
    }

    public function startSession()
    {
        $endPoint = $this->URL . "/session/start/$this->INSTANCEID";
        $response = $this->sendRequest($endPoint, [], 'get');
        return $response;
    }

    public function statusSession()
    {
        // session/status/:sessionId
        $endPoint = $this->URL . "/session/status/$this->INSTANCEID";
        $response = $this->sendRequest($endPoint, [], 'get');
        return $response;
    }

    public function getImage()
    {
        //{{baseUrl}}/session/qr/:sessionId/image
        $endPoint = $this->URL . "/session/qr/$this->INSTANCEID/image";
        $response = $this->sendRequest($endPoint, [], 'get');
        return $response;
    }

    public function getImageQr()
    {
        //{{baseUrl}}/session/qr/:sessionId
        $endPoint = $this->URL . "/session/qr/$this->INSTANCEID/image";
        $response = $this->sendRequest($endPoint, [], 'get',false);
        return $response;
    }

    public function terminateSession()
    {
        //{{baseUrl}}/session/terminate/:sessionId
        $endPoint = $this->URL . "/session/terminate/$this->INSTANCEID";
        $response = $this->sendRequest($endPoint, [], 'get');
        return $response;
    }

    public function terminateInactiveSession()
    {
        //{{baseUrl}}/session/terminate/inactive/:sessionId
        $endPoint = $this->URL . "/session/terminateInactive";
        $response = $this->sendRequest($endPoint, [], 'get');
        return $response;
    }
    public function terminateAll()
    {
        //{{baseUrl}}/session/terminate/all
        $endPoint = $this->URL . "/session/terminateAll";
        $response = $this->sendRequest($endPoint, [], 'get');
        return $response;
    }
    //{{baseUrl}}/client/getClassInfo/:sessionId
    public function getInformation()
    {
        $endPoint = $this->URL . "/client/getClassInfo/$this->INSTANCEID";
        $response = $this->sendRequest($endPoint, [], 'get');
        return $response;
    }

    //{{baseUrl}}/client/getChats/:sessionId
    public function getChats()
    {
        $endPoint = $this->URL . "/client/getChats/$this->INSTANCEID";
        $response = $this->sendRequest($endPoint, [], 'get');
        return $response;
    }



    /**
     * Send single text message
     *
     * @param string $chatId
     * @param string $content
     *
     * @return void
     */
    function sendTextMessage(string $chatId, string $message,$options = null)
    {
        $params = [
            'chatId' => $chatId,
            'contentType' => 'string',
            'content' => $message,
            'options' => $options
        ];
        // dd(json_decode(json_encode($params)));
        return $this->sendMessage($params);
    }

    /**
     * Send media message
     *
     * @param string $chatId
     * @param string $filename
     * @param string $mimetype
     * @param string $data
     *
     *{
     *   "chatId": "6281288888888@c.us",
     *   "contentType": "MessageMedia",
     *   "content": {
     *   "mimetype": "image/jpeg",
     *   "data": "iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=",
     *   "filename": "image.jpg"
     *   }
     *}
     * @return void
     */
    function sendMediaMessage(string $chatId, string $filename, string $mimetype, string $data)
    {
        $params = [
            'chatId' => $chatId,
            'contentType' => 'MessageMedia',
            'content' => [
                'filename' => $filename,
                'mimetype' => $mimetype,
                'data' => $data
            ]
        ];
        return $this->sendMessage($params);
    }

    /**
     * Send media from URL
     *
     * @param string $chatId
     * @param string $url
     *
     * {
     *   "chatId": "6281288888888@c.us",
     *   "contentType": "MessageMediaFromURL",
     *  "content": "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Example"
     *  "options" :{
     * "caption": "Caption Text"
     * }
     * }
     * @return void
     *
     */
    function sendMediaFromUrl(string $chatId, string $url)
    {
        $params = [
            'chatId' => $chatId,
            'contentType' => 'MessageMediaFromURL',
            'content' => $url
        ];
        return $this->sendMessage($params);
    }

    /**
     * Send poll
     *
     * @param string $chatId
     * @param string $pollName
     * @param array $pollOptions
     * @param array $options
     *
     *
     *   "chatId": "6281288888888@c.us",
     *   "contentType": "Poll",
     *   "content": {
     *       "pollName": "Cats or Dogs?",
     *       "pollOptions": [
     *           "Cats",
     *           "Dogs"
     *       ],
     *       "options": {
     *           "allowMultipleAnswers": true
     *       }
     *  }

     * @return void
     */
    function sendPoll(string $chatId, string $pollName, array $pollOptions, array $options)
    {
        $params = [
            'chatId' => $chatId,
            'contentType' => 'Poll',
            'content' => [
                'pollName' => $pollName,
                'pollOptions' => $pollOptions,
                'options' => $options
            ]
        ];
        return $this->sendMessage($params);
    }


    public function sendMessage($data)
    {
        $endPoint = $this->URL . "/client/sendMessage/$this->INSTANCEID";
        $data = $data;
        $response = $this->sendRequest($endPoint, $data, 'post');
        return $response;
    }

    private function sendRequest($endPoint, $data, $method = 'get')
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'x-api-key' => $this->APIKEY,
            ])->$method($endPoint, $data);
            if ($response->header('Content-Type') == 'image/png'){
                $imagen = $response->body();
                $imagen_base64 = base64_encode($imagen);
                return $imagen_base64;
            }
            return json_decode($response->body());
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody();
            $errorDetails = [];
            if ($responseBody->getSize() > 0) {
                $responseBodyString = $responseBody->getContents();
                $decodedBody = json_decode($responseBodyString);
                $errorDetails['message'] = $decodedBody->message ?? 'No message';
            } else {
                $errorDetails['message'] = 'No response body';
            }
            return [
                "success" => false,
                "statusCode" => $response->getStatusCode(),
                "error" => $errorDetails['message']
            ];
        } catch (\Exception $e) {
        }
    }
}
