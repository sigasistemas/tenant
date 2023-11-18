 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            if (config('tenant.incrementing', false)) {
                $table->id();
            } else {
                $table->ulid('id')->primary();
            }
            $table->enum('type', ['tenant', 'landlord'])->default('tenant')->comment('Tipo do tenant, se é um tenant ou subtenant');
            $table->string('name', 255)->comment('Razão social do tenant');
            $table->string('slug')->nullable()->unique();
            $table->string('email')->nullable()->unique()->comment('Email do tenant');
            $table->string('domain')->unique()->comment('Domínio do tenant');
            $table->string('provider')->nullable()->comment('Conexão do tenant, qual base de dados ele vai usar');
            $table->string('prefix')->nullable()->comment('Path para acessar o tenant, ex: http://dominio/tenant');
            $table->enum('status', ['draft', 'published'])->default('published')->comment('Status do tenant');
            $table->text('description')->nullable()->comment('Descrição do tenant');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('tenants', function (Blueprint $table) {
            if (config('tenant.incrementing', false)) {
                $table->unsignedBigInteger('tenant_id')->nullable();
            } else {
                $table->ulid('tenant_id')->nullable()->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
