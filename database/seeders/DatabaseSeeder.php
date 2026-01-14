<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesYPermisosSeeder::class,
            UserSeeder::class, //EVIDENCIA, TICKET, CITA

            PaisSeeder::class,
            RegionSeeder::class,
            ProvinciaSeeder::class,
            DistritoSeeder::class,

            //ImagenSeeder::class,
            //ArchivoSeeder::class,

            UnidadNegocioSeeder::class, //EVIDENCIA
            GrupoProyectoSeeder::class, //EVIDENCIA
            ProyectoSeeder::class, //EVIDENCIA

            EstadoEvidenciaPagoSeeder::class, //EVIDENCIA
            //EvidenciaPagoSeeder::class, //EVIDENCIA

            /*EstadoTicketSeeder::class, //TICKET
            PrioridadTicketSeeder::class, //TICKET
            CanalSeeder::class, //TICKET
            AreaSeeder::class, //TICKET
            AreaUserSeeder::class, //TICKET
            TipoSolicitudSeeder::class, //TICKET
            SubTipoSolicitudSeeder::class, //TICKET
            AreaTipoSolicitudSeeder::class, //TICKET
            TicketSeeder::class, //TICKET
            TicketHistorialSeeder::class, //TICKET
            TicketDerivadoSeeder::class, //TICKET

            SedeSeeder::class, //CITA
            MotivoCitaSeeder::class, //CITA
            EstadoCitaSeeder::class, //CITAs
            CitaSeeder::class, //CITA*/
        ]);
    }
}
