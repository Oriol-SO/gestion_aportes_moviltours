<?php

namespace App\Http\Controllers;

use App\Exports\AportesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdministradorController extends Controller
{
    public function reporte(Request $request){
        return Excel::download(new AportesExport($request->mes), 'aportes.xlsx');
    }
}
