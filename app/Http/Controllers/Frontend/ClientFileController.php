<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ClientFile;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientFileController extends Controller
{
    public function index($client_id)
    {
       $client = Client::with('files')->findOrFail($client_id);
    return view('frontend.client.client_files.index', compact('client'));


    }

   public function create($client_id)
{
    $client = Client::findOrFail($client_id);

    // ส่ง array ของประเภทเอกสารไปยัง view
    $fileTypes = [
        'id_card' => 'บัตรประชาชน',
        'house_registration' => 'ทะเบียนบ้าน',
        'education_certificate' => 'วุฒิการศึกษา',
        'birth_certificate' => 'สูติบัตร',
        'other' => 'อื่น ๆ',
    ];

    return view('frontend.client.client_files.create', compact('client', 'fileTypes'));
}

public function store(Request $request, $client_id)
{
    $request->validate([
        'file_type' => 'required|string',
        'file' => 'required|mimes:pdf|max:2048',
    ]);

    $originalName = $request->file('file')->getClientOriginalName();
    $path = $request->file('file')->store("clients/{$client_id}/{$request->file_type}", 'public');

    ClientFile::create([
        'client_id' => $client_id,
        'file_type' => $request->file_type,
        'file_name' => $originalName,
        'file_path' => $path,
        'uploaded_at' => now(),
    ]);

    return redirect()->route('client_files.index', $client_id)
                     ->with('success', 'ไฟล์ถูกบันทึกเรียบร้อยแล้ว');
}

public function destroy($client_id, $fileId)
{
    $file = ClientFile::findOrFail($fileId);
    Storage::disk('public')->delete($file->file_path);
    $file->delete();

    return redirect()->route('client_files.index', $client_id)
                     ->with('success', 'ไฟล์ถูกลบเรียบร้อยแล้ว');
}
}