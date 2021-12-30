<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->string('notes')->nullable()->after('phone_no');
            $table->string('detaild_loc')->after('phone_no');
            $table->string('brgy')->after('phone_no');
            $table->string('municipality')->after('phone_no');
            $table->string('province')->after('phone_no');
            $table->string('region')->after('phone_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            //
        });
    }
}
