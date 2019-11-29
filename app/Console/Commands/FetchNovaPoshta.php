<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use App\NpArea;
use App\NpCity;
use App\NpWarehouse;

class FetchNovaPoshta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetchNovaPoshta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        Schema::disableForeignKeyConstraints();

        NpArea::truncate();
        NpCity::truncate();
        NpWarehouse::truncate();

        Schema::enableForeignKeyConstraints();

        $this->getAreas();
        $this->getCities();
        $this->getWarehouses();
        \Log::info('Базы Новой почты обновлены', ['Yes']);
    }

    public function getAreas()  //Справочник географических областей Украины
    {
        //curl для новой почты - получаем список отделений (с помощью php)
        $url = 'https://api.novaposhta.ua/v2.0/json/json'; 
        $ch = curl_init(); //инициализирует связь, открывает канал связи с др. страницей (Channel)
        $data_json = [
            "modelName" => "AddressGeneral",
            "calledMethod" => "getAreas",
            "methodProperties" => [
                 "Language" => "ru"
            ],
            "apiKey" => "dd28535535da73faed9f13450e191277"  //без квадратных скобок           
        ];            
        curl_setopt($ch, CURLOPT_URL, $url);  //curl_setopt - настройки обращения, константа и url
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data_json)); //данные которые мы б. отправлять
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $areas  = curl_exec($ch);
        curl_close($ch);
        $all_regions = json_decode($areas); 
        
        foreach ($all_regions->data as $single_region) {
            $region = new NpArea();
            $region->Ref = $single_region->Ref;
            $region->Description = $single_region->Description; 
            $region->save();             
        }
    }

    public function getCities()   //Справочник городов компании
    {
        //curl для новой почты - получаем список отделений (с помощью php)
        $url = 'https://api.novaposhta.ua/v2.0/json/json'; //https://devcenter.novaposhta.ua/docs/services/556d7ccaa0fe4f08e8f7ce43/operations/556d8211a0fe4f08e8f7ce45 после надписи try it
        $ch = curl_init(); //инициализирует связь, открывает канал связи с др. страницей (Channel)
        $data_json = [
            "modelName" => "Address",
            "calledMethod" => "getCities",
            "methodProperties" => [
                 "Language" => "ru",
                //"Area" => "7150812f-9b87-11de-822f-000c2965ae0e",
            ],
            "apiKey" => "dd28535535da73faed9f13450e191277"  //без квадратных скобок           
        ];      
        curl_setopt($ch, CURLOPT_URL, $url);  //curl_setopt - настройки обращения, константа и url
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data_json)); //данные которые мы б. отправлять
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $cities = curl_exec($ch);
        curl_close($ch);
        $all_cities = json_decode($cities);

        foreach ($all_cities->data as $single_city) {
            //dd($single_city);
            $city = new NpCity();
            $city->Ref = $single_city->Ref;
            $city->DescriptionRu = $single_city->DescriptionRu;
            $city->Area = $single_city->Area;
            if (isset($single_city->SettlementTypeDescriptionRu)) {
                $city->SettlementTypeDescriptionRu = $single_city->SettlementTypeDescriptionRu;
            }
            //dd($city);
            $city->save();             
        }
    }

    public function getWarehouses()  //Справочник населенных пунктов Украины
    {
        $url = 'https://api.novaposhta.ua/v2.0/json/json'; 
        $ch = curl_init(); 
        $data_json = [
            "modelName" => "AddressGeneral",
            "calledMethod" => "getWarehouses",
            "methodProperties" => [
                 "Language" => "ru",
                 //"CityRef" => "ebc0eda9-93ec-11e3-b441-0050568002cf"
                 // "CityName" => "Запорожье"
            ],
            "apiKey" => "dd28535535da73faed9f13450e191277"        
        ];   
        curl_setopt($ch, CURLOPT_URL, $url);  
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data_json));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $warehouses  = curl_exec($ch);
        curl_close($ch);
        $all_warehouses = json_decode($warehouses);
        foreach ($all_warehouses->data as $single_warehouse) {
            //dd($single_warehouse);
            $warehouse = new NpWarehouse();
            $warehouse->CityRef = $single_warehouse->CityRef;
            $warehouse->DescriptionRu = $single_warehouse->DescriptionRu;
            //dd($warehouse);
            $warehouse->save();             
        }
    }
}
