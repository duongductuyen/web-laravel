<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Redis;
use phpDocumentor\Reflection\DocBlock\Tags\See;

session_start();

class CartController extends Controller
{
    public function save_cart(Request $request)
    {        
        $productId = $request->productid_hidden;
        $quantity = $request->qty;
        $product_info = DB::table('tbl_product')->where('product_id',$productId)->first();

        $data['id'] = $product_info->product_id;
        $data['qty'] = $quantity;
        $data['name'] = $product_info->product_name;
        $data['price'] = $product_info->product_price;
        $data['weight'] = '123';
        $data['options']['image'] = $product_info->product_image;
        Cart::add($data);
        Cart::setGlobalTax(5);

        return Redirect::to('/show-cart');   
        // Cart::destroy();     
    }

    public function show_cart()
    {
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id')->get();
        $brand_product = DB::table('tbl-brand')->where('brand_status','1')->orderBy('brand_id')->get();
        return view('pages.cart.show_cart')->with('category',$cate_product)->with('brand',$brand_product);
    }

    public function delete_to_cart($rowId)
    {
        Cart::update($rowId,0);
        return Redirect::to('/show-cart'); 
    }

    public function update_cart_quatity(Request $request)
    {
        $rowId = $request->rowId_cart;
        $qty = $request->cart_quantity;
        Cart::update($rowId,$qty);
        return Redirect::to('/show-cart');
    }

    public function add_cart_ajax(Request $request)
    {
        $data = $request->all();
        $session_id = substr(md5(microtime()), rand(0,26),5);
        $cart = Session::get('cart');

        if($cart == true)
        {
            $is_avaiable = 0;
            foreach($cart as $key => $val){
                if($val['product_id'] == $data['product_id']){
                    $is_avaiable++;
                }
            }
            if($is_avaiable == 0){
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_id' => $data['cart_product_id'],
                    'product_name' => $data['cart_product_name'],
                    'product_image' => $data['cart_product_image'],
                    'product_price' => $data['cart_product_price'],
                    'product_qty' => $data['cart_product_qty'],
                );
                Session::put('cart',$cart);
            }
        }
        else{
            $cart[] = array(
                'session_id' => $session_id,
                'product_id' => $data['cart_product_id'],
                'product_name' => $data['cart_product_name'],
                'product_image' => $data['cart_product_image'],
                'product_price' => $data['cart_product_price'],
                'product_qty' => $data['cart_product_qty'],
            );
        }
        Session::put('cart',$cart);
        Session::save();
    }

    public function gio_hang(Request $request)
    {
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id')->get();
        $brand_product = DB::table('tbl-brand')->where('brand_status','1')->orderBy('brand_id')->get();
        return view('pages.cart.cart_ajax')->with('category',$cate_product)->with('brand',$brand_product);
    }
}
