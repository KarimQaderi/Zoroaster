<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreatePermissionTables extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('permissions', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('display_name');
                $table->timestamps();
            });

            Schema::create('roles', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('guard_name');
                $table->timestamps();
            });

            Schema::create('role_has_permissions', function (Blueprint $table) {
                $table->unsignedInteger('permission_id');
                $table->unsignedInteger('role_id');

                $table->foreign('permission_id')
                    ->references('id')
                    ->on('permissions')
                    ->onDelete('cascade');

                $table->foreign('role_id')
                    ->references('id')
                    ->on('roles')
                    ->onDelete('cascade');

                $table->primary(['permission_id', 'role_id']);

            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::drop('role_has_permissions');
            Schema::drop('roles');
            Schema::drop('permissions');
        }
    }