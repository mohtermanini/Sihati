<?php

namespace Database\Seeders;
use App\Models\Profile;

use Illuminate\Database\Seeder;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::insert([
            [
                'first_name' => 'صحتي',
                'last_name' => null,
                'avatar' => 'files/profiles/admin.png',
                'birthday' => null,
                'gender' => -1,
                'description' => null,
                'email_visible' => 0,
                'birthday_visible' => 0
            ],
            [
                'first_name' => 'سوسن',
                'last_name' => 'الأحمد',
                'avatar' => 'files/profiles/woman1.jpg',
                'birthday' => '1992-10-2',
                'gender' => 1,
                'description' => 'عملت في مصر والسعودية لمدة 8 سنوات شغوفة بمجال الكتابة والترجمة الطبية وأعمل في عدة مواقع طبية',
                'email_visible' => 0,
                'birthday_visible' => 0
            ],
            [
                'first_name' => 'مريم',
                'last_name' => 'نابلسي',
                'avatar' => 'files/profiles/woman2.jpg',
                'birthday' => '1990-01-7',
                'gender' => 1,
                'description' => 'تعمل ككاتبة محتوى وباحثة، ولها العديد من المنشورات المتمحورة حول المحتوى الصحي والدوائي، وتدور اهتماماتها حول الصحة الالكترونية والتوعية الدوائية، بالإضافة للأبحاث في المجال السريري.',
                'email_visible' => 1,
                'birthday_visible' => 1
            ],
            [
                'first_name' => 'أحمد',
                'last_name' => 'قاضي',
                'avatar' => 'files/profiles/man1.jpg',
                'birthday' => '1981-5-7',
                'gender' => 0,
                'description' => 'طالب في السنة الرابعة بكلية الصيدلة جامعة فاروس بالأسكندرية، كاتب محتوى طبي، كتب العديد من المقالات لعدة مواقع مثل موقع ترياقي للصحة النفسية وغيره من المواقع الطبية، وعلى منصات العمل الحر أيضًا. يعمل كذلك بعدة مجالات صيدلانية، منها الصيدلة العشبية، والتركيبات، ومستحضرات التجميل، وغيرهم ... وعمل في الصيدلة المجتمعية عام 2019',
                'email_visible' => 1,
                'birthday_visible' => 1
            ],
            [
                'first_name' => 'عارف',
                'last_name' => 'الطويل',
                'avatar' => 'files/profiles/man2.jpg',
                'birthday' => '1962-5-8',
                'gender' => 0,
                'description' => 'كاتب ومثري ومدقق طبي سابق ، مترجم طبي معتمد لدى شركة لينجي البريطانية مدير منح طبية لدى مؤسسة المنار للتنمية البشرية سابقا، مساعد ابحاث جامعة طوكيو سابقا باحث طبي لدى موقع الطبي.',
                'email_visible' => 0,
                'birthday_visible' => 0
            ],
            [
                'first_name' => 'مريم',
                'last_name' => 'وهاب',
                'avatar' => 'files/profiles/woman3.jpg',
                'birthday' => '1984-7-13',
                'gender' => 1,
                'description' => 'دكتورة صيدلانية مهتمة بكتابة المحتوى الطبي و المساهمة برفع الوعي بالمعلومات الطبية والصيدلانية الصحيحة',
                'email_visible' => 0,
                'birthday_visible' => 0
            ],
            [
                'first_name' => 'إيهاب',
                'last_name' => 'جمعة',
                'avatar' => 'files/profiles/default.png',
                'birthday' => '1990-10-13',
                'gender' => 0,
                'description' => 'صيدلاني مصري لدي خبرة طبية ودوائية واسعة وكاتب محتوى طبي، أعمل على إثراء المحتوى الطبي والصيدلي العربي على الإنترنت لتوفير المعلومة الطبية بصورة مبسطة للجمهور العربي إيمانًا بحقه في المعرفة الطبية بما يعتريه من أمراض وماهية العلاج الذي يتناوله، فالمعرفة حقٌ للجميع وأسعى بكتاباتي دائما لوضع بصمتي في ذلك، كما أعمل مترجم طبي ساع لتقريب المسافات بين الشعوب والثقافات بترجمتي إلى جانب حبي للتقنيات الحديثة من برامج وأسعى لتعلم كل ما هو جديد مواكبةً لعصري.',
                'email_visible' => 0,
                'birthday_visible' => 0
            ]
        ]);
    }
}
