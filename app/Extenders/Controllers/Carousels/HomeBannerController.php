<?php

namespace App\Extenders\Controllers\Carousels;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests\Admin\Carousels\HomeBannerStoreRequest;

use App\Models\Carousels\HomeBanner;

class HomeBannerController extends Controller
{
    protected $indexView;
    protected $createView;
    protected $showView;
    protected $guard = 'admin';
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->indexView, [
            //
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->createView, [
            //
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HomeBannerStoreRequest $request)
    {
        $item = HomeBanner::store($request);

        $message = "You have successfully created {$item->renderName()}";
        $redirect = $item->renderShowUrl();

        return response()->json([
            'message' => $message,
            'redirect' => $redirect,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HomeBanner  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id, $slug = null)
    {
        $item = HomeBanner::withTrashed()->findOrFail($id);

        if ($this->guard == 'web' && !$slug) {
            return redirect()->to($item->renderShowUrl('web'));
        }

        return view($this->showView, [
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HomeBanner $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function update(HomeBannerStoreRequest $request, $id)
    {
        $item = HomeBanner::withTrashed()->findOrFail($id);
        $message = "You have successfully updated {$item->renderName()}";

        $item = HomeBanner::store($request, $item);

        return response()->json([
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HomeBanner  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = HomeBanner::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived {$item->renderName()}",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\HomeBanner  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = HomeBanner::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored {$item->renderName()}",
        ]);
    }

    public function removeImage(Request $request, $id)
    {
        $item = HomeBanner::withTrashed()->findOrFail($id);
        $message = "You have successfully remove the image in {$item->renderName()}";

        $result = $item->removeImage($request);

        return response()->json([
            'message' => $message,
        ]);
    }
}
