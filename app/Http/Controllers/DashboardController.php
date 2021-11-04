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
        // User All Data Get
        $user = $request->_host;

        //Shopify Shop Access Token
        $accessToken = "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";

        //Get Current Theme
        $user = Auth::user();
        $theme = $user->api()->rest('GET', '/admin/themes.json');
        $activeTheme = $theme['body']['container']['themes'];
        $acttime = [];
        foreach ($activeTheme as $maintheme){
            if($maintheme['role'] == 'main'){
                $acttime = $maintheme['id'];
            }
        }

        //Data Save Active Or not
        if ($request->value == 1){
            $value = 1;
        }else{
            $value = 0;
        }

        if ($value == 1){
            $data = AdminSettings::updateOrCreate(['slug' => $request->_host], ['value' => $value]);
            //Insert All Data

            //Insert The Script & Style Data
            $scriptPushInsert = array('asset' => array(
                'key' => 'layout/theme.liquid'
            ));
            $requestApi = $user->api()->rest('GET', '/admin/themes/'.$acttime.'/assets.json', $scriptPushInsert);
            $getValue = $requestApi['body']['container']['asset']['value'];
            $insertStyle = str_replace("{{ content_for_header }}",
                "{{ content_for_header }}
            <link rel=\"stylesheet\" href=\"https://cdn.ewebdevs.com/wp-content/uploads/2021/11/bootstrap.min_.css\">
            <link rel=\"stylesheet\" href=\"https://cdn.ewebdevs.com/wp-content/uploads/2021/11/owl.carousel.min_.css\">
            "
                , $getValue
            );

            $valuePut = array('asset' => array(
                'key' => 'layout/theme.liquid',
                'value' => $insertStyle
            ));
            $putvalue = $user->api()->rest('PUT', '/admin/api/2021-10/themes/'.$acttime.'/assets.json', $valuePut);

            //Script Value Add
            $insertStyle = str_replace("{% section 'footer' %}",
                "{% section 'footer' %}
        <script src=\"https://cdn.ewebdevs.com/wp-content/uploads/2021/11/jquery.min_.js\"></script>
        <script src=\"https://cdn.ewebdevs.com/wp-content/uploads/2021/11/bootstrap.min_.js\"></script>
        <script src=\"https://cdn.ewebdevs.com/wp-content/uploads/2021/11/owl.carousel.min_.js\"></script>
        <script src=\"https://cdn.ewebdevs.com/wp-content/uploads/2021/11/scripts.js\"></script>
        "
                , $getValue
            );
            $valuePut = array('asset' => array(
                'key' => 'layout/theme.liquid',
                'value' => $insertStyle
            ));
            $putvalue = $user->api()->rest('PUT', '/admin/api/2021-10/themes/'.$acttime.'/assets.json', $valuePut);

        //Template Intregate
        $productSlider = file_get_contents(base_path("resources\assets\liquid_template\product-slider.liquid"));
        $productSliderSave = array('asset' => array('key' => 'sections/product-slider.liquid', 'value'=> $productSlider));
        $insert = $user->api()->rest('PUT', '/admin/themes/'.$acttime.'/assets.json', $productSliderSave);


        }
        else{
            $data = AdminSettings::updateOrCreate(['slug' => $request->_host], ['value' => $value]);
        }
    }

    public function home(){
        return view('dashboard');
    }
    public function getTheme(){
        $user = auth()->user()->api()->rest('GET', '/admin/api/2021-10/themes.json');
        $theme = 1;
        dd($user);
    }
    public function documentation(){
        $data['user'] = Auth::user();
        return view('documentation', $data);
    }
}
