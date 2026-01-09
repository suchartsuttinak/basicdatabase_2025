<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
       public function ShowDocument(){
       $document = Document::latest()->get();
            return view('backend.document.document_show',compact('document'));
    }
    public function StoreDocument(Request $request){
        // ตรวจสอบชื่อห้ามซ้ำ
        $validator = Validator::make($request->all(), [
            'document_name' => 'required|unique:documents,document_name'
        ], [
            'document_name.required' => 'กรุณากรอกชื่อเอกสาร',
            'document_name.unique' => 'ชื่อนี้มีอยู่แล้วในระบบ'
        ]);

        // ถ้ามี error → กลับไปพร้อม error message
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        // ถ้าไม่ซ้ำ → บันทึกข้อมูล
        Document::create([
            'document_name' => $request->document_name
        ]);

        $notification = array(
            'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
        }
        //End Method

        public function EditDocument($id)
        {
            $document = Document::find($id);
            return response()->json($document);
        }
        //End Method

         public function UpdateDocument(Request $request)
    {
        $document_id = $request->document_id; // ใช้ชื่อให้ตรงกับ hidden input

        $validator = Validator::make($request->all(), [
            'document_name' => 'required|unique:documents,document_name,' . $document_id,
        ], [
            'document_name.required' => 'กรุณากรอกชื่อเอกสาร',
            'document_name.unique' => 'ชื่อนี้มีอยู่แล้วในระบบ',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        Document::findOrFail($document_id)->update([
            'document_name' => $request->document_name,
        ]);

        $notification = [
            'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }
      //End Method
        public function DeleteDocument($id)
            {
                $document = Document::find($id);
                $document->delete();

        return redirect()->back();
            }
            //End Method
}


