<?php

namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;

use App\Models\House;
use App\Models\Income;
use App\Models\Region;
use App\Models\Status;
use App\Models\Target;
use App\Models\Contact;
use App\Models\Marital;
use App\Models\Problem;
use App\Models\Project;
use App\Models\District;
use App\Models\National;
use App\Models\Province;
use App\Models\Religion;
use App\Models\Client;
use App\Models\Occupation;
use App\Models\SubDistrict;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Education;
use App\Models\Title;

// use Image;  
use Intervention\Image\ImageManager;
// use Intervention\Image\Drivers\Imagick\Driver; (เกิดข้อผิดพลาดกับบางเครื่อง)
use Intervention\Image\Drivers\Gd\Driver; 
class ClientController extends Controller
{
   
    public function ClientAll()
    {
        $clients = Client::with('problems')->get();
        return view('backend.client.client_all', compact('clients'));   
    }
   
    public function ClientAdd()
    {
        $problems    = Problem::all();
        $provinces   = Province::all();
        $districts   = District::all();
        $sub_districts = SubDistrict::all();
        $nations     = National::all();
        $religions   = Religion::all();
        $maritals    = Marital::all();
        $occupations = Occupation::all();
        $incomes     = Income::all();
        $educations  = Education::all();
        $contacts    = Contact::all();
        $projects    = Project::all();
        $statuses    = Status::all();
        $houses      = House::all(); 
        $targets     = Target::all(); 
        $titles      = Title::all();  
     
  
            return view('backend.client.client_add', compact(
            'problems',
            'provinces',
            'districts',
            'sub_districts',
            'nations',
            'religions',
            'maritals',
            'occupations',
            'incomes',
            'educations',
            'contacts',
            'projects',
            'statuses',
            'houses',
            'targets',
            'titles'
        ));
}

//จังหวัด อำเภอ ตำบล รหัสไปรษณีย์
// RecipientController.php

public function getDistricts($province_id)
{
    $districts = District::where('province_id', $province_id)->get(['id', 'dist_name']);
    return response()->json($districts);
}

public function getSubdistricts($district_id)
{
    $subdistricts = SubDistrict::where('district_id', $district_id)->get(['id', 'subd_name']);
    return response()->json($subdistricts);
}

public function getZipcode($subdistrict_id)
{
    $subdistrict = SubDistrict::find($subdistrict_id);
    return response()->json(['zipcode' => $subdistrict ? $subdistrict->zipcode : null]);
}
//สิ้นสุด จังหวัด อำเภอ ตำบล รหัสไปรษณีย์


public function ClientStore(Request $request)
{
    $validated = $request->validate([
        'register_number' => 'nullable|string|max:255',
        'title_id'        => 'required|integer',
        'nick_name'       => 'nullable|string|max:255',
        'first_name'      => 'required|string|max:255',
        'last_name'       => 'required|string|max:255',
        'gender'          => 'required|in:male,female',
        'birth_date'      => 'nullable|date',
        'id_card'         => 'nullable|string|max:13|unique:clients,id_card',
        'national_id'     => 'required|integer',
        'religion_id'     => 'required|integer',
        'marital_id'      => 'required|integer',
        'occupation_id'   => 'required|integer',
        'income_id'       => 'nullable|integer',
        'education_id'    => 'required|integer',
        'scholl'          => 'nullable|string|max:255',
        'address'         => 'nullable|string|max:255',
        'moo'             => 'nullable|string|max:255',
        'soi'             => 'nullable|string|max:255',
        'road'            => 'nullable|string|max:255',
        'village'         => 'nullable|string|max:255',
        'province_id'     => 'nullable|integer',
        'district_id'     => 'nullable|integer',
        'sub_district_id' => 'nullable|integer',
        'zipcode'         => 'nullable|integer',
        'phone'           => 'nullable|string|max:50',
        'arrival_date'    => 'required|date',
        'target_id'       => 'required|integer',
        'contact_id'      => 'required|integer',
        'project_id'      => 'required|integer',
        'house_id'        => 'nullable|integer',
        'status_id'       => 'required|integer',
        'case_resident'   => 'required|in:Active,Not Active',
        'problems'        => 'nullable|array',
        'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // ✅ จัดการไฟล์ภาพ
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('upload/client_images'), $filename);
        $validated['image'] = $filename;
    }

    // ✅ ดึง problems ออกมาแยก
    $problems = $validated['problems'] ?? [];
    unset($validated['problems']);

    // ✅ บันทึก Client
    $client = Client::create($validated);


    // ✅ แนบ problems (many-to-many)
    if (!empty($problems)) {
        $client->problems()->attach($problems);
    }

     

    $notification = [
        'message' => 'บันทึกข้อมูลเรียบร้อย',
        'alert-type' => 'success'
    ];

    return redirect()->route('client.all')->with($notification);
}


}



