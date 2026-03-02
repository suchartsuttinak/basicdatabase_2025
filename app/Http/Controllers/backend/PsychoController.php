<?php

namespace App\Http\Controllers\backend;

use App\Models\Psycho;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator; // ✅ ต้องมีบรรทัดนี้


class PsychoController extends Controller
{
    public function ShowPsycho(){
       $psycho = Psycho::latest()->get();
            return view('backend.psycho.psycho_show',compact('psycho'));
    }
    public function StorePsycho(Request $request){
        // ตรวจสอบชื่อห้ามซ้ำ
        $validator = Validator::make($request->all(), [
            'psycho_name' => 'required|unique:psychos,psycho_name'
        ], [
            'psycho_name.required' => 'กรุณากรอกชื่อโรคทางจิตเวช',
            'psycho_name.unique' => 'ชื่อนี้มีอยู่แล้วในระบบ'
        ]);

        // ถ้ามี error → กลับไปพร้อม error message
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        // ถ้าไม่ซ้ำ → บันทึกข้อมูล
        Psycho::create([
            'psycho_name' => $request->psycho_name
        ]);

        $notification = array(
            'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
        }
        //End Method

        public function EditPsycho($id)
        {
            $psycho = Psycho::find($id);
            return response()->json($psycho);
        }
        //End Method

         public function UpdatePsycho(Request $request)
    {
        $psycho_id = $request->psycho_id; // ใช้ชื่อให้ตรงกับ hidden input

        $validator = Validator::make($request->all(), [
            'psycho_name' => 'required|unique:psychos,psycho_name,' . $psycho_id,
        ], [
            'psycho_name.required' => 'กรุณากรอกชื่อโรคทางจิตเวช',
            'psycho_name.unique' => 'ชื่อนี้มีอยู่แล้วในระบบ',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        Psycho::findOrFail($psycho_id)->update([
            'psycho_name' => $request->psycho_name,
        ]);

        $notification = [
            'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }
      //End Method
        public function DeletePsycho($id)
            {
                $psycho = Psycho::find($id);
                $psycho->delete();
    
        return redirect()->back();
            }
            //End Method
}
