<?php
namespace App\Modules\Cars\Models;
use App\Modules\Cars\Models\Cars;
use DB;
use Session;
use Log;
use Illuminate\Support\Str;
class Cars 
{
    protected $table = 'car';
    // protected $fillable = [
    //     'name', 'email',
    // ];  

    public function getCarsData(){
      $query = DB::table('car as c')->select(['c.make','cc.name','c.model','c.build_date','c.created_at','c.updated_at'])
              ->leftjoin('car_colour as cc','cc.colour_id','=','c.colour_id')
              ->get()->all();
      return $query;
    }  

    public function getCarsByCarID($id){
      //$query = DB::table('car')->select('*')->where('id',$id)->first();

      $query = DB::table('car as c')->select(['c.make','cc.name','c.model','c.build_date','c.created_at','c.updated_at'])
              ->where('id',$id)
              ->leftjoin('car_colour as cc','cc.colour_id','=','c.colour_id')
              ->first();
      return $query;
    }

    public function insertCarData($data,$input_date,$getColour){
      $car_data = array(
        'make'=>$data['name'],
        'model'=>$data['model'],
        'build_date'=>$input_date,
        'colour_id'=>$getColour,
        'created_at'=>date('Y-m-d H:i:s'),
        'updated_at'=>date('Y-m-d H:i:s'),
      );
      $query = DB::table('car')->insertGetId($car_data);
      return $query;
    }

    public function getColourID($colour){
      $query = DB::table('car_colour')->select('colour_id')->where('name',"$colour")->first();
      return $query;
    }
    public function getRecordByID($id){
      $getRecord =  DB::table('car')->select('*')->where('id',$id)->first();
      return $getRecord;
    }

    public function getColourFromTable($colour_id){
      $query = DB::table('car_colour')->select('colour_id')->where('name',"$colour_id")->first();
      return $query;
    }
    public function updateData($result,$check,$colourID,$input_date){
      $query = DB::table('car')->select('*')
              ->where('id',$check->id)
              ->update(['colour_id'=>$colourID->colour_id,
                        'make'=>$result['name'],
                        'model'=>$result['model'],
                        'build_date'=>$input_date,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s')
            ]);
      return $query;        
    }

    public function findRecordByID($id){
      $getRecord =  DB::table('car')->select('*')->where('id',$id)->first();
      return $getRecord;
    }
    public function deleteRecordByID($id){
     $query = DB::table('car')->where('id',$id)->delete();
     return $query;
    }
}


