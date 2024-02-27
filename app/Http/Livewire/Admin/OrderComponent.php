<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\HelperFunctions;
use App\Mail\OrderClosed;

class OrderComponent extends Component
{

    public function changeStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|string',
            'order_id'=> 'required|numeric',
        ]);

        $order_id = $request->order_id;
        $status = $request->status;

        $order=Order::find($order_id);
        $old_status = $order->status;
        $order->status=$status;
        $order->save();

        $new_status = $order->status;

        if ($new_status == $old_status) {
            session()->flash('order_message','The order status is the same!');
            return redirect()->back();
        }

        if ($new_status != $old_status) {
            HelperFunctions::replace_order_pdf($order);

            if (strtolower($new_status)=='closed' or strtolower($new_status)=='canceled') {
                //Nao envia email se user nao estiver sido apagado
                if ($order->customerRef->trashed()) {
                    session()->flash('order_message','The user was deleted so we cant envite an email!');
                    return redirect()->back();
                }
                Mail::to($order->customerRef->userRef)->send(new OrderClosed($order));
            }

        }

        session()->flash('order_message','Order status has been updated successfully!');
        return redirect()->back();
    }

    public function download_pdf(order $order){
        $url_image = $order->receipt_url == null ? '(nao existe)' : $order->receipt_url;
        $url = 'pdf_receipts/'.$url_image;

        // Caso Exista a referencia caso nao
        if(!Storage::exists($url)){
            $name_pdf = HelperFunctions::not_exist_PDF($order,$order->orderitemRef);
            $order->receipt_url = $name_pdf; //Ficheiro para o pdf
            $order->save();
        }

        $full_url = 'app/pdf_receipts/'.$order->receipt_url;
        $name_file = 'order_'.$order->id.'.pdf';
        return response()->download(storage_path($full_url),$name_file);
    }

    public function show_pdf(order $order){
        return HelperFunctions::show_pdf($order);
    }

    public function render(Request $request)
    {
        $type_search = '';
        $type_sort = '';
        $search = '';
        $orders = null;

        if ($request->has('type_search') and $request->type_search !=''){
            $type_search = $request->type_search;
        }

        if ($request->has('type_sort') and $request->type_sort !=''){
            $type_sort = $request->type_sort;
        }

        if ($request->has('search_term') and $request->search_term !='') {
            $search = $request->search_term;

            switch ($type_search) {
                case 'ID':
                    $orders = order::where('id',$search);
                    break;

                case 'DATE':
                    $orders = order::where('date',$search);
                    break;

                case 'CUSTM_ID':
                    $orders = order::where('customer_id',$search);
                    break;
            }

        }else{
            $orders= order::query();
        }


        switch ($type_sort) {
            case 'DEF':
                $orders = $orders->paginate(6);
                break;

            case 'DATE_ASC':
                $orders = $orders->orderBy('date')->paginate(6);
                break;

            case 'DATE_DESC':
                $orders = $orders->orderByDesc('date')->paginate(6);
                break;

            case 'STATUS_ASC':
                $orders = $orders->orderBy('status')->paginate(6);
                break;

            case 'STATUS_DESC':
                $orders = $orders->orderByDesc('status')->paginate(6);
                break;

            case 'TOTAL_ASC':
                $orders = $orders->orderBy('total_price')->paginate(6);
                break;

            case 'TOTAL_DESC':
                $orders = $orders->orderByDesc('total_price')->paginate(6);
                break;
        }

        if($type_search == '' and $type_sort == '' and $search == ''){
            $orders = $orders->paginate(6);
        }

        return view('livewire.admin.order-component',
        ['orders'=>$orders,
        'search'=>$search, 'type_search'=>$type_search, 'type_sort'=>$type_sort]);
    }
}
