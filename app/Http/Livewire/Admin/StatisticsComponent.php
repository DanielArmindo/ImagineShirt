<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\order;
use Livewire\Component;
use App\Models\tshirt_image;
use Illuminate\Support\Facades\DB;
use App\Models\customer;


class StatisticsComponent extends Component
{

    public function render()
    {
        $usersCount = User::count();
        $totalProducts = tshirt_image::count();
        $totalClosed = order::where('status','=','closed')->count();
        $totalPrice = order::where('status','=','closed')->sum('total_price');


        //grafico 1 vendas
        $orders = order::select([
            DB::raw('YEAR(created_at) as ano'),
            DB::raw('COUNT(*) as value')
        ])
        ->groupBy('ano')
        ->orderby('ano','asc')
        ->get();

        //preparar arrays
        foreach($orders as $order){
            $ano[] = $order->ano;
            $total[] = $order->value;
        }

        //formatar para chartjs
        $ano = implode(',',$ano);
        $total = implode(',',$total);


        //grafico 2 costumers
        $customers = customer::select([
            DB::raw('YEAR(created_at) as ano'),
            DB::raw('COUNT(*) as value')
        ])
        ->groupBy('ano')
        ->orderby('ano','asc')
        ->get();

        //preparar arrays
        foreach($customers as $customer){
            $anoCustomer[] = $customer->ano;
            $totalCustomer[] = $customer->value;
        }

        //formatar para chartjs
        $anoCustomer = implode(',',$anoCustomer);
        $totalCustomer = implode(',',$totalCustomer);


        //grafico 3 vendas por mes deste ano
        $ordersMonth = order::select([
            DB::raw('MONTH(created_at) as mes'),
            DB::raw('COUNT(*) as value')
        ])
        ->whereYear('created_at',date('Y'))
        ->groupBy('mes')
        ->orderby('mes','asc')
        ->get();

        //preparar arrays
        foreach($ordersMonth as $orderMonth){
            $mesvendas[] = $orderMonth->mes;
            $totalMonthvendas[] = $orderMonth->value;
        }

        //formatar para chartjs
        $mesvendas = implode(',',$mesvendas);
        $totalMonthvendas = implode(',',$totalMonthvendas);


        //grafico 4 fatura por ano onde o status é closed
        $ordersPrice = order::select([
            DB::raw('YEAR(created_at) as ano'),
            DB::raw('SUM(total_price) as value')


        ])
        ->where('status','=','closed')
        ->groupBy('ano')
        ->orderby('ano','asc')
        ->get();

        $totalYearPrice = array();
        //preparar arrays
        foreach($ordersPrice as $orderPrice){
            $anoPrice[] = $orderPrice->ano;
            //array de strings
            array_push($totalYearPrice,$orderPrice->value);

        }

        //formatar para chartjs
        $anoPrice = implode(',',$anoPrice);
        $totalYearPrice = implode(',',$totalYearPrice);


        //grafico 5 fatura por mes este ano onde o status é closed
        $ordersMonthPrice = order::select([
            DB::raw('MONTH(created_at) as mes'),
            DB::raw('SUM(total_price) as value')
        ])
        ->where('status','=','closed')
        ->whereYear('created_at',date('Y'))
        ->groupBy('mes')
        ->orderby('mes','asc')
        ->get();


        $totalMonthPrice = array();
        //preparar arrays
        foreach($ordersMonthPrice as $orderMonthPrice){
            $mesPrice[] = $orderMonthPrice->mes;
            array_push($totalMonthPrice,$orderMonthPrice->value);

        }

        //formatar para chartjs
        $mesPrice = implode(',',$mesPrice);
        $totalMonthPrice = implode(',',$totalMonthPrice);
    

        return view('livewire.admin.statistics-component', ['usersCount' => $usersCount, 'totalProducts' => $totalProducts, 'totalClosed' => $totalClosed,'totalPrice' => $totalPrice,'ano' => $ano,'total' => $total,'anoCustomer' => $anoCustomer,'totalCustomer' => $totalCustomer,'mesvendas' => $mesvendas,'totalMonthvendas' => $totalMonthvendas,'anoPrice' => $anoPrice,'totalYearPrice' => $totalYearPrice,'mesPrice' => $mesPrice,'totalMonthPrice' => $totalMonthPrice]);
    }
}
