<?php

namespace App\Http\Controllers;


use App\Category;

use App\Traits\GeneralTrait;

use Illuminate\Http\Request;


class CategoriesController extends Controller

{
   
 use GeneralTrait ;


    
public function getAll()
    
{
       
 $categories = Category::select('id','name_'.app()->getLocale().' as name')->get();
   
     return $this->returnData('category',$categories,'','5000');


//        return response()->json($categories);
 
   }


    
public function getCategoryId(request $request)
   
 {
       
 $categories = Category::find($request->id);
        
return $this->returnData('category',$categories,'','5000');
    
}


    
public function getCategoryById($id)
  
  {
      
  $category = Category::select('id','name_'.app()->getLocale().' as name')->find($id);
        if($category)
        {
            return $this->returnData('category',$category,'هذا القسم موجود بالفعل','5000');
        }
        else
        {
            return $this->returnError('001','هذا القسم غير موجود');
        }
    }


    public function updateCategoryById(request $request,$id)
    {
        $category = Category::find($id);
        if($category)
        {
            Category::find($id)->update(['active'=>$request->active]) ;
            return $this->returnSuccessMessage(' تم التعديل ','200') ;
        }
        else
        {
            return $this->returnError('001','هذا القسم غير موجود');
        }
    }




}















//        $category = new Category();
//        $category->name_ar  = request()->input('name_ar');
//        $category->name_en  = request()->input('name_en');
//        $category->save();
//
//        return request()->response()->json($category);
