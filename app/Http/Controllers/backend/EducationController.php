<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Education;
use Illuminate\Support\Facades\Validator;

class EducationController extends Controller
{
   public function ShowEducation(){
       $education = Education::latest()->get();
            return view('backend.education.education_show',compact('education'));
    }
    public function StoreEducation(Request $request){
        // ตรวจสอบชื่อห้ามซ้ำ
        $validator = Validator::make($request->all(), [
            'education_name' => 'required|unique:education,education_name'
        ], [
            'education_name.required' => 'กรุณากรอกระดับการศึกษา',
            'education_name.unique' => 'ชื่อนี้มีอยู่แล้วในระบบ'
        ]);

        // ถ้ามี error → กลับไปพร้อม error message
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        // ถ้าไม่ซ้ำ → บันทึกข้อมูล
        Education::create([
            'education_name' => $request->education_name
        ]);

        $notification = array(
            'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
        }
        //End Method

        public function EditEducation($id)
        {
            $education = Education::find($id);
            return response()->json($education);
        }
        //End Method

         public function UpdateEducation(Request $request)
    {
        $education_id = $request->education_id; // ใช้ชื่อให้ตรงกับ hidden input

        $validator = Validator::make($request->all(), [
            'education_name' => 'required|unique:education,education_name,' . $education_id,
        ], [
            'education_name.required' => 'กรุณากรอกชื่อการศึกษา',
            'education_name.unique' => 'ชื่อนี้มีอยู่แล้วในระบบ',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        Education::findOrFail($education_id)->update([
            'education_name' => $request->education_name,
        ]);

        $notification = [
            'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }
      //End Method
        public function DeleteEducation($id)
            {
                $education = Education::find($id);
                $education->delete();

        return redirect()->back();
            }
            //End Method
}


