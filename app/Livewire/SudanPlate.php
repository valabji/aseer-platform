<?php

namespace App\Livewire;

use Livewire\Component;

class SudanPlate extends Component
{
    public string $number_ar;
    public string $number_en;
    public string $letter_ar;
    public string $code_ar;
    public string $code_en;
    public function render()
    {
        // <livewire:sudan-plate
        //        number_ar="١٠٣٦"
        //        number_en="111"
        //        letter_ar="خ"
        //        code_ar="٧"
        //        code_en="7KH"
        //    />
        return view('livewire.carplate');
    }
}
