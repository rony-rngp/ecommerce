<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdraw;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function admin_login(Request $request)
    {
        if (Auth::guard('admin')->check()){
            return redirect()->route('admin.dashboard');
        }

        if ($request->isMethod('post')){

            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' =>$request->password], $request->remember)){
                return redirect()->route('admin.dashboard');
            }else{
                throw ValidationException::withMessages(['email' => 'These credentials do not match our records.']);
            }
        }
        return view('backend.auth.login');
    }

    public function dashboard()
    {
        $data['total_deposits'] = Deposit::where('status', 'Completed')->sum('amount');
        $data['total_user_balance'] = User::sum('balance');
        $data['total_refer_earning']  = Transaction::where('tran_type', 'refer_bonus')->sum('amount');
        $data['total_convert'] = Transaction::where('tran_type', 'convert_balance')->sum('amount');
        $data['total_withdraw']  = Withdraw::sum('amount');
        $data['total_user_refer_balance'] = User::sum('refer_balance');
        $data['total_orders']  = Order::where('status', 'Delivered')->count();
        $data['total_order_amount']  = Order::where('status', 'Delivered')->sum('grand_total');
        return view('backend.dashboard', $data);
    }

    public function order_static(Request $request)
    {
        $status = $request->status;
        if ($request->date_type == 'this_year'){

            $labels = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
            $orders = Order::where(['status' => $status])
                ->select(
                    DB::raw('(count(id)) as total'),
                    DB::raw('YEAR(created_at) year, MONTH(created_at) month')
                )
                ->whereBetween('created_at', [Carbon::parse(now())->startOfYear(), Carbon::parse(now())->endOfYear()])
                ->groupby('year', 'month')
                ->get()
                ->toArray();

            $data = [];

            for ($i = 1; $i <= 12; $i++) {
                $data[$i] = 0;
                foreach ($orders as $match) {
                    if ($match['month'] == $i) {
                        $data[$i] = $match['total'];
                    }
                }
            }
            $data = array_values($data);

        }

        if ($request->date_type == 'this_month'){

            $orders = Order::where(['status' => $status])
                ->select(
                    DB::raw('(count(id)) as total'),
                    DB::raw('DAY(created_at) day')
                )
                ->whereBetween('created_at', [Carbon::parse(now())->startOfMonth(), Carbon::parse(now())->endOfMonth()])
                ->groupby('day')
                ->get()
                ->toArray();

            $lastDayOfMonth = date('d', strtotime(Carbon::now()->endOfMonth()));
            $labels = [];

            for ($day = 1; $day <= $lastDayOfMonth; $day++) {
                $day = str_pad($day, 2, '0', STR_PAD_LEFT);
                $labels[] = $day;

                $data[$day] = 0;
                foreach ($orders as $match) {
                    if ($match['day'] == $day) {
                        $data[$day] = $match['total'];
                    }
                }

            }

            $data = array_values($data);
        }

        if ($request->date_type == 'this_week'){


            $orders = Order::where(['status' => $status])
                ->select(
                    DB::raw('(count(id)) as total'),
                    DB::raw('DAY(created_at) day')
                )
                ->whereBetween('created_at', [Carbon::parse(now())->startOfWeek(), Carbon::parse(now())->endOfWeek()])
                ->groupby('day')
                ->get()
                ->toArray();

            $labels = [];

            $start = Carbon::now()->startOfWeek();
            $start_day = date('d', strtotime($start));
            $end_day = date('d', strtotime(Carbon::now()->endOfWeek()));
            for ($i = $start_day; $i <= $end_day; $i++) {
                $currentDay = date('Y-m-'.$i);
                $labels[] = date('l', strtotime($currentDay));
                $data[$i] = 0;
                foreach ($orders as $match) {
                    if ($match['day'] == $i) {
                        $data[$i] = $match['total'];
                    }
                }

            }

            $data = array_values($data);

        }

        if ($status == 'Delivered'){
            $background = '#FFB315';
        }elseif ($status == 'Pending'){
            $background = '#FB6514';
        }else{
            $background = '#D92D20';
        }

        $chat = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => $status,
                    'data' => $data,
                    'backgroundColor' => $background,
                    'borderRadius' => 10,
                    'maxBarThickness' => 40
                ],
            ]
        ];
        return response()->json($chat);
    }

    public function sales_static(Request $request)
    {
        $online_order = [];

        if ($request->statistics_type == 'this_year'){

            $labels = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

            $online_data = Order::where(['status' => 'Delivered'])
                ->select(
                    DB::raw('IFNULL(sum(grand_total),0) as total'),
                    DB::raw('YEAR(created_at) year, MONTH(created_at) month')
                )
                ->whereBetween('created_at', [Carbon::parse(now())->startOfYear(), Carbon::parse(now())->endOfYear()])
                ->groupby('year', 'month')
                ->get()
                ->toArray();


            for ($i = 1; $i <= 12; $i++) {
                //online order
                $online_order[$i] = 0;
                foreach ($online_data as $match) {
                    if ($match['month'] == $i) {
                        $online_order[$i] = $match['total'];
                    }
                }
            }
        }

        if ($request->statistics_type == 'this_month'){

            $online_data = Order::where(['status' => 'Delivered'])
                ->select(
                    DB::raw('IFNULL(sum(grand_total),0) as total'),
                    DB::raw('DAY(created_at) day')
                )
                ->whereBetween('created_at', [Carbon::parse(now())->startOfMonth(), Carbon::parse(now())->endOfMonth()])
                ->groupby('day')
                ->get()
                ->toArray();

            $lastDayOfMonth = date('d', strtotime(Carbon::now()->endOfMonth()));
            $labels = [];

            for ($day = 1; $day <= $lastDayOfMonth; $day++) {
                $day = str_pad($day, 2, '0', STR_PAD_LEFT);
                $labels[] = $day;
                //online order
                $online_order[$day] = 0;
                foreach ($online_data as $match) {
                    if ($match['day'] == $day) {
                        $online_order[$day] = $match['total'];
                    }
                }

            }
        }

        if ($request->statistics_type == 'this_week'){

            $online_data = Order::where([ 'status' => 'Delivered'])
                ->select(
                    DB::raw('IFNULL(sum(grand_total),0) as total'),
                    DB::raw('DAY(created_at) day')
                )
                ->whereBetween('created_at', [Carbon::parse(now())->startOfWeek(), Carbon::parse(now())->endOfWeek()])
                ->groupby('day')
                ->get()
                ->toArray();


            $labels = [];

            $start = Carbon::now()->startOfWeek();
            $start_day = date('d', strtotime($start));
            $end_day = date('d', strtotime(Carbon::now()->endOfWeek()));
            for ($i = $start_day; $i <= $end_day; $i++) {
                $currentDay = date('Y-m-'.$i);
                $labels[] = date('l', strtotime($currentDay));
                //online order
                $online_order[$i] = 0;
                foreach ($online_data as $match) {
                    if ($match['day'] == $i) {
                        $online_order[$i] = $match['total'];
                    }
                }

            }
        }

        $chat = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Total Sales',
                    'data' => array_values($online_order),
                    'borderColor' => '#6938EF',
                    'backgroundColor' => '#6938EF',
                    'borderWidth' => 2,
                    'fill' => false,
                    'tension' => 0.1,
                ]
            ]
        ];
        return response()->json($chat);
    }



    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function profile(Request $request)
    {
        if ($request->isMethod('post')){
            $request->validate([
                'name' => 'required',
                'email' => 'required|unique:admins,email,'.\auth('admin')->id(),
                'phone' => 'required',
                'image' => 'nullable|mimes:jpeg,jpg,png,PNG'
            ]);

            $admin = Auth::guard('admin')->user();
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->phone = $request->phone;
            if ($request->has('image')) {
                $admin->image = update_image('admin/', $admin->image, $request->file('image'));
            }
            $admin->save();
            return redirect()->back()->with('success', 'Profile updated successfully');
        }
        $admin = Auth::guard('admin')->user();
        return view('backend.auth.profile', compact('admin'));
    }

    public function change_password(Request $request)
    {
        if ($request->isMethod('post')){
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if (Hash::check($request->current_password, \auth('admin')->user()->password)){
                $admin = Auth::guard('admin')->user();
                $admin->password = Hash::make($request->password);
                $admin->save();
                return redirect()->back()->with('success', 'Password updated successfully');
            }else{
                throw ValidationException::withMessages(['current_password' => 'Your current password is wrong']);
            }
        }
        return view('backend.auth.change_password');
    }

}
