<?php

namespace App\Exports;

use App\Models\Aporte;
use App\Models\Veiculo;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AportesExport implements FromCollection,WithTitle,WithHeadings,WithStyles,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    public $mes;
    public $headers;
    public $columnas;
    public $anio;

    public $columnatotal;
    public $columnadeuda;

    public function __construct($fecha)
    {
        
        $f=Carbon::parse($fecha)->startOfMonth();
        $this->mes=$f->month;
        $anio=$f->year;
        $this->anio=$anio;
        $this->headers=$this->listarDiasSemana($anio, $this->mes);
        $this->columnas=$this->calcularColumnaExcel(count($this->headers)-2);
        $this->columnatotal=$this->calcularColumnaExcel(count($this->headers)-1);
        $this->columnadeuda=$this->calcularColumnaExcel(count($this->headers));
    }

    public function calcularColumnaExcel($columnNumber) {
        $columnLetter = '';
    
        while ($columnNumber > 0) {
            $remainder = ($columnNumber - 1) % 26;
            $columnLetter = chr(65 + $remainder) . $columnLetter;
            $columnNumber = ($columnNumber - $remainder - 1) / 26;
        }
    
        return $columnLetter;
    }
    public function styles(Worksheet $sheet)
    {
        $borderDashed = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        
        $sheet->getStyle('A3:'.($this->columnas).'3')->getFill()
        ->setFillType(Fill::FILL_SOLID)
        ->getStartColor()->setARGB('ACB9CA');

        //columa total y deuda
        $sheet->getStyle(($this->columnatotal).'3')->getFill()
        ->setFillType(Fill::FILL_SOLID)
        ->getStartColor()->setARGB('6BCF70');
        $sheet->getStyle(($this->columnadeuda).'3')->getFill()
        ->setFillType(Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FF8062');

        $sheet->mergeCells('A1:'.($this->columnadeuda).'1');
        $sheet->mergeCells('A2:'.($this->columnadeuda).'2');
        $sheet->getStyle('A1:'.($this->columnadeuda).$sheet->getHighestRow())->ApplyFromArray($borderDashed);

        $sheet->getStyle('A1:'.($this->columnadeuda). $sheet->getHighestRow())->getAlignment()->setHorizontal('center');
    
    }

    public function title(): string
    {
        $meses = [
            "enero", "febrero", "marzo", "abril", "mayo", "junio",
            "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"
            ];

        return 'REPORTE DE  '.mb_strtoupper($meses[$this->mes-1]);
    }
    public function headings(): array
    {   
        $meses = [
            "enero", "febrero", "marzo", "abril", "mayo", "junio",
            "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"
            ];
        $titulo=['EMPRESA DE TRANSPORTE MOVIL TOURS HCO'];
        $titulo2=['PLANILLA DE MES DE '.mb_strtoupper($meses[$this->mes-1]).' '. $this->anio];
        $cabeceras=$this->headers;
        $c=['N°','APELLIDOS Y NOMBRES','PLACA'];
        return [$titulo,$titulo2,$cabeceras];
    }
    public function listarDiasSemana($year, $month) {
        $numDias = cal_days_in_month(CAL_GREGORIAN, $month, $year); // Número de días en el mes

        $diasSemana = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];
        $nomdias = ['N°','APELLIDOS Y NOMBRES','PLACA'];

        for ($dia = 1; $dia <= $numDias; $dia++) {
            $nombreDiaSemana = date('w', strtotime("$year-$month-$dia"));
            array_push($nomdias, $diasSemana[$nombreDiaSemana].' '.$dia);
        }
        array_push($nomdias, ' Total');
        array_push($nomdias, ' Debe');

        return $nomdias;
    }
    
    public function collection()
    {
        $i=1;
        $primerDiaMes = Carbon::createFromDate($this->anio, $this->mes, 1);
        $ultimoDiaMes = $primerDiaMes->copy()->endOfMonth();
        $numDiasMes = $primerDiaMes->diffInDays($ultimoDiaMes) + 1;
        $aportes= Veiculo::where('circulacion',1)->get()->map(function($v) use(&$i,$numDiasMes){
           $aportes=[
            'N°'=>$i++,
            'APELLIDOS Y NOMBRES' =>$v->user->name,
            'PLACA'=>$v->placa,
           ];
           $total=0;
           $debe=0;
           $registrosdelmes=Aporte::where('veiculo_id',$v->id)->whereYear('fecha', $this->anio)
                            ->whereMonth('fecha', $this->mes)
                            ->get()->map(function($a) use(&$total){
                                $total+=$a->monto;
                                return[
                                    'monto'=>$a->monto,
                                    'dia'=>Carbon::parse($a->fecha)->day,
                                ];
                            });

           for ($j=1; $j <=$numDiasMes ; $j++) { 
                $monto=$this->buscar_monto_dia($registrosdelmes,$j);
                array_push($aportes, $monto );
           }
           array_push($aportes, $total );
           
           $debe=($numDiasMes-count($registrosdelmes))*1.5;
           array_push($aportes, $debe );
            return $aportes;
        });

        return $aportes;
    }

    public function buscar_monto_dia($aportes,$dia){
        foreach ($aportes as $a) {
            if($a['dia']==$dia){
                return $a['monto'];
            }
        }
        return ' ';
    }
}
