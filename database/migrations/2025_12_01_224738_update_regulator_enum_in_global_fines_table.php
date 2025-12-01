<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE `global_fines`
            CHANGE `regulator` `regulator`
            ENUM(
                'ICO (UK)',
                'CNIL (France)',
                'BfDI (Germany)',
                'DPC (Ireland)',
                'AEPD (Spain)',
                'FTC (USA)',
                'OAIC (Australia)',
                'OPC (Canada)',
                'CNPD (Luxembourg)',
                'AP (Netherlands)',
                'Garante (Italy)',
                'NCSC (Norway)',
                'IMY (Sweden)',
                'Datatilsynet (Denmark)',
                'UODO (Poland)',
                'ANSPDCP (Romania)',
                'AZOP (Croatia)',
                'DVI (Latvia)',
                'VDAI (Lithuania)',
                'CNPD (Portugal)',
                'IDPC (Malta)',
                'EDPS (EU)',
                'ANPD (Brazil)',
                'HHS OCR (USA)',
                'PDPC (Singapore)',
                'PPC (Japan)',
                'PIPC (South Korea)',
                'PCPD (Hong Kong)',
                'NPC (Philippines)',
                'PDPA (Thailand)',
                'SDAIA (Saudi Arabia)',
                'NDPC (Nigeria)',
                'Information Regulator (South Africa)'
            ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE `global_fines`
            CHANGE `regulator` `regulator`
            ENUM(
                'ICO (UK)',
                'CNIL (France)',
                'BfDI (Germany)',
                'DPC (Ireland)',
                'AEPD (Spain)',
                'FTC (USA)',
                'OAIC (Australia)',
                'OPC (Canada)',
                'CNPD (Luxembourg)'
            ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
        ");
    }
};
