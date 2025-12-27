<?php

namespace App\Http\Controllers\backend;

use App\Models\Psycho;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator; // ✅ ต้องมีบรรทัดนี้


class PsychoController extends Controller
{
    public function PsychoShow(){
       $psycho = Psycho::latest()->get();
            return view('backend.psycho.psycho_show',compact('psycho'));
    }
    public function PsychoStore(Request $request){
        // ตรวจสอบชื่อห้ามซ้ำ
        $validator = Validator::make($request->all(), [
            'psycho_name' => 'required|unique:psychos,psycho_name'
        ], [
            'psycho_name.required' => 'กรุณากรอกชื่อโรค',
            'psycho_name.unique' => 'ชื่อวิชาเรียนนี้มีอยู่แล้วในระบบ'
        ]);

        // ถ้ามี error → กลับไปพร้อม error message
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        // ถ้าไม่ซ้ำ → บันทึกข้อมูล
        Psycho::create([
            'psycho_name' => $request->subject_name
        ]);

        $notification = array(
            'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
        }
        //End Method

        public function EditSubject($id)
        {
            $subject = Subject::find($id);
            return response()->json($subject);
        }
        //End Method

         public function UpdateSubject(Request $request)
    {
        $sub_id = $request->sub_id; // ใช้ชื่อให้ตรงกับ hidden input

        $validator = Validator::make($request->all(), [
            'subject_name' => 'required|unique:subjects,subject_name,' . $sub_id,
        ], [
            'subject_name.required' => 'กรุณากรอกชื่อวิชาเรียน',
            'subject_name.unique' => 'ชื่อวิชาเรียนนี้มีอยู่แล้วในระบบ',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        Subject::findOrFail($sub_id)->update([
            'subject_name' => $request->subject_name,
        ]);

        $notification = [
            'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }
      //End Method
        public function DeleteSubject($id)
            {
                $subject = Subject::find($id);
                $subject->delete();
    
        return redirect()->back();
            }
            //End Method
}
