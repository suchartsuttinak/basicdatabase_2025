<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institution;
use Illuminate\Support\Facades\Validator; // ✅ ต้องมีบรรทัดนี้

class InstitutionController extends Controller
{
        public function InstitutionAll(){
            $institution = Institution::latest()->get();
            return view('backend.institution.institution_all',compact('institution'));
        }

        public function InstitutionStore(Request $request){
        // ตรวจสอบชื่อห้ามซ้ำ
        $validator = Validator::make($request->all(), [
            'institution_name' => 'required|unique:institutions,institution_name'
        ], [
            'institution_name.required' => 'กรุณากรอกชื่อสถานศึกษา',
            'institution_name.unique' => 'ชื่อสถานศึกษานี้มีอยู่แล้วในระบบ'
        ]);

        // ถ้ามี error → กลับไปพร้อม error message
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        // ถ้าไม่ซ้ำ → บันทึกข้อมูล
        Institution::create([
            'institution_name' => $request->institution_name
        ]);

        $notification = array(
            'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
        }
        //End Method

        public function EditInstitution($id)
        {
            $institution = Institution::find($id);
            return response()->json($institution);
        }

        public function UpdateInstitution(Request $request)
        {
        // ตรวจสอบชื่อห้ามซ้ำ
        $validator = Validator::make($request->all(), [
            'institution_name' => 'required|unique:institutions,institution_name'
        ], [
            'institution_name.required' => 'กรุณากรอกชื่อสถานศึกษา',
            'institution_name.unique' => 'ชื่อสถานศึกษานี้มีอยู่แล้วในระบบ'
        ]);

        // ถ้ามี error → กลับไปพร้อม error message
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
            // ถ้าไม่ซ้ำ → บันทึกข้อมูล
            $ins_id = $request->ins_id;

            Institution::find($ins_id)->update([
            'institution_name' => $request->institution_name,
            
            ]);
    
        $notification = array(
            'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
        }
        //End Method

        public function DeleteInstitution($id)
        {
         $institution = Institution::find($id);
         $institution->delete();
    
        return redirect()->back();
        }
        //End Method
      }
