<?php

namespace App\Http\Controllers\backend;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Misbehavior;

class MisbehaviorController extends Controller
{
   public function ShowMisbehavior(){
       $misbehavior = Misbehavior::latest()->get();
            return view('backend.misbehavior.misbehavior_all',compact('misbehavior'));
    }
    public function StoreMisbehavior(Request $request){
        // ตรวจสอบชื่อห้ามซ้ำ
        $validator = Validator::make($request->all(), [
            'misbehavior_name' => 'required|unique:misbehaviors,misbehavior_name'
        ], [
            'misbehavior_name.required' => 'กรุณากรอกชื่อพฤติกรรม',
            'misbehavior_name.unique' => 'ชื่อนี้มีอยู่แล้วในระบบ'
        ]);

        // ถ้ามี error → กลับไปพร้อม error message
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        // ถ้าไม่ซ้ำ → บันทึกข้อมูล
        Misbehavior::create([
            'misbehavior_name' => $request->misbehavior_name
        ]);

        $notification = array(
            'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
        }
        //End Method

        public function EditMisbehavior($id)
        {
            $misbehavior = Misbehavior::find($id);
            return response()->json($misbehavior);
        }
        //End Method

         public function UpdateMisbehavior(Request $request)
    {
        $mis_id = $request->mis_id; // ใช้ชื่อให้ตรงกับ hidden input

        $validator = Validator::make($request->all(), [
            'misbehavior_name' => 'required|unique:misbehaviors,misbehavior_name,' . $mis_id,
        ], [
            'misbehavior_name.required' => 'กรุณากรอกชื่อพฤติกรรม',
            'misbehavior_name.unique' => 'ชื่อนี้มีอยู่แล้วในระบบ',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        Misbehavior::findOrFail($mis_id)->update([
            'misbehavior_name' => $request->misbehavior_name,
        ]);

        $notification = [
            'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }
      //End Method
        public function DeleteMisbehavior($id)
            {
                $misbehavior = Misbehavior::find($id);
                $misbehavior->delete();
    
        return redirect()->back();
            }
            //End Method
}





