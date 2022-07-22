<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CountryCode;
use App\Models\Job;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    /**
     * Display a reports/daily-report view to user
     * if request is ajax then function will return the json of the daily data group by country and day.
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function dailyReport(Request $request)
    {
        if ($request->ajax()) {
            $query = Job::join('job_processing', 'job_processing.job_id', 'job.id')
                ->join('number', 'number.id', 'job_processing.number_id')
                ->join('company', 'company.id', 'number.company_id')
                ->join('country_code', 'country_code.id', 'number.country_code_id')
                ->select(
                    DB::Raw('strftime("%m-%Y", job_processing.created_on) AS day'),
                    DB::Raw('company.name AS company_name'),
                    'country_code.country_name',
                    DB::Raw('COUNT(job_processing.id) AS number_of_tests'),
                    DB::raw('SUM(CASE
                WHEN job_processing.call_description_id != ""
                THEN 1 ELSE 0 END) AS number_of_fails'),
                    DB::raw('IFNULL(COUNT(job_processing.id) / (COUNT(job_processing.id) - SUM(CASE
                WHEN job_processing.call_description_id != ""
                THEN 1 ELSE 0 END)) * 100,0) AS connection_score'),
                    DB::raw('AVG(ROUND((JULIANDAY(call_connect_time) - JULIANDAY(call_start_time)) * 86400)) AS pdd_score')
                )
                ->groupBy('number.country_code_id', 'day');

            return Datatables::of($query)
                ->editColumn('pdd_score', function ($row) {
                    return round($row->pdd_score) . ' seconds';
                })
                ->editColumn('connection_score', function ($row) {
                    return round($row->connection_score) . '%';
                })
                ->filter(function ($instance) use ($request) {

                    /*Filter records if parameter 'company' is not empty, checks column 'company.id' is equal to 'company' parameter*/
                    if (!empty($request->get('company'))) {
                        $instance->where(function ($w) use ($request) {
                            $w->where('company.id', $request->get('company'));
                        });
                    }

                    /*Filter records if parameter 'country' parameter is not empty, checks column 'country.id' is equal to 'country' parameter*/
                    if (!empty($request->get('country'))) {
                        $instance->where(function ($w) use ($request) {
                            $w->where('country_code.id', $request->get('country'));
                        });
                    }

                    /*Filter records if parameter 'from' is not empty, checks column 'job_processing.created_on' greater than or equal to 'from' parameter*/
                    if (!empty($request->get('from'))) {
                        $instance->where(function ($w) use ($request) {
                            $w->whereDate('job_processing.created_on', '>=', $request->get('from'));
                        });
                    }

                    /*Filter records if parameter 'to' is not empty, checks column 'job_processing.created_on' less than or equal to 'to' parameter*/
                    if (!empty($request->get('to'))) {
                        $instance->where(function ($w) use ($request) {
                            $w->whereDate('job_processing.created_on', '<=', $request->get('to'));
                        });
                    }
                })
                ->toJson();
        }

        /*get the list of companies*/
        $company = Company::get();

        /*get the list of countries*/
        $country = CountryCode::get();

        return view('reports.daily-report', compact('company', 'country'));
    }

    /**
     * Display a reports/month-report view to user
     * if request is ajax then function will return the json of the monthly data group by country and month.
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function monthlyReport(Request $request)
    {
        if ($request->ajax()) {
            $query = Job::join('job_processing', 'job_processing.job_id', 'job.id')
                ->join('number', 'number.id', 'job_processing.number_id')
                ->join('company', 'company.id', 'number.company_id')
                ->join('country_code', 'country_code.id', 'number.country_code_id')
                ->select(
                    DB::Raw('strftime("%m-%Y", job_processing.created_on) AS month'),
                    DB::Raw('company.name AS company_name'),
                    'country_code.country_name',
                    DB::Raw('COUNT(job_processing.id) AS number_of_tests'),
                    DB::raw('SUM(CASE
                WHEN job_processing.call_description_id != ""
                THEN 1 ELSE 0 END) AS number_of_fails'),
                    DB::raw('IFNULL(COUNT(job_processing.id) / (COUNT(job_processing.id) - SUM(CASE
                WHEN job_processing.call_description_id != ""
                THEN 1 ELSE 0 END)) * 100,0) AS connection_score'),
                    DB::raw('AVG(ROUND((JULIANDAY(call_connect_time) - JULIANDAY(call_start_time)) * 86400)) AS pdd_score')
                )
                ->groupBy('number.country_code_id', 'month');

            return Datatables::of($query)
                ->editColumn('pdd_score', function ($row) {
                    return round($row->pdd_score) . ' seconds';
                })
                ->editColumn('connection_score', function ($row) {
                    return round($row->connection_score) . '%';
                })
                ->filter(function ($instance) use ($request) {

                    /*Filter records if parameter 'company' is not empty, checks column 'company.id' is equal to 'company' parameter*/
                    if (!empty($request->get('company'))) {
                        $instance->where(function ($w) use ($request) {
                            $w->where('company.id', $request->get('company'));
                        });
                    }

                    /*Filter records if parameter 'country' parameter is not empty, checks column 'country.id' is equal to 'country' parameter*/
                    if (!empty($request->get('country'))) {
                        $instance->where(function ($w) use ($request) {
                            $w->where('country_code.id', $request->get('country'));
                        });
                    }

                    /*Filter records if parameter 'from' is not empty, checks column 'job_processing.created_on' greater than or equal to 'from' parameter*/
                    if (!empty($request->get('from'))) {
                        $instance->where(function ($w) use ($request) {
                            $w->whereDate('job_processing.created_on', '>=', $request->get('from') . '-01');
                        });
                    }

                    /*Filter records if parameter 'to' is not empty, checks column 'job_processing.created_on' less than or equal to 'to' parameter*/
                    if (!empty($request->get('to'))) {
                        $instance->where(function ($w) use ($request) {
                            $w->whereDate('job_processing.created_on', '<=', Carbon::parse($request->get('to') . '-01')->endOfMonth());
                        });
                    }
                })
                ->toJson();
        }

        /*get the list of companies*/
        $company = Company::get();

        /*get the list of countries*/
        $country = CountryCode::get();

        return view('reports.monthly-report', compact('company', 'country'));
    }
}
