<?php

namespace App\Http\Controllers;
use App\Models\AdminSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Osiset\BasicShopifyAPI\BasicShopifyAPI;
use Shopify\Clients\Rest;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class DashboardController extends Controller
{
    public function dashboard(){
        $data['user'] = Auth::user();
        return view('dashboard', $data);
    }
    public function sliderOnOff(Request $request){
        if ($request->value == 1){
            $value = 1;
        }else{
            $value = 0;
        }
        $data = AdminSettings::updateOrCreate(['slug' => $request->slug], ['value' => $value]);
    }

    public function home(){
        $user = Auth::user();
        $accessToken = "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";
        $shop = "app-development-qa.myshopify.com";
        $theme = $user->api()->rest('GET', '/admin/themes.json');
        $activeTheme = $theme['body']['container']['themes'];
        $acttime = [];
        foreach ($activeTheme as $maintheme){
            if($maintheme['role'] == 'main'){
                $acttime = $maintheme['id'];
            }
        }

        //File Intregate
        $bootstrap = file_get_contents(base_path("resources\assets\css\bootstrap.min.css"));
        $bootstrapinsert = array('asset' => array('key' => 'assets/bootstrap.min.css', 'value'=> $bootstrap));
        $insert = $user->api()->rest('PUT', '/admin/themes/'.$acttime.'/assets.json', $bootstrapinsert);

        //Owl Carousel
        $owlcarousel = file_get_contents(base_path("resources\assets\css\owl.carousel.min.css"));
        $owlcarouselinsert = array('asset' => array('key' => 'assets/owl.carousel.min.css', 'value'=> $owlcarousel));
        $insert = $user->api()->rest('PUT', '/admin/themes/'.$acttime.'/assets.json', $owlcarouselinsert);

        //Carousel Theme
        $owlcarouseltheme = file_get_contents(base_path("resources\assets\css\owl.theme.default.min.css"));
        $owlcarouselthemeinsert = array('asset' => array('key' => 'assets/owl.theme.default.min.css', 'value'=> $owlcarouseltheme));
        $insert = $user->api()->rest('PUT', '/admin/themes/'.$acttime.'/assets.json', $owlcarouselthemeinsert);


        //Swiper
        $swiper = file_get_contents(base_path("resources\assets\css\swiper.min.css"));
        $swiperinsert = array('asset' => array('key' => 'assets/swiper.min.css', 'value'=> $swiper));
        $insert = $user->api()->rest('PUT', '/admin/themes/'.$acttime.'/assets.json', $swiperinsert);


        //Style CSS
        $codexprosytle = file_get_contents(base_path("resources\assets\css\style.css"));
        $codexprosytleisert = array('asset' => array('key' => 'assets/codexprostyle.css', 'value'=> $codexprosytle));
        $insert = $user->api()->rest('PUT', '/admin/themes/'.$acttime.'/assets.json', $codexprosytleisert);

        //Responsive CSS
        $codexproresponsive = file_get_contents(base_path("resources\assets\css/responsive.css"));
        $codexproresponsiveisert = array('asset' => array('key' => 'assets/responsivecodexpro.css', 'value'=> $codexproresponsive));
        $insert = $user->api()->rest('PUT', '/admin/themes/'.$acttime.'/assets.json', $codexproresponsiveisert);


        //Script Add Section

        // Bootstrap
        $bootstrap = file_get_contents(base_path("resources\assets\js\bootstrap.min.js"));
        $bootstrapinsert = array('asset' => array('key' => 'assets/bootstrap.min.js', 'value'=> $bootstrap));
        $insert = $user->api()->rest('PUT', '/admin/themes/'.$acttime.'/assets.json', $bootstrapinsert);

        // Jquery
        $jquery = file_get_contents(base_path("resources\assets\js\jquery.min.js"));
        $jqueryinsret = array('asset' => array('key' => 'assets/jquery.min.js', 'value'=> $jquery));
        $insert = $user->api()->rest('PUT', '/admin/themes/'.$acttime.'/assets.json', $jqueryinsret);

        // oWl Carousel
        $carousel = file_get_contents(base_path("resources\assets\js\owl.carousel.min.js"));
        $carouselinsert = array('asset' => array('key' => 'assets/owl.carousel.min.js', 'value'=> $carousel));
        $insert = $user->api()->rest('PUT', '/admin/themes/'.$acttime.'/assets.json', $carouselinsert);
        $insert = $user->api()->rest('PUT', '/admin/themes/'.$acttime.'/assets.json', $jqueryinsret);

        // Scrpt JS
        $script = file_get_contents(base_path("resources\assets\js\scripts.js"));
        $scriptsinsert = array('asset' => array('key' => 'assets/scripts.js', 'value'=> $script));
        $insert = $user->api()->rest('PUT', '/admin/themes/'.$acttime.'/assets.json', $scriptsinsert);
        $insert = $user->api()->rest('PUT', '/admin/themes/'.$acttime.'/assets.json', $jqueryinsret);

        // Swiper JS
        $swiper = file_get_contents(base_path("resources\assets\js\swiper.min.js"));
        $swiperinsert = array('asset' => array('key' => 'assets/swiper.min.js', 'value'=> $swiper));
        $insert = $user->api()->rest('PUT', '/admin/themes/'.$acttime.'/assets.json', $swiperinsert);


        //Template Intregate
        $productSlider = file_get_contents(base_path("resources\assets\liquid_template\product-slider.liquid"));
        $productSliderSave = array('asset' => array('key' => 'sections/product-slider.liquid', 'value'=> $productSlider));
        $insert = $user->api()->rest('PUT', '/admin/themes/'.$acttime.'/assets.json', $productSliderSave);


        $scriptPushInsert = array('asset' => array(
            'key' => 'layout/theme.liquid'
        ));
        $request = $user->api()->rest('GET', '/admin/themes/128464126179/assets.json', $scriptPushInsert);

        $getValue = $request['body']['container']['asset']['value'];

        $insertStyle = str_replace("{{ content_for_header }}",
            "{{ content_for_header }}
            <link rel=\"stylesheet\" href=\"{{ 'bootstrap.min.css' | asset_url }}\">
            <link rel=\"stylesheet\" href=\"{{ 'owl.carousel.min.css' | asset_url }}\">
            <link rel=\"stylesheet\" href=\"{{ 'owl.theme.default.min.css' | asset_url }}\">
            <link rel=\"stylesheet\" href=\"{{ 'swiper.min.css' | asset_url }}\">
            <link rel=\"stylesheet\" href=\"{{ 'slicknav.min.css' | asset_url }}\">
            <link rel=\"stylesheet\" href=\"{{ 'magnific-popup.css' | asset_url }}\">
            <link rel=\"stylesheet\" href=\"{{ 'jquery.fancybox.min.css' | asset_url }}\">
            <link rel=\"stylesheet\" href=\"{{ 'slick.min.css' | asset_url }}\">
            <link rel=\"stylesheet\" href=\"{{ 'slick-theme.min.css' | asset_url }}\">
            <link rel=\"stylesheet\" href=\"{{ 'codexprostyle.css' | asset_url }}\">
            <link rel=\"stylesheet\" href=\"{{ 'responsivecodexpro.css' | asset_url }}\">
            "
            , $getValue
        );
        $valuePut = array('asset' => array(
            'key' => 'layout/theme.liquid',
            'value' => $insertStyle
        ));
        $putvalue = $user->api()->rest('PUT', '/admin/api/2021-10/themes/128464126179/assets.json', $valuePut);


        $insertStyle = str_replace("{% section 'footer' %}",
            "{% section 'footer' %}
        <script src=\"{{ 'jquery.min.js' | asset_url }}\"></script>
        <script src=\"{{ 'bootstrap.min.js' | asset_url }}\"></script>
        <script src=\"{{ 'owl.carousel.min.js' | asset_url }}\"></script>
        <script src=\"{{ 'waypoints.min.js' | asset_url }}\"></script>
        <script src=\"{{ 'counterup.min.js' | asset_url }}\"></script>
        <script src=\"{{ 'magnific-popup.min.js' | asset_url }}\"></script>
        <script src=\"{{ 'swiper.min.js' | asset_url }}\"></script>
        <script src=\"{{ 'jquery.fancybox.min.js' | asset_url }}\"></script>
        <script src=\"{{ 'slick.min.js' | asset_url }}\"></script>
        <script src=\"{{ 'scripts.js' | asset_url }}\"></script>
        <script src=\"{{ 'ajaxProduct.js' | asset_url }}\"></script>
            "
            , $getValue
        );
        $valuePut = array('asset' => array(
            'key' => 'layout/theme.liquid',
            'value' => $insertStyle
        ));
        $putvalue = $user->api()->rest('PUT', '/admin/api/2021-10/themes/128464126179/assets.json', $valuePut);

        dd($putvalue);




            $response = $user->api('GET', '/admin/themes/128464126179/assets.json?asset[key]=layout/theme.liquid');


//        $scriptPush = $user->api('https://app-development-qa.myshopify.com/admin/api/2021-10/script_tags.json?script_tag[event]=onload&script_tag[src]=https://aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa.org/fancy.js');
        $scriptPushInsert = array('script_tag' => array(
            'event' => 'onload',
            'src'=> 'https://bbbbbbbbbbbbbbbbbbbbbbbb.org/fancy.js'
        ));
        $jsonData = json_encode($scriptPushInsert, true);

        $jsonEncode =  json_decode($jsonData);

        $insert = $user->api()->rest('POST', '/admin/api/2021-10/script_tags.json', $scriptPushInsert);
        dd($insert);


        $get = $user->api()->rest('GET', '/admin/api/2021-10/script_tags.json?since_id=421379493');

        return $request;



        $theme = $user->api()->rest('GET', '/admin/themes/'.$acttime.'/assets.json');

        $template = [];
        foreach($theme['body']['container']['assets'] as $temp){
            if($temp['key'] == "layout/theme.liquid"){


            }
        }

        //File Insert
        dd($insert);
        return view('dashboard');
    }
    public function getTheme(){
        $user = auth()->user()->api()->rest('GET', '/admin/api/2021-10/themes.json');
        $theme = 1;
        dd($user);
    }
}
