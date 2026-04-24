<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Refer;
use App\Models\Client;
use App\Models\Translate;
use Illuminate\Support\Str;

class ReferController extends Controller
{
    /**
     * แสดงตาราง refer ของ client ที่เลือก
     */
    public function index($client_id)
    {
        // =========================
        // PATCH: กันเดา URL เข้าถึง client ที่ไม่มีสิทธิ์
        // =========================
        $client = Client::forUser(auth()->user())->findOrFail($client_id);

        $translates = Translate::all();
        $refers = Refer::with(['client', 'translate'])
            ->where('client_id', $client_id)
            ->latest()
            ->get();

        return view('frontend.client.refer.refer_index', compact('translates', 'refers', 'client'));
    }

    /**
     * บันทึกข้อมูล refer ใหม่
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'refer_date'          => 'required|date',
            'translate_id'        => 'required|exists:translates,id',
            'destination'         => 'nullable|string',
            'address'             => 'nullable|string',
            'guardian'            => 'required|in:มี,ไม่มี',
            'parent_name'         => 'nullable|string',
            'parent_tel'          => 'nullable|string',
            'member'              => 'nullable|string',
            'teacher'             => 'required|string',
            'committee_result'    => 'required|in:ผ่าน,ไม่ผ่าน',
            'meeting_report_file' => 'nullable|file|mimes:pdf|max:10240',
            'remark'              => 'nullable|string',
            'client_id'           => 'required|exists:clients,id',
        ], [
            'refer_date.required'          => 'กรุณาระบุวันที่ส่งต่อ',
            'refer_date.date'              => 'รูปแบบวันที่ไม่ถูกต้อง',
            'translate_id.required'        => 'กรุณาเลือกการแปล',
            'translate_id.exists'          => 'ข้อมูลการแปลไม่ถูกต้อง',
            'guardian.required'            => 'กรุณาเลือกว่ามีผู้ปกครองหรือไม่',
            'guardian.in'                  => 'ค่าที่เลือกไม่ถูกต้อง',
            'teacher.required'             => 'กรุณาระบุชื่อผู้นำส่ง',
            'committee_result.required'    => 'กรุณาเลือกผลคณะกรรมการฯ',
            'committee_result.in'          => 'ค่าผลคณะกรรมการฯ ไม่ถูกต้อง',
            'meeting_report_file.file'     => 'ไฟล์แนบรายงานการประชุมไม่ถูกต้อง',
            'meeting_report_file.mimes'    => 'แนบรายงานการประชุมได้เฉพาะไฟล์ PDF เท่านั้น',
            'meeting_report_file.max'      => 'ไฟล์ PDF ต้องมีขนาดไม่เกิน 10 MB',
            'client_id.required'           => 'กรุณาเลือกผู้รับบริการ',
            'client_id.exists'             => 'ข้อมูลผู้รับบริการไม่ถูกต้อง',
        ]);

        // =========================
        // PATCH: กันยิง request เปลี่ยน client_id
        // =========================
        $client = Client::forUser(auth()->user())->findOrFail($validated['client_id']);

        // =========================
        // PATCH: ถ้าเลือก "ผ่าน" ต้องแนบไฟล์รายงานการประชุม
        // =========================
        if (($validated['committee_result'] ?? 'ไม่ผ่าน') === 'ผ่าน' && !$request->hasFile('meeting_report_file')) {
            return redirect()->back()
                ->withErrors(['meeting_report_file' => 'กรณีคณะกรรมการฯ มีมติ "ผ่าน" กรุณาแนบรายงานการประชุม (PDF)'])
                ->withInput();
        }

        // =========================
        // PATCH: ตรวจว่า user ปัจจุบันมีสิทธิ์อนุมัติได้ทันทีหรือไม่
        // admin / executive บันทึกแล้วให้อนุมัติทันที
        // =========================
        $canAutoApprove = auth()->check() && in_array(auth()->user()->role, ['admin', 'executive']);

        // =========================
        // PATCH: กันสร้าง refer ซ้ำตามสถานะที่เกี่ยวข้อง
        // - ถ้าเป็น admin/executive กันซ้ำรายการ approved
        // - ถ้าเป็น role อื่น กันซ้ำรายการ pending
        // =========================
        $duplicateRefer = Refer::where('client_id', $client->id)
            ->where('approve_status', $canAutoApprove ? 'approved' : 'pending')
            ->latest()
            ->first();

        if ($duplicateRefer) {
            return redirect()->route('refers.index', $client->id)->with([
                'message'    => $canAutoApprove
                    ? 'มีรายการจำหน่ายที่อนุมัติแล้วอยู่แล้ว ไม่สามารถบันทึกซ้ำได้'
                    : 'มีรายการจำหน่ายรออนุมัติอยู่แล้ว ไม่สามารถบันทึกซ้ำได้',
                'alert-type' => 'warning',
            ]);
        }

        // =========================
        // PATCH: อัปโหลดไฟล์ PDF เมื่อเลือกผ่าน
        // =========================
        if ($request->hasFile('meeting_report_file')) {
            $file = $request->file('meeting_report_file');
            $filename = 'refer_meeting_' . $client->id . '_' . now()->format('Ymd_His') . '_' . Str::random(8) . '.pdf';

            $destinationPath = public_path('uploads/refer_meeting_reports');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $file->move($destinationPath, $filename);
            $validated['meeting_report_file'] = $filename;
        } else {
            $validated['meeting_report_file'] = null;
        }

        // =========================
        // PATCH: ถ้าเป็น admin / executive ให้อนุมัติทันที
        // ถ้าไม่ใช่ ให้ส่งรออนุมัติตาม flow เดิม
        // =========================
        if ($canAutoApprove) {
            $validated['approve_status'] = 'approved';
            $validated['created_by'] = auth()->id();
            $validated['approved_by'] = auth()->id();
            $validated['approved_at'] = now();
        } else {
            $validated['approve_status'] = 'pending';
            $validated['created_by'] = auth()->id();
            $validated['approved_by'] = null;
            $validated['approved_at'] = null;
        }

        // ✅ บันทึก refer
        Refer::create($validated);

        // =========================
        // PATCH: เปลี่ยนสถานะ client ตามสิทธิ์ผู้บันทึก
        // - admin / executive = refer ทันที
        // - role อื่น = pending_refer
        // =========================
        $client->update([
            'release_status' => $canAutoApprove ? 'refer' : 'pending_refer'
        ]);

        return redirect()->route('refers.index', $client->id)->with([
            'message'    => $canAutoApprove
                ? 'บันทึกและอนุมัติการจำหน่ายเรียบร้อยแล้ว'
                : 'บันทึกการจำหน่ายเรียบร้อยแล้ว และส่งรออนุมัติแล้ว',
            'alert-type' => 'success',
        ]);
    }

    /**
     * อนุมัติการจำหน่าย
     */
    public function approve($id)
    {
        $refer = Refer::with('client')->findOrFail($id);

        if (!$refer->client) {
            return $this->errorResponse('ไม่พบข้อมูล client ที่เกี่ยวข้อง', 404);
        }

        // =========================
        // PATCH: กันเดา URL client ที่ไม่มีสิทธิ์
        // =========================
        $client = Client::forUser(auth()->user())->findOrFail($refer->client_id);

        // =========================
        // PATCH: จำกัดสิทธิ์อนุมัติ เฉพาะ admin / executive
        // =========================
        abort_unless(
            auth()->check() && in_array(auth()->user()->role, ['admin', 'executive']),
            403,
            'คุณไม่มีสิทธิ์อนุมัติการจำหน่าย'
        );

        // =========================
        // PATCH: ถ้าอนุมัติแล้ว ไม่ต้องอนุมัติซ้ำ
        // =========================
        if (($refer->approve_status ?? null) === 'approved') {
            return redirect()->route('refers.index', $client->id)->with([
                'message'    => 'รายการนี้ถูกอนุมัติแล้ว',
                'alert-type' => 'warning',
            ]);
        }

        // =========================
        // PATCH: ถ้ารายการนี้ไม่ใช่สถานะ pending
        // ให้กันไว้ก่อนเพื่อไม่ให้ flow เพี้ยน
        // =========================
        if (($refer->approve_status ?? 'pending') !== 'pending') {
            return redirect()->route('refers.index', $client->id)->with([
                'message'    => 'ไม่สามารถอนุมัติรายการนี้ได้',
                'alert-type' => 'warning',
            ]);
        }

        // =========================
        // PATCH: อนุมัติ refer
        // =========================
        $refer->update([
            'approve_status' => 'approved',
            'approved_by'    => auth()->id(),
            'approved_at'    => now(),
        ]);

        // =========================
        // PATCH: ค่อยเอา client ออกจากระบบตอน "อนุมัติ" เท่านั้น
        // =========================
        $client->update([
            'release_status' => 'refer'
        ]);

        return redirect()->route('refers.index', $client->id)->with([
            'message'    => 'อนุมัติการจำหน่ายเรียบร้อยแล้ว',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Restore สถานะ client กลับเป็น show
     */
    public function restore($id)
    {
        $refer = Refer::with('client')->findOrFail($id);

        if (!$refer->client) {
            return $this->errorResponse('ไม่พบข้อมูล client ที่เกี่ยวข้อง', 404);
        }

        // =========================
        // PATCH: กันเดา URL มา restore สถานะของ client ที่ไม่มีสิทธิ์
        // =========================
        $client = Client::forUser(auth()->user())->findOrFail($refer->client_id);

        // =========================
        // PATCH: จำกัดสิทธิ์คืนสถานะ เฉพาะ admin / executive
        // =========================
        abort_unless(
            auth()->check() && in_array(auth()->user()->role, ['admin', 'executive']),
            403,
            'คุณไม่มีสิทธิ์คืนสถานะ'
        );

        // ✅ ถ้า client มีสถานะ show อยู่แล้ว
        if ($client->release_status === 'show') {
            return $this->errorResponse('ผู้รับรายนี้มีสถานะอยู่แล้ว', 400, 'warning');
        }

        // =========================
        // PATCH: คืนสถานะ refer record ด้วย
        // ใช้ cancelled เพื่อกันไม่ให้รายการนี้กลับไปเป็น pending/approved
        // =========================
        $refer->update([
            'approve_status' => 'cancelled',
            'approved_by'    => null,
            'approved_at'    => null,
        ]);

        // =========================
        // PATCH: คืนสถานะ client กลับเข้าอยู่ในระบบ
        // =========================
        $client->update([
            'release_status' => 'show'
        ]);

        if (request()->ajax()) {
            return response()->json(['message' => 'Restore สำเร็จ']);
        }

        return redirect()->route('client.show', $refer->client_id)->with([
            'message'    => 'คืนค่าสถานะ ' . $client->fullname . ' เรียบร้อยแล้ว',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Helper สำหรับ error response
     */
    private function errorResponse($message, $status = 400, $alertType = 'error')
    {
        if (request()->ajax()) {
            return response()->json(['message' => $message], $status);
        }

        return back()->with([
            'message'    => $message,
            'alert-type' => $alertType
        ]);
    }

    public function report($client_id)
    {
        // =========================
        // PATCH: กันเดา URL เข้าถึง client ที่ไม่มีสิทธิ์
        // =========================
        $client = Client::forUser(auth()->user())->findOrFail($client_id);

        $refers = Refer::with(['client', 'translate'])
            ->where('client_id', $client_id)
            ->latest('refer_date')
            ->latest('id')
            ->get();

        return view('frontend.client.refer.refer_report', compact('client', 'refers'));
    }

    public function allRefers(Request $request)
{
    abort_unless(
        auth()->check() && in_array(auth()->user()->role, ['admin', 'executive']),
        403,
        'คุณไม่มีสิทธิ์เข้าถึงตารางการจำหน่ายรวม'
    );

    $query = Refer::with(['client', 'translate'])
        ->latest('refer_date')
        ->latest('id');

    // filter: วันที่เริ่มต้น
    if ($request->filled('date_from')) {
        $query->whereDate('refer_date', '>=', $request->date_from);
    }

    // filter: วันที่สิ้นสุด
    if ($request->filled('date_to')) {
        $query->whereDate('refer_date', '<=', $request->date_to);
    }

    // filter: ปี
    if ($request->filled('year')) {
        $query->whereYear('refer_date', $request->year);
    }

    // filter: เดือน
    if ($request->filled('month')) {
        $query->whereMonth('refer_date', $request->month);
    }

    // filter: สถานะอนุมัติ
    if ($request->filled('approve_status')) {
        $query->where('approve_status', $request->approve_status);
    }

    // filter: ผลคณะกรรมการ
    if ($request->filled('committee_result')) {
        $query->where('committee_result', $request->committee_result);
    }

    // filter: keyword
    if ($request->filled('keyword')) {
        $keyword = trim($request->keyword);

        $query->where(function ($q) use ($keyword) {
            $q->where('destination', 'like', "%{$keyword}%")
              ->orWhere('teacher', 'like', "%{$keyword}%")
              ->orWhere('parent_name', 'like', "%{$keyword}%")
              ->orWhere('parent_tel', 'like', "%{$keyword}%")
              ->orWhere('member', 'like', "%{$keyword}%")
              ->orWhere('remark', 'like', "%{$keyword}%")
              ->orWhereHas('client', function ($sub) use ($keyword) {
                  $sub->where('first_name', 'like', "%{$keyword}%")
                      ->orWhere('last_name', 'like', "%{$keyword}%")
                      ->orWhereRaw("CONCAT(COALESCE(first_name,''), ' ', COALESCE(last_name,'')) LIKE ?", ["%{$keyword}%"])
                      ->orWhere('id', $keyword);
              })
              ->orWhereHas('translate', function ($sub) use ($keyword) {
                  $sub->where('translate_name', 'like', "%{$keyword}%");
              });
        });
    }

    $refers = $query->paginate(20)->withQueryString();

    $summaryQuery = Refer::query();

    if ($request->filled('date_from')) {
        $summaryQuery->whereDate('refer_date', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        $summaryQuery->whereDate('refer_date', '<=', $request->date_to);
    }

    if ($request->filled('year')) {
        $summaryQuery->whereYear('refer_date', $request->year);
    }

    if ($request->filled('month')) {
        $summaryQuery->whereMonth('refer_date', $request->month);
    }

    if ($request->filled('approve_status')) {
        $summaryQuery->where('approve_status', $request->approve_status);
    }

    if ($request->filled('committee_result')) {
        $summaryQuery->where('committee_result', $request->committee_result);
    }

    if ($request->filled('keyword')) {
        $keyword = trim($request->keyword);

        $summaryQuery->where(function ($q) use ($keyword) {
            $q->where('destination', 'like', "%{$keyword}%")
              ->orWhere('teacher', 'like', "%{$keyword}%")
              ->orWhere('parent_name', 'like', "%{$keyword}%")
              ->orWhere('parent_tel', 'like', "%{$keyword}%")
              ->orWhere('member', 'like', "%{$keyword}%")
              ->orWhere('remark', 'like', "%{$keyword}%")
              ->orWhereHas('client', function ($sub) use ($keyword) {
                  $sub->where('first_name', 'like', "%{$keyword}%")
                      ->orWhere('last_name', 'like', "%{$keyword}%")
                      ->orWhereRaw("CONCAT(COALESCE(first_name,''), ' ', COALESCE(last_name,'')) LIKE ?", ["%{$keyword}%"])
                      ->orWhere('id', $keyword);
              })
              ->orWhereHas('translate', function ($sub) use ($keyword) {
                  $sub->where('translate_name', 'like', "%{$keyword}%");
              });
        });
    }

    $summary = [
        'total'     => (clone $summaryQuery)->count(),
        'approved'  => (clone $summaryQuery)->where('approve_status', 'approved')->count(),
        'pending'   => (clone $summaryQuery)->where('approve_status', 'pending')->count(),
        'cancelled' => (clone $summaryQuery)->where('approve_status', 'cancelled')->count(),
    ];

    return view('frontend.client.refer.refer_all', compact('refers', 'summary'));
}
}