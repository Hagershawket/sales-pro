<?php

namespace App\Http\Controllers;
use App\ProductVariant;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    public function getvar($id){
         $productVatinets = ProductVariant::where("product_id" , $id)->get();
         return $productVatinets;
    }
}