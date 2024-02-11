<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Utils\WhatsappBussines;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class WhatsappController extends Controller
{
    private $business;
    private $whatsappBussines;
    public function __construct()
    {
        $this->business = Business::getBusiness();
        $this->whatsappBussines = new WhatsappBussines($this->business);
    }

    public function startSession()
    {
        $response = $this->whatsappBussines->startSession();
        return response()->json($response);
    }

    public function statusSession()
    {
        $response = $this->whatsappBussines->statusSession();
        return response()->json($response);
    }

    public function getImageQrBase64(Request $request)
    {
        $response = $this->whatsappBussines->getImageQrBase64();
        return response()->json($response);
    }

    public function getImageQr()
    {
        return $this->whatsappBussines->getImageQr();
    }

    public function getChats()
    {
        $response = $this->whatsappBussines->getChats();
        return response()->json($response);
    }
    public function getChatsHtml()
    {
        $response = $this->whatsappBussines->getChats();
        $view = View::make('admin.monthly_closure.modal.table-contacts')->with(['chats' => $response->chats])->render();
        return response()->json(["html" => $view]);
    }

    public function getContactsHtml()
    {
        $response = $this->whatsappBussines->getContacts();
        $contacts = $response->success ?  $response->contacts: [];
        $view = view('admin.monthly_closure.modal.table-contacts-v2')->with(['contactos' => $contacts])->render();
        return response()->json(["html" => $view]);
    }

    public function verifySession()
    {
        $response = $this->whatsappBussines->verifySession();
        return response()->json(["success" => $response]);
    }

    public function getChatsGroup()
    {
        $response = $this->whatsappBussines->getChatsGroup();
        return response()->json($response);
    }

    public function terminateSession()
    {
        $response = $this->whatsappBussines->terminateSession();
        return response()->json($response);
    }
}
