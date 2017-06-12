<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;
use App\Company;
use App\Person;
use Illuminate\Support\Facades\Artisan;
use Redirect;
use PDF;

class AppointmentsController extends Controller
{
    private $token = '8542516f8870173d7d1daba1daaaf0a1';
    //function __construct() { Artisan::call('view:clear'); }

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
        $f = fopen('php://memory', 'w'); 
        fputcsv($f, array('id', 'status', 'datetime', 'place', 'contact information', 'note', 'company name', 'company address', 'company postal code', 'URL', 'person', 'person telephone', 'person email', 'person salutation'), ';'); 
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
     * Download pdf file
     */
    public function get_pdf(Appointment $appointment)
    {
        $html = '<h1>Appointment list</h1>';

        $data = $appointment->list_all();
        $html .= '<table><tbody>';
        foreach ($data as $r)
        { 
            $html .= "<tr style='background:#eee;'>"
                    ."<td>#{$r->id}</td>"
                    ."<td>{$r->status}</td>"
                    ."<td>{$r->datetime}</td>"
                    ."<td>{$r->place}</td></tr>";
            $html .= "<tr><td colspan='4'>Contact information: {$r->contacts}</td></tr>";
            $html .= "<tr><td colspan='4'>Note: {$r->note}</td></tr>";
            $html .= "<tr>"
                    ."<td>Company name: {$r->company->name}</td>"
                    ."<td>Company address: {$r->company->locality}, {$r->company->street}, {$r->company->house_number}</td>"
                    ."<td>".($r->company->postal_code ? "Postal code: {$r->company->postal_code}" : '')."</td>"
                    ."<td>".($r->company->url ? "Company URL: {$r->company->url}" : '')."</td>"
                    ."</tr>";
            $html .= "<tr>"
                    ."<td>".($r->person ? "Person name: {$r->person->first_name} {$r->person->last_name}" : '')."</td>"
                    ."<td>".($r->person ? "Person telephone: {$r->person->telephone}" : '')."</td>"
                    ."<td>".($r->person ? "Person email: {$r->person->email}" : '')."</td>"
                    ."<td>".($r->person ? "Salutation: {$r->person->salutation}" : '')."</td>"
                    ."</tr>";
        }
        $html .= '</tbody></table>';
        $pdf = PDF::loadHTML($html);
        return $pdf->download('appointments.pdf');
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
        if ($this->token != $request->input('token'))
        {
            die(json_encode(array('result' => 'ERROR', 'message' => 'Auth field')));
        }
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
