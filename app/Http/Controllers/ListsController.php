<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Lists;

class ListsController extends Controller
{
    /*
     * Add and remove correspondents from different lists: blacklist, favourites...
     */
    /*
     * Add correspondent($cor_id) to list($list) by user($id)
     */
    public function addToList($id, $cor_id, $list){

        $list_record = new Lists();
        $list_record->subject_id = $id;
        $list_record->object_id = $cor_id;
        $list_record->list = $list;
        $list_record->save();

        return redirect()->back();
    }
    /*
     * Remove correspondent($cor_id) from list($list) by user($id)
     */
    public function removeFromList($id, $cor_id, $list){

        $list_record = Lists::where('subject_id', '=', $id)
            ->where('object_id', '=', $cor_id)
            ->where('list', '=', $list)
            ->first();
        $list_record->delete();

        return redirect()->back();
    }

}
