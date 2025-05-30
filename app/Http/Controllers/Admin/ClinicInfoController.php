<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClinicInfoRequest;
use App\Services\ClinicInfoService;

class ClinicInfoController extends Controller
{
    protected ClinicInfoService $clinicInfoService;

    public function __construct(ClinicInfoService $clinicInfoService)
    {
        $this->clinicInfoService = $clinicInfoService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->clinicInfoService->getClinicInfoForIndex();

        return view('admin.clinic-info.index', $data);
    }

    public function create()
    {
        $data = $this->clinicInfoService->getClinicInfoFormData();

        return view('admin.clinic-info.create', $data);
    }

    public function storeOrUpdate(ClinicInfoRequest $request)
    {
        $this->clinicInfoService->saveClinicInfo($request->validated());

        return redirect()->route('admin.clinic-info.index')
            ->with('success', 'Información de la clínica guardada exitosamente.');
    }
}
