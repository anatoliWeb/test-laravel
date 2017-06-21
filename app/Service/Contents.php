<?php
namespace App\Service;

use App\Model\Contacts as ModelContacts;
use Zoho\CRM\Entities\Contact as ZohoContact;
use Zoho\CRM\ZohoClient;
use Illuminate\Http\Request;
/**
 * Class Contents
 * @package App\Service
 */
class Contents extends base
{

    /**
     * method create new row local and Zoho
     *
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    public function Create(Request $request)
    {

        // add validation

        $Contacts = ModelContacts::getModel();
        $Contacts->user_id = 0;
        $Contacts->zoho_id = 0;
        $Contacts->email= $request->get('email', '');
        $Contacts->first_name= $request->get('first_name', '');
        $Contacts->last_name= $request->get('last_name', '');
        $Contacts->phone= $request->get('phone', '');
        $Contacts->save();

        //create dato to zoho
        $mZohoContact = new ZohoContact();

        // Mapping the request for create xmlstr
        $xmlstr = $mZohoContact->serializeXml($Contacts->toArray());

        $mZohoContact->deserializeXml($xmlstr);

        // Make the connection to zoho api
        $ZohoClient = new ZohoClient(config('zohocrm.token'));

        // Selecting the module
        $ZohoClient->setModule('Contact');

        // Create valid XML (zoho format)
        $validXML = $ZohoClient->mapEntity($ZohoClient);

        // Insert the new record
        $response = $ZohoClient->insertRecords($validXML, ['wfTrigger' => 'true']);

        // add check response

        return true;
    }

    /**
     * method update data local and Zoho
     *
     * @param Request $request
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function Update(Request $request, $id = 0)
    {
        // add validation

        $Contacts = ModelContacts::find($id);
        $Contacts->email= $request->get('email', '');
        $Contacts->first_name= $request->get('first_name', '');
        $Contacts->last_name= $request->get('last_name', '');
        $Contacts->phone= $request->get('phone', '');
        $Contacts->save();

        //create dato to zoho
        $mZohoContact = new ZohoContact();

        // Mapping the request for create xmlstr
        $xmlstr = $mZohoContact->serializeXml($Contacts->toArray());

        $mZohoContact->deserializeXml($xmlstr);

        // Make the connection to zoho api
        $ZohoClient = new ZohoClient(config('zohocrm.token'));

        // Selecting the module
        $ZohoClient->setModule('Contact');

        // Create valid XML (zoho format)
        $validXML = $ZohoClient->mapEntity($ZohoClient);

        // Update the new record
        $response = $ZohoClient->updateRecords($Contacts->zoho_id ,$validXML, ['wfTrigger' => 'true']);

        // add check response

        return true;
    }

    /**
     * method delete row local and Zoho
     *
     * @param $id
     * @return bool
     */
    public function Delete($id)
    {
        $Contacts = ModelContacts::find($id);

        if (is_null($Contacts)) {
            return redirect(route('contacts'));
        }

        // first remove to zoho if ok remove local
        // Make the connection to zoho api
        $ZohoClient = new ZohoClient(config('zohocrm.token'));

        // Selecting the module
        $ZohoClient->setModule('Contact');

        // Delete the new record
        $response = $ZohoClient->deleteRecords($Contacts->zoho_id);

        // add check response

        $Contacts = ModelContacts::find($id);
        $Contacts->delete();

        return true;
    }
}
