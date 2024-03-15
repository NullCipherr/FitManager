<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->index();
            $table->integer('professor_id')->nullable()->index();
            $table->integer('funcionario_id')->nullable()->index();
            $table->integer('aluno_id')->nullable()->index();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('cpf')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('owner')->default(false);
            $table->string('password');
            $table->string('type')->default('Aluno');
            $table->rememberToken();
            $table->timestamps();
            $table->string('photo_path', 100)->nullable();

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
        Schema::dropIfExists('users');
    }
}
