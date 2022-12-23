<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("
        INSERT INTO `languages` (id, name_english)
        VALUES 
            (1,'OTHER..'),
            (2,'Angika'),
            (3,'Arabic'),
            (4,'Assamese'),
            (5,'Banjara'),
            (6,'Bazika'),
            (7,'Bengali'),
            (8,'Bhojpuri'),
            (9,'Bhoti'),
            (10,'Bhotia'),
            (11,'Bodo'),
            (12,'Bundelkhandi'),
            (13,'Burmese'),
            (14,'Byari'),
            (15,'Chhattisgarhi'),
            (16,'Chinese Mandarin'),
            (17,'Dhatki'),
            (18,'Dogri'),
            (19,'English'),
            (20,'French'),
            (21,'Garhwali (Pahari)'),
            (22,'German'),
            (23,'Gondi'),
            (24,'Gujarati'),
            (25,'Gujjar or Gujjari'),
            (26,'Hindi'),
            (27,'Ho'),
            (28,'Italian'),
            (29,'Japanese'),
            (30,'Javanese'),
            (31,'Kaachachhi'),
            (32,'Kamtapuri'),
            (33,'Kannada'),
            (34,'Karbi'),
            (35,'Kashmiri'),
            (36,'Khasi'),
            (37,'Kodava (Coorg)'),
            (38,'Kok Barak'),
            (39,'Konkani'),
            (40,'Korean'),
            (41,'Kumaoni (Pahari)'),
            (42,'Kurak'),
            (43,'Lepcha'),
            (44,'Limbu'),
            (45,'Magahi'),
            (46,'Maithili'),
            (47,'Malayalam'),
            (48,'Manipuri'),
            (49,'Marathi'),
            (50,'Mizo (Lushai)'),
            (51,'Mundari'),
            (52,'Nagpuri'),
            (53,'Nepali'),
            (54,'Nicobarese'),
            (55,'Oriya'),
            (56,'Pahari (Himachali)'),
            (57,'Pali'),
            (58,'Persian'),
            (59,'Polish'),
            (60,'Portuguese'),
            (61,'Punjabi'),
            (62,'Rajasthani'),
            (63,'Russian'),
            (64,'Sambalpuri or Kosali'),
            (65,'Sanskrit'),
            (66,'Santhali'),
            (67,'Shaurseni (Prakrit)'),
            (68,'Sindhi'),
            (69,'Siraiki'),
            (70,'Spanish'),
            (71,'Tamil'),
            (72,'Telugu'),
            (73,'Tenyidi'),
            (74,'Thai'),
            (75,'Tulu'),
            (76,'Turkish'),
            (77,'Ukrainian'),
            (78,'Urdu'),
            (79,'Vietnamese');
        ");
    }
}
