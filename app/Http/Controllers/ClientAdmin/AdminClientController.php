<?php

namespace App\Http\Controllers\ClientAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Problem;
use App\Models\Province;
use App\Models\District;
use App\Models\SubDistrict;
use App\Models\National;
use App\Models\Religion;
use App\Models\Marital;
use App\Models\Occupation;
use App\Models\Income;
use App\Models\Education;
use App\Models\Contact;
use App\Models\Project;
use App\Models\Status;
use App\Models\House;
use App\Models\Target;
use App\Models\Title;


class AdminClientController extends Controller
{
    public function Index($id)
    {
        $client = Client::find($id);
        return view('admin_client.index.client_index', compact('client'));
    }

    public function ClientReport($id)
    {
      $client = Client::with([    
        'problems',
        'province',
        'district',
        'sub_district',
        'national',
        'religion',
        'marital',
        'occupation',
        'income',
        'education',
        'contact',
        'project',
        'status',
        'house',
        'target',
        'title'

    ])->findOrFail($id);

    $problems = Problem::all(); // ✅ ต้องมีถ้าใช้ compact('problems')

        return view('admin_client.index.client_report', compact('client', 'problems'));
    }
}

