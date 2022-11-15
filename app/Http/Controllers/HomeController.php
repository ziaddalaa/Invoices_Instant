<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $count = invoices::count();
        $count1 = invoices::where('value_status', 1)->count();
        $count2 = invoices::where('value_status', 2)->count();
        $count3 = invoices::where('value_status', 3)->count();

        $percent1 = round(($count1 / $count) * 100, 2);
        $percent2 = round(($count2 / $count) * 100, 2);
        $percent3 = round(($count3 / $count) * 100, 2);



        $chartjs = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['الفواتير الغير مدفوعة', 'الفواتير المدفوعة'])
            ->datasets([
                [
                    'backgroundColor' => ['#f84b68', '#089c6c'],
                    'hoverBackgroundColor' => ['#f85771', '#36A2EB'],
                    'data' => [$percent1, $percent2]
                ]
            ])
            ->options([]);

        ///////////////////



        $chartjs1 = app()->chartjs
            ->name('lineChartTest')
            ->type('bar')

            ->size(['width' => 170, 'height' => 85])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "نسبة الفواتير",
                    'backgroundColor' => ['#f84b68', '#089c6c', '#f66f31'],
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [$percent1, $percent2, $percent3]
                ],

            ])
            ->options([]);
        $chartjs1->optionsRaw("{
                legend: {
                    display:true,
                    
                },  
                              
                scales: {
                    xAxes: [{
                        gridLines: {
                            display:false
                        }  
                    }],
                    

                }
            }");

        return view('home', compact('chartjs', 'chartjs1'));



        return view('home');
    }
}
