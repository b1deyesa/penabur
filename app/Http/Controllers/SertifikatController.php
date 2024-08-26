<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class SertifikatController extends Controller
{
    public function index(Request $request)
    {
        $sertifikat = Sertifikat::where('number', $request->number)->first();
        $data = [
            'months' => [
                1 => "Januari",
                2 => "Februari",
                3 => "Maret",
                4 => "April",
                5 => "Mei",
                6 => "Juni",
                7 => "Juli",
                8 => "Agustus",
                9 => "September",
                10 => "Oktober",
                11 => "November",
                12 => "Desember"
            ],
            'sertifikat' => $sertifikat,
            'start_day' => $sertifikat->date('start', 'day'),
            'start_month' => $sertifikat->date('start', 'month'),
            'start_year' => $sertifikat->date('start', 'year'),
            'end_day' => $sertifikat->date('end', 'day'),
            'end_month' => $sertifikat->date('end', 'month'),
            'end_year' => $sertifikat->date('end', 'year') 
        ];
        
        return view('sertifikat.index', $data);
    }
    
    public function print(Request $request)
    {
        $grayscale = (int)$request->grayscale;
        $copies = (int)$request->copies;
        $sertifikat = Sertifikat::where('number', $request->number)->first();
        $scriptPath = base_path('public/print_script.py');
        
        $process = new Process(["python3", $scriptPath, $sertifikat->number, $grayscale ? 'True' : 'False', $copies]);
        $process->run();

        return redirect()->back();
    }
}
