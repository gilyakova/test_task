<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;
use App\Company;
use App\Person;
use Illuminate\Support\Facades\Artisan;
use Redirect;

class AppointmentsController extends Controller
{
    function __construct() { Artisan::call('view:clear'); }

    /**
     *
     */
    public function index(Appointment $appointment)
    {
        $data['page_type'] = 'index';
        return view("index", $data);
    }

    /**
     * Download csv file
     */
    public function get_csv(Appointment $appointment)
    {
        $data = $appointment->list_all();
        $data = $appointment->list_all();
        $f = fopen('php://memory', 'w'); 
        fputcsv($f, array('id', 'status', 'datetime', 'place', 'contacts', 'note', 'company name', 'company address', 'company postal code', 'URL', 'person', 'person telephone', 'person email', 'person salutation'), ';'); 
        foreach ($data as $r)
        { 
            $arr = [
                $r->id,
                $r->status,
                $r->datetime,
                $r->place,
                $r->contacts,
                $r->note,
                $r->company->name,
                $r->company->locality . ', ' . $r->company->street . ', ' . $r->company->house_number,
                $r->company->postal_code,
                $r->company->url,
                $r->person ? $r->person->first_name . ' ' . $r->person->last_name : '',
                $r->person ? $r->person->telephone : '',
                $r->person ? $r->person->email : '',
                $r->person ? $r->person->salutation : '',
            ];
            fputcsv($f, $arr, ';'); 
        }
        fseek($f, 0);
        $size = fstat($f)['size'];
        header('Content-Description: File Transfer');
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename=appointments.csv' );
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . $size);
        // I think dialog doesn't work in all browser
        fpassthru($f);
    }

    /**
     *
     */
    public function create(Appointment $appointment, Company $company)
    {
        $data['page_type'] = 'create';
        $tmp = $company->list();
        $data['companies'] = [];
        $data['companies'][''] = ' - ';
        foreach ($tmp as $r)
        {
            $data['companies'][$r->id] = $r->name;
        }
        return view('appointments/form', $data);
    }


    /**
     *
     */
    public function update(Request $request, Company $company, $id)
    {
        $data['page_type'] = 'index';
        $tmp = $company->list();
        $data['companies'] = [];
        $data['companies'][''] = ' - ';
        foreach ($tmp as $r)
        {
            $data['companies'][$r->id] = $r->name;
        }
        $data['item'] = Appointment::find($id);
        if ( ! $data['item'])
        {
            return Redirect::to('/');
        }
        $company_item = Company::find($data['item']->company_id);
        $data['person_list'] = [];
        $data['person_list'][''] = ' - ';
        foreach ($company_item->people as $r)
        {
            $data['person_list'][$r->id] = $r->first_name . ' ' . $r->last_name;
        }
        $data['item']->datetime = date('d.m.Y H:i', strtotime($data['item']->datetime));
        return view('appointments/form', $data);
    }

    /**
     *
     */
    public function set_status(Request $request)
    {
        if (array_search($request->input('status'), array('active', 'cancel', 'confirm')) === FALSE || ! $request->input('id') || ! $item = Appointment::find($request->input('id')))
        {
            die(json_encode(array('result' => 'ERROR')));
        }

        $item->status = $request->input('status');
        $item->save();
        die(json_encode(array('result' => 'OK')));
    }

    /**
     *
     */
    public function store(Request $request, $id = NULL)
    {
        $this->validate($request, [
            'datetime' => 'required|max:255',
            'place' => 'required|max:255',
            'company_id' => 'required',
            'contacts' => 'max:2000',
        ]);
        $inputs = $request->all();
        unset($inputs['_token']);
        $inputs['datetime'] = date('Y-m-d H:i', strtotime($inputs['datetime']));
        Appointment::updateOrCreate(array('id' => $id), $inputs);
        return Redirect::to('/');
    }

    /**
     *
     */
    public function delete(Request $request)
    {
        if ( ! $request->input('id') || ! $item = Appointment::find($request->input('id')))
        {
            die(json_encode(array('result' => 'ERROR')));
        }

        $item->delete();
        die(json_encode(array('result' => 'OK')));
    }

    /**
     * Return list people by company
     * @param int $company_id
     */
    public function get_people(Person $person, $company_id)
    {
        $tmp = $person->list($company_id);
        die(json_encode(array('result' => 'OK', 'list' => $tmp)));
    }

    //======================API=========================//

    /**
     * Return list people by company
     * @param int $company_id
     */
    public function get_appoinpent_list(Appointment $appointment, Request $request)
    {
        if ( ! $request->input('limit') || intval($request->input('limit')) > 1000 || intval($request->input('limit')) < 1)
        {
            $limit = 10;
        }
        else
        {
            $limit = intval($request->input('limit'));
        }
        if ( ! $request->input('page') || intval($request->input('page')) < 0)
        {
            $page = 0;
        }
        else
        {
            $page = intval($request->input('page'));
        }
        if (array_search($request->input('status'), array('active', 'cancel', 'confirm')) === FALSE)
        {
            $status = 'active';
        }
        else
        {
            $status = $request->input('status');
        }

        $list = $appointment->list($status, $limit, $page);
        die(json_encode(array('result' => 'OK', 'list' => $list)));
    }

}
