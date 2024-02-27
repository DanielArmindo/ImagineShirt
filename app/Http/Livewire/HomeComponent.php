<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\categorie;
use App\Models\price;
use App\Models\tshirt_image;

class HomeComponent extends Component
{
    use WithPagination;
    public $pageSize = 8;
    public $orderBy = "Default  Sorting";

    public function changeOrderBy($order)
    {
        $this->orderBy = $order;
    }

    public function render()
    {
        $prices = price::all()->first();
        $categories = categorie::orderBy('name','ASC')->get();
        $image = tshirt_image::whereNull('customer_id')->latest()->first()->image_url;
        $camisolas = array();

        for ($i=0; $i < 2; $i++) {
            switch ($i) {
                case 0:
                    $camisola = route('merge_tshirt',['tshirt'=>'1e1e21.jpg','estampa'=>$image]);
                    array_push($camisolas,$camisola);
                    break;

                default:
                    array_push($camisolas,asset('/storage/tshirt_base/fafafa.jpg'));
                break;
            }
        }

        return view('livewire.home-component', ['categories' => $categories,'prices' => $prices,'camisolas'=>$camisolas]);
    }
}
