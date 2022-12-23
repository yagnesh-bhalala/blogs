<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArticleCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("
        INSERT INTO `article_categories` (id, name_english, name_kannada) 
        VALUES 
        (1, 'OTHER..', 'ಇತರ..'),
        (2, 'Arts and Entertainment', 'ಕಲೆ ಮತ್ತು ಮನೋರಂಜನೆ'),
        (3, 'Business and Trade','ವ್ಯಾಪಾರ ಮತ್ತು ವ್ಯವಹಾರ'),
        (4, 'Career','ವೃತ್ತಿ'),
        (5, 'Children','ಮಕ್ಕಳು'),
        (6, 'Cooking and Receipie','ಅಡುಗೆ ಮತ್ತು ತಿನಿಸು'),
        (7, 'Culture','ಸಂಸ್ಕೃತಿ'),
        (8, 'Education', 'ಕಲಿಕೆ (ಶಿಕ್ಷಣ)'),
        (9, 'Family', 'ಕುಟುಂಬ'),
        (10, 'Jobs','ಕೆಲಸಗಳು'),
        (11, 'Legal', 'ಕಾನೂನು'),
        (12, 'Literature', 'ಸಾಹಿತ್ಯ'),
        (13, 'Matrimonial', 'ಮದುವೆ'),
        (14, 'Meeting and Discussion', 'ಕೂಟ ಮತ್ತು ಮಾತುಕತೆ'),
        (15, 'Political and State', 'ರಾಜಕೀಯ ಮತ್ತು ರಾಜ್ಯ'),
        (16, 'Recreational', 'ಮನೋಲ್ಲಾಸ'),
        (17, 'Religion', 'ಧರ್ಮ'),
        (18, 'Science', 'ವಿಜ್ಞಾನ'),
        (19, 'Social', 'ಸಾಮಾಜಿಕ'),
        (20, 'Sports', 'ಆಟಗಳು'),
        (21, 'Superstition', 'ಮೂಢನಂಬಿಕೆ'),
        (22, 'Travel', 'ಪ್ರವಾಸ'),
        (23, 'Volunteering','ಸ್ವಯಂ ಸೇವೆ');
        ");
    }
}
