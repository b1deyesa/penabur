<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    
    public function date($status, $part)
    {
        if ($status == 'start') {
            $parts = explode('-', $this->start);
        } else {
            $parts = explode('-', $this->end);
        }
        
        if ($part == 'day') {
            return $parts[0];
        } elseif ($part == 'month') {
            return $parts[1];
        } else {
            return $parts[2];
        }
    }
    
    public function roman($part) 
    {
        $map = [
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1
        ];

        $roman = '';
        
        if ($part == 'day') {
            $number = (int)$this->date('end', 'day');
        } elseif ($part == 'month') {
            $number = (int)$this->date('end', 'month');
        } else {
            $number = substr((int)$this->date('end', 'year'), 2, 2);
        }
        
        foreach ($map as $roman_numeral => $value) {
            while ($number >= $value) {
                $roman .= $roman_numeral;
                $number -= $value;
            }
        }
        
        return $roman;
    }
}
