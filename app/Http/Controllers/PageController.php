<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Session;


class PageController extends Controller
{


    const KESZENALLOKGOMB_HU = '<a href="/registration"><button class="btn btn-stanford btn-lg">Készen állok</button></a>';
    const KESZENALLOKGOMB_ENG = '<a href="/registration"><button class="btn btn-stanford btn-lg">I`m Ready to Start</button></a>';





    private function getSection($section)
    {
        $locale = Session::get('locale', 'hu');


        $contentModel = Content::where('is_active', true)
                          ->where('key', $section)
                          ->first();


        // dd($contentModel);

        // if (!$contentModel) {
        //     return view('bemutatkozas');
        // }

        if (!$contentModel) {
            // Ha nincs találat, létrehozunk egy alap tartalmat vagy üres objektumot
            $content = new \stdClass();
            $content->title = 'Feltöltés alatt álló oldal';
            $content->content = 'Ez az oldal még szerkesztés alatt áll.';
        }



        if ($contentModel) {
            // dd(Session::all());
            // Nyelv szerinti tartalom kiválasztása
            if ($locale == 'en' && !empty($contentModel->title_english) && !empty($contentModel->content_english)) {
                $content = (object)[
                    'title' => $contentModel->title_english,
                    'content' => $contentModel->content_english
                ];
                $content->content = str_replace(
                    '{{keszenAllokGomb}}',
                    self::KESZENALLOKGOMB_ENG,
                    $content->content
                );
            } else {

                $content = (object)[
                    'title' => $contentModel->title,
                    'content' => $contentModel->content
                ];
                $content->content = str_replace(
                    '{{keszenAllokGomb}}',
                    self::KESZENALLOKGOMB_HU,
                    $content->content
                );
            }
        }


        return $content;

    }


    public function akademia()
    {
        $content = $this->getSection('academy');
        return view('bemutatkozas', compact('content'));
    }

    public function bemutatkozas()
    {
        $content = $this->getSection('bemutatkozas');
        return view('bemutatkozas', compact('content'));
    }


    public function tanfolyam()
    {
        $content = $this->getSection('tanfolyam');
        return view('bemutatkozas', compact('content'));
    }


}
