<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\VisitFamily;
use App\Models\Province;
use App\Models\District;
use App\Models\SubDistrict;
use App\Models\Income;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;






class VisitFamilyController extends Controller
{
    // หน้าเพิ่มข้อมูลการเยี่ยมบ้าน (แสดงฟอร์ม)
    public function AddvisitFamily($client_id)
    {
        $client = Client::findOrFail($client_id);
        $incomes = Income::all();
        $provinces = Province::all();

        $districts = [];
        $sub_districts = [];

        // ถ้ามีข้อมูลเดิมแล้ว ดึงมาแสดง
        $visitFamily = VisitFamily::where('client_id', $client_id)->first();

        if ($visitFamily) {
        return redirect()
            ->route('vitsitFamily.edit', $visitFamily->id)
            ->with('warning', 'มีการบันทึกข้อมูลรายนี้แล้ว กรุณาแก้ไขข้อมูล');
    }



        return view('frontend.client.visitFamily.visitFamily_add', compact(
            'provinces', 'districts', 'sub_districts', 'client_id', 'client', 'incomes', 'visitFamily'
        ));
    }

    // Ajax: ดึงอำเภอตามจังหวัด
    public function getDistricts($province_id)
    {

        $districts = District::where('province_id', $province_id)->get();
        return response()->json($districts);
    }

    // Ajax: ดึงตำบลตามอำเภอ
    public function getSubdistricts($district_id)
    {
        $subdistricts = SubDistrict::where('district_id', $district_id)->get();
        return response()->json($subdistricts);
    }

    // Ajax: ดึงรหัสไปรษณีย์ตามตำบล
    public function getZipcode($subdistrict_id)
    {
        $subdistrict = SubDistrict::find($subdistrict_id);
        return response()->json([
            'zipcode' => $subdistrict ? $subdistrict->zipcode : null
        ]);
    }

    // บันทึกข้อมูลใหม่
    public function StoreVisitFamily(Request $request, $client_id)
    {

  
        $validated = $request->validate([
        'visit_date'      => 'required|date',
        'count'           => 'nullable|integer',
        'family_fname'    => 'required|string|max:255',
        'family_age'      => 'nullable|integer',
        'member'          => 'nullable|string|max:255',
        'address'         => 'nullable|string|max:255',
        'moo'             => 'nullable|string|max:50',
        'soi'             => 'nullable|string|max:50',
        'road'            => 'nullable|string|max:255',
        'village'         => 'nullable|string|max:255',
        'province_id'     => 'required|integer',
        'district_id'     => 'required|integer',
        'sub_district_id' => 'required|integer',
        'zipcode'         => 'required|string|max:10',
        'phone'           => 'nullable|string|max:20',
        'outside_address' => 'nullable|string',
        'inside_address'  => 'nullable|string',
        'environment'     => 'nullable|string',
        'neighbor'        => 'nullable|string',
        'member_relation' => 'nullable|string',
        'income_id'       => 'nullable|integer',
        'problem'         => 'nullable|string',
        'need'            => 'nullable|string',
        'diagnose'        => 'nullable|string',
        'assistance'      => 'nullable|string',
        'comment'         => 'nullable|string',
        'modify'          => 'nullable|string',
        'teacher'         => 'nullable|string',
        'remark'          => 'nullable|string',
        'images'          => 'nullable|array',
        'images.*'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $validated['client_id'] = $client_id;

    $visitFamily = VisitFamily::create($validated);

    // ✅ ลดขนาดไฟล์รูปตอนอัปโหลด
     if ($request->hasFile('images')) {
    $manager = new ImageManager(new Driver()); // ✅ ใช้ GD driver

    foreach ($request->file('images') as $file) {
        $image = $manager->read($file)
            ->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->toJpeg(75); // ลดคุณภาพลงเหลือ 75%

        $filename = uniqid() . '.jpg';
        $path = 'visit_images/' . $filename;
        Storage::disk('public')->put($path, (string) $image);

        Image::create([
            'file_path'       => $path,
            'file_name'       => $file->getClientOriginalName(),
            'mime_type'       => 'image/jpeg',
            'size'            => Storage::disk('public')->size($path),
            'visit_family_id' => $visitFamily->id,
            'client_id'       => $client_id,
        ]);
    }

        }

    return redirect()->route('visitFamily.create', $client_id)
                     ->with('success', 'บันทึกข้อมูลเรียบร้อย');

    }
    
    // แสดงฟอร์มแก้ไขข้อมูล
    public function EditVisitFamily($id)
    {
        $visitFamily = VisitFamily::findOrFail($id);
        $client = Client::findOrFail($visitFamily->client_id);

        $incomes = Income::all();
        $provinces = Province::all();
        $districts = District::where('province_id', $visitFamily->province_id)->get();
        $sub_districts = SubDistrict::where('district_id', $visitFamily->district_id)->get();

         // ✅ ดึงรูปทั้งหมดที่เคยอัปโหลด
        $images = $visitFamily->images ?? [];

        return view('frontend.client.visitFamily.visitFamily_add', compact(
            'provinces', 'districts', 'sub_districts', 'client', 'incomes', 'visitFamily', 'images'
        ));
    }

    // อัปเดตข้อมูลเดิม
    public function UpdateVisitFamily(Request $request, $id)
    {
        $validated = $request->validate([
            'visit_date'      => 'required|date',
            'count'           => 'nullable|integer',
            'family_fname'    => 'required|string|max:255',
            'family_age'      => 'nullable|integer',
            'member'          => 'nullable|string|max:255',
            'address'         => 'nullable|string|max:255',
            'moo'             => 'nullable|string|max:50',
            'soi'             => 'nullable|string|max:50',
            'road'            => 'nullable|string|max:255',
            'village'         => 'nullable|string|max:255',
            'province_id'     => 'required|integer',
            'district_id'     => 'required|integer',
            'sub_district_id' => 'required|integer',
            'zipcode'         => 'required|string|max:10',
            'phone'           => 'nullable|string|max:20',
            'outside_address' => 'nullable|string',
            'inside_address'  => 'nullable|string',
            'environment'     => 'nullable|string',
            'neighbor'        => 'nullable|string',
            'member_relation' => 'nullable|string',
            'income_id'       => 'nullable|integer',
            'problem'         => 'nullable|string',
            'need'            => 'nullable|string',
            'diagnose'        => 'nullable|string',
            'assistance'      => 'nullable|string',
            'comment'         => 'nullable|string',
            'modify'          => 'nullable|string',
            'teacher'         => 'nullable|string',
            'remark'          => 'nullable|string',
            'images.*'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $visitFamily = VisitFamily::findOrFail($id);
        $visitFamily->update($validated);

         // ✅ เพิ่มรูปใหม่ตอนแก้ไข
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('visit_images', 'public');

                Image::create([
                    'file_path'       => $path,
                    'file_name'       => $file->getClientOriginalName(),
                    'mime_type'       => $file->getClientMimeType(),
                    'size'            => $file->getSize(),
                    'visit_family_id' => $visitFamily->id,
                    'client_id'       => $visitFamily->client_id,
                ]);
            }
        }

        return redirect()->route('vitsitFamily.edit', $id)
                         ->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }

     // ลบรูป (ตอบกลับ JSON สำหรับ AJAX)
public function destroy($id)
{
    $image = Image::find($id);

    if (!$image) {
        return response()->json(['error' => 'ไม่พบรูปภาพ'], 404);
    }

    // ลบไฟล์จริง
    Storage::disk('public')->delete($image->file_path);

    // ลบแถวฐานข้อมูล
    $image->delete();

    return response()->json(['success' => true]);
}

// (ตัวเลือก) แทนที่ไฟล์รูปเดิม
public function replaceImage(Request $request, $id)
{
    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $image = Image::find($id);
    if (!$image) {
        return response()->json(['error' => 'ไม่พบรูปภาพ'], 404);
    }

    // ลบไฟล์เดิม
    Storage::disk('public')->delete($image->file_path);

    // อัปโหลดไฟล์ใหม่
    $file = $request->file('image');
    $path = $file->store('visit_images', 'public');

    // อัปเดตข้อมูลรูป
    $image->update([
        'file_path' => $path,
        'file_name' => $file->getClientOriginalName(),
        'mime_type' => $file->getClientMimeType(),
        'size'      => $file->getSize(),
    ]);

    return response()->json(['success' => true, 'id' => $image->id, 'url' => asset('storage/'.$path)]);
}

}