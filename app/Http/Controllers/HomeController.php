<?php
namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\category;
use App\Models\Comment;
use App\Models\order;
use App\Models\product;
use App\Models\promotion;
use App\Models\Reply;
use App\Models\subscribe;
use App\Models\suggested_product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Empty_;
use Session;
use Stripe;

use RealRashid\SweetAlert\Facades\Alert;
class HomeController extends Controller
{
    //
    public function index()
    {
        $products=product::paginate(9);
        $comment=Comment::orderby('id','desc')->get();
        $reply=Reply::all();
        $categories=category::where('popular','yes')->get();
        $promotion=promotion::all();
        if (Auth::id()) {
            $userid=Auth::user()->id;
            $suggested_products=suggested_product::where('user_id',$userid)->get();
            $suggested_categories = $suggested_products->pluck('category_name')->unique();
            $sugg_prods=product::whereIn('category',$suggested_categories)->get();
            $cart_count=Cart::where('user_id',$userid)->count();
            $order_count=order::where('user_id',$userid)->count();
            return view('home.userpage')->with('promotions',$promotion)->with('sugg_prods',$sugg_prods)->with('categories',$categories)->with('products',$products)->with('comment',$comment)->with('reply',$reply)->with('cart_count',$cart_count)->with('order_count',$order_count);
        }
        $cart_count=0;
        $order_count=0;
        $sugg_prods=NULL;
        return view('home.userpage')->with('promotions',$promotion)->with('sugg_prods',$sugg_prods)->with('categories',$categories)->with('products',$products)->with('comment',$comment)->with('reply',$reply)->with('cart_count',$cart_count)->with('order_count',$order_count);
    }

    public function product_search(Request $req){
        $categories=category::where('popular','yes')->get();
        $search=$req->search;
        $comment=Comment::orderby('id','desc')->get();
        $reply=Reply::all();
        $promotion=promotion::all();
        $products=product::where('product_name','LIKE',"%$search%")->paginate(9);
        if (Auth::id()) {
        $userid=Auth::user()->id;
        $suggested_products=suggested_product::where('user_id',$userid)->get();
        $suggested_categories = $suggested_products->pluck('category_name')->unique();
        $sugg_prods=product::whereIn('category',$suggested_categories)->get();
        $cart_count=Cart::where('user_id',$userid)->count();
        $order_count=order::where('user_id',$userid)->count();

        
        // return view('home.userpage')->with('products',$products)->with('comment',$comment)->with('reply',$reply);
        return view('home.userpage')->with('promotions',$promotion)->with('sugg_prods',$sugg_prods)->with('categories',$categories)->with('products',$products)->with('comment',$comment)->with('reply',$reply)->with('cart_count',$cart_count)->with('order_count',$order_count);
        }
        $cart_count=0;
        $order_count=0;
        $sugg_prods=NULL;
        return view('home.userpage')->with('promotions',$promotion)->with('sugg_prods',$sugg_prods)->with('categories',$categories)->with('products',$products)->with('comment',$comment)->with('reply',$reply)->with('cart_count',$cart_count)->with('order_count',$order_count);
    }

    public function product_detail($id){
        $currentProduct = product::find($id);

        $user = Auth::user();

        // Simulated user preferences based on the current product's category
        $userPreferences = [$currentProduct->category];

        // Get suggested products based on preferences and the current product's category
        $suggestedProducts = product::whereIn('category', $userPreferences)
            ->where('id', '!=', $id) // Exclude the current product
            ->inRandomOrder()
            ->limit(5) // Adjust the limit as needed
            ->get();

        return view('home.product_detail', [
            'product' => $currentProduct,
            'suggestedProducts' => $suggestedProducts,
        ]);
    }

    public function redirect(Request $request)
    {
        // $usertype= User::pluck('usertype')->first();
        $usertype=Auth::user()->usertype;
    if ($usertype == '1') {
        $total_products=product::all()->count();
        $total_orders=order::all()->count();
        $total_users=User::all()->count();
        $order=order::all();
        $total_revenue=0;
        foreach ($order as $order) {
            $total_revenue=$total_revenue+$order->price;
        }

        $total_delivered=order::where('delievery_status','Delivered')->count();

        $total_processing=order::where('delievery_status','processing')->count();

        return view('admin.home')->with('total_products',$total_products)->with('total_orders',$total_orders)
                                 ->with('total_users',$total_users)->with('total_revenue',$total_revenue)
                                 ->with('total_delivered',$total_delivered)->with('total_processing',$total_processing);
    }

    else {

        $promotion=promotion::all();
        $products=product::paginate(9);
        $comment=Comment::orderby('id','desc')->get();
        $reply=Reply::all();
        $categories=category::where('popular','yes')->get();
        $userid=Auth::user()->id;
        $cart_count=Cart::where('user_id',$userid)->count();
        $order_count=order::where('user_id',$userid)->count();

        $suggested_products=suggested_product::where('user_id',$userid)->get();

        $suggested_categories = $suggested_products->pluck('category_name')->unique();
        // $suggested_categories = $suggested_products->category_name;
        $suggested_product_ids = $suggested_products->pluck('product_id')->unique();

        $sugg_prods=product::whereIn('category',$suggested_categories)->get();

        return view('home.userpage')->with('promotions',$promotion)->with('sugg_prods',$sugg_prods)->with('products',$products)->with('categories',$categories)->with('comment',$comment)->with('reply',$reply)->with('cart_count',$cart_count)->with('order_count',$order_count);
    }
    }

    public function add_cart(Request $req,$id){
        if (Auth::id()) {
            $user=Auth::user();
            $userid=$user->id;
            $product=product::find($id);
            $product_exist_id=Cart::where('product_id',$id)->where('user_id',$userid)->get('id')->first();
            // return $q=$req->quantity;exit;

            if ($product_exist_id) {
                $cart=Cart::find($product_exist_id)->first();
                $cart->quantity=$cart->quantity+$req->quantity;
                if($product->discount_price){
                    $cart->price=$cart->quantity * $product->discount_price;
                }else {
                    $cart->price=$cart->quantity * $product->price;
                }
                $cart->save();

                Alert::success('Product Added Successfully','We added your product to Cart Page');

                return redirect()->back();
                
            }
            else {
                
            if($product->discount_price){
                $price=$req->quantity * $product->discount_price;
            }else {
                $price=$req->quantity * $product->price;
            }
            Cart::create([
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
                'user_id' => $user->id,
                'product_title' => $product->product_name,
                'price' => $price,
                'image' => $product->image,
                'product_id' => $product->id,
                'quantity' => $req->quantity,
            ]);

            $cat_id=category::where('Category_name',$product->category)->first();
            
            suggested_product::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'category_id' => $cat_id->id,
                'category_name' => $product->category,
            ]);
            return redirect()->back()->with('message','Product Added Successfully');
        }
        }
        else {
            return redirect('login');
        }
    }
    public function show_cart(){
        if (Auth::id()) {
            $id=Auth::user()->id;
            $product=Cart::where('user_id',$id)->get();
                $userid=Auth::user()->id;
                $cart_count=Cart::where('user_id',$userid)->count();
                $order_count=order::where('user_id',$userid)->count();
            return view('home.show_cart')->with('product',$product)->with('cart_count',$cart_count)->with('order_count',$order_count);
        }
        else {
            return redirect('login')->with('Please Login First');
        }
    }

    public function remove_cart($id){
        $pro=Cart::find($id);
        $pro->delete();
        Alert::info('Product Deleted Successfully','We Delete your product');
        return redirect()->back()->with('message','Product deleted successfully');
    }

    public function cash_order(){
        $user_id=Auth::user()->id;
        $data=Cart::where('user_id',$user_id)->get();
        foreach ($data as $data) {

        order::create([
            'name' => $data->name,
            'email' => $data->email,
            'phone' => $data->phone,
            'address' => $data->address,
            'user_id' => $data->user_id,
            'product_title' => $data->product_title,
            'price' => $data->price,
            'quantity' => $data->quantity,
            'image' => $data->image,
            'product_id' => $data->product_id,
            'payment_status' => 'Cash on Delievery',
            'delievery_status' => 'processing'
        ]);

        $prod_cat=product::where('product_name',$data->product_title)->first();
        
        $cat_id=category::where('Category_name',$prod_cat->category)->first();

        suggested_product::create([
            'user_id' => $data->user_id,
            'product_id' => $data->product_id,
            'product_name' => $data->product_title,
            'category_id' => $cat_id->id,
            'category_name' => $prod_cat->category,

        ]);

        $cart_id=$data->id;
        $cart=cart::find($cart_id);
        $cart->delete();
        $quan=product::where('product_name',$data->product_title)->get();
        foreach ($quan as $quan) {
           $total_quan=$quan->quantity;
        }
        $rem_quantity=$total_quan - $data->quantity;

        $quantity_id=product::find($quan->id);

        $quantity_id->update([
            'quantity' => $rem_quantity,
        ]);
    }
    // if ($order) {
    //     $user_id1=Auth::user()->id;
    //     $data_del=Cart::where('user_id',$user_id1)->get();
    //     foreach ($data_del as $data_del) {
    //         $data_del->delete();
    //     }
    // }
    return redirect()->back()->with('message_order','We Have Recieved your order.We will contact to you soon...');
    }

    public function stripe($total_payment){
        return view('home.stripe')->with('total_payment',$total_payment);
    }

    public function stripePost(Request $request,$total_payment)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" => $total_payment * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Thanks for Payment",
        ]);

        $user_id=Auth::user()->id;
        $data=Cart::where('user_id',$user_id)->get();
        foreach ($data as $data) {

        order::create([
            'name' => $data->name,
            'email' => $data->email,
            'phone' => $data->phone,
            'address' => $data->address,
            'user_id' => $data->user_id,
            'product_title' => $data->product_title,
            'price' => $data->price,
            'quantity' => $data->quantity,
            'image' => $data->image,
            'product_id' => $data->product_id,
            'payment_status' => 'Paid',
            'delievery_status' => 'processing',
        ]);
        $product=product::where('product_name',$data->product_title)->get();
        foreach ($product as $product) {
            $rem_quantity=$product->quantity-$data->quantity;
            $product_id=product::find($product->id);
            $product_id->update([
                'quantity' => $rem_quantity
            ]);
        }

        $cart_id=$data->id;
        $cart=cart::find($cart_id);
        $cart->delete();
    }
      
        session()->flash('success', 'Payment successful!');
              
        return back();
    }


    public function show_order(){
        if (Auth::id()) {
            $user_id=Auth::user()->id;
            $order=order::where('user_id',$user_id)->get();
            $cart_count=Cart::where('user_id',$user_id)->count();
            $order_count=order::where('user_id',$user_id)->count();
            return view('home.userorder')->with('order',$order)->with('cart_count',$cart_count)->with('order_count',$order_count);
        }
        else {
            return redirect('login');
        }
    }

    
    public function cancel_order($id){
        $order=order::find($id);
        $order->update([
            'delievery_status' => 'You Cancelled the Order',
        ]);
        return redirect()->back();
    }

    public function add_comment(Request $req){
        if (Auth::id()) {
            $name=Auth::user()->name;
            $comment=$req->comment;
            $user_id=Auth::user()->id;
            Comment::create([
                'name' =>  $name,
                'comment' => $comment,
                'user_id' => $user_id
            ]);
            return redirect()->back();
        }
        else {
           return redirect('login');
        }
    }

    public function add_reply(Request $req){
        if (Auth::id()) {
            $id=Auth::user()->id;
            $name=Auth::user()->name;
            $comment_id=$req->commentId;
            $reply=$req->reply;
            Reply::create([
                'name' => $name,
                'user_id' => $id,
                'reply' => $reply,
                'comment_id' => $comment_id,
            ]);
            return redirect()->back();
        }
        else {
            return redirect('login');
        }
    }



    public function products(){
        $products=product::paginate(9);
        $comment=Comment::orderby('id','desc')->get();
        $reply=Reply::all();
        if (Auth::id()) {
            $userid=Auth::user()->id;
            $cart_count=Cart::where('user_id',$userid)->count();
            $order_count=order::where('user_id',$userid)->count();
            return view('home.all_products')->with('products',$products)->with('comment',$comment)->with('reply',$reply)->with('cart_count',$cart_count)->with('order_count',$order_count);
        }
            $cart_count=0;
            $order_count=0;
        return view('home.all_products')->with('products',$products)->with('comment',$comment)->with('reply',$reply)->with('cart_count',$cart_count)->with('order_count',$order_count);
       
    }

    public function products_cat($id_cat){
        $products=product::where('category',$id_cat)->paginate(9);
        $comment=Comment::orderby('id','desc')->get();
        $reply=Reply::all();
        if (Auth::id()) {
            $userid=Auth::user()->id;
            $cart_count=Cart::where('user_id',$userid)->count();
            $order_count=order::where('user_id',$userid)->count();
            return view('home.all_products')->with('products',$products)->with('comment',$comment)->with('reply',$reply)->with('cart_count',$cart_count)->with('order_count',$order_count);
        }
            $cart_count=0;
            $order_count=0;
        return view('home.all_products')->with('products',$products)->with('comment',$comment)->with('reply',$reply)->with('cart_count',$cart_count)->with('order_count',$order_count);
    }

    public function products_sale(){
        $products=product::whereNotNull('discount_price')->paginate(9);
        $comment=Comment::orderby('id','desc')->get();
        $reply=Reply::all();
        if (Auth::id()) {
            $userid=Auth::user()->id;
            $cart_count=Cart::where('user_id',$userid)->count();
            $order_count=order::where('user_id',$userid)->count();
            return view('home.all_products')->with('products',$products)->with('comment',$comment)->with('reply',$reply)->with('cart_count',$cart_count)->with('order_count',$order_count);
        }
            $cart_count=0;
            $order_count=0;
        return view('home.all_products')->with('products',$products)->with('comment',$comment)->with('reply',$reply)->with('cart_count',$cart_count)->with('order_count',$order_count);
    }

    public function search_product(Request $req){
        $search=$req->search;
        $comment=Comment::orderby('id','desc')->get();
        $reply=Reply::all();
        $products=product::where('product_name','LIKE',"%$search%")->paginate(9);
        return view('home.all_products')->with('products',$products)->with('comment',$comment)->with('reply',$reply);
    }

    public function subscribe(Request $req){
        $email=$req->email;
        if (Auth::id()) {
            $user_id=Auth::user()->id;
            subscribe::create([
                'user_id' => $user_id,
                'email' => $email
            ]);
            return redirect()->back()->with('msg','Congratulations! Your subscription has been done');
        }
        else {
            subscribe::create([
                'email' => $email
            ]);
            return redirect()->back()->with('msg','Congratulations! Your subscription has been done.Please Register yourself');
        }
    }
}