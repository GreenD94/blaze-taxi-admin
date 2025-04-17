<?php

namespace App\Http\Controllers;

use App\DataTables\BonusDataTable;
use App\Http\Requests\BonusRequest;
use App\Models\Bonus;
use App\Models\User;
use Illuminate\Http\Request;

class BonusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BonusDataTable $dataTable)
    {
        $pageTitle = __('message.list_form_title',['form' => __('message.bonus')] );
        $auth_user = authSession();
        $assets = ['datatable'];
        $button = $auth_user->can('bonus add') ? '<a href="'.route('bonus.create').'" class="float-right btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> '.__('message.add_form_title',['form' => __('message.bonus')]).'</a>' : '';
        return $dataTable->render('global.datatable', compact('pageTitle','button','auth_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = __('message.add_form_title',[ 'form' => __('message.bonus')]);
        $assets = [];
        
        return view('bonus.form', compact('pageTitle','assets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BonusRequest $request)
    {
        $data = $request->all();

        if ($data['start_date_type'] == 'verification_date') {
            $data['starts_at'] = null;
        } else {
            $data['starts_at'] = $data['starts_at'] . ' 00:00:00';
        }

        if ($data['end_date_type'] == 'fixed') {
            $data['days_to_expiration'] = null;
            $data['ends_at'] = $data['ends_at'] . ' 23:59:59';
        } else if ($data['end_date_type'] == 'days_to_expiration') {
            $data['ends_at'] = null;
        }

        // dd($data);

        Bonus::create($data);

        return redirect()->route('bonus.index')->withSuccess(__('message.save_form', ['form' => __('bonus')]));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bonus  $bonus
     * @return \Illuminate\Http\Response
     */
    public function show(Bonus $bonus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bonus  $bonus
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle = __('message.update_form_title',[ 'form' => __('message.bonus')]);
        $data = Bonus::findOrFail($id);

        $assets = [];

        return view('bonus.form', compact('data', 'pageTitle', 'id', 'assets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bonus  $bonus
     * @return \Illuminate\Http\Response
     */
    public function update(BonusRequest $request, $id)
    {
        $bonus = Bonus::findOrFail($id);

        $data = $request->all();

        if ($data['start_date_type'] == 'verification_date') {
            $data['starts_at'] = null;
        } 

        if ($data['end_date_type'] == 'fixed_date') {
            $data['days_to_expiration'] = null;
        } else if ($data['end_date_type'] == 'days_to_expiration') {
            $data['ends_at'] = null;
        }

        $bonus->fill($data)->update();

        return redirect()->route('bonus.index')->withSuccess(__('message.update_form',['form' => __('message.bonus')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bonus  $bonus
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bonus = Bonus::findOrFail($id);
        $bonus->delete();
        $message = __('message.delete_form',['form' => __('message.bonus')]);
        $status = 'success';

        return redirect()->back()->with($status,$message);
    }

    public function getBonuses() {
        $driver = User::find(3);
        return checkBonusesForDriver($driver);
    }
}
