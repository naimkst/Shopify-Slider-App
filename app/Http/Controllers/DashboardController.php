<?php

namespace App\Http\Controllers;
use App\Models\AdminSettings;
use App\Models\UninstallUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Osiset\BasicShopifyAPI\BasicShopifyAPI;
use Shopify\Clients\Rest;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class DashboardController extends Controller
{
    //Dashboard Data
    public function dashboard(){
        $data['user'] = Auth::user();
        return view('dashboard', $data);
    }

    //Ajax Request Data
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
        }
        else{
            $data = AdminSettings::updateOrCreate(['slug' => $request->_host], ['value' => $value]);
        }
    }

    //Home Setup Data
    public function home(){
        $data['user'] = Auth::user();
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


        $scriptPushInsertUpdate = array('asset' => array(
            'key' => 'layout/theme.liquid'
        ));
        $requestApiUpdate = $user->api()->rest('GET', '/admin/themes/'.$acttime.'/assets.json', $scriptPushInsertUpdate);
        $getValueUpdate = $requestApiUpdate['body']['container']['asset']['value'];

        $insertStyleUpdate = str_replace("{{ content_for_header }}",
            "{{ content_for_header }}{% include 'product-slider-style' %}", $getValueUpdate
        );
        $insertStyleUpdate = str_replace("{% include 'product-slider-style' %}{% include 'product-slider-style' %}",
            "{% include 'product-slider-style' %}", $insertStyleUpdate
        );

        //Script Value Add
        $insertJsUpdate = str_replace("{% section 'footer' %}",
            "{% section 'footer' %}{% include 'product-slider-script' %}", $insertStyleUpdate
        );

        $insertJsUpdate = str_replace("{% include 'product-slider-script' %}{% include 'product-slider-script' %}",
            "{% include 'product-slider-script' %}", $insertJsUpdate
        );

        $valuePutUpdate = array('asset' => array(
            'key' => 'layout/theme.liquid',
            'value' => $insertJsUpdate,
        ));

        $putvalueStyle = $user->api()->rest('PUT', '/admin/api/2021-10/themes/'.$acttime.'/assets.json', $valuePutUpdate);

        //Template Intregate
        $productSlider = file_get_contents(base_path("resources/assets/liquid_template/product-slider.liquid"));
        $productSliderSave = array('asset' => array('key' => 'sections/product-slider.liquid', 'value'=> $productSlider));
        $insert = $user->api()->rest('PUT', '/admin/themes/'.$acttime.'/assets.json', $productSliderSave);

        //Snippet Style
        $productSliderStyle = file_get_contents(base_path("resources/assets/liquid_template/product-slider-style.liquid"));
        $productSliderStyleSave = array('asset' => array('key' => 'snippets/product-slider-style.liquid', 'value'=> $productSliderStyle));
        $insert = $user->api()->rest('PUT', '/admin/themes/'.$acttime.'/assets.json', $productSliderStyleSave);

        //Snippet Script
        $productSliderScript = file_get_contents(base_path("resources/assets/liquid_template/product-slider-script.liquid"));
        $productSliderScriptSave = array('asset' => array('key' => 'snippets/product-slider-script.liquid', 'value'=> $productSliderScript));
        $insert = $user->api()->rest('PUT', '/admin/themes/'.$acttime.'/assets.json', $productSliderScriptSave);

        return view('dashboard', $data);
    }
    //Get Theme Data
    public function getTheme(){
        $user = auth()->user()->api()->rest('GET', '/admin/api/2021-10/themes.json');
        $theme = 1;
        dd($user);
    }
    //Documentataion data
    public function documentation(){
        $data['user'] = Auth::user();
        return view('documentation', $data);
    }
    public function uninstall(Request $request){
        $user = $request->all();
        $delete = DB::table("users")->where('name', $user['domain'])->delete();
        $whereemail = User::where('name', $user['domain'])->first();
        $data = [
            'name' => $user['name'],
            'email' => $user['email'],
            'domain' => $user['domain'],
            'country_name' => $user['country_name'],
            'customer_email' => $user['customer_email'],
            'shop_owner' => $user['shop_owner'],
        ];
        $userDeleteData = DB::table("uninstall_users")->insert($data);

        Log::info('insseeeeeeeeeeeeeeeeerrrrrrrrrrrrr', $userDeleteData);
        Log::info($delete);
        Log::info("Delete", $user['domain']);
        Log::info('okkkkkkkkkkkkkkkk');
    }
}
