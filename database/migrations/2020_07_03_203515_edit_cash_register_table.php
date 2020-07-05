<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditCashRegisterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cash_register_transactions', function (Blueprint $table) {
            //$table->enum('pay_method', ['Cash', 'Credit Card', 'Cheque', 'Deposit'])->change();
        });

        Schema::table('cash_registers', function (Blueprint $table) {
            $table->decimal('register_close_amount', 22, 4)->nullable()->after('closing_note'); //money in register on close #1
            $table->decimal('total_sales_amount', 22, 4)->nullable()->after('register_close_amount'); //total sales amount #2

            $table->string('close_status')->nullable()->after('total_sales_amount'); // negative - positive - equal
            $table->decimal('close_status_amount', 22, 4)->nullable()->after('close_status'); //if postive or negative  #2 - #1
            
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
