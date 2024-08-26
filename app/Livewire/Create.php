<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Sertifikat;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Storage;

class Create extends Component
{
    use WithFileUploads;
    public Sertifikat $sertifikat;

    public $step = 1;
    public $types;
    public $years;
    public $months;
    public $days;
    
    public $type;
    public $date = [
        'start' => [
            'year' => 2022,
            'month' => 1,
            'day' => 1
        ],
        'end' => [
            'year' => 2022,
            'month' => 1,
            'day' => 1
        ]
    ];
    public $name;
    public $photo;
    public $choose_month = true;
    
    public function mount()
    {
        $this->types = [
            0 => 'Kursus Langsung',
            1 => 'Jalur Cepat'
        ];
        $this->months = [
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
        ];
        $this->years = range(date('Y') - 2, date('Y'));
    }
    
    public function setType($type)
    {
        $this->type = $type;
        $this->step++;
    }
    
    public function setYear($start = null, $end = null)
    {
        $default = date('Y') - 1;
        
        $this->date['start']['year'] = $start ?? $default;
        $this->date['end']['year'] = $end ?? $this->date['start']['year'];
    }
    
    public function setMonth($start = null, $end = null, $day = false)
    {
        $default = [3, 6, 8, 10];
        
        $this->date['start']['month'] = $start ?? $default[array_rand($default)];
        $this->date['end']['month'] = $end ?? $this->date['start']['month'];
        
        if ($day) {
            $this->setDay();
            $this->step = 4;
        }    
    }
    
    public function setDay($start = null, $end = null)
    {
        $default = 3;
        
        $this->date['start']['day'] = $start ?? $default;
        $this->date['end']['day'] = $end ?? $this->date['start']['day'] + 16;
    }
    
    public function chooseMonth($bool)
    {
        $this->choose_month = $bool;
        $this->setDay();
        
        if ($this->choose_month) {
            $this->step = 3;
        } else {
            $this->setMonth();
            $this->step = 4;
        }
    }
    
    public function save()
    {
        $this->validate([
           'name' => 'required' 
        ]);
        
        $start_date = sprintf("%02d", $this->date['start']['day']) .'-'. sprintf("%02d", $this->date['start']['month']) .'-'. $this->date['start']['year'];
        $end_date = sprintf("%02d", $this->date['end']['day']) .'-'. sprintf("%02d", $this->date['end']['month']) .'-'. $this->date['end']['year'];
        
        if ($this->photo) {
            $photo_name = Str::slug($this->name) .'-'. str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT) .'.'. $this->photo->getClientOriginalExtension();
            $this->photo->storeAs('sertifikat/foto', $photo_name, 'public');
        }
        
        $this->sertifikat = Sertifikat::create([
            'type' => $this->type,
            'name' => $this->name,
            'start' => $start_date,
            'end' => $end_date,
            'number' => substr($this->date['end']['year'], 2, 2) . sprintf("%02d", $this->date['end']['month']) . sprintf("%02d", $this->date['end']['day']) . sprintf("%03d", (Sertifikat::where('end', $end_date)->count() + 1)),
            'photo' => $photo_name ?? null
        ]);
        
        $this->pdf();
        
        return redirect()->route('sertifikat.index', ['number' => $this->sertifikat->number]);
    }
    
    public function pdf()
    {
        $pdf = PDF::loadView('sertifikat.print', [
            'months' => $this->months,
            'sertifikat' => $this->sertifikat,
            'start_day' => $this->sertifikat->date('start', 'day'),
            'start_month' => $this->sertifikat->date('start', 'month'),
            'start_year' => $this->sertifikat->date('start', 'year'),
            'end_day' => $this->sertifikat->date('end', 'day'),
            'end_month' => $this->sertifikat->date('end', 'month'),
            'end_year'  => $this->sertifikat->date('end', 'year')
        ]);
        
        $fileName = $this->sertifikat->number .'.pdf';
        $filePath = 'public/sertifikat/file/' . $fileName;
        Storage::disk('local')->put($filePath, $pdf->output());
        
        return response()->download( 
            base_path('public/storage/sertifikat/file/' . $fileName), $fileName
        );
    }
        
    public function render()
    {
        return view('livewire.create');
    }
}
