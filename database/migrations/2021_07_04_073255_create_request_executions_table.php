<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestExecutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_executions', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('method')->comment('1:POST, 2:GET, 3:PATCH, 4:DELETE, 5:PUT');
            $table->string('path');
            $table->float('seconds', 4, 2);
            $table->string('ip');
            $table->string('user_agent');
            $table->bigInteger('create_user');
            $table->timestamp('created_at');

            $table->index('seconds');
            $table->index(['path', 'method']);
            $table->index('create_user');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_execution');
    }
}
