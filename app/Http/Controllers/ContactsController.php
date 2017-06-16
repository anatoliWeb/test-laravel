<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Contacts;


class ContactsController extends Controller
{
    public function index(){

        // check all data to zoho

        $contacts = Contacts::all();
        return view('contacts.list',['rows'=>$contacts]);
    }

    public function show($id = 0){
        $rows = Contacts::find($id);
        return view('contacts.form', is_null($rows)?[]:$rows->toArray());
    }

    public function create(Request $request){

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


        // if oko update zoho_id else remove data and show messeges error

        return redirect(route('contacts'));
    }

    public function update(Request $request, $id = 0){

        // add validation

        $model = Contacts::find($id);
        $model->email= $request->get('email', '');
        $model->first_name= $request->get('first_name', '');
        $model->last_name= $request->get('last_name', '');
        $model->phone= $request->get('phone', '');
        $model->save();

        // update data to zoho

        return redirect(route('contacts'));
    }

    public function delete($id = 0){

        // first remove to zoho if ok remove local

        $model = Contacts::find($id);
        $model->delete();

        return redirect(route('contacts'));
    }
}
