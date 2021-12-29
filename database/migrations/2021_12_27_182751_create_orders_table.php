<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateOrdersTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('service_id');
                $table->unsignedBigInteger('car_id');
                $table->boolean('status')->default(0);
                $table->decimal('price');
                $table->timestamps();
                $table->softDeletes();

                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('service_id')->references('id')->on('services');
                $table->foreign('car_id')->references('id')->on('cars');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('orders');
        }
    }
