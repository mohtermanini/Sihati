<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Slide;

class SlidesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Slide::insert([
            [
                'title' => 'هل تعلم',
                'content' => 'هل تعلم أن بعض الأطباء يستخدمون زيت الأفعى لعلاج الكثير من الأمراض الخطيرة والقاتلة',
                'img' => 'files/slides/slide1.jpg'
            ],
            [
                'title' => 'هل تعلم',
                'content' => 'هل تعلم أن عظمة الفخذ في جسم الإنسان أصلب وأشد من الخرسانة',
                'img' => 'files/slides/slide2.jpg'
            ],
            [
                'title' => 'معلومة طبية',
                'content' => 'إذا كنت تظن بأنّ الأطفال يولدون بركبتين فأنت مخطئ، إذ يولد الأطفال بغضاريف تتصلب فيما بعد لتصبح عظاماً تشكّل هاتين الركبتين بين العامين الثالث والسادس',
                'img' => 'files/slides/slide3.jpg'
            ],
            [
                'title' => 'هل تعلم',
                'content' => 'مضغ البصل أو الثوم لمدة أربع دقائق كاف لقتل جميع الميكروبات التي توجد في الفم لدرجة التعقيم',
                'img' => 'files/slides/slide4.jpg'
            ],
            [
                'title' => 'هل تعلم',
                'content' => 'يبلغ حجم الهواء الذي يستنشقه الإنسان في كل عام خمسة ملايين لتر',
                'img' => 'files/slides/slide5.jpg'
            ]
        ]);
    }
}
