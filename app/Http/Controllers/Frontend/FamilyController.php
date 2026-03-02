<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Province;
use App\Models\District;
use App\Models\SubDistrict;
use Illuminate\Support\Facades\DB;
use App\Models\Father;
use App\Models\Mother;
use App\Models\Spouse;
use App\Models\Relative;




class FamilyController extends Controller
{
    public function FamilyAdd($client_id)
{
    // ดึงข้อมูล client หลัก
    $client = Client::findOrFail($client_id);

    // ดึงข้อมูลครอบครัวถ้ามี
    $father   = Father::where('client_id', $client_id)->first();
    $mother   = Mother::where('client_id', $client_id)->first();
    $spouse   = Spouse::where('client_id', $client_id)->first();
    $relative = Relative::where('client_id', $client_id)->first();

    // ดึงข้อมูลจังหวัด/อำเภอ/ตำบล สำหรับ dropdown
    $provinces     = Province::all();
    $districts     = District::all();
    $sub_districts = SubDistrict::all();

    return view('frontend.client.family.family_add', compact(
        'client',
        'father',
        'mother',
        'spouse',
        'relative',
        'provinces',
        'districts',
        'sub_districts'
    ));
}
    // End Method

    //จังหวัด อำเภอ ตำบล รหัสไปรษณีย์

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

    //บันทึกข้อมูล
public function FamilyStore(Request $request)
{
    $request->validate([
        'client_id' => 'required|integer|exists:clients,id',
        // เพิ่ม validation สำหรับ father.fname, mother.fname ฯลฯ ตามต้องการ
    ]);

    $messageType = null; // เก็บสถานะว่าเป็น insert หรือ update

    DB::transaction(function () use ($request, &$messageType) {
        $clientId = $request->input('client_id');

        $fields = [
            'fname','lname','idcard','age','occupation','income',
            'address_no','moo','soi','road','village',
            'province_id','district_id','sub_district_id','zipcode','phone'
        ];

        if (is_array($request->input('father'))) {
            $father = Father::updateOrCreate(
                ['client_id' => $clientId],
                collect($request->input('father'))->only($fields)->toArray()
            );
            $messageType = $father->wasRecentlyCreated ? 'create' : 'update'; // กำหนดข้อความตามสถานะ
        }

        if (is_array($request->input('mother'))) {
            $mother = Mother::updateOrCreate(
                ['client_id' => $clientId],
                collect($request->input('mother'))->only($fields)->toArray()
            );
            $messageType = $mother->wasRecentlyCreated ? 'create' : 'update'; // กำหนดข้อความตามสถานะ
        }

        if (is_array($request->input('spouse'))) {
            $spouse = Spouse::updateOrCreate(
                ['client_id' => $clientId],
                collect($request->input('spouse'))->only($fields)->toArray()
            );
            $messageType = $spouse->wasRecentlyCreated ? 'create' : 'update'; // กำหนดข้อความตามสถานะ
        }

        if (is_array($request->input('relative'))) {
            $relative = Relative::updateOrCreate(
                ['client_id' => $clientId],
                collect($request->input('relative'))->only($fields)->toArray()
            );
            $messageType = $relative->wasRecentlyCreated ? 'create' : 'update'; // กำหนดข้อความตามสถานะ
        }
    });

    // กำหนดข้อความตามสถานะ
    $message = $messageType === 'create'
        ? 'บันทึกข้อมูลครอบครัวเรียบร้อย'
        : 'แก้ไขข้อมูลครอบครัวเรียบร้อย';

    return redirect()->route('family.add', $request->client_id)
        ->with(['message' => $message, 'alert-type' => 'success']);
}
        // End Method
    }
    


    

