<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HelpType;
use Illuminate\Support\Facades\Validator;

class HelpTypeController extends Controller
{
 public function ShowHelpType(){
       $help = HelpType::latest()->get();
            return view('backend.help_type.help_show',compact('help'));
    }
    public function StoreHelpType(Request $request){
        // ตรวจสอบชื่อห้ามซ้ำ
        $validator = Validator::make($request->all(), [
            'help_name' => 'required|unique:help_types,help_name'
        ], [
            'help_name.required' => 'กรุณากรอกชื่อประเภทความช่วยเหลือ',
            'help_name.unique' => 'ชื่อประเภทความช่วยเหลือนี้มีอยู่แล้วในระบบ'
        ]);

        // ถ้ามี error → กลับไปพร้อม error message
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        // ถ้าไม่ซ้ำ → บันทึกข้อมูล
        HelpType::create([
            'help_name' => $request->help_name
        ]);

        $notification = array(
            'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
        }
        //End Method

        public function EditHelpType($id)
        {
            $help = HelpType::find($id);
            return response()->json($help);
        }
        //End Method

         public function UpdateHelpType(Request $request)
    {
        $help_id = $request->help_id; // ใช้ชื่อให้ตรงกับ hidden input

        $validator = Validator::make($request->all(), [
            'help_name' => 'required|unique:help_types,help_name,' . $help_id,
        ], [
            'help_name.required' => 'กรุณากรอกชื่อประเภทความช่วยเหลือ',
            'help_name.unique' => 'ชื่อประเภทความช่วยเหลือนี้มีอยู่แล้วในระบบ',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        HelpType::findOrFail($help_id)->update([
            'help_name' => $request->help_name,
        ]);

        $notification = [
            'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }
      //End Method
        public function DeleteHelpType($id)
            {
                $help = HelpType::find($id);
                $help->delete();
    
        return redirect()->back();
            }
            //End Method
}
