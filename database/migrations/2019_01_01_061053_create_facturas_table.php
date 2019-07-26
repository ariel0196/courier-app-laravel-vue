<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $estadosFactura = Config::get('data.estados_factura');
        $tiposPago = Config::get('data.tipos_pago');

        Schema::create('facturas', function (Blueprint $table) use ($estadosFactura, $tiposPago) {
            $table->increments('id');
            $table->unsignedInteger('numero');
            $table->unsignedInteger('cliente_id');
            $table->enum('tipo_pago', $tiposPago)->default($tiposPago[0]);
            $table->decimal('monto_total', 20, 2)->nullable();
            $table->enum('estado', $estadosFactura)->default($estadosFactura[0]);
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_cobro')->nullable();

            $table->foreign('cliente_id')->references('id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturas');
    }
}
