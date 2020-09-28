<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
use App\Account;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;
use DB;
use App\CashRegister;
use App\CashRegisterTransaction;

class ExpenseController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('expenses-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
            $lims_account_list = Account::where('is_active', true)->get();
            
            if(Auth::user()->hasRole('Staff') && config('staff_access') == 'own')
                $lims_expense_all = Expense::orderBy('id', 'desc')->where('user_id', Auth::id())->get();
            else
                $lims_expense_all = Expense::orderBy('id', 'desc')->get();
            return view('expense.index', compact('lims_account_list', 'lims_expense_all', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {   
        $account = Account::where('id', $request->account_id)->first();
        if($account->total_balance < $request->amount) {
            return redirect()->back()->with('not_permitted', 'Sorry, Expense Amount Bigger than Account Balance.');
        }
        $data = $request->all();
        $data['reference_no'] = 'er-' . date("Ymd") . '-'. date("his");
        $data['user_id'] = Auth::id();
        Expense::create($data);
        //update account balance
        $account->decrement('total_balance', $data['amount']);

        //record in cash register transaction
        $cash_register = CashRegister::where('user_id', Auth::id())
            ->where('warehouse_id', Auth::user()->warehouse_id)
            ->where('status', 'open')->first();

        if($cash_register) {
            
            $expense_payment = new CashRegisterTransaction([
                'amount' => $request->amount,
                'pay_method' => 'Cash',
                'type' => 'debit',
                'transaction_type' => 'expense',
                'sale_id' => null
            ]);

            if (!empty($expense_payment)) {
                $cash_register->cash_register_transactions()->save($expense_payment);
            }
        }
        
        return redirect('expenses')->with('message', 'Data inserted successfully');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $role = Role::firstOrCreate(['id' => Auth::user()->role_id]);
        if ($role->hasPermissionTo('expenses-edit')) {
            $lims_expense_data = Expense::find($id);
            return $lims_expense_data;
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $lims_expense_data = Expense::find($data['expense_id']);
        $lims_expense_data->update($data);
        return redirect('expenses')->with('message', 'Data updated successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $expense_id = $request['expenseIdArray'];
        foreach ($expense_id as $id) {
            $lims_expense_data = Expense::find($id);
            $lims_expense_data->delete();
        }
        return 'Expense deleted successfully!';
    }

    public function destroy($id)
    {
        $lims_expense_data = Expense::find($id);
        $lims_expense_data->delete();
        return redirect('expenses')->with('not_permitted', 'Data deleted successfully');
    }
}
