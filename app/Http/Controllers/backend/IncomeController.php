<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Income;
use Illuminate\Support\Facades\Validator;

class IncomeController extends Controller
{
   public function ShowIncome(){
       $income = Income::latest()->get();
            return view('backend.income.income_show',compact('income'));
    }
    public function StoreIncome(Request $request){
        // ตรวจสอบชื่อห้ามซ้ำ
        $validator = Validator::make($request->all(), [
            'income_name' => 'required|unique:incomes,income_name'
        ], [
            'income_name.required' => 'กรุณากรอกชื่อรายได้',
            'income_name.unique' => 'ชื่อนี้มีอยู่แล้วในระบบ'
        ]);

        // ถ้ามี error → กลับไปพร้อม error message
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        // ถ้าไม่ซ้ำ → บันทึกข้อมูล
        Income::create([
            'income_name' => $request->income_name
        ]);

        $notification = array(
            'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
        }
        //End Method

        public function EditIncome($id)
        {
            $income = Income::find($id);
            return response()->json($income);
        }
        //End Method

         public function UpdateIncome(Request $request)
    {
        $income_id = $request->income_id; // ใช้ชื่อให้ตรงกับ hidden input

        $validator = Validator::make($request->all(), [
            'income_name' => 'required|unique:incomes,income_name,' . $income_id,
        ], [
            'income_name.required' => 'กรุณากรอกชื่อรายได้',
            'income_name.unique' => 'ชื่อนี้มีอยู่แล้วในระบบ',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        Income::findOrFail($income_id)->update([
            'income_name' => $request->income_name,
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


