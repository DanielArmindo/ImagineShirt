<?php

namespace App\Http\Livewire\Employee;

use App\Models\Order;
use Livewire\Component;
use App\Mail\OrderClosed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\HelperFunctions;

class EmployeeDashboardComponent extends Component
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
            if (strtolower($new_status)=='closed') {
                Mail::to($order->customerRef->userRef)->send(new OrderClosed($order));
            }
        }

        session()->flash('order_message','Order status has been updated successfully!');
        return redirect()->back();
    }

    public function render(Request $request)
    {
        $msg = '';
        if ($request->has('search_term') and $request->search_term !='') {
            $orders = Order::where('id',$request->search_term)->whereIn('status',['pending','paid'])->paginate(6);
            $msg=$request->search_term;
        }else{
            $orders=Order::whereIn('status',['pending','paid'])->paginate(6);
        }

        return view('livewire.employee.employee-dashboard-component',['orders'=>$orders,'msg'=>$msg]);
    }

    public function change_password(){
        return view('livewire.employee.employee-change-password-component');
    }
}
