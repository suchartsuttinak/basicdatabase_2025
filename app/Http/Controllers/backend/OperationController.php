<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Operation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class OperationController extends Controller
{
  /**
     * แสดงรายการ
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Operation::with('user');

        // admin เห็นทั้งหมด / user ทั่วไปเห็นเฉพาะของตนเอง
        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        // ค้นหา
        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);

            $query->where(function ($q) use ($keyword) {
                $q->where('subject', 'like', "%{$keyword}%")
                  ->orWhere('result', 'like', "%{$keyword}%")
                  ->orWhere('remark', 'like', "%{$keyword}%");
            });
        }

        // กรองวันที่
        if ($request->filled('date')) {
            $query->whereDate('operation_date', $request->date);
        }

        $operations = $query
            ->orderByDesc('operation_date')
            ->orderByDesc('sequence_no')
            ->paginate(10)
            ->withQueryString();

        return view('backend.operations.index', compact('operations'));
    }

    /**
     * ฟอร์มเพิ่มข้อมูล
     */
    public function create()
    {
        return view('backend.operations.create');
    }

    /**
     * บันทึกข้อมูล
     */
   public function store(Request $request)
{
    $user = auth()->user();

    $validated = $request->validate([
        'operation_date' => ['required', 'date'],
        'subject'        => ['required', 'string', 'max:500'],
        'result'         => ['nullable', 'string'],
        'remark'         => ['nullable', 'string'],
    ], [
        'operation_date.required' => 'กรุณาระบุวันที่',
        'operation_date.date'     => 'รูปแบบวันที่ไม่ถูกต้อง',
        'subject.required'        => 'กรุณาระบุเรื่องที่ดำเนินงาน',
        'subject.max'             => 'เรื่องที่ดำเนินงานต้องไม่เกิน 500 ตัวอักษร',
    ]);

    $selectedDate = \Carbon\Carbon::parse($validated['operation_date'])->startOfDay();
    $today = now()->startOfDay();
    $yesterday = now()->subDay()->startOfDay();

    // ห้ามเลือกวันอนาคตทุก role
    if ($selectedDate->gt($today)) {
        return back()
            ->withErrors(['operation_date' => 'ไม่สามารถเลือกวันที่เกินกว่าวันปัจจุบันได้'])
            ->withInput();
    }

    // user ทั่วไปย้อนหลังได้ไม่เกิน 1 วัน
    // admin เลือกย้อนหลังได้ทุกวัน
    if (!$user->isAdmin() && $selectedDate->lt($yesterday)) {
        return back()
            ->withErrors(['operation_date' => 'ไม่สามารถบันทึกย้อนหลังเกิน 1 วันได้'])
            ->withInput();
    }

    // รันเลขครั้งที่ตามปีของวันที่ปฏิบัติงาน
    // เช่น ปี 2569/2026 เริ่ม 1,2,3... พอขึ้นปีใหม่เริ่ม 1 ใหม่
    $operationYear = \Carbon\Carbon::parse($validated['operation_date'])->year;

    $lastSequenceNo = Operation::whereYear('operation_date', $operationYear)
        ->max('sequence_no');

    $newSequenceNo = ($lastSequenceNo ?? 0) + 1;

    $operation = Operation::create([
        'user_id'         => $user->id,
        'operation_date'  => $validated['operation_date'],
        'sequence_no'     => $newSequenceNo,
        'subject'         => $validated['subject'],
        'result'          => $validated['result'] ?? null,
        'remark'          => $validated['remark'] ?? null,
    ]);

    $this->reorderSequenceByYear($operationYear);

    return redirect()
        ->route('operations.index')
        ->with('success', 'บันทึกรายงานการปฏิบัติงานเรียบร้อยแล้ว');
}

    /**
     * ฟอร์มแก้ไข
     */
    public function edit($id)
    {
        $operation = Operation::with('user')->findOrFail($id);

        $this->authorizeOperation($operation);

        return view('backend.operations.edit', compact('operation'));
    }

    /**
     * อัปเดตข้อมูล
     */
       public function update(Request $request, $id)
{
    $operation = Operation::findOrFail($id);

    $this->authorizeOperation($operation);

    $user = auth()->user();

    $oldYear = \Carbon\Carbon::parse($operation->operation_date)->year;

    $validated = $request->validate([
        'operation_date' => ['required', 'date'],
        'subject'        => ['required', 'string', 'max:500'],
        'result'         => ['nullable', 'string'],
        'remark'         => ['nullable', 'string'],
    ], [
        'operation_date.required' => 'กรุณาระบุวันที่',
        'operation_date.date'     => 'รูปแบบวันที่ไม่ถูกต้อง',
        'subject.required'        => 'กรุณาระบุเรื่องที่ดำเนินงาน',
        'subject.max'             => 'เรื่องที่ดำเนินงานต้องไม่เกิน 500 ตัวอักษร',
    ]);

    $selectedDate = \Carbon\Carbon::parse($validated['operation_date'])->startOfDay();
    $today = now()->startOfDay();
    $yesterday = now()->subDay()->startOfDay();

    if ($selectedDate->gt($today)) {
        return back()
            ->withErrors(['operation_date' => 'ไม่สามารถเลือกวันที่เกินกว่าวันปัจจุบันได้'])
            ->withInput();
    }

    if (!$user->isAdmin() && $selectedDate->lt($yesterday)) {
        return back()
            ->withErrors(['operation_date' => 'ไม่สามารถบันทึกย้อนหลังเกิน 1 วันได้'])
            ->withInput();
    }

    $operation->update([
        'operation_date' => $validated['operation_date'],
        'subject'        => $validated['subject'],
        'result'         => $validated['result'] ?? null,
        'remark'         => $validated['remark'] ?? null,
    ]);

    $newYear = \Carbon\Carbon::parse($validated['operation_date'])->year;

    $this->reorderSequenceByYear($oldYear);

    if ($newYear !== $oldYear) {
        $this->reorderSequenceByYear($newYear);
    }

    return redirect()
        ->route('operations.index')
        ->with('success', 'อัปเดตรายงานการปฏิบัติงานเรียบร้อยแล้ว');
}
    /**
     * ลบข้อมูล
     */
    public function destroy($id)
    {
        $operation = Operation::findOrFail($id);

        $this->authorizeOperation($operation);

        $operation->delete();

        return redirect()
            ->route('operations.index')
            ->with('success', 'ลบรายการเรียบร้อยแล้ว');
    }

    /**
     * ตรวจสอบสิทธิ์
     */
    private function authorizeOperation(Operation $operation): void
    {
        $user = auth()->user();

        if (!$user->isAdmin() && $operation->user_id !== $user->id) {
            abort(403, 'คุณไม่มีสิทธิ์เข้าถึงข้อมูลนี้');
        }
    }

    /**
 * รายงานการปฏิบัติงานรายวัน
 */
    public function dailyReport(Request $request)
    {
        $authUser = auth()->user();

        $query = Operation::with('user');

        // user ทั่วไปเห็นเฉพาะของตัวเอง
        if (!$authUser->isAdmin()) {
            $query->where('user_id', $authUser->id);
        } else {
            // admin เลือกดูเฉพาะคนได้
            if ($request->filled('user_id')) {
                $query->where('user_id', $request->user_id);
            }
        }

        // กรองช่วงวันที่
        if ($request->filled('start_date')) {
            $query->whereDate('operation_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('operation_date', '<=', $request->end_date);
        }

        // ✅ เรียงให้ถูกต้อง:
        // วันที่ -> ผู้ดำเนินงาน -> ครั้งที่
        $query->join('users', 'operations.user_id', '=', 'users.id')
            ->select('operations.*')
            ->orderByDesc('operations.operation_date')
            ->orderBy('users.name')
            ->orderBy('operations.sequence_no');

        $operations = $query->get();

        // จัดกลุ่มตามวัน
        $groupedOperations = $operations->groupBy(function ($item) {
            return $item->operation_date->format('Y-m-d');
        });

        $users = collect();
        if ($authUser->isAdmin()) {
            $users = \App\Models\User::orderBy('name')->get();
        }

        return view('backend.operations.report_daily', compact('groupedOperations', 'users'));
    }

    private function reorderSequenceByYear(int $year): void
    {
        $items = Operation::whereYear('operation_date', $year)
            ->orderBy('operation_date')
            ->orderBy('id')
            ->get();

        $sequence = 1;

        foreach ($items as $item) {
            $item->update([
                'sequence_no' => $sequence,
            ]);

            $sequence++;
        }
    }

    private function validateOperationDateByRole(string $date): void
    {
        $user = auth()->user();

        $selectedDate = Carbon::parse($date)->startOfDay();
        $today = now()->startOfDay();
        $yesterday = now()->subDay()->startOfDay();

        // ห้ามเลือกวันอนาคตทุก role
        if ($selectedDate->gt($today)) {
            abort(422, 'ไม่สามารถเลือกวันที่เกินกว่าวันปัจจุบันได้');
        }

        // admin เลือกย้อนหลังได้ทุกวัน
        if ($user->isAdmin()) {
            return;
        }

        // user ทั่วไป เลือกได้เฉพาะวันนี้ หรือย้อนหลังได้ไม่เกิน 1 วัน
        if ($selectedDate->lt($yesterday)) {
            abort(422, 'ไม่สามารถบันทึกย้อนหลังเกิน 1 วันได้');
        }
    }
 }