<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\GlobalController;

use App\SQLDatabase;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        GlobalController::set_table('permissions');
        $sql = new SQLDatabase;

        $data = [];

        $type = isset($_GET['type']) ? $_GET['type'] : '';
        switch ($type) {
            case 'master':
                $condition = ['parent_id'=>0];
                $getJson    = true;
                $jsonStatus = 200;
                break;
            default:
                $condition  = '';
                $getJson    = true;
                $jsonStatus = 301;
                break;
        }

        if($getJson) {
            $get_data = $sql->get_data('get', $condition);
            if(!empty($get_data)) {
                foreach($get_data as $items) {
                    $data[] = [
                        'value' => $items->id,
                        'text'  => $items->name
                    ];
                }
            }
            return response()->json($data);
        } else {
            return 'No type';
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
