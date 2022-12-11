<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBondsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonds', function (Blueprint $table) {
            $table->id();
            $table->timestamp('emission_date')->nullable(false);
            $table->timestamp('last_turnover_date')->nullable(false);
            $table->decimal('nominal_price')->nullable(false);
            $table->double('pay_frequency')->nullable(false);
            $table->double('percent_calculation_period')->nullable(false);
            $table->double('coupon_percent')->nullable(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bonds');
    }
}
