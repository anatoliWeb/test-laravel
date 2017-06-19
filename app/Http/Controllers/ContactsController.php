<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Contacts;
use Zoho\CRM\Entities\Contact as ZohoContact;
use Zoho\CRM\ZohoClient;


class ContactsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        // check all data to zoho

        $contacts = Contacts::all();
        return view('contacts.list',['rows'=>$contacts]);
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id = 0)
    {
        $rows = Contacts::find($id);
        return view('contacts.form', is_null($rows)?[]:$rows->toArray());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function create(Request $request)
    {

        // add validation

        $model = Contacts::getModel();
        $model->user_id = 0;
        $model->zoho_id = 0;
        $model->email= $request->get('email', '');
        $model->first_name= $request->get('first_name', '');
        $model->last_name= $request->get('last_name', '');
        $model->phone= $request->get('phone', '');
        $model->save();

        //create dato to zoho
        $mZohoContact = new ZohoContact();

        // Mapping the request for create xmlstr
        $xmlstr = $mZohoContact->serializeXml($model->toArray());

        $mZohoContact->deserializeXml($xmlstr);

        // Make the connection to zoho api
        $ZohoClient = new ZohoClient(config('zohocrm.token'));

        // Selecting the module
        $ZohoClient->setModule('Contact');

        // Create valid XML (zoho format)
        $validXML = $ZohoClient->mapEntity($ZohoClient);

        // Insert the new record
        $response = $ZohoClient->insertRecords($validXML, ['wfTrigger' => 'true']);

        dd($response);
        // if oko update zoho_id else remove data and show messeges error

        return redirect(route('contacts'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function update(Request $request, $id = 0)
    {

        // add validation

        $model = Contacts::find($id);
        $model->email= $request->get('email', '');
        $model->first_name= $request->get('first_name', '');
        $model->last_name= $request->get('last_name', '');
        $model->phone= $request->get('phone', '');
        $model->save();

        //create dato to zoho
        $mZohoContact = new ZohoContact();

        // Mapping the request for create xmlstr
        $xmlstr = $mZohoContact->serializeXml($model->toArray());

        $mZohoContact->deserializeXml($xmlstr);

        // Make the connection to zoho api
        $ZohoClient = new ZohoClient(config('zohocrm.token'));

        // Selecting the module
        $ZohoClient->setModule('Contact');

        // Create valid XML (zoho format)
        $validXML = $ZohoClient->mapEntity($ZohoClient);

        // Update the new record
        $response = $ZohoClient->updateRecords($model->zoho_id ,$validXML, ['wfTrigger' => 'true']);

        return redirect(route('contacts'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id = 0)
    {
        $model = Contacts::find($id);

        if(is_null($model)){
            return redirect(route('contacts'));
        }

        // first remove to zoho if ok remove local
        // Make the connection to zoho api
        $ZohoClient = new ZohoClient(config('zohocrm.token'));

        // Selecting the module
        $ZohoClient->setModule('Contact');

        // Delete the new record
        $response = $ZohoClient->deleteRecords($model->zoho_id);

        $model = Contacts::find($id);
        $model->delete();

        return redirect(route('contacts'));
    }
}
