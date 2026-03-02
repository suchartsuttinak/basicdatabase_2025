<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Outside;
use Illuminate\Support\Facades\Validator; // ✅ ต้องมีบรรทัดนี้

class OutsideController extends Controller
{
    public function ShowOutside(){
       $outside = Outside::latest()->get();
            return view('backend.outside.outside_show',compact('outside'));
    }
    public function StoreOutside(Request $request){
        // ตรวจสอบชื่อห้ามซ้ำ
        $validator = Validator::make($request->all(), [
            'outside_name' => 'required|unique:outsides,outside_name'
        ], [
            'outside_name.required' => 'กรุณากรอกสาเหตุที่เด็กอาศัยอยู่ภายนอก',
            'outside_name.unique' => 'ชื่อนี้มีอยู่แล้วในระบบ'
        ]);

        // ถ้ามี error → กลับไปพร้อม error message
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        // ถ้าไม่ซ้ำ → บันทึกข้อมูล
        Outside::create([
            'outside_name' => $request->outside_name
        ]);

        $notification = array(
            'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
        }
        //End Method

        public function EditOutside($id)
        {
            $outside = Outside::find($id);
            return response()->json($outside);
        }
        //End Method

         public function UpdateOutside(Request $request)
    {
        $outside_id = $request->outside_id; // ใช้ชื่อให้ตรงกับ hidden input

        $validator = Validator::make($request->all(), [
            'outside_name' => 'required|unique:outsides,outside_name,' . $outside_id,
        ], [
            'outside_name.required' => 'กรุณากรอกสาเหตุที่เด็กอาศัยอยู่ภายนอก',
            'outside_name.unique' => 'ชื่อนี้มีอยู่แล้วในระบบ',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        Outside::findOrFail($outside_id)->update([
            'outside_name' => $request->outside_name,
        ]);

        $notification = [
            'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }
      //End Method
        public function DeleteOutside($id)
            {
                $outside = Outside::find($id);
                $outside->delete();

        return redirect()->back();
            }
            //End Method
}
