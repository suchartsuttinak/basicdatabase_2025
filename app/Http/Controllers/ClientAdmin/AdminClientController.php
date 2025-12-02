<?php

namespace App\Http\Controllers\ClientAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;


class AdminClientController extends Controller
{
    public function Index($id)
    {
        $client = Client::find($id);
        return view('admin_client.index.client_index', compact('client'));
    }

    public function ClientReport($id)
    {
       $client = Client::findOrFail($id);
   return view('admin_client.index.client_report', compact('client'));


    }
}

