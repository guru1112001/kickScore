<?php


// namespace App\Filament\Widgets;


// use App\Models\Calendar;

// use App\Models\Attendance;

// use Filament\Widgets\ChartWidget;

// use Illuminate\Support\Facades\DB;

// use Illuminate\Support\Facades\Auth;


// class AttendanceChart extends ChartWidget

// {
//     protected static ?int $sort = 3;

//     public static function canView(): bool
//     {
//         $user = auth()->user();
//         return $user && $user->role_id === 6;
//     }

//     protected static ?string $heading = 'Attendance';

//     protected static string $color = 'primary';

//     public ?string $filter = 'year';

//     protected function getData(): array

//     {

//         $scheduleData = $this->getMonthlyScheduleData();

//         $attendanceData = $this->getMonthlyAttendanceData();


//         $months = [

//             'January', 'February', 'March', 'April', 'May', 'June',

//             'July', 'August', 'September', 'October', 'November', 'December'

//         ];


//         return [

//             'datasets' => [

//                 [

//                     'label' => 'Scheduled Classes',

//                     'data' => $scheduleData,

//                     'backgroundColor' => '#36A2EB',

//                     'borderColor' => '#9BD0F5',

//                 ],

//                 [

//                     'label' => 'Attendance',

//                     'data' => $attendanceData,

//                     'backgroundColor' => '#FF6384',

//                     'borderColor' => '#FF9BBF',

//                 ],

//             ],

//             'labels' => $months,

//         ];

//     }


//     protected function getType(): string

//     {

//         return 'bar';

//     }


//     protected function getMonthlyScheduleData()

//     {

//         $schedules = Calendar::select(

//             DB::raw('MONTH(start_time) as month'),

//             DB::raw('COUNT(*) as total')

//         )
//             ->groupBy(DB::raw('MONTH(start_time)'))
//             ->get()
//             ->pluck('total', 'month')
//             ->toArray();


//         return $this->formatDataForChart($schedules);

//     }


//     protected function getMonthlyAttendanceData()

//     {

//         $userId = Auth::id(); // Get the logged-in user's ID


//         $attendances = Attendance::where('attendances.user_id', $userId)
//             ->select(

//                 DB::raw('MONTH(attendances.date) as month'),

//                 DB::raw('COUNT(*) as total')

//             )
//             ->groupBy(DB::raw('MONTH(attendances.date)'))
//             ->get()
//             ->pluck('total', 'month')
//             ->toArray();


//         return $this->formatDataForChart($attendances);

//     }


//     protected function formatDataForChart($data)

//     {

//         $formattedData = array_fill(0, 12, 0);


//         foreach ($data as $month => $total) {

//             $monthIndex = (int)$month - 1;

//             if ($monthIndex >= 0 && $monthIndex < 12) {

//                 $formattedData[$monthIndex] = $total;

//             }

//         }


//         return $formattedData;

//     }



//     // public function getFilters(): ?array

//     // {

//     //     return [

//     //         'year' => 'This year',

//     //         'month' => 'This month',

//     //     ];

//     // }

// }
