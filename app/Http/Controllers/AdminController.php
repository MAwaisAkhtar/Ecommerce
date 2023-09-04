<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\order;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SendEmailNotification;
use Notification;
use PDF;
class AdminController extends Controller
{
    //
    public function category()
    {
        if (Auth::id() && Auth::user()->usertype==1) {
            $category=category::all();
            $cat_first=category::paginate(1,['*'],'cat_first');
            return view('admin.category')->with('category',$category)->with('c',$cat_first);
        }
        else {
            return redirect('login');
        }
    }
    public function add_category(Request $req)
    {
        $image=$req->img;
        $imagename=time().'.'.$image->getClientOriginalExtension();
        $req->img->move('product',$imagename);
        category::create([
            'Category_name' => $req->category,
            'image' => $imagename,
        ]);
        return redirect()->back()->with('message','Category Inserted Successfully');
    }
    public function dlt_cat($id)
    {
        $dlt=category::findorfail($id);
        $dlt->delete();
        return redirect()->back()->with('dlt_msg','Deleted Successfully');
    }
    public function product()
    {
        $category=category::all();
       return view('admin.product')->with('category',$category);
    }
   
    public function add_product(Request $req)
    {
        $image=$req->img;
        $imagename=time().'.'.$image->getClientOriginalExtension();
        $req->img->move('product',$imagename);

       product::create([
        'product_name' => $req->name,
        'description' => $req->des,
        'image' =>  $imagename,
        'category' => $req->cat,
        'quantity' => $req->qty,
        'price' => $req->price,
        'discount_price' => $req->discount,
       ]);
       return redirect()->back()->with('message','product added succesfully');
    }
    public function showProduct(){
        $product=product::all();
        return view('admin.showProduct')->with('product',$product);
    }
    public function delete_product($id){
        $delete=product::findorfail($id);
        $delete->delete();
        return redirect()->back()->with('dltmsg','Product deleted successfully');
    }
    public function update_product( $id){
        $product=product::where('id',$id)->get();
        $category=category::all();
        // return $product;
        return view('admin.update_product')->with('category',$category)->with('product',$product);
    }
    public function upd_pro(Request $req, $id){
        // $pro=product::where('id',$id)->get();
        $pro=product::find($id);
        $image=$req->img;
        if($image){
            $imagename=time().'.'.$image->getClientOriginalExtension();
            $req->img->move('product',$imagename);
        }else {
            $imagename=$req->prev_file;
        }

       $pro->update([
        'product_name' => $req->name,
        'description' => $req->des,
        'image' =>  $imagename,
        'category' => $req->cat,
        'quantity' => $req->qty,
        'price' => $req->price,
        'discount_price' => $req->discount,
       ]);
       return redirect()->route('show_product')->with('update','product updated succesfully');
    }

    public function order(){
        $order=order::all();
        return view('admin.order')->with('order',$order);
    }

    public function delivered($id){
        $delivered=order::find($id);
        $delivered->update([
            'delievery_status' => 'Delivered',
            'payment_status' => 'Paid'
        ]);

        return redirect()->back();
    }

    public function print_pdf($id){
        $order=order::find($id);
        $pdf=PDF::loadView('admin.pdf',compact('order'));
        return $pdf->download('order_details.pdf');
    }

    public function send_email($id){
        $order=order::find($id);
        return view('admin.email_info')->with('order',$order);
    }

    public function send_user_email(Request $request,$id){
        $order=order::find($id);
        $details=[
            'greeting' => $request->greeting,
            'firstline' => $request->firstline,
            'body' => $request->body,
            'button' => $request->button,
            'url' => $request->url,
            'lastline' => $request->lastline,
        ];
        Notification::send($order,new SendEmailNotification($details));
        return redirect()->back();
    }

    public function search(Request $req){
        $searchrecord=$req->search;
        $order=order::where('name','LIKE',"%$searchrecord%")->orWhere('phone','LIKE',"%$searchrecord%")->orWhere('email','LIKE',"%$searchrecord%")->get();
        return view('admin.order')->with('order',$order);
    }

}
