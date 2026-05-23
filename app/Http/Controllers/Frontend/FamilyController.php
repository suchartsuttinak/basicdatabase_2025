<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Province;
use App\Models\District;
use App\Models\SubDistrict;
use App\Models\Father;
use App\Models\Mother;
use App\Models\Spouse;
use App\Models\Relative;
use Illuminate\Validation\ValidationException;
use Throwable;
use App\Models\CaseActivity;

class FamilyController extends Controller
{
    public function FamilyAdd($client_id)
    {
        // ✅ [แก้ไข] กันการเดา URL เข้า client ของคนอื่น
        $client = Client::forUser(auth()->user())->findOrFail($client_id);

        // ❗ ของเดิมคงไว้ทั้งหมด
        $father   = Father::where('client_id', $client->id)->first(); // ✅ เปลี่ยน $client_id → $client->id
        $mother   = Mother::where('client_id', $client->id)->first();
        $spouse   = Spouse::where('client_id', $client->id)->first();
        $relative = Relative::where('client_id', $client->id)->first();

        $provinces     = Province::all();
        $districts     = District::all();
        $sub_districts = SubDistrict::all();

        return view('frontend.client.family.family_add', compact(
            'client',
            'father',
            'mother',
            'spouse',
            'relative',
            'provinces',
            'districts',
            'sub_districts'
        ));
    }

    public function getDistricts($province_id)
    {
        return response()->json(
            District::where('province_id', $province_id)->get(['id', 'dist_name'])
        );
    }

    public function getSubdistricts($district_id)
    {
        return response()->json(
            SubDistrict::where('district_id', $district_id)->get(['id', 'subd_name'])
        );
    }

    public function getZipcode($subdistrict_id)
    {
        $subdistrict = SubDistrict::find($subdistrict_id);

        return response()->json([
            'zipcode' => $subdistrict ? $subdistrict->zipcode : null
        ]);
    }

        public function FamilyStore(Request $request)
        {
            try {
                $validated = $request->validate([
                    'client_id' => ['required', 'integer', 'exists:clients,id'],
                    'active_tab' => ['nullable', 'string', 'max:50'],

                    'father.fname' => ['nullable', 'string', 'max:255'],
                    'father.lname' => ['nullable', 'string', 'max:255'],
                    'father.idcard' => ['nullable', 'regex:/^[0-9]{1}-[0-9]{4}-[0-9]{5}-[0-9]{2}-[0-9]{1}$/'],
                    'father.age' => ['nullable', 'integer', 'min:0'],
                    'father.occupation' => ['nullable', 'string', 'max:255'],
                    'father.income' => ['nullable'],
                    'father.address_no' => ['nullable', 'string', 'max:255'],
                    'father.moo' => ['nullable', 'string', 'max:255'],
                    'father.soi' => ['nullable', 'string', 'max:255'],
                    'father.road' => ['nullable', 'string', 'max:255'],
                    'father.village' => ['nullable', 'string', 'max:255'],
                    'father.province_id' => ['nullable', 'integer'],
                    'father.district_id' => ['nullable', 'integer'],
                    'father.sub_district_id' => ['nullable', 'integer'],
                    'father.zipcode' => ['nullable', 'string', 'max:20'],
                    'father.phone' => ['nullable', 'string', 'max:20'],

                    'mother.fname' => ['nullable', 'string', 'max:255'],
                    'mother.lname' => ['nullable', 'string', 'max:255'],
                    'mother.idcard' => ['nullable', 'regex:/^[0-9]{1}-[0-9]{4}-[0-9]{5}-[0-9]{2}-[0-9]{1}$/'],
                    'mother.age' => ['nullable', 'integer', 'min:0'],
                    'mother.occupation' => ['nullable', 'string', 'max:255'],
                    'mother.income' => ['nullable'],
                    'mother.address_no' => ['nullable', 'string', 'max:255'],
                    'mother.moo' => ['nullable', 'string', 'max:255'],
                    'mother.soi' => ['nullable', 'string', 'max:255'],
                    'mother.road' => ['nullable', 'string', 'max:255'],
                    'mother.village' => ['nullable', 'string', 'max:255'],
                    'mother.province_id' => ['nullable', 'integer'],
                    'mother.district_id' => ['nullable', 'integer'],
                    'mother.sub_district_id' => ['nullable', 'integer'],
                    'mother.zipcode' => ['nullable', 'string', 'max:20'],
                    'mother.phone' => ['nullable', 'string', 'max:20'],

                    'spouse.fname' => ['nullable', 'string', 'max:255'],
                    'spouse.lname' => ['nullable', 'string', 'max:255'],
                    'spouse.idcard' => ['nullable', 'regex:/^[0-9]{1}-[0-9]{4}-[0-9]{5}-[0-9]{2}-[0-9]{1}$/'],
                    'spouse.age' => ['nullable', 'integer', 'min:0'],
                    'spouse.occupation' => ['nullable', 'string', 'max:255'],
                    'spouse.income' => ['nullable'],
                    'spouse.address_no' => ['nullable', 'string', 'max:255'],
                    'spouse.moo' => ['nullable', 'string', 'max:255'],
                    'spouse.soi' => ['nullable', 'string', 'max:255'],
                    'spouse.road' => ['nullable', 'string', 'max:255'],
                    'spouse.village' => ['nullable', 'string', 'max:255'],
                    'spouse.province_id' => ['nullable', 'integer'],
                    'spouse.district_id' => ['nullable', 'integer'],
                    'spouse.sub_district_id' => ['nullable', 'integer'],
                    'spouse.zipcode' => ['nullable', 'string', 'max:20'],
                    'spouse.phone' => ['nullable', 'string', 'max:20'],

                    'relative.fname' => ['nullable', 'string', 'max:255'],
                    'relative.lname' => ['nullable', 'string', 'max:255'],
                    'relative.idcard' => ['nullable', 'regex:/^[0-9]{1}-[0-9]{4}-[0-9]{5}-[0-9]{2}-[0-9]{1}$/'],
                    'relative.age' => ['nullable', 'integer', 'min:0'],
                    'relative.occupation' => ['nullable', 'string', 'max:255'],
                    'relative.income' => ['nullable'],
                    'relative.address_no' => ['nullable', 'string', 'max:255'],
                    'relative.moo' => ['nullable', 'string', 'max:255'],
                    'relative.soi' => ['nullable', 'string', 'max:255'],
                    'relative.road' => ['nullable', 'string', 'max:255'],
                    'relative.village' => ['nullable', 'string', 'max:255'],
                    'relative.province_id' => ['nullable', 'integer'],
                    'relative.district_id' => ['nullable', 'integer'],
                    'relative.sub_district_id' => ['nullable', 'integer'],
                    'relative.zipcode' => ['nullable', 'string', 'max:20'],
                    'relative.phone' => ['nullable', 'string', 'max:20'],
                ]);

                $client = Client::forUser(auth()->user())
                    ->where('id', $validated['client_id'])
                    ->firstOrFail();

                $clientId = $client->id;
                $activeTab = $validated['active_tab'] ?? 'father-tab';

                $this->saveFamilyGroup(Father::class, $clientId, $validated['father'] ?? []);
                $this->saveFamilyGroup(Mother::class, $clientId, $validated['mother'] ?? []);
                $this->saveFamilyGroup(Spouse::class, $clientId, $validated['spouse'] ?? []);
                $this->saveFamilyGroup(Relative::class, $clientId, $validated['relative'] ?? []);

                CaseActivity::where('client_id', $client->id)
                    ->where('module', 'family')
                    ->delete();

                CaseActivity::record([
                    'client_id'   => $client->id,
                    'module'      => 'family',
                    'type'        => 'success',
                    'title'       => 'บันทึกข้อมูลครอบครัว',
                    'description' => 'มีการบันทึกหรือปรับปรุงข้อมูลครอบครัวของผู้รับบริการ',
                    'occurred_at' => now(),
                    'icon'        => 'bi-people',
                    'url'         => url('/client/family/add/' . $client->id),
                ]);

                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'บันทึกข้อมูลครอบครัวเรียบร้อยแล้ว',
                        'active_tab' => $activeTab,
                    ]);
                }

                return redirect()
                    ->back()
                    ->with('success', 'บันทึกข้อมูลครอบครัวเรียบร้อยแล้ว')
                    ->with('active_tab', $activeTab);

            } catch (ValidationException $e) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'กรุณาตรวจสอบข้อมูลที่กรอกอีกครั้ง',
                        'errors' => $e->errors(),
                        'active_tab' => $request->input('active_tab', 'father-tab'),
                    ], 422);
                }

                throw $e;
            } catch (Throwable $e) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $e->getMessage(),
                        'active_tab' => $request->input('active_tab', 'father-tab'),
                    ], 500);
                }

                return redirect()
                    ->back()
                    ->with('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $e->getMessage())
                    ->with('active_tab', $request->input('active_tab', 'father-tab'));
            }
        }
    private function saveFamilyGroup(string $modelClass, int $clientId, array $data): void
    {
        $payload = $this->normalizeFamilyPayload($data);

        $hasAnyValue = collect($payload)->filter(function ($value) {
            return $value !== null && $value !== '';
        })->isNotEmpty();

        if (!$hasAnyValue) {
            return;
        }

        $modelClass::updateOrCreate(
            ['client_id' => $clientId],
            $payload
        );
    }

    private function normalizeFamilyPayload(array $data): array
    {
        return [
            'fname' => $data['fname'] ?? null,
            'lname' => $data['lname'] ?? null,
            'idcard' => $data['idcard'] ?? null,
            'age' => $data['age'] ?? null,
            'occupation' => $data['occupation'] ?? null,

           'income' => isset($data['income'])
            ? preg_replace('/[^0-9.]/', '', (string) $data['income'])
            : null,
            
            'address_no' => $data['address_no'] ?? null,
            'moo' => $data['moo'] ?? null,
            'soi' => $data['soi'] ?? null,
            'road' => $data['road'] ?? null,
            'village' => $data['village'] ?? null,
            'province_id' => $data['province_id'] ?? null,
            'district_id' => $data['district_id'] ?? null,
            'sub_district_id' => $data['sub_district_id'] ?? null,
            'zipcode' => $data['zipcode'] ?? null,
            'phone' => $data['phone'] ?? null,
        ];
    }
}