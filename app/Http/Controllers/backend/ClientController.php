<?php

namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator; // ✅ ต้องมีบรรทัดนี้

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
   
    public function ClientShow()
    {
    // ✅ ดึงเฉพาะ clients ที่ยัง active (release_status = 'show')
            $clients = Client::with('problems')
        ->where('release_status', 'show')
        ->get();

    // ✅ ส่งข้อมูลไปยัง view
    return view('backend.client.client_show', compact('clients'));



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
//สิ้นสุด method show

//จังหวัด อำเภอ ตำบล รหัสไปรษณีย์
// RecipientController.php

public function getDistricts($province_id)
{
        return response()->json(
        District::where('province_id', $province_id)->get(['id', 'dist_name'])
    );
}

public function getSubdistricts($district_id)
{
        return response()->json(
        SubDistrict::where('district_id', $district_id)->get(['id', 'subd_name'])
    );
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
        'register_number' => 'nullable|string|max:255|unique:clients,register_number',
        'title_id'        => 'required|integer',
        'nick_name'       => 'nullable|string|max:255',
        'first_name'      => 'required|string|max:255',
        'last_name'       => 'required|string|max:255',
        'gender'          => 'required|in:male,female',
        'birth_date'      => 'required|date',
        'id_card'         => 'nullable|string|max:13|unique:clients,id_card',
        'national_id'     => 'required|integer',
        'religion_id'     => 'required|integer',
        'marital_id'      => 'required|integer',
        'occupation_id'   => 'required|integer',
        'income_id'       => 'required|integer',
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
        'house_id'        => 'required|integer',
        'status_id'       => 'required|integer',
        'case_resident'   => 'required|in:Active,Not Active',
        'problems'        => 'nullable|array',
        'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ], [
        // ✅ ข้อความภาษาไทยสำหรับ validation
        'register_number.unique'   => 'เลขทะเบียนนี้ถูกใช้แล้ว',
        'title_id.required'        => 'กรุณาเลือกคำนำหน้า',
        'first_name.required'      => 'กรุณากรอกชื่อ',
        'last_name.required'       => 'กรุณากรอกนามสกุล',
        'gender.required'          => 'กรุณาเลือกเพศ',
        'birth_date.required'      => 'กรุณากรอกวัน/เดือน/ปีเกิด',
        'id_card.unique'           => 'เลขบัตรประชาชนนี้ถูกใช้แล้ว',
        'national_id.required'     => 'กรุณาเลือกสัญชาติ',
        'religion_id.required'     => 'กรุณาเลือกศาสนา',
        'marital_id.required'      => 'กรุณาเลือกสถานภาพสมรส',
        'occupation_id.required'   => 'กรุณาเลือกอาชีพ',
        'income_id.required'       => 'กรุณาเลือกรายได้',
        'education_id.required'    => 'กรุณาเลือกการศึกษา',
        'arrival_date.required'    => 'กรุณากรอกวันที่เข้ารับบริการ',
        'target_id.required'       => 'กรุณาเลือกเป้าหมาย',
        'contact_id.required'      => 'กรุณาเลือกผู้ติดต่อ',
        'project_id.required'      => 'กรุณาเลือกโครงการ',
        'house_id.required'        => 'กรุณาเลือกบ้าน',
        'status_id.required'       => 'กรุณาเลือกสถานะ',
        'case_resident.required'   => 'กรุณาเลือกสถานะการอยู่อาศัย',
        'image.image'              => 'ไฟล์ต้องเป็นรูปภาพ',
        'image.mimes'              => 'รูปภาพต้องเป็นไฟล์ประเภท jpeg, png, jpg, gif หรือ svg',
        'image.max'                => 'รูปภาพต้องมีขนาดไม่เกิน 2MB',
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

    // ✅ กำหนดค่า release_status ให้เป็น 'show' เสมอเมื่อสร้างใหม่
    $validated['release_status'] = 'show';

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

    return redirect()->route('client.show')->with($notification);
}
//สิ้นสุด method store

public function ClientEdit($id )
{
        $client = Client::findOrFail($id);
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

        return view('backend.client.client_edit', compact(
            'client',
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

public function ClientUpdate(Request $request)
{
    // ✅ ดึงข้อมูล จากฟอร์ม และตรวจสอบ
    $id = $request->id;

    $validated = $request->validate([
        'register_number' => 'nullable|unique:clients,register_number,' . $id,
        'id_card' => 'nullable|unique:clients,id_card,' . $id,
        'title_id'        => 'required|integer',
        'nick_name'       => 'nullable|string|max:255',
        'first_name'      => 'required|string|max:255',
        'last_name'       => 'required|string|max:255',
        'gender'          => 'required|in:male,female',
        'birth_date'      => 'required|date',
        'national_id'     => 'required|integer',
        'religion_id'     => 'required|integer',
        'marital_id'      => 'required|integer',
        'occupation_id'   => 'required|integer',
        'income_id'       => 'required|integer',
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
        'house_id'        => 'required|integer',
        'status_id'       => 'required|integer',
        'case_resident'   => 'required|in:Active,Not Active',
        'problems'        => 'nullable|array',
        'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ], [
        'register_number.unique' => 'เลขทะเบียนนี้ถูกใช้แล้ว',
        'register_number.string' => 'เลขทะเบียนต้องเป็นตัวอักษร',
        'register_number.max'    => 'เลขทะเบียนต้องไม่เกิน 255 ตัวอักษร',
        'id_card.unique'         => 'เลขบัตรประชาชนนี้ถูกใช้แล้ว',
        'id_card.string'         => 'เลขบัตรประชาชนต้องเป็นตัวอักษร',
        'id_card.max'            => 'เลขบัตรประชาชนต้องไม่เกิน 13 หลัก',
        // ข้อความอื่น ๆ ตามที่คุณเขียนไว้
    ]);

    // จัดการไฟล์ภาพ
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('upload/client_images'), $filename);
        $validated['image'] = $filename;
    }

    // ดึง problems ออกมาแยก
    $problems = $validated['problems'] ?? [];
    unset($validated['problems']);

    // บันทึก Client
    $client = Client::findOrFail($id);
    // ✅ กำหนดค่า release_status ให้คงเป็น 'show' เสมอเมื่อมีการแก้ไข
    $validated['release_status'] = 'show';
    $client->update($validated);

    // แนบ problems (many-to-many)
    $client->problems()->sync($problems);

    $notification = [
        'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว',
        'alert-type' => 'success'
    ];

    return redirect()->route('client.show', $client->id)->with($notification);
}

       public function ClientDelete($id)
{
    // ดึงข้อมูล Client ถ้าไม่เจอจะ throw 404
    $client = Client::findOrFail($id);

    // ❌ ไม่ต้อง detach ความสัมพันธ์ problems
    // ❌ ไม่ต้อง unlink รูปภาพ ถ้าใช้ soft delete

    // ✅ เปลี่ยนสถานะ release_status เป็น refer
    $client->update(['release_status' => 'refer']);

    // แจ้งเตือน
    $notification = [
        'message' => 'เปลี่ยนสถานะเป็น refer เรียบร้อยแล้ว',
        'alert-type' => 'success'
    ];

    return redirect()->route('client.show')->with($notification);
}
    


}

