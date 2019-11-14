<?php

namespace App\Http\Controllers\Admin\AnnualIncomes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\AnnualIncomes\AnnualIncome;

use App\Http\Requests\Admin\AnnualIncomes\AnnualIncomeStoreRequest;

class AnnualIncomeController extends Controller
{

    public function __construct() {
        $this->middleware('App\Http\Middleware\Admin\AnnualIncomes\AnnualIncomeMiddleware', 
            ['only' => ['index', 'create', 'store', 'show', 'update', 'archive', 'restore', 'reOrder']]
        );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.annual_incomes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.annual_incomes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnnualIncomeStoreRequest $request)
    {
        $item = AnnualIncome::store($request);

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = AnnualIncome::withTrashed()->findOrFail($id);
        return view('admin.annual_incomes.show', [
            'item' => $item,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnnualIncomeStoreRequest $request, $id)
    {
        $item = AnnualIncome::withTrashed()->findOrFail($id);
        $message = "You have successfully updated {$item->renderName()}";

        $item = AnnualIncome::store($request, $item);

        return response()->json([
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AnnualIncome  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = AnnualIncome::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived {$item->renderName()}",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\AnnualIncome  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = AnnualIncome::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored {$item->renderName()}",
        ]);
    }

    /*
     * Reorder the position of annual income 
     */
    public function reOrder(Request $request)
    {
        foreach ($request->items as $key => $item) {

            $incomePos = AnnualIncome::find($item['id']);

            if($incomePos) {
                $incomePos->update(['order' => $key ]);
            }

        }

        return response()->json([
            'message' => 'Successfully updated the order of annual income',
        ]);
    }
}
