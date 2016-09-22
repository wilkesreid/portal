<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class TimeReportController extends Controller
{
    private $pay_period_one;
    private $pay_period_two;
    private $fdotm;
    private $fdolm;
    private $fdonm;
    private $pptm;
    private $pplm;
    private $ppnm;
    
    public function __construct() {
        $this->pay_period_one = \App\Setting::getValue("pay_period_one");
        $this->pay_period_two = \App\Setting::getValue("pay_period_two");
        $this->fdotm = new Carbon("first day of this month"); // fdotm = first day of this month
        $this->pptm = [ // pptm = pay period this month
            "first" => $this->fdotm->copy()->addDays($this->pay_period_one)->subDays(1),
            "second" => $this->fdotm->copy()->addDays($this->pay_period_two)->subDays(1)  
        ];
        $this->fdolm = new Carbon("first day of last month"); // fdolm = first day of last month
        $this->pplm = [ // pplm = pay period last month
            // first unnecessary (first pay period day of last month will never be relevant to now)
            "second" => $this->fdolm->copy()->addDays($this->pay_period_two)->subDays(1)
        ];
        $this->fdonm = new Carbon("first day of next month"); // fdonm = first day of next month
        $this->ppnm = [ // ppnm = pay period next month
            "first" => $this->fdonm->copy()->addDays($this->pay_period_one)->subDays(1)
            // second uneccessary (second pay period day of next month will never be relevant to now)
        ];
    }
    
    public function now() {
        return Carbon::now();
    }
    
    public function next_pay_period_day() {
        $now = Carbon::now();
        $fdotm = $this->fdotm; // first day of this month
        $fdolm = $this->fdolm; // first day of last month
        $fdonm = $this->fdonm; // first day of next month
        $pptm = $this->pptm; // pay period this month
        $pplm = $this->pplm; // pay period last month
        $ppnm = $this->ppnm; // pay period next month
        
        if ($now->lt($pptm['first'])) {
            return $pptm['first']->copy()->hour(0)->minute(0)->second(0);
        } elseif ($now->gte($pptm['first']) && $now->lt($pptm['second'])) {
            return $pptm['second']->copy()->hour(0)->minute(0)->second(0);
        } else {
            return $ppnm['first']->copy()->hour(0)->minute(0)->second(0);
        }
    }
    
    public function prev_pay_period_day() {
        $now = Carbon::now();
        $fdotm = $this->fdotm; // first day of this month
        $fdolm = $this->fdolm; // first day of last month
        $fdonm = $this->fdonm; // first day of next month
        $pptm = $this->pptm; // pay period this month
        $pplm = $this->pplm; // pay period last month
        $ppnm = $this->ppnm; // pay period next month
        
        if ($now->lt($pptm['first'])) {
            return $pplm['second']->copy()->hour(0)->minute(0)->second(0);
        } elseif ($now->gte($pptm['first']) && $now->lt($pptm['second'])) {
            return $pptm['first']->copy()->hour(0)->minute(0)->second(0);
        } else {
            return $pptm['second']->copy()->hour(0)->minute(0)->second(0);
        }
    }
    
    // View
    
    public function time() {
        return view('time/time', [
            "prev_pay_period_day" => $this->prev_pay_period_day(),
            "next_pay_period_day" => $this->next_pay_period_day()
        ]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
