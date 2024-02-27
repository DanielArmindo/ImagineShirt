<?php

namespace App\Http\Livewire\User;

use PDF;
use App\Models\order;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\HelperFunctions;
use App\Models\customer;

class OrdersHistoryComponent extends Component
{
    public function render(Request $request)
    {

      $order = order::where('id',$request->order)->first();

      $images = array();

      foreach($order->orderitemRef as $order_item){

        $color = $order_item->colorRef->code.'.jpg';
        $img = $order_item->tshirt_imageRef->image_url;

        if ($order_item->tshirt_imageRef->customer_id !=null) {
            $back = json_decode($order_item->tshirt_imageRef->extra_info,true);

            try {
                $back = intval($back['background']);
            } catch (\Throwable $th) {
                $back = 1;
            }
            $final = route('merge_imageb64',['background'=>$back,'tshirt'=>$color,'estampa'=>$img]);
        }else{
            $final = route('merge_tshirt',['tshirt'=>$color,'estampa'=>$img]);
        }
        array_push($images,$final);
      }

        return view('livewire.user.orders-history-component',['orders'=>$order,'images'=>$images]);
    }

    public function download_pdf(Request $request, order $order){

        if ($request->user()->id != $order->customer_id) {
            session()->flush();
            return redirect()->route('home.index');
        }

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

    public function show_pdf(Request $request, order $order){
        if ($request->user()->id != $order->customer_id) {
            session()->flush();
            return redirect()->route('home.index');
        }

        return HelperFunctions::show_pdf($order);
    }

}
