<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Contacts;
use App\Service\Contents as ServiceContacts;

class ContactsController extends Controller
{
    /**
     * @class App\Service\Contents
     */
    protected $service;

    public function __construct()
    {
        // init service (better add this proces to base controller)
        $this->service = new ServiceContacts();
    }

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

        // function create contact
        $this->service->Create($request);

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
        $this->service->Update($request, $id);

        return redirect(route('contacts'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id = 0)
    {
        $this->service->Delete($id);

        return redirect(route('contacts'));
    }
}
