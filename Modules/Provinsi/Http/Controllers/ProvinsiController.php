<?php

namespace Modules\Provinsi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Provinsi\Entities\Provinsi;
class ProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $items = Provinsi::latest()->paginate(5);
        
        
                $response = [
        
                    'pagination' => [
        
                        'total' => $items->total(),
        
                        'per_page' => $items->perPage(),
        
                        'current_page' => $items->currentPage(),
        
                        'last_page' => $items->lastPage(),
        
                        'from' => $items->firstItem(),
        
                        'to' => $items->lastItem()
        
                    ],
        
                    'data' => $items
        
                ];
        
        
                return response()->json($response);
    }
    public function provinsi(){
        return view('provinsi::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
      
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $provinsiobject = new Provinsi();
        $provinsiobject->namaprovinsi = $request->provinsi;
        $provinsiobject->save();

    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('provinsi::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('provinsi::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request,$id)
    {
        $edit = Provinsi::where('id',$id)->update(['namaprovinsi'=>$request->provinsi]);
        //return response()->json($edit);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
       Provinsi::where('id',$id)->delete();
    }
}
