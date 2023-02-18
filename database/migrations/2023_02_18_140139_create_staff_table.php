<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('code')->index();
            $table->string('name', 25);
            $table->string('email', 50)->unique();
            $table->string('mobile')->unique();
            $table->date('join_date');
            $table->foreignId('department_id')->default(0)->constrained('departments');
            $table->string('position');
            $table->integer('age');
            $table->enum('gender', ['male', 'female', 'others', 'prefer not to disclose']);
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff');
    }
}
