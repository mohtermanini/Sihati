<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::insert([
            [
                'content' => 'الافضل هو الرضاعة الطبيعية و التي كلما انتظمت و اكثرتي من شرب السوائل زاد ادرار الحليب' ,
                'consultation_id' => 1,
                'user_id' => 3,
                'best' => 1,
                'created_at' => now()
            ],
            [
                'content' => '1-على الاغلب لاداعي للصناعي. 2- كيف عرفت أنها لا تشبع؟ 3- كم مقدار الزيادة بالوزن منذ الولادة؟! سلامتها',
                'consultation_id' => 2,
                'user_id' => 3,
                'best' => 0,
                'created_at' => now()
            ],
            [
                'content' => 'هل أجريت تصوير رقبه وتحاليل الدم لاستبعاد أسباب أخرى للآلام وإليك بعض من النصائح الطبية في حياتك اليوميه تجنب الحركات الفجائيه الحذر عند استخدام الجوال عدم حني الرقبه واستخدام وساده سمكها من ٨سم الى١٢سم والجلوس والنوم الصحيح وكيفية الوقوف وممكن العلاج الطبيعي' ,
                'consultation_id' => 3,
                'user_id' => 4,
                'best' => 1,
                'created_at' => now()
            ],
            [
                'content' => 'غالبا هذه أعراض احتباس العصب الأوسط في اليد لدى الحوامل أو ما يسمى CTS .' ,
                'consultation_id' =>4,
                'user_id' => 5,
                'best' => 0,
                'created_at' => now()
            ],
            [
                'content' => 'نصح استخدام داعمة يد لمنع ثني الرسغ .تخطيط اعصاب الاطراف العلوية لمعرفة درجة ضغط العصب ومدى الحاجة لتدخل جراحي' ,
                'consultation_id' =>4,
                'user_id' => 6,
                'best' => 0,
                'created_at' => now()
            ]
        ]);
    }
}
