<?php

namespace App\Http\Controllers\expenses_reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\expenses_reports\Expense;
use App\Models\expenses_reports\AdvanceRequest;
use App\Models\expenses_reports\CostCenter;
use App\Models\expenses_reports\Department;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdvanceRequestController extends Controller
{
    public function listAdvanceRequest(){
        $userAuth = Auth::user();
        if($userAuth->user_type_id === 1){
            $advanceRequest = DB::table('advance_requests')
            ->join('expenses', 'expenses.advanceRequest_id', '=', 'advance_requests.id')
            ->join('users', 'users.id', '=', 'expenses.user_id')
            ->leftJoin('departments', 'departments.id', '=', 'expenses.department_id')
            ->leftJoin('cost_centers', 'cost_centers.id', '=', 'expenses.cc_id')
            ->select(
                "advance_requests.id",
                "advance_requests.reference",
                "advance_requests.depositDate",
                "advance_requests.coment",
                "advance_requests.created_at as requestDate",
                "advance_requests.status",
                "expenses.destinyFrom",
                "expenses.destinyTo",
                "expenses.endingDate",
                "expenses.payAdvance",
                "expenses.purposeTravel",
                "advance_requests.approveBy",
                "users.emp",
                "cost_centers.cc",
                "cost_centers.name",
                "users.nombre",
                "users.apellido_paterno",
                "users.apellido_materno",
                "departments.department",
                DB::raw("CONCAT(users.nombre, ' ', users.apellido_paterno, ' ', COALESCE(users.apellido_materno, '')) as nombre_completo"),
                DB::raw("
                    CASE advance_requests.status
                        WHEN 0 THEN 'Proceso'
                        ELSE 'Aprobado'
                    END as status_text
                ")
            )
            ->get();
        }else{
            $advanceRequest = DB::table('advance_requests')
            ->join('expenses', 'expenses.advanceRequest_id', '=', 'advance_requests.id')
            ->join('users', 'users.id', '=', 'expenses.user_id')
            ->leftJoin('departments', 'departments.id', '=', 'expenses.department_id')
            ->leftJoin('cost_centers', 'cost_centers.id', '=', 'expenses.cc_id')
            ->select(
                "advance_requests.id",
                "advance_requests.reference",
                "advance_requests.depositDate",
                "advance_requests.coment",
                "advance_requests.created_at as requestDate",
                "advance_requests.status",
                "expenses.destinyFrom",
                "expenses.destinyTo",
                "expenses.purposeTravel",
                "advance_requests.approveBy",
                "expenses.endingDate",
                "expenses.payAdvance",
                "users.emp",
                "users.nombre",
                "users.apellido_paterno",
                "users.apellido_materno",
                "cost_centers.cc",
                "cost_centers.name",
                "departments.department",
                DB::raw("CONCAT(users.nombre, ' ', users.apellido_paterno, ' ', COALESCE(users.apellido_materno, '')) as nombre_completo"),
                DB::raw("
                    CASE advance_requests.status
                        WHEN 0 THEN 'Proceso'
                        ELSE 'Aprobado'
                    END as status_text
                ")
            )
            ->where('expenses.user_id', '=', $userAuth->id)
            ->get();
        }

        $centerCosts = CostCenter::All();
        $departments = Department::All();

        return Inertia::render('admin/expenses/listAdvanceRequest', [
            'advanceRequests' => $advanceRequest,
            'centerCosts' => $centerCosts,
            'departments' => $departments,
            'user' => $userAuth
        ]);

    }

    public function updateAdvancePay(Request $request ){
        $userAuth = Auth::user();

        $AdvanceRequest = AdvanceRequest::findOrFail($request->id);

        // Paso 5: Actualizar el registro con los nuevos datos
        $AdvanceRequest->reference = $request->reference;
        $AdvanceRequest->depositDate = $request->depositDate;
        $AdvanceRequest->coment = $request->coment;
        $AdvanceRequest->approveBy = $request->approveBy;
        $AdvanceRequest->status = 1;
        // Actualiza más campos según sea necesario

        // Paso 6: Guardar los cambios
        $AdvanceRequest->save();

        return redirect()->route('advanceRequest.list')->with('success', 'Usuario actualizado correctamente.');
    }

    public function advanceRequestReport(string $id) {

        try {
            
            $advanceRequest = DB::table('advance_requests')
            ->join('expenses', 'expenses.advanceRequest_id', '=', 'advance_requests.id')
            ->join('users', 'users.id', '=', 'expenses.user_id')
            ->leftJoin('departments', 'departments.id', '=', 'expenses.department_id')
            ->leftJoin('cost_centers', 'cost_centers.id', '=', 'expenses.cc_id')
            ->select(
                "advance_requests.id",
                "advance_requests.reference",
                "advance_requests.depositDate",
                "advance_requests.coment",
                "advance_requests.created_at as requestDate",
                "advance_requests.status",
                "expenses.destinyFrom",
                "expenses.destinyTo",
                "expenses.purposeTravel",
                "advance_requests.approveBy",
                "expenses.endingDate",
                "expenses.payAdvance",
                "users.emp",
                "users.nombre",
                "users.apellido_paterno",
                "users.apellido_materno",
                "cost_centers.cc",
                "cost_centers.name as costCenter",
                "departments.department",
                DB::raw("CONCAT(users.nombre, ' ', users.apellido_paterno, ' ', COALESCE(users.apellido_materno, '')) as nombre_completo"),
                DB::raw("
                    CASE advance_requests.status
                        WHEN 0 THEN 'Proceso'
                        ELSE 'Aprobado'
                    END as status_text
                ")
            )
            ->where('advance_requests.id', '=', $id)
            ->get();

            $pdf = Pdf::loadView("reporte-solicitud-anticipo", compact('advanceRequest'));

            return $pdf->download("advanceRequest.pdf");
        }finally {
           
        }
    }

    public function listCenterCost(){
      
        $centerCosts = CostCenter::where('status', 0)->get();

        return Inertia::render('admin/expenses/listCostCenters', [
            'centerCosts' => $centerCosts
        ]);

    }

    public function addCenterCost(Request $request){
        $centerCost = CostCenter::create([
            'cc' => $request->cc,
            'name' => $request->name
        ]);

        return redirect()->route('advanceRequest.listCenterCost')->with('success');
    }

    public function updateCenterCost(Request $request){

        $centerCost = CostCenter::findOrFail($request->id);
        $centerCost->cc = $request->cc;
        $centerCost->name = $request->name;
        $centerCost->save();

        return redirect()->route('advanceRequest.listCenterCost')->with('success');
    }

    public function deleteCenterCost(Request $request){

        $centerCost = CostCenter::findOrFail($request->id);
        $centerCost->status = 1;
        $centerCost->save();

        return redirect()->route('advanceRequest.listCenterCost')->with('success');
    }

    
    
}
