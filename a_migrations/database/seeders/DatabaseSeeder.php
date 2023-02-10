<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([

            CoursegroupSeeder::class,
            CoursesubgroupSeeder::class,
            CoursetypeSeeder::class,
            CourseSeeder::class,
            BuildingtypeSeeder::class,
            troubletypeSeeder::class,

            LecturerTypesSeeder::class,

            OoapMasOcuupationSeeder::class,
            ooapMasRolePerSeeder::class,
            UserSeeder::class,
            OoapMasDivisionSeeder::class,
            PatternareaSeeder::class,
            provinceSeeder::class,
            amphurSeeder::class,
            TambonSeeder::class,
            // TambonSeeder2::class,
            // TambonSeeder3::class,
            acttypeSeeder::class,
            OwnertypeSeeder::class,
            // UnitSeeder::class,
            UnitsSeeder::class,
            EmployeeSeeder::class,
            RoleSeeder::class,
            // ReqformSeeder::class,
           // FiscalyearSeeder::class,
            GeopraphySeeder::class,
            // Reqformstatus::class,
            // ReqformSeeder::class,
            MenuSeeder::class,
            SubMenuSeeder::class,
            SubMenu1Seeder::class,
           // UsersPerSeeder::class,
            // MasRolePerSeeder::class,
            // TblFiscalyearSeeder::class, //test data
            // TblReqformSeeder::class, //test data
            // TblFybdtransferSeeder::class, //test data
            // RequestsSeeder::class, //test data
            // TblBudgetProjectplanPeriodsSeeder::class, //test data
            // TblAssesslogsSeeder::class, //test data
            // TblPopulationsSeeder::class, //test data
            // TblAssessSeeder::class, //test data
            // PopulationTypeSeeder::class,
            PerOrgAssSeeder::class,
            PerLevelSeeder::class,
            PerOffTypeSeeder::class,
            PerPrenameSeeder::class,
            PERPERSONALSeeder::class,
        ]);
    }
}
