<?php

use App\Enum\TicketStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_transaction_history', function (Blueprint $table) {
            $table->id();
            $table->string('xid');
            $table->unsignedBigInteger('user_id');
            $table->string('movie_title');
            $table->string('movie_age_rating');
            $table->string('seat_number');
            $table->enum('status', [TicketStatusEnum::SUCCESS->value, TicketStatusEnum::CANCELED->value])->default(TicketStatusEnum::SUCCESS->value);
            $table->integer('ticket_price');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_transaction_history');
    }
};
