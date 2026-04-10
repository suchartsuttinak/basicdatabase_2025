<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Contact;
use App\Models\District;
use App\Models\Document;
use App\Models\Education;
use App\Models\House;
use App\Models\Income;
use App\Models\Marital;
use App\Models\National;
use App\Models\Occupation;
use App\Models\Problem;
use App\Models\Project;
use App\Models\Province;
use App\Models\Religion;
use App\Models\Status;
use App\Models\SubDistrict;
use App\Models\Target;
use App\Models\Title;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{
    /**
     * ดึง client ที่ user มีสิทธิ์เท่านั้น
     */
    protected function findAuthorizedClient($id): Client
    {
        return Client::forUser(auth()->user())->findOrFail($id);
    }

    /**
     * ดึงรายการบ้านที่ user มีสิทธิ์
     */
    protected function getAuthorizedHouseIds(): array
    {
        $user = auth()->user();

        if (!$user) {
            return [];
        }

        // admin เห็นได้ทั้งหมด
        if (
            (method_exists($user, 'isAdmin') && $user->isAdmin()) ||
            (($user->role ?? null) === 'admin')
        ) {
            return House::pluck('id')->map(fn ($id) => (int) $id)->toArray();
        }

        // กรณีมีหลายบ้านผ่าน relation houses()
        if (method_exists($user, 'houses')) {
            return $user->houses()
                ->pluck('houses.id')
                ->map(fn ($id) => (int) $id)
                ->toArray();
        }

        // fallback กรณี user มี house_id เดียว
        if (!empty($user->house_id)) {
            return [(int) $user->house_id];
        }

        return [];
    }

    /**
     * ดึงบ้านตามสิทธิ์เพื่อใช้ในฟอร์ม
     */
    protected function getAuthorizedHouses()
    {
        $houseIds = $this->getAuthorizedHouseIds();

        if (empty($houseIds)) {
            return collect();
        }

        return House::whereIn('id', $houseIds)->get();
    }

    /**
     * ตรวจว่า house_id ที่ส่งมาอยู่ในสิทธิ์ user หรือไม่
     */
    protected function ensureAuthorizedHouseId($houseId): void
    {
        $houseIds = $this->getAuthorizedHouseIds();

        abort_unless(
            in_array((int) $houseId, $houseIds, true),
            Response::HTTP_FORBIDDEN,
            'คุณไม่มีสิทธิ์เข้าถึงบ้านนี้'
        );
    }

    /**
     * หน้าแสดงรายการ client
     */
    public function ClientShow()
    {
        $clients = Client::forUser(auth()->user())
            ->with('problems')
            ->where('release_status', 'show')
            ->latest()
            ->get();

        return view('backend.client.client_show', compact('clients'));
    }

    /**
     * หน้าแสดงรายละเอียด client สำหรับ route เช่น /admin/client/{id}
     * ป้องกัน null และกันการเดา URL ข้ามสิทธิ์
     */
    public function ClientIndex($id)
    {
        $client = Client::forUser(auth()->user())
            ->with([
                'educationRecords',
                'problems',
                'house',
                'title',
                'national',
                'religion',
                'marital',
                'occupation',
                'income',
                'education',
                'contact',
                'status',
                'project',
                'target',
                'province',
                'district',
                'sub_district',
                'originProvince',
                'originDistrict',
                'originSubDistrict',
                'father',
                'mother',
                'spouse',
                'relative',
                'members',
                'files',
                'vaccinations',
                'refers',
            ])
            ->findOrFail($id);

        return view('admin_client.index.client_index', compact('client'));
    }

    public function ClientAdd()
    {
        $problems      = Problem::all();
        $provinces     = Province::all();
        $districts     = District::all();
        $sub_districts = SubDistrict::all();
        $nations       = National::all();
        $religions     = Religion::all();
        $maritals      = Marital::all();
        $occupations   = Occupation::all();
        $incomes       = Income::all();
        $educations    = Education::all();
        $contacts      = Contact::all();
        $projects      = Project::all();
        $statuses      = Status::all();

        // เห็นเฉพาะบ้านที่ user มีสิทธิ์
        $houses        = $this->getAuthorizedHouses();

        $targets       = Target::all();
        $titles        = Title::all();

        $origin_provinces     = Province::all();
        $origin_districts     = District::all();
        $origin_sub_districts = SubDistrict::all();

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
            'titles',
            'origin_provinces',
            'origin_districts',
            'origin_sub_districts'
        ));
    }

    // จังหวัด อำเภอ ตำบล รหัสไปรษณีย์
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

        return response()->json([
            'zipcode' => $subdistrict ? $subdistrict->zipcode : null
        ]);
    }

    // จังหวัด อำเภอ ตำบล รหัสไปรษณีย์ (ภูมิลำเนาเดิม)
    public function getOriginDistricts($province_id)
    {
        return response()->json(
            District::where('province_id', $province_id)->get(['id', 'dist_name'])
        );
    }

    public function getOriginSubdistricts($district_id)
    {
        return response()->json(
            SubDistrict::where('district_id', $district_id)->get(['id', 'subd_name'])
        );
    }

    public function getOriginZipcode($subdistrict_id)
    {
        $subdistrict = SubDistrict::find($subdistrict_id);

        return response()->json([
            'origin_zipcode' => $subdistrict ? $subdistrict->zipcode : null
        ]);
    }

    public function ClientStore(Request $request)
    {
        $validated = $request->validate([
            'register_number' => 'nullable|string|max:255|unique:clients,register_number',
            'title_id'        => 'required|integer',
            'gender'          => 'required|in:male,female',
            'nick_name'       => 'nullable|string|max:255',
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
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

            'origin_address'         => 'nullable|string|max:255',
            'origin_moo'             => 'nullable|string|max:255',
            'origin_soi'             => 'nullable|string|max:255',
            'origin_road'            => 'nullable|string|max:255',
            'origin_village'         => 'nullable|string|max:255',
            'origin_province_id'     => 'nullable|integer',
            'origin_district_id'     => 'nullable|integer',
            'origin_sub_district_id' => 'nullable|integer',
            'origin_zipcode'         => 'nullable|integer',
            'origin_phone'           => 'nullable|string|max:50',

            'arrival_date'    => 'required|date',
            'target_id'       => 'required|integer',
            'contact_id'      => 'required|integer',
            'project_id'      => 'required|integer',
            'house_id'        => 'required|integer',
            'status_id'       => 'required|integer',
            'case_resident'   => 'required|in:Active,Inactive',
            'problems'        => 'nullable|array',
            'problems.*'      => 'integer',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'register_number.unique' => 'เลขทะเบียนนี้ถูกใช้แล้ว',
            'title_id.required'      => 'กรุณาเลือกคำนำหน้า',
            'gender.required'        => 'กรุณาเลือกเพศ',
            'first_name.required'    => 'กรุณากรอกชื่อ',
            'last_name.required'     => 'กรุณากรอกนามสกุล',
            'birth_date.required'    => 'กรุณากรอกวัน/เดือน/ปีเกิด',
            'id_card.unique'         => 'เลขบัตรประชาชนนี้ถูกใช้แล้ว',
            'national_id.required'   => 'กรุณาเลือกสัญชาติ',
            'religion_id.required'   => 'กรุณาเลือกศาสนา',
            'marital_id.required'    => 'กรุณาเลือกสถานภาพสมรส',
            'occupation_id.required' => 'กรุณาเลือกอาชีพ',
            'income_id.required'     => 'กรุณาเลือกรายได้',
            'education_id.required'  => 'กรุณาเลือกการศึกษา',
            'arrival_date.required'  => 'กรุณากรอกวันที่เข้ารับบริการ',
            'target_id.required'     => 'กรุณาเลือกเป้าหมาย',
            'contact_id.required'    => 'กรุณาเลือกผู้ติดต่อ',
            'project_id.required'    => 'กรุณาเลือกโครงการ',
            'house_id.required'      => 'กรุณาเลือกบ้าน',
            'status_id.required'     => 'กรุณาเลือกสถานะ',
            'case_resident.required' => 'กรุณาเลือกสถานะการอยู่อาศัย',
            'case_resident.in'       => 'สถานะการอยู่อาศัยต้องเป็น Active หรือ Inactive เท่านั้น',
            'image.image'            => 'ไฟล์ต้องเป็นรูปภาพ',
            'image.mimes'            => 'รูปภาพต้องเป็นไฟล์ประเภท jpeg, png, jpg, gif หรือ svg',
            'image.max'              => 'รูปภาพต้องมีขนาดไม่เกิน 2MB',
        ]);

        // กันการส่ง house_id ปลอม
        $this->ensureAuthorizedHouseId($validated['house_id']);

        $title = Title::find($validated['title_id']);
        if ($title) {
            $age = Carbon::parse($validated['birth_date'])->age;
            $errors = [];

            if ($validated['gender'] === 'male' && !in_array($title->title_name, ['นาย', 'ด.ช.', 'เด็กชาย'])) {
                $errors['title_id'] = 'คำนำหน้าที่เลือกไม่ตรงกับเพศชาย';
            }

            if ($validated['gender'] === 'female' && !in_array($title->title_name, ['นาง', 'นางสาว', 'ด.ญ.', 'เด็กหญิง'])) {
                $errors['title_id'] = 'คำนำหน้าที่เลือกไม่ตรงกับเพศหญิง';
            }

            if ($age >= 15) {
                if (in_array($title->title_name, ['ด.ช.', 'เด็กชาย']) && $validated['gender'] === 'male') {
                    $validated['title_id'] = Title::where('title_name', 'นาย')->value('id') ?? $validated['title_id'];
                }

                if (in_array($title->title_name, ['ด.ญ.', 'เด็กหญิง']) && $validated['gender'] === 'female') {
                    $validated['title_id'] = Title::where('title_name', 'นางสาว')->value('id') ?? $validated['title_id'];
                }
            }

            if ($age >= 15 && in_array($title->title_name, ['ด.ช.', 'เด็กชาย', 'ด.ญ.', 'เด็กหญิง'])) {
                $errors['title_id'] = 'อายุ 15 ปีขึ้นไป ไม่สามารถใช้คำนำหน้า ' . $title->title_name . ' ได้';
            }

            if ($age < 15 && in_array($title->title_name, ['นาย', 'นาง', 'นางสาว'])) {
                $errors['title_id'] = 'อายุต่ำกว่า 15 ปี ไม่ควรใช้คำนำหน้า ' . $title->title_name;
            }

            if (!empty($errors)) {
                return back()->withErrors($errors)->withInput();
            }
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/client_images'), $filename);
            $validated['image'] = $filename;
        }

        $problems = $validated['problems'] ?? [];
        unset($validated['problems']);

        $validated['release_status'] = 'show';

        $client = Client::create($validated);

        if (!empty($problems)) {
            $client->problems()->attach($problems);
        }

        return redirect()
            ->route('client.edit', $client->id)
            ->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    public function ClientEdit($id)
    {
        $client        = $this->findAuthorizedClient($id);
        $problems      = Problem::all();
        $provinces     = Province::all();
        $districts     = District::all();
        $sub_districts = SubDistrict::all();
        $nations       = National::all();
        $religions     = Religion::all();
        $maritals      = Marital::all();
        $occupations   = Occupation::all();
        $incomes       = Income::all();
        $educations    = Education::all();
        $contacts      = Contact::all();
        $projects      = Project::all();
        $statuses      = Status::all();

        // เห็นเฉพาะบ้านที่ตัวเองมีสิทธิ์
        $houses        = $this->getAuthorizedHouses();

        $targets       = Target::all();
        $titles        = Title::all();

        $origin_provinces     = Province::all();
        $origin_districts     = District::all();
        $origin_sub_districts = SubDistrict::all();

        $documents = Document::all();

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
            'titles',
            'origin_provinces',
            'origin_districts',
            'origin_sub_districts',
            'documents'
        ));
    }

    public function ClientUpdate(Request $request)
    {
        $id = $request->id;

        // กันการเดา id ตั้งแต่ต้น
        $client = $this->findAuthorizedClient($id);

        $validated = $request->validate([
            'register_number' => 'nullable|unique:clients,register_number,' . $id,
            'id_card'         => 'nullable|unique:clients,id_card,' . $id,
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

            'origin_address'         => 'nullable|string|max:255',
            'origin_moo'             => 'nullable|string|max:255',
            'origin_soi'             => 'nullable|string|max:255',
            'origin_road'            => 'nullable|string|max:255',
            'origin_village'         => 'nullable|string|max:255',
            'origin_province_id'     => 'nullable|integer',
            'origin_district_id'     => 'nullable|integer',
            'origin_sub_district_id' => 'nullable|integer',
            'origin_zipcode'         => 'nullable|integer',
            'origin_phone'           => 'nullable|string|max:50',

            'arrival_date'    => 'required|date',
            'target_id'       => 'required|integer',
            'contact_id'      => 'required|integer',
            'project_id'      => 'required|integer',
            'house_id'        => 'required|integer',
            'status_id'       => 'required|integer',
            'case_resident'   => 'required|in:Active,Inactive',
            'problems'        => 'nullable|array',
            'problems.*'      => 'integer',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'register_number.unique' => 'เลขทะเบียนนี้ถูกใช้แล้ว',
            'register_number.string' => 'เลขทะเบียนต้องเป็นตัวอักษร',
            'register_number.max'    => 'เลขทะเบียนต้องไม่เกิน 255 ตัวอักษร',
            'id_card.unique'         => 'เลขบัตรประชาชนนี้ถูกใช้แล้ว',
            'id_card.string'         => 'เลขบัตรประชาชนต้องเป็นตัวอักษร',
            'id_card.max'            => 'เลขบัตรประชาชนต้องไม่เกิน 13 หลัก',
            'case_resident.required' => 'กรุณาเลือกสถานะการอยู่อาศัย',
            'case_resident.in'       => 'สถานะการอยู่อาศัยต้องเป็น Active หรือ Inactive เท่านั้น',
        ]);

        // กันการเปลี่ยน house_id ไปบ้านที่ไม่มีสิทธิ์
        $this->ensureAuthorizedHouseId($validated['house_id']);

        $title = Title::find($validated['title_id']);
        if ($title) {
            $age = Carbon::parse($validated['birth_date'])->age;
            $errors = [];

            if ($validated['gender'] === 'male' && !in_array($title->title_name, ['นาย', 'ด.ช.', 'เด็กชาย'])) {
                $errors['title_id'] = 'คำนำหน้าที่เลือกไม่ตรงกับเพศชาย';
            }

            if ($validated['gender'] === 'female' && !in_array($title->title_name, ['นาง', 'นางสาว', 'ด.ญ.', 'เด็กหญิง'])) {
                $errors['title_id'] = 'คำนำหน้าที่เลือกไม่ตรงกับเพศหญิง';
            }

            if ($age >= 15) {
                if (in_array($title->title_name, ['ด.ช.', 'เด็กชาย']) && $validated['gender'] === 'male') {
                    $validated['title_id'] = Title::where('title_name', 'นาย')->value('id') ?? $validated['title_id'];
                }

                if (in_array($title->title_name, ['ด.ญ.', 'เด็กหญิง']) && $validated['gender'] === 'female') {
                    $validated['title_id'] = Title::where('title_name', 'นางสาว')->value('id') ?? $validated['title_id'];
                }
            }

            if ($age >= 15 && in_array($title->title_name, ['ด.ช.', 'เด็กชาย', 'ด.ญ.', 'เด็กหญิง'])) {
                $errors['title_id'] = 'อายุ 15 ปีขึ้นไป ไม่สามารถใช้คำนำหน้า ' . $title->title_name . ' ได้';
            }

            if ($age < 15 && in_array($title->title_name, ['นาย', 'นาง', 'นางสาว'])) {
                $errors['title_id'] = 'อายุต่ำกว่า 15 ปี ไม่ควรใช้คำนำหน้า ' . $title->title_name;
            }

            if (!empty($errors)) {
                return back()->withErrors($errors)->withInput();
            }
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/client_images'), $filename);
            $validated['image'] = $filename;
        }

        $problems = $validated['problems'] ?? [];
        unset($validated['problems']);

        $validated['release_status'] = 'show';

        $client->update($validated);
        $client->problems()->sync($problems);

        return redirect()->back()->with('success', 'แก้ไขข้อมูลเรียบร้อยแล้ว');
    }

    public function ClientDelete($id)
{
    // อนุญาตเฉพาะ admin
    if (auth()->user()->role !== 'admin') {
        abort(403, 'คุณไม่มีสิทธิ์ลบข้อมูล');
    }

    $client = $this->findAuthorizedClient($id);

    $client->update(['release_status' => 'refer']);

    return redirect()->route('client.show')->with([
        'message' => 'เปลี่ยนสถานะเป็น refer เรียบร้อยแล้ว',
        'alert-type' => 'success',
    ]);
}

    public function ClientShowRefer()
    {
        $clients = Client::forUser(auth()->user())
            ->with('problems')
            ->whereIn('release_status', ['show', 'refer'])
            ->latest()
            ->get();

        return view('backend.client.client_show_refer', compact('clients'));
    }

    public function changeStatus($id)
    {
        $client = $this->findAuthorizedClient($id);

        if ($client->release_status === 'refer') {
            $client->release_status = 'show';
            $client->save();
        }

        return redirect()->back()
            ->with('success', 'ปรับสถานะเรียบร้อยแล้ว')
            ->with('alert', 'สถานะถูกเปลี่ยนจาก Refer เป็น Show');
    }
}