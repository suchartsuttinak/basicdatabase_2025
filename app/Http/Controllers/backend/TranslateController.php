<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // ✅ ต้องมีบรรทัดนี้
use App\Models\Translate;

class TranslateController extends Controller
{
    public function ShowTranslate(){
       $translate = Translate::latest()->get();
            return view('backend.translate.translate_show',compact('translate'));
    }
    public function StoreTranslate(Request $request){
        // ตรวจสอบชื่อห้ามซ้ำ
        $validator = Validator::make($request->all(), [
            'translate_name' => 'required|unique:translates,translate_name'
        ], [
            'translate_name.required' => 'กรุณากรอกชื่อวิชาเรียน',
            'translate_name.unique' => 'ชื่อวิชาเรียนนี้มีอยู่แล้วในระบบ'
        ]);

        // ถ้ามี error → กลับไปพร้อม error message
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        // ถ้าไม่ซ้ำ → บันทึกข้อมูล
        Translate::create([
            'translate_name' => $request->translate_name
        ]);

        $notification = array(
            'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
        }
        //End Method

        public function EditTranslate($id)
        {
            $translate = Translate::find($id);
            return response()->json($translate);
        }
        //End Method

         public function UpdateTranslate(Request $request)
    {
        $translate_id = $request->translate_id; // ใช้ชื่อให้ตรงกับ hidden input

        $validator = Validator::make($request->all(), [
            'translate_name' => 'required|unique:translates,translate_name,' . $translate_id,
        ], [
            'translate_name.required' => 'กรุณากรอกชื่อวิชาเรียน',
            'translate_name.unique' => 'ชื่อวิชาเรียนนี้มีอยู่แล้วในระบบ',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        Translate::findOrFail($translate_id)->update([
            'translate_name' => $request->translate_name,
        ]);

        $notification = [
            'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }
      //End Method
        public function DeleteTranslate($id)
            {
                $translate = Translate::find($id);
                $translate->delete();

        return redirect()->back();
            }
            //End Method
}





