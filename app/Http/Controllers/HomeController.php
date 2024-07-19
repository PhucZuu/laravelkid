<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\table;

class HomeController extends Controller
{
    public function index(){

        /*

        //INSERT/CREATE  
        DB::table('users')->insert([
            [
                'name' => 'Nguyen Van A',
                'email' => 'a@gmail.com',
                'password' => bcrypt(123456)
            ],
            [
                'name' => 'Nguyen Van B',
                'email' => 'b@gmail.com',
                'password' => bcrypt(123456)
            ]
        ]);

        User::insert([
            [
                'name' => 'Nguyen Van C',
                'email' => 'c@gmail.com',
                'password' => bcrypt(123456)
            ],
            [
                'name' => 'Nguyen Van D',
                'email' => 'd@gmail.com',
                'password' => bcrypt(123456)
            ]
        ]); 

        User::create(
            [
                'name' => 'ahihi',
                'email' => 'ahihi@gmail.com',
                'password' => bcrypt(123456)
            ]
        );

        // DELETE
        DB::table('users')->where('email', 'a@gmail.com')->delete();
        User::query()->where('email', 'b@gmail.com')->delete();

        // LIST/SHOW
        $data1 = DB::table('users')->where('id','>',3)->orderByDesc('id')->ddRawSql();
        $data2 = User::query()->get();

        $data1 = DB::table('users')->where('id',3)->first();
        $data2= DB::table('users')->find(3);

        $data1 = User::query()->where('id',3)->first();
        $data2= User::query()->find(3);
        dd($data2->name);

        // UPDATE
        DB::table('users')->where('id',5)->update([
            'name' => 'Update Value',
            'password' => bcrypt(123131)
        ]);

        User::query()->where('id',5)->update([
            'name' => 'Update Value 1',
            'password' => bcrypt(123131)
        ]);

        DB::table('users')
        ->where([
            ['id','<>',3],
            ['email','c@gmail.com']
        ])
        ->orWhere('id',5)
        ->ddRawSql();

        DB::table('users')
        ->join('comments','comments.users_id','=','users.id')
        ->ddRawSql();

       
        // Yêu cầu 1: Truy vấn tất cả các bản ghi - Viết truy vấn để lấy tất cả các bản ghi từ bảng users.
        User::query()->get();

        // Yêu cầu 2: Truy vấn với điều kiện - Viết truy vấn để lấy các bản ghi từ bảng users mà cột age lớn hơn 25.
        User::query()->where('age','>',25);

        // Yêu cầu 3: Truy vấn với nhiều điều kiện - Viết truy vấn để lấy các bản ghi từ bảng users mà cột age lớn hơn 25 và status bằng 'active'
        User::query()
        ->where('age','>',25)
        ->where('status','active')
        ->get();

        // Yêu cầu 4: Sắp xếp kết quả - Viết truy vấn để lấy các bản ghi từ bảng users, sắp xếp theo age giảm dần.
        User::query()->orderByDesc('age')->get();

        // Yêu cầu 5: Giới hạn số lượng kết quả - Viết truy vấn để lấy 10 bản ghi đầu tiên từ bảng products.
        DB::table('products')->limit(10)->get();

        // Yêu cầu 6: Truy vấn với điều kiện OR - Viết truy vấn để lấy các bản ghi từ bảng orders mà status là 'completed' hoặc total lớn hơn 100.
        DB::table('orders')
        ->where('status','completed')
        ->orWhere('total','>',100)
        ->get();

        // Yêu cầu 7: Truy vấn với LIKE - Viết truy vấn để lấy các bản ghi từ bảng customers mà name chứa chuỗi 'John'.
        DB::table('customers')->where('name','LIKE','%John%')->get();

        // Yêu cầu 8: Truy vấn với BETWEEN - Viết truy vấn để lấy các bản ghi từ bảng sales mà amount nằm trong khoảng từ 1000 đến 5000.
        DB::table('sales')->whereBetween('amount',[1000,5000])->get();

        // Yêu cầu 9: Truy vấn với IN - Viết truy vấn để lấy các bản ghi từ bảng employees mà department_id nằm trong danh sách [1, 2, 3].
        DB::table('employees')->whereIn('department_id',[1,2,3])->get();

        // Yêu cầu 10: Thực hiện JOIN - Viết truy vấn để lấy thông tin từ bảng orders và bảng customers với điều kiện orders.customer_id = customers.id.
        DB::table('orders')->join('customers','customer.id','=','order.customer_id')->get();

        // Yêu cầu 11: Truy vấn với nhóm và tổng hợp - Viết truy vấn để tính tổng số lượng quantity của mỗi sản phẩm từ bảng order_items, nhóm theo product_id.
        DB::table('order_items')->groupBy('product_id')->sum('quantity')->ddRawSql();

        // Yêu cầu 12: Cập nhật bản ghi - Viết truy vấn để cập nhật status của tất cả các đơn hàng trong bảng orders thành 'shipped' nếu status hiện tại là 'processing'.
        DB::table('orders')->where('status','processing')->update([
            'status' => 'shipped'
        ]);

        // Yêu cầu 13: Xóa bản ghi - Viết truy vấn để xóa tất cả các bản ghi từ bảng logs mà created_at trước ngày 1/1/2020.
        DB::table('logs')->whereDate('created_at','<','2020-1-1')->delete();

        // Yêu cầu 14: Thêm bản ghi mới - Viết truy vấn để thêm một bản ghi mới vào bảng products với các thông tin về tên sản phẩm, giá và số lượng.
        DB::table('products')->insert([
            'name' => "Product 1",
            'price' => 2000,
            'quantity' => 10
        ]);

        // Yêu cầu 15: Sử dụng Raw Expressions - Viết truy vấn để lấy các bản ghi từ bảng users mà tháng sinh (birth_date) là tháng 5.
        DB::table('users')->select(DB::raw('*'))
        ->whereMonth('birth_date','=',5)->get();
        
        
        // 1
        DB::table('employees','e')->select(['e.first_name','e.last_name','d.department_name'])
        ->where('d.departments_name','IT')
        ->join('departments as d','d.department_id','=','e.department_id')
        ->get();

        // 2
        DB::table('employees','e')->select(['e.first_name','e.last_name','d.department_name'])
        ->where('e.salary','>',70000)
        ->where('d.departments_name','Marketing')
        ->join('departments as d','d.department_id','=','e.department_id')
        ->get();  
        
        // 3
        DB::table('employees','e')->select(['e.first_name','e.last_name','d.department_name'])
        ->whereBetween('e.salary',[50000,70000])
        ->join('departments as d','d.department_id','=','e.department_id')
        ->get();
        
        // 4
        DB::table('employees','e')->select(['e.first_name','e.last_name','d.department_name'])
        ->where('d.departments_name','<>','HR')
        ->join('departments as d','d.department_id','=','e.department_id')
        ->get();
        
        // 5
        DB::table('employees','e')->select(['e.first_name','e.last_name','d.department_name'])
        ->where('e.last_name','LIKE','D%')
        ->join('departments as d','d.department_id','=','e.department_id')
        ->get();

        // 6
        DB::table('employees','e')->select(['e.first_name','e.last_name','d.department_name'])
        ->join('departments as d','d.department_id','=','e.department_id')
        ->where('e.salary','=', function (Builder $query) {
            $query->selectRaw('MAX(e.salary)')
            ->from('employees')
            ->where('department_id','e.department_id');
        })->ddRawSql();

        // 7
        DB::table('employees','e')->select(['e.first_name','e.last_name','d.department_name'])
        ->join('departments as d','d.department_id','=','e.department_id')
        ->where('e.hire_date','<=',DB::raw('DATEADD(year, -3, GETDATE())'))
        ->ddRawSql();
        

        // return view('welcome', [
        //     'users' => $users
        // ]);
        
        */
        
        
    
    
    
    }
}
