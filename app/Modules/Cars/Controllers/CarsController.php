<?php 
namespace App\Modules\Cars\Controllers;
use App\Modules\Cars\Controllers\CarsController;
use Illuminate\Http\Request;
use App\Modules\Cars\Models\Cars;
use Lang;
use DateTime;
use Carbon\Carbon;
date_default_timezone_set('Asia/Kolkata'); 

class CarsController{
    private $cars;
  	public function __construct(){
    $this->cars = new Cars();
    }

    public function getCars(){
    	return response()->json($this->cars->getCarsData(),200);
    }

    public function getCarsByID($id){
    	$result = $this->cars->getCarsByCarID($id);
    	if (is_null($result)){
    		return response()->json(["message"=>"Car Record not Found"],404);
    	}
    	return response()->json($result,200);
    }

    public function insertCarRecord(Request $request){
    	$request = $request->all();
        $start_date = $request['date'];
        $current = date('Y-m-d', strtotime('-4 years'));
        $date_str = str_replace('/', '-', $start_date);
        $input_date = date('Y-m-d', strtotime($date_str));
        if ($input_date< $current) {
            return response()->json(["message"=>"The car cannot be older than four years"],404);
        }
        $colour = $request['colour_name'];
        $getColour =$this->cars->getColourID($colour);
        if (empty($getColour)) {
            return response()->json(["message"=>"please Provide Proper Colour"],404);
        }
    	$result = $this->cars->insertCarData($request,$input_date,$getColour->colour_id);
    	if ($result>0) {
    		return response()->json(["message"=>"Car Record Saved Successfully"],201);
    	}
    	return response()->json(["message"=>"Something Went Wrong"],500);
    }
    public function updateRecord(Request $request,$id){
        $request=$request->all();
    	$check = $this->cars->getRecordByID($id);
    	if (is_null($check)){
    		return response()->json(["message"=>"Car Record not Found"],404);
    	}
        $getColourID =$this->cars->getColourFromTable($request['colour_name']);
        if (empty($getColourID->colour_id)) {
            return response()->json(["message"=>"please Provide Proper Colour"],404);
        }
        $start_date = $request['date'];
        $current = date('Y-m-d', strtotime('-4 years'));
        $date_str = str_replace('/', '-', $start_date);
        $input_date = date('Y-m-d', strtotime($date_str));
        if ($input_date< $current) {
            return response()->json(["message"=>"The car cannot be older than four years"],404);
        }
    	$update = $this->cars->updateData($request,$check,$getColourID,$input_date);
        if (is_null($update)){
            return response()->json(["message"=>"Something Went Wrong"],500);
        }
        return response("Car Record Updated Successfully",200);
    }

    public function deleteCarByID($id){
    	$result = $this->cars->findRecordByID($id);
        if (is_null($result)){
            return response()->json(["message"=>"Car Record not Found"],404);
        }
        $getResult = $this->cars->deleteRecordByID($id);
        if ($getResult>0) {
            return response()->json("Record Deleted Successfully",200);
        }
    }
}    