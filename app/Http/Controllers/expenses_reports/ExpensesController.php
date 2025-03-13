<?php

namespace App\Http\Controllers\expenses_reports;

use App\Http\Controllers\Controller;
use App\Models\expenses_reports\Expense;
use App\Models\expenses_reports\CostCenter;
use App\Models\expenses_reports\Department;
use App\Models\expenses_reports\ExpenseGeneral;
use App\Models\expenses_reports\ExpenseMeal;
use App\Models\expenses_reports\ExpenseOther;
use App\Models\expenses_reports\AdvanceRequest;
use App\Models\expenses_reports\ExpenseTicket;
use App\Models\expenses_reports\ExpenseCalculator;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use NumberFormatter;
use Intervention\Image\Facades\Image as ImageIntervention;
use DateTime;
use ZipArchive;


class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show($id){
        $expenses = DB::table('expenses')
        ->join('users', 'users.id', '=', 'expenses.user_id')
        ->leftJoin('departments', 'departments.id', '=', 'expenses.department_id')
        ->leftJoin('cost_centers', 'cost_centers.id', '=', 'expenses.cc_id')
        ->leftJoin('advance_requests', 'advance_requests.id', '=', 'expenses.advanceRequest_id')
        ->select(
            'expenses.*',
            'advance_requests.depositDate',
            'advance_requests.coment',
            'advance_requests.approveBy as approveByAdvancePay',
            'users.nombre',
            'users.emp',
            'users.apellido_paterno',
            'users.apellido_materno',
            'cost_centers.cc',
            'cost_centers.name as costCenter',
            'departments.department'
        )
        ->where('expenses.uuid', $id)
        ->first();
            
        $centerCosts = CostCenter::where('status', 0)->get();
        $departments = Department::All();

        $expenseGenerals = ExpenseGeneral::where('expense_id', $expenses->id)->get(); 
        $expenseMeals = ExpenseMeal::where('expense_id', $expenses->id)->get(); 
        $expenseOthers = ExpenseOther::where('expense_id', $expenses->id)->get(); 
        $expenseTickets = ExpenseTicket::where('expense_id', $expenses->id)
            ->select(['id', 'expense_id', 'uuid', 'amount', 'concept', 'ticketPdf'])
            ->selectRaw('IF(ticket IS NOT NULL OR ticketPdf IS NOT NULL, 0, 1) AS typeTicket')
            ->get();
        $expenseCalculator = ExpenseCalculator::where('expense_id', $expenses->id)->get();    
            
        $userAuth = Auth::user();

        return Inertia::render('admin/expenses/edit', [
            'expense' => $expenses,
            'centerControls' => $centerCosts,
            'departments' => $departments,
            'expenseGenerals' => $expenseGenerals,
            'expenseMeals' => $expenseMeals,
            'expenseOthers' => $expenseOthers,
            'expenseTickets' => $expenseTickets,
            'expenseCalculator' => $expenseCalculator,
            'userAuth' => $userAuth->user_type_id
        ]);
    }

    public function listExpense(){
        $userAuth = Auth::user();
        if($userAuth->user_type_id === 1){
            $expenses = DB::table('expenses')
            ->join('users', 'users.id', '=', 'expenses.user_id')
            ->leftJoin('departments', 'departments.id', '=', 'expenses.department_id')
            ->leftJoin('advance_requests', 'advance_requests.id', '=', 'expenses.advanceRequest_id')
            ->leftJoin('cost_centers', 'cost_centers.id', '=', 'expenses.cc_id')
            ->select('expenses.*','advance_requests.depositDate', 'advance_requests.reference',
                DB::raw("CONCAT(users.nombre, ' ', users.apellido_paterno, ' ', COALESCE(users.apellido_materno, '')) as nombre_completo"),
                DB::raw("CONCAT(departments.department, '/ ', cost_centers.cc, ' ', cost_centers.name) as cc_department"),
                DB::raw("
                    CASE expenses.status
                        WHEN 0 THEN 'Proceso'
                        WHEN 1 THEN 'Por aprobar'
                        WHEN 2 THEN 'Aprobado'
                        ELSE 'Finalizado'
                    END as status_text
                ")
            )
            ->get();
        }else{
            $expenses = DB::table('expenses')
            ->join('users', 'users.id', '=', 'expenses.user_id')
            ->leftJoin('departments', 'departments.id', '=', 'expenses.department_id')
            ->leftJoin('advance_requests', 'advance_requests.id', '=', 'expenses.advanceRequest_id')
            ->leftJoin('cost_centers', 'cost_centers.id', '=', 'expenses.cc_id')
            ->select('expenses.*', 'advance_requests.depositDate', 'advance_requests.reference',
                DB::raw("CONCAT(users.nombre, ' ', users.apellido_paterno, ' ', COALESCE(users.apellido_materno, '')) as nombre_completo"),
                DB::raw("CONCAT(departments.department, '/ ', cost_centers.cc, ' ', cost_centers.name) as cc_department"),
                DB::raw("
                    CASE expenses.status
                        WHEN 0 THEN 'proceso'
                        WHEN 1 THEN 'por aprobar'
                        WHEN 2 THEN 'aprobado'
                        ELSE 'desconocido'
                    END as status_text
                ")
            )
            ->where('expenses.user_id', '=', $userAuth->id)
            ->get();
        }

        $centerCosts = CostCenter::where('status', 0)->get();
        $departments = Department::All();
        $users = User::All();

        return Inertia::render('admin/expenses/listExpenses', [
            'expenses' => $expenses,
            'centerCosts' => $centerCosts,
            'departments' => $departments,
            'user' => $userAuth,
            'usersList' => $users
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function createExpense(Request $request ){
        $userAuth = Auth::user();
        $uuid = Str::uuid()->toString();

        $date = Carbon::parse($request->travelDateStart);
        // Añade 6 días a la fecha
        $endingDate = $date->addDays(6);

        $AdvanceRequest = AdvanceRequest::create([
            'status' => 0
        ]);

        $expense = Expense::create([
            'uuid' => $uuid,
            'endingDate' => $endingDate,
            'user_id' => $request->travelPerson, 
            'department_id' => $request->travelDepartment, 
            'cc_id' => $request->travelCenterCost,
            'advanceRequest_id' => $AdvanceRequest->id,
            'payAdvance' => $request->travelAdvance,
            'purposeTravel' => $request->travelReason,
            'destinyFrom' => $request->travelDestinyFrom,
            'destinyTo' => $request->travelDestinyTo,
            'status' => 0
        ]);
        
        return redirect()->route('expenses.show', $expense->uuid)->with('success');

    }

    public function createExpenseGeneral(Request $request ){
        $userAuth = Auth::user();

        $generalExpense = $request->get('general');
        
        $general = ExpenseGeneral::create([
            'expense_id' => $generalExpense['idExpense'],
            'uuid' => $generalExpense['id'],
            'selectExpense' => $generalExpense['selectExpense'],
            'city' => $generalExpense['city'], 
            'amount' => $generalExpense['amount'], 
            'tip' => $generalExpense['tip'],
            'dateExpense' => substr($generalExpense['date'], 0, 10)
        ]);

        if($generalExpense['selectExpense'] == 5 || $generalExpense['selectExpense'] == 6 || $generalExpense['selectExpense'] == 7){
            $mealExpense = $request->get('meal');
            $meal = ExpenseMeal::create([
                'expense_id' => $generalExpense['idExpense'],
                'general_id' => $mealExpense['idGeneral'],
                'selectExpense' => $mealExpense['selectExpense'],
                'city' => $mealExpense['city'], 
                'restaurant' => $mealExpense['restaurant'], 
                'amount' => $mealExpense['amount'], 
                'tip' => $mealExpense['tip'],
                'time' => null,
                'dateExpense' => substr($generalExpense['date'], 0, 10)
            ]);
        }else{
            $otherExpense = $request->get('other');
            $other = ExpenseOther::create([
                'expense_id' => $generalExpense['idExpense'],
                'general_id' => $otherExpense['idGeneral'],
                'selectExpense' => $otherExpense['selectExpense'],
                'description' => $otherExpense['description'], 
                'amount' => $otherExpense['amount'], 
                'dateExpense' => substr($generalExpense['date'], 0, 10)
            ]);

        }
        
        return redirect()->route('expenses.show', $generalExpense['uuidExpense'])->with('success');

    }

    public function updateExpensesMeal(Request $request ){

        $ExpenseMeal = ExpenseMeal::findOrFail($request->id);
        $ExpenseMeal->restaurant = $request->restaurant;
        $ExpenseMeal->save();

        return redirect()->route('expenses.show', $request->uuidExpense)->with('success');
        
    }

    public function updateExpensesOther(Request $request ){

        $ExpenseOther = ExpenseOther::findOrFail($request->id);
        $ExpenseOther->description = $request->description;
        $ExpenseOther->save();

        return redirect()->route('expenses.show', $request->uuidExpense)->with('success');
        
    }

    public function finishExpensesReport(Request $request ){
        $data = json_decode($request->input('expense'), true);
        $Expense = Expense::findOrFail($data['id']);
            $Expense->daysAway = $data['daysAway'];
            $Expense->daysPersonalAffairs = $data['daysPersonalAffairs'];
            $Expense->totalDaysAway = $data['totalDaysAway'];
            $Expense->approveBy = $data['approveBy'];
            $Expense->totalExpense = $data['totalExpense'];
            $Expense->payToReturn = $data['payToReturn'];
            $Expense->methodOfReimbursment = $data['methodOfReimbursment'];
            $Expense->status = 1;
        $Expense->save();    

        return redirect()->route('expenses.show', $data['uuid'])->with('success');
    }

    public function approveExpensesReport(Request $request ){

        $Expense = Expense::findOrFail($request->input('id'));
        $Expense->status = $request->input('approve');
        $Expense->save();    

        return redirect()->route('expenses.show', $request->input('uuid'))->with('success');
    }

    public function requestTransferExpensesReport(Request $request ){

        $Expense = Expense::findOrFail($request->input('id'));
        $Expense->status = 3;
        $Expense->concept = $request->input('concept');
        $Expense->save();    

        return redirect()->route('expenses.show', $request->input('uuid'))->with('success');
    }

    
    

    public function deleteExpenseGeneral(Request $request ){

        $data = json_decode($request->input('datos'), true);

        ExpenseTicket::where('uuid', $data['id'])->delete();
    
        if($data['selectExpense'] == 5 || $data['selectExpense'] == 6 || $data['selectExpense'] == 7){
            ExpenseMeal::where('general_id', $data['uuid'])->delete();
        }else{
            ExpenseOther::where('general_id', $data['uuid'])->delete();
        }

        ExpenseGeneral::find($data['id'])->delete();;

        return redirect()->route('expenses.show', $request->input('uuidExpense') )->with('success');
    }

    public function createTicketExpense(Request $request){
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            // Si el archivo es una imagen (jpeg, png, etc.)
            if (in_array($extension, ['jpeg', 'png', 'jpg', 'gif'])) {
                return $this->processImage($file, $request);
            }
            
            // Si el archivo es un PDF, convertirlo a imágenes
            if ($extension === 'pdf') {
                return $this->processPdf($file, $request);
            }

            return response()->json(['error' => 'Formato no compatible'], 400);
        }else{
            $data = json_decode($request->input('datos'), true);
            
            $ticket = ExpenseTicket::create([
                'expense_id' => $data['idExpense'],
                'uuid' => $data['idGeneral'],
                'amount' => $data['amount'], 
                'concept' => $data['concept'] ?? null,
                'ticket' => null
            ]);

            return redirect()->route('expenses.show', $data['uuidExpense'])->with('success');
        }

    }

    private function processImage($image, $request){
       
        $imageIntervention = ImageIntervention::make($image)->resize(800, 800, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->encode('png', 85);

        $binaryImage = $imageIntervention->encode('png')->getEncoded();
        $data = json_decode($request->input('datos'), true);
        
        $ticket = ExpenseTicket::create([
            'expense_id' => $data['idExpense'],
            'uuid' => $data['idGeneral'],
            'amount' => $data['amount'], 
            'concept' => $data['concept'] ?? null,
            'ticket' => $binaryImage,
            'ticketPdf' => null // No hay PDF, se mantiene null
        ]);

        return redirect()->route('expenses.show', $data['uuidExpense'])->with('success');
    }

    private function processPdf($pdfFile, $request){
        // Obtener datos del request
        $data = json_decode($request->input('datos'), true);

        // Buscar el ExpenseGeneral para obtener fechaExpense
        $expenseGeneral = ExpenseGeneral::where('id', $data['idGeneral'])->first();

        // Crear el registro en la base de datos primero
        $ticket = ExpenseTicket::create([
            'expense_id' => $data['idExpense'],
            'uuid' => $data['idGeneral'],
            'amount' => $data['amount'],
            'concept' => $data['concept'] ?? null,
            'ticket' => null, // No guardamos imágenes, solo la ruta del PDF
            'ticketPdf' => null // Se actualizará después de guardar el archivo
        ]);

        // Construir el nombre del archivo con el ID del ticket recién creado
        $fileName = "{$ticket->id}_{$expenseGeneral->dateExpense}.pdf";

        // Guardar el PDF en storage con el nuevo nombre
        $pdfPath = $pdfFile->storeAs('tickets', $fileName, 'public');

        // Actualizar la ruta en la base de datos
        $ticket->update(['ticketPdf' => $pdfPath]);

        return redirect()->route('expenses.show', $data['uuidExpense'])->with('success');
    }
   

    public function deleteTicketExpense(Request $request) {
        $data = json_decode($request->input('datos'), true);
        $ticket = ExpenseTicket::find($data['id']);

        if ($ticket) {
            // Si existe un archivo PDF asociado, eliminarlo del almacenamiento
            if ($ticket->ticketPdf) {
                $pdfPath = storage_path("app/public/{$ticket->ticketPdf}");
                if (file_exists($pdfPath)) {
                    unlink($pdfPath);
                }
            }

            // Eliminar el registro de la base de datos
            $ticket->delete();
        }
        return redirect()->route('expenses.show', $request->input('uuidExpense') )->with('success');
    }

    public function showImageTickets($id){
        $image = ExpenseTicket::findOrFail($id);
        return response($image->ticket)->header('Content-Type', 'image/png');
    }


    public function createCalculatorExpense(Request $request){
        $data = json_decode($request->input('datos'), true);

        $ticket = ExpenseCalculator::create([
            'expense_id' => $request->input('id'),
            'amount' => $data['amount'],
            'change' => $data['change'], 
            'total' => $data['total'],
            'currency' => $data['currency']
        ]);

        return redirect()->route('expenses.show', $request->input('uuid'))->with('success');
    }

    public function deleteCalculatorExpense(Request $request){
        ExpenseCalculator::where('id', $request->input('id'))->delete();
        return redirect()->route('expenses.show', $request->input('uuid'))->with('success');
    }
    

    public function transferRequestReport(string $id) {

        try {
            
            $expenses = DB::table('expenses')
            ->join('users', 'users.id', '=', 'expenses.user_id')
            ->leftJoin('departments', 'departments.id', '=', 'expenses.department_id')
            ->leftJoin('cost_centers', 'cost_centers.id', '=', 'expenses.cc_id')
            ->leftJoin('advance_requests', 'advance_requests.id', '=', 'expenses.advanceRequest_id')
            ->select(
                'expenses.*',
                'advance_requests.depositDate',
                'advance_requests.coment',
                'advance_requests.reference',
                'advance_requests.approveBy as approveByAdvancePay',
                'users.nombre',
                'users.emp',
                'users.apellido_paterno',
                'users.apellido_materno',
                'cost_centers.cc',
                'cost_centers.name as costCenter',
                'departments.department'
            )
            ->where('expenses.uuid', $id)
            ->first();

            
            $formatter = new NumberFormatter('es_ES', NumberFormatter::SPELLOUT);
            // Convertir el número a una cadena y dividirlo por el punto decimal
            $parts = explode('.', (string) $expenses->payToReturn);
            // Parte entera
            $integerPart = (int) $parts[0];
            // Parte decimal, completando con ceros si es necesario
            $cents = isset($parts[1]) ? (int) str_pad($parts[1], 2, '0') : 0;

            $today = Carbon::now()->format('d.m.Y');
            $referencia = $expenses->emp . ' '. strtoupper(substr($expenses->nombre, 0, 1)) . $expenses->apellido_paterno . ' ' . $expenses->destinyFrom . ' ' .$today;

            $payToReturn = $formatter->format($integerPart);

            $pdf = Pdf::loadView("reporte-solicitud-transferencia", compact('expenses', 'payToReturn', 'cents', 'referencia'));

            return $pdf->download("transferRequest.pdf");
        }finally {
           
        }
    }

    public function expenseReportExcel(string $id){

        $expenses = DB::table('expenses')
        ->join('users', 'users.id', '=', 'expenses.user_id')
        ->leftJoin('departments', 'departments.id', '=', 'expenses.department_id')
        ->leftJoin('cost_centers', 'cost_centers.id', '=', 'expenses.cc_id')
        ->leftJoin('advance_requests', 'advance_requests.id', '=', 'expenses.advanceRequest_id')
        ->select(
            'expenses.*',
            'advance_requests.depositDate',
            'advance_requests.coment',
            'advance_requests.approveBy as approveByAdvancePay',
            'advance_requests.reference',
            'users.nombre',
            'users.emp',
            'users.apellido_paterno',
            'users.apellido_materno',
            'cost_centers.cc',
            'cost_centers.name as costCenter',
            'departments.department'
        )
        ->where('expenses.uuid', $id)
        ->first();
            
        $centerControls = CostCenter::All();
        $departments = Department::All();

        $expenseGenerals = ExpenseGeneral::where('expense_id', $expenses->id)->get(); 
        $expenseMeals = ExpenseMeal::where('expense_id', $expenses->id)->get(); 
        $expenseOthers = ExpenseOther::where('expense_id', $expenses->id)->get(); 
        $expenseTickets = ExpenseTicket::where('expense_tickets.expense_id', $expenses->id)
            ->select(['expense_tickets.id', 'expense_tickets.expense_id', 'expense_tickets.uuid', 'expense_tickets.amount', 'concept', 'ticket', 'expense_generals.dateExpense'])
            ->selectRaw('IF(ticket IS NOT NULL OR ticketPdf IS NOT NULL, 0, 1) AS typeTicket')
            ->join('expense_generals', 'expense_generals.id', '=', 'expense_tickets.uuid')
            ->get();
        $expenseTicketsVales = ExpenseTicket::where('expense_tickets.expense_id', $expenses->id)
            ->select(['expense_tickets.id', 'expense_tickets.expense_id', 'expense_tickets.uuid', 'expense_tickets.amount', 'concept', 'ticket', 'expense_generals.dateExpense'])
            ->selectRaw('IF(ticket IS NOT NULL OR ticketPdf IS NOT NULL, 0, 1) AS typeTicket')
            ->join('expense_generals', 'expense_generals.id', '=', 'expense_tickets.uuid')
            ->havingRaw('typeTicket = true')
            ->get();
        $expenseCalculator = ExpenseCalculator::where('expense_id', $expenses->id)->get();

        // Cargar el template
        $filePath = public_path('excel/expenseReport.xlsx');
        $spreadsheet = IOFactory::load($filePath);

        // Seleccionar la hoja activa
        $spreadsheet->setActiveSheetIndex(0);

        // Obtener la hoja activa
        $sheet = $spreadsheet->getActiveSheet();

        // Modificar el template (Ejemplo: cambiar un valor)
        $nombre = $expenses->nombre.' '.$expenses->apellido_paterno.' '.$expenses->apellido_materno;
        $sheet->setCellValue('C6', $nombre);
        $sheet->setCellValue('J6', $expenses->department);
        $sheet->setCellValue('Q6', $expenses->endingDate);
        $sheet->setCellValue('Q7', $expenses->cc);
        $sheet->setCellValue('Q8', $expenses->costCenter);
        $sheet->setCellValue('T7', $expenses->daysAway);
        $sheet->setCellValue('T11', $expenses->daysPersonalAffairs);
        $sheet->setCellValue('T15', $expenses->totalDaysAway);
        $sheet->setCellValue('T19', $expenses->purposeTravel);
        $sheet->setCellValue('T34', $expenses->payAdvance);
        $sheet->setCellValue('T47', $nombre);
        $sheet->setCellValue('T55', $expenses->approveBy);
        if($expenses->methodOfReimbursment == 0){
            $sheet->setCellValue('T30', 'X');
        }else{
            $sheet->setCellValue('W30', 'X');
        }

        // Convertir la fecha inicial a un objeto DateTime
        $date = new DateTime($expenses->endingDate);

        // Array para almacenar las fechas
        $fechas = [];

        // Generar las fechas de los 6 días anteriores
        for ($i = 1; $i <= 6; $i++) {
            $fechas[] = $date->modify('-1 day')->format('Y-m-d');
        }

        $sheet->setCellValue('B14', $fechas[5]);
        $sheet->setCellValue('B20', $fechas[4]);
        $sheet->setCellValue('B26', $fechas[3]);
        $sheet->setCellValue('B32', $fechas[2]);
        $sheet->setCellValue('B38', $fechas[1]);
        $sheet->setCellValue('B44', $fechas[0]);
        $sheet->setCellValue('B50', $expenses->endingDate);

        foreach ($expenseGenerals as $expenseGeneral) {
            if($expenseGeneral->dateExpense == $fechas[5]){
                $rowGeneral = 13;
            }else if($expenseGeneral->dateExpense == $fechas[4]){
                $rowGeneral = 19;
            }else if($expenseGeneral->dateExpense == $fechas[3]){
                $rowGeneral = 25;
            }else if($expenseGeneral->dateExpense == $fechas[2]){
                $rowGeneral = 31;
            }else if($expenseGeneral->dateExpense == $fechas[1]){
                $rowGeneral = 37;
            }else if($expenseGeneral->dateExpense == $fechas[0]){
                $rowGeneral = 43;
            }else if($expenseGeneral->dateExpense == $expenses->endingDate){
                $rowGeneral = 49;
            }
            if($expenseGeneral->selectExpense == 0){
                $this->insertValue($sheet, $expenseGeneral, 'D', $rowGeneral);
            }else if($expenseGeneral->selectExpense == 1){
                $this->insertValue($sheet, $expenseGeneral, 'E', $rowGeneral);
            }else if($expenseGeneral->selectExpense == 2){
                $this->insertValue($sheet, $expenseGeneral, 'F', $rowGeneral);
            }else if($expenseGeneral->selectExpense == 3){
                $this->insertValue($sheet, $expenseGeneral, 'H', $rowGeneral);
            }else if($expenseGeneral->selectExpense == 4){
                $this->insertValue($sheet, $expenseGeneral, 'I', $rowGeneral);
            }else if($expenseGeneral->selectExpense == 5){
                if($expenseGeneral->tip > 0){
                    $amountTip = $expenseGeneral->amount;
                    $expenseGeneral->amount = $expenseGeneral->tip;
                    $this->insertValue($sheet, $expenseGeneral, 'P', $rowGeneral);
                }
                $expenseGeneral->amount = $amountTip;
                $this->insertValue($sheet, $expenseGeneral, 'J', $rowGeneral);
            }else if($expenseGeneral->selectExpense == 6){
                if($expenseGeneral->tip > 0){
                    $amountTip = $expenseGeneral->amount;
                    $expenseGeneral->amount = $expenseGeneral->tip;
                    $this->insertValue($sheet, $expenseGeneral, 'P', $rowGeneral);
                }
                $expenseGeneral->amount = $amountTip;
                $this->insertValue($sheet, $expenseGeneral, 'K', $rowGeneral);
            }else if($expenseGeneral->selectExpense == 7){
                if($expenseGeneral->tip > 0){
                    $amountTip = $expenseGeneral->amount;
                    $expenseGeneral->amount = $expenseGeneral->tip;
                    $this->insertValue($sheet, $expenseGeneral, 'P', $rowGeneral);
                }
                $expenseGeneral->amount = $amountTip;
                $this->insertValue($sheet, $expenseGeneral, 'L', $rowGeneral);
            }else if($expenseGeneral->selectExpense == 8){
                $this->insertValue($sheet, $expenseGeneral, 'N', $rowGeneral);
            }else if($expenseGeneral->selectExpense == 9){
                $this->insertValue($sheet, $expenseGeneral, 'P', $rowGeneral);
            }
        }

        $sheet->setCellValue('B67', $fechas[5]);
        $sheet->setCellValue('B73', $fechas[4]);
        $sheet->setCellValue('B79', $fechas[3]);
        $sheet->setCellValue('B85', $fechas[2]);
        $sheet->setCellValue('B91', $fechas[1]);
        $sheet->setCellValue('B97', $fechas[0]);
        $sheet->setCellValue('B103', $expenses->endingDate);

        foreach ($expenseMeals as $expenseMeal) {
            if($expenseMeal->dateExpense == $fechas[5]){
                $rowMeal = 66;
            }else if($expenseMeal->dateExpense == $fechas[4]){
                $rowMeal = 72;
            }else if($expenseMeal->dateExpense == $fechas[3]){
                $rowMeal = 78;
            }else if($expenseMeal->dateExpense == $fechas[2]){
                $rowMeal = 84;
            }else if($expenseMeal->dateExpense == $fechas[1]){
                $rowMeal = 90;
            }else if($expenseMeal->dateExpense == $fechas[0]){
                $rowMeal = 96;
            }else if($expenseMeal->dateExpense == $expenses->endingDate){
                $rowMeal = 102;
            }

            // Iterar hasta encontrar una celda vacía
            while ($sheet->getCell('C' . $rowMeal)->getValue() !== null) {
                $rowMeal++; // Moverse a la siguiente fila
            }

            $pursose = '';
            if($expenseMeal->selectExpense == 5) $pursose = 'BREAKFAST';
            if($expenseMeal->selectExpense == 6) $pursose = 'LUNCH';
            if($expenseMeal->selectExpense == 7) $pursose = 'DINNER';

            $descriptionMeal = 'City: '.$expenseMeal->city.', Restaurant: '.$expenseMeal->restaurant;
            $sheet->setCellValue('C' . $rowMeal, $descriptionMeal);
            $sheet->setCellValue('H' . $rowMeal, $pursose);
            $sheet->setCellValue('J' . $rowMeal, $expenseMeal->amount);
            $sheet->setCellValue('k' . $rowMeal, $expenseMeal->tip);
        }

        $sheet->setCellValue('M67', $fechas[5]);
        $sheet->setCellValue('M73', $fechas[4]);
        $sheet->setCellValue('M79', $fechas[3]);
        $sheet->setCellValue('M85', $fechas[2]);
        $sheet->setCellValue('M91', $fechas[1]);
        $sheet->setCellValue('M97', $fechas[0]);
        $sheet->setCellValue('M103', $expenses->endingDate);

        $sheet->setCellValue('S67', $fechas[5]);
        $sheet->setCellValue('S73', $fechas[4]);
        $sheet->setCellValue('S79', $fechas[3]);
        $sheet->setCellValue('S85', $fechas[2]);
        $sheet->setCellValue('S91', $fechas[1]);
        $sheet->setCellValue('S97', $fechas[0]);
        $sheet->setCellValue('S103', $expenses->endingDate);

        foreach ($expenseOthers as $expenseOther) {
            if($expenseOther->dateExpense == $fechas[5]){
                $rowOther = 66;
            }else if($expenseOther->dateExpense == $fechas[4]){
                $rowOther = 72;
            }else if($expenseOther->dateExpense == $fechas[3]){
                $rowOther = 78;
            }else if($expenseOther->dateExpense == $fechas[2]){
                $rowOther = 84;
            }else if($expenseOther->dateExpense == $fechas[1]){
                $rowOther = 90;
            }else if($expenseOther->dateExpense == $fechas[0]){
                $rowOther = 96;
            }else if($expenseOther->dateExpense == $expenses->endingDate){
                $rowOther = 102;
            }

            // Iterar hasta encontrar una celda vacía
            

            if($expenseOther->selectExpense == 1){
                while ($sheet->getCell('N' . $rowOther)->getValue() !== null) {
                    $rowOther++; // Moverse a la siguiente fila
                }
                $this->insertValueExpenseOther($sheet, $expenseOther, 'N', 'Q', $rowOther);
            }else if($expenseOther->selectExpense == 2){
                while ($sheet->getCell('N' . $rowOther)->getValue() !== null) {
                    $rowOther++; // Moverse a la siguiente fila
                }
                $this->insertValueExpenseOther($sheet, $expenseOther, 'N', 'Q', $rowOther);
            }else if($expenseOther->selectExpense == 3){
                while ($sheet->getCell('N' . $rowOther)->getValue() !== null) {
                    $rowOther++; // Moverse a la siguiente fila
                }
                $this->insertValueExpenseOther($sheet, $expenseOther, 'N', 'Q', $rowOther);
            }else if($expenseOther->selectExpense == 4){
                while ($sheet->getCell('N' . $rowOther)->getValue() !== null) {
                    $rowOther++; // Moverse a la siguiente fila
                }
                $this->insertValueExpenseOther($sheet, $expenseOther, 'N', 'Q', $rowOther);
            }else {
                while ($sheet->getCell('T' . $rowOther)->getValue() !== null) {
                    $rowOther++; // Moverse a la siguiente fila
                }
                $this->insertValueExpenseOther($sheet, $expenseOther, 'T', 'W', $rowOther);
            }
        }

        $row = 24;
        foreach ($expenseCalculator as $expenseCalcul) {
            
                $sheet->setCellValue('T' . $row, $expenseCalcul->currency);
                $sheet->setCellValue('V' . $row, $expenseCalcul->change);
                $sheet->setCellValue('W' . $row, $expenseCalcul->amount);
                $sheet->setCellValue('X' . $row, $expenseCalcul->total);
            $row++;
        }

        //insertar las imagenes de los tickets guardados
        $spreadsheet->setActiveSheetIndex(2);    
        $sheet = $spreadsheet->getActiveSheet();

        $startRow = 2;  // Fila inicial
        $columns = ['C', 'G', 'L'];
        $imagesPerRow = 3;  // Cantidad de imágenes por fila
        $rowSpacing = 24;  // Saltar 24 filas entre cada fila de imágenes
        $index = 0;

        foreach ($expenseTickets as $expenseTicket) {
            if($expenseTicket->ticket !== null){
                $row = $startRow + (intdiv($index, $imagesPerRow) * $rowSpacing); // Cada 3 imágenes, saltar 24 filas
        
                // Calcular la columna (C, G, L) según el índice
                $column = $columns[$index % $imagesPerRow]; 

                $binaryData = $expenseTicket->ticket;
                $tempFile = tempnam(sys_get_temp_dir(), 'img');
                file_put_contents($tempFile, $binaryData);

                $drawing = new Drawing();
                $drawing->setName('Imagen');
                $drawing->setDescription('Descripción de la imagen');
                $drawing->setPath($tempFile); // Ruta del archivo temporal
                $drawing->setHeight(400); // Ajustar el tamaño si es necesario
                $drawing->setCoordinates($column . $row); // Celda donde se insertará la imagen
                $drawing->setWorksheet($sheet);
                
                $index++;
            }
        }

        $spreadsheet->setActiveSheetIndex(1);    
        $sheet = $spreadsheet->getActiveSheet();
        // Definir las posiciones iniciales de los campos para el primer recibo
        $positions = [
            ['J5', 'E7', 'G7', 'F9', 'D13', 'J13'],
            ['V5', 'Q7', 'S7', 'R9', 'P13', 'V13'],
            ['AH5', 'AC7', 'AE7', 'AD9', 'AB13', 'AH13'],
        ];
        
        $rowOffset = 15;  // Saltar 15 filas para el siguiente bloque de recibos
        $columnOffset = 11; // Saltar 11 columnas para el siguiente recibo en la misma fila

        foreach ($expenseTicketsVales as $index => $expenseTicket) {
            if($expenseTicket->ticket == null){
                // Calcular el offset si es necesario (15 filas abajo)
                $rowMultiplier = intdiv($index, 3);  // 3 recibos por fila
                $currentRowOffset = $rowMultiplier * $rowOffset;

                // Obtener las posiciones para el recibo actual (0, 1 o 2)
                $receiptIndex = $index % 3;
                $receiptPositions = $positions[$receiptIndex];

                // Llenar los datos en las celdas correspondientes, ajustando las filas
                $sheet->setCellValue($this->adjustCell($receiptPositions[0], $currentRowOffset), $expenseTicket->dateExpense);
                $sheet->setCellValue($this->adjustCell($receiptPositions[1], $currentRowOffset), $expenseTicket->amount);

                $formatter = new NumberFormatter('es_ES', NumberFormatter::SPELLOUT);
                // Convertir el número a una cadena y dividirlo por el punto decimal
                $parts = explode('.', (string) $expenseTicket->amount);
                // Parte entera
                $integerPart = (int) $parts[0];
                // Parte decimal, completando con ceros si es necesario
                $cents = isset($parts[1]) ? (int) str_pad($parts[1], 2, '0') : 0;
                $amountTicket = $formatter->format($integerPart);
                $amountTicket = $amountTicket. ' pesos '.$cents.'/100';
                $sheet->setCellValue($this->adjustCell($receiptPositions[2], $currentRowOffset), $amountTicket);
                $sheet->setCellValue($this->adjustCell($receiptPositions[3], $currentRowOffset), $expenseTicket->concept);
                $sheet->setCellValue($this->adjustCell($receiptPositions[4], $currentRowOffset), $nombre);
                $sheet->setCellValue($this->adjustCell($receiptPositions[5], $currentRowOffset), $expenses->approveBy);
            }
        }

        // Guardar el archivo modificado
        $writer = new Xlsx($spreadsheet);
        $fileName = $expenses->reference . '.xlsx';
        $filePath = public_path('excel/' . $fileName);
        $writer->save($filePath);

        // Obtener los tickets con ticketPdf no null
            $tickets = ExpenseTicket::where('expense_id', $expenses->id)
            ->whereNotNull('ticketPdf')
            ->get();
        // Crear el archivo ZIP
        $zip = new ZipArchive;
        $zipFileName = public_path("excel/{$expenses->reference}_with_pdfs.zip");

        if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
            // Agregar el archivo Excel al ZIP
            $zip->addFile($filePath, $fileName);

            // Agregar los PDFs de los tickets al ZIP
            foreach ($tickets as $ticket) {
                $pdfPath = storage_path("app/public/{$ticket->ticketPdf}");
                if (file_exists($pdfPath)) {
                    $zip->addFile($pdfPath, basename($pdfPath));
                }
            }

            // Cerrar el archivo ZIP
            $zip->close();

            // Eliminar el archivo Excel original (opcional)
            unlink($filePath);

            // Descargar el archivo ZIP
            return response()->download($zipFileName)->deleteFileAfterSend(true);
        }
        return response()->json(['error' => 'Failed to create ZIP file'], 500);
    }

    function adjustCell($cell, $rowOffset){
        // Extraer la columna y la fila del formato "A1"
        preg_match('/([A-Z]+)(\d+)/', $cell, $matches);
        $column = $matches[1];  // Columna (letra)
        $row = (int)$matches[2];  // Fila (número)
        
        // Ajustar la fila por el offset
        $newRow = $row + $rowOffset;
        
        return $column . $newRow;  // Devolver la nueva posición
    }

    public function insertValue($sheet, $expenseGeneral, $column, $row){
        // Iterar hasta encontrar una celda vacía
        while ($sheet->getCell($column . $row)->getValue() !== null) {
            $row++; // Moverse a la siguiente fila
        }

        if($sheet->getCell('C' . $row)->getValue() !== null){
            $sheet->setCellValue('C' . $row, $expenseGeneral->city);
            $sheet->setCellValue($column . $row, $expenseGeneral->amount);
        }else if($sheet->getCell('C' . $row)->getValue() == $expenseGeneral->city){
            $sheet->setCellValue($column . $row, $expenseGeneral->amount);
        }else{
            while ($sheet->getCell('C' . $row)->getValue() !== null) {
                $row++; // Moverse a la siguiente fila
            }
            $sheet->setCellValue('C' . $row, $expenseGeneral->city);
            $sheet->setCellValue($column . $row, $expenseGeneral->amount);
        }

    }

    public function insertValueExpenseOther($sheet, $expenseOther, $columnDes, $columnAmo, $row){

        $description = '';
            if($expenseOther->selectExpense == 0) $description = 'LODGING';
            if($expenseOther->selectExpense == 1) $description = 'AIR, RAIL, ETC';
            if($expenseOther->selectExpense == 2) $description = 'RENTAL CAR, LIMO, ETC';
            if($expenseOther->selectExpense == 3) $description = 'LOCAL TAXI, TOLLS & PUBLIC TRNSIT';
            if($expenseOther->selectExpense == 4) $description = 'AUTO EXPENSES';
            if($expenseOther->selectExpense == 8) $description = 'ENTERTAINMENT';
            if($expenseOther->selectExpense == 9) $description = 'MISCELANEUS';

        // Iterar hasta encontrar una celda vacía
        while ($sheet->getCell($columnDes . $row)->getValue() !== null) {
            $row++; // Moverse a la siguiente fila
        }

        $sheet->setCellValue($columnDes . $row, $description.': '.$expenseOther->description);
        $sheet->setCellValue($columnAmo . $row, $expenseOther->amount);

    }

}
