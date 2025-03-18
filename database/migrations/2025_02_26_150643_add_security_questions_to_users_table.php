<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSecurityQuestionsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('security_question_1')->nullable();
            $table->string('security_answer_1')->nullable();
            $table->string('security_question_2')->nullable();
            $table->string('security_answer_2')->nullable();
            $table->dateTime('token_expiration')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'security_question_1',
                'security_answer_1',
                'security_question_2',
                'security_answer_2',
                'verification_token_used',
                'token_used',
                'two_factor_code',
                'two_factor_expires_at',
                'token_expiration'
            ]);
        });
    }
}
