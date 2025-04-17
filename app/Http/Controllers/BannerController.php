<?php

namespace App\Http\Controllers;

use App\DataTables\BannerDataTable;
use App\Models\Banner;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BannerDataTable $dataTable)
    {
        $pageTitle = __('message.list_form_title',['form' => __('message.banner')] );
        $auth_user = authSession();
        $assets = ['datatable'];
        $button = $auth_user->can('banner add') ? '<a href="'.route('banner.create').'" class="float-right btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> '.__('message.add_form_title',['form' => __('message.banner')]).'</a>' : '';
        return $dataTable->render('global.datatable', compact('pageTitle','button','auth_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = __('message.add_form_title',[ 'form' => __('message.banner')]);
        $assets = [];
        
        return view('banner.form', compact('pageTitle','assets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBannerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBannerRequest $request)
    {
        $data = $request->all();

        // if type es bottom then check if any other bottom banner exist and remove them
        if ($request->type == 'bottom') {
            Banner::where('type', 'bottom')->delete();
        }

        $banner = Banner::create($data);
            
        uploadMediaFile($banner, $banner->image, 'banner');

        $banner->image = getSingleMedia($banner, 'banner');
        $banner->save();

        return redirect()->route('banner.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle = __('message.update_form_title',[ 'form' => __('message.banner')]);
        $data = Banner::findOrFail($id);

        $assets = [];

        return view('banner.form', compact('data', 'pageTitle', 'id', 'assets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBannerRequest  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBannerRequest $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $data = $request->all();

        $banner->fill($data)->update();

        if (isset($request->image) && $request->image != null) {
            $banner->clearMediaCollection('banner');
            $banner->addMediaFromRequest('image')->toMediaCollection('banner');
        }

        return redirect()->route('banner.index')->withSuccess(__('message.update_form',['form' => __('message.banner')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        $message = __('message.delete_form',['form' => __('message.banner')]);
        $status = 'success';

        return redirect()->back()->with($status,$message);
    }
}
