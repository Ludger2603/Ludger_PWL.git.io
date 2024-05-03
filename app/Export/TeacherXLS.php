<?php

namespace App\Export;

use App\Models\Teacher;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TeacherXLS implements FromView
{

    public function view(): View
    {
        $rows = Teacher::query()->get();
        return view('content.teacher.export-excel', [
            "rows" => $rows
        ]);
    }
}
