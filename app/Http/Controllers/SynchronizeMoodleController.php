<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityCourseRegisteredUser;
use App\Models\Course;
use App\Models\CourseRegisteredUser;
use App\Models\Platform;
use App\Models\RegisteredUser;
use App\Models\Rut;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SynchronizeMoodleController extends Controller
{
    private $base_url;
    private $username;
    private $password;
    private $domain;
    private $cookieFile;
    private $agent;
    private $ch_actual;

    public function __construct()
    {
        $this->base_url = "https://www.e-mineduc.cl/";
        $this->username = "7.449.057-3";
        $this->password = "9057";
        $this->domain = "moodle.iie.cl/";
    }

    public function getBASE_URL()
    {
        return $this->base_url;
    }

    public function loginMoodle()
    {
        $this->agent = $this->detectBrowser();
        $ruta_actual = getcwd() . "\cookies";

        $this->cookieFile = @tempnam($ruta_actual, "../cookies");

         $postfields = array( "username" => $this->username,
                                "password" => $this->password,
                                "domain" => $this->domain);

         $url = $this->base_url . "login/index.php";

         $ch = curl_init();
         curl_setopt($ch, CURLOPT_USERAGENT, $this->agent);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($ch, CURLOPT_TIMEOUT, 0);
         curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile);
         curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieFile);
         curl_setopt($ch, CURLOPT_VERBOSE, '');
         curl_setopt($ch, CURLINFO_HEADER_OUT, true);
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
         curl_setopt($ch, CURLOPT_POST, 1);
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
         curl_setopt($ch, CURLOPT_HEADER, 1);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
         
         $result = curl_exec ($ch);
         curl_close ($ch);

        return true;
    }

    public function syncUsersByCourse($idCursoMoodle)
    {
        $curso = Course::where("id_course_moodle", $idCursoMoodle)->first();
        if(!isset($curso)){
            return response()->json(['success' => false, 'error' => 'Curso no se encuentra en el sistema.'], 500);
            return;
        }

        $this->loginMoodle();
        $url = $this->base_url . "/enrol/users.php?id=" . $idCursoMoodle ."&perpage=1000";
        $html = $this->runCurl($url); 
        curl_close($this->ch_actual);
        $alumnos = array();
        try {
            $doc = new \DOMDocument();
            libxml_use_internal_errors(true);
            if (trim($html) == "")
            {
                return response()->json(['success' => false, 'error' => 'La url no retornó datos. URL: $url'], 500);
            }
            $doc->loadHTML($html);

            $tables = $doc->getElementsByTagName("table");
            if ($tables == null)
            {
                return response()->json(['success' => false, 'error' => 'No hay tablas de matriculacion.'], 500);
            }
            
            $cont_users = 0;
            foreach ($tables as $table)
            {
                $classTable = $table -> getAttribute("class");
                $pos = strpos ($classTable, "userenrolment");
                if ($pos !== false)
                    {
                        $rows = $table->getElementsByTagName("tr");
                        foreach ($rows as $row)
                        {
                            $IdUser = $row -> getAttribute("id");
                            if ($IdUser != null && $IdUser != "")
                                {
                                    $name = "";
                                    $rut = "";
                                    $email = "";
                                    $ultacceso = "";
                                    $roles = array ();
                                    $IdUser = substr($IdUser, strlen("user_"));
                                    $name = "";
                                    $rut = "";
                                    $email = "";
                                    $tds = $row -> getElementsByTagName('td');
                                    foreach ($tds as $td)
                                        {
                                            $tdclass = $td -> getAttribute("class");
                                            if (strpos ($tdclass, "col_userdetails") !== false)
                                                {
                                                    $cells = $td -> getElementsByTagName('div');
                                                    foreach ($cells as $cell)
                                                        {
                                                            $class = $cell -> getAttribute("class");
                                                            if (!strpos($class, "subfield_userfullnamedisplay") === false)
                                                                $name = $cell -> childNodes->item(0)->nodeValue;
                                                            elseif (!strpos($class, "subfield_idnumber") === false)
                                                                $rut = $cell -> childNodes->item(0)->nodeValue;
                                                            elseif (!strpos($class, "subfield_email") === false)
                                                                $email = $cell -> childNodes->item(0)->nodeValue;
                                                        }
                                                }
                                            elseif (strpos ($tdclass, "col_lastcourseaccess") !== false)
                                                {
                                                    $ultacceso = $td  -> childNodes->item(0)->nodeValue;
                                                }
                                            elseif (strpos ($tdclass, "col_role") !== false)
                                                {
                                                    $cells = $td -> getElementsByTagName('div');
                                                    $cell = $cells [0]; //as $cell)
                                                    $child = $cell -> firstChild;
                                                    $perfil = $child -> nodeValue;
                                                    $idperfil = $child ->getAttribute("rel");
                                                }
                                        }

                                    $rUser = RegisteredUser::where("id_registered_moodle", $IdUser)->first();

                                    if(isset($rUser->id))
                                        {
                                            $rUser->id_registered_moodle = isset($IdUser) ? $IdUser : null;
                                            $rUser->rut_registered_moodle = isset($rut) ? $rut : null;
                                            $rUser->name_registered_moodle = isset($name) ? $name : null;
                                            $rUser->email_registered_moodle = isset($email) ? $email : null;
                                            $userCurso = CourseRegisteredUser::where("registered_user_id", $rUser->id)
                                                            ->where("course_id", $curso->id)
                                                            ->first();
                                            if(isset($userCurso))
                                            {
                                                $userCurso->last_access_registered_moodle = $ultacceso;
                                                $userCurso->save();
                                                $cont_users++;
                                            }
                                        }
                                }
                        }
                }
            }
            return response()->json(
                [
                'status' => 'ok'
              ],
                201
            );
        }catch (\Exception $ex) {
            return response()->json(
                [
              'status' => 'error',
              'error' => $ex->getMessage(),
              'line' => $ex->getLine()
            ],
                200
            );
        }
    }

    public function syncUserByCourseRut($idCursoMoodle, $rutInp)
    {
        $curso = Course::where("id_course_moodle", $idCursoMoodle)->first();
        if(!isset($curso)){
            return response()->json(['success' => false, 'error' => 'Curso no se encuentra en el sistema.'], 500);
            return;
        }
        $this->loginMoodle();
        $url = $this->base_url . "/enrol/users.php?id=" . $idCursoMoodle ."&perpage=1000";
        $html = $this->runCurl($url); 
        curl_close($this->ch_actual);
        $alumnos = array();
        try {
            $doc = new \DOMDocument();
            libxml_use_internal_errors(true);
            if (trim($html) == "")
            {
                return response()->json(['success' => false, 'error' => 'La url no retornó datos. URL: $url .'], 500);
            }
            $doc->loadHTML($html);

            $tables = $doc->getElementsByTagName("table");
            if ($tables == null)
            {
                return response()->json(['success' => false, 'error' => 'No hay tablas de matriculacion.'], 500);
            }

            foreach ($tables as $table)
            {
                $classTable = $table -> getAttribute("class");
                $pos = strpos ($classTable, "userenrolment");
                if ($pos !== false)
                    {
                        $rows = $table->getElementsByTagName("tr");
                        foreach ($rows as $row)
                        {
                            $IdUser = $row -> getAttribute("id");
                            if ($IdUser != null && $IdUser != "")
                                {
                                    $ultacceso = "";
                                    $roles = array ();
                                    $IdUser = substr($IdUser, strlen("user_"));
                                    $rut = "";
                                    $tds = $row -> getElementsByTagName('td');
                                    foreach ($tds as $td)
                                        {
                                            $tdclass = $td -> getAttribute("class");
                                            if (strpos ($tdclass, "col_userdetails") !== false)
                                                {
                                                    $cells = $td -> getElementsByTagName('div');
                                                    foreach ($cells as $cell)
                                                        {
                                                            $class = $cell -> getAttribute("class");
                                                            if (!strpos($class, "subfield_idnumber") === false)
                                                                {
                                                                    $rut = $cell -> childNodes->item(0)->nodeValue;
                                                                }
                                                        }
                                                }
                                            elseif (strpos ($tdclass, "col_lastcourseaccess") !== false)
                                                {
                                                    $ultacceso = $td  -> childNodes->item(0)->nodeValue;
                                                }
                                        }

                                    if(strtoupper($rutInp) == strtoupper($rut))
                                    {
                                        $rUser = RegisteredUser::where("rut", "ilike", $rut)->first();
                                        if(isset($rUser->id))
                                            {
                                                $userCurso = CourseRegisteredUser::where("registered_user_id", $rUser->id)
                                                                ->where("course_id", $curso->id)
                                                                ->first();
                                                if(isset($userCurso))
                                                {
                                                    $userCurso->last_access_registered_moodle = $ultacceso;
                                                    $userCurso->save();
                                                    return response()->json(
                                                        [
                                                        'status' => 'ok'
                                                      ],
                                                        201
                                                    );
                                                }
                                           }

                                    }
                                }
                        }
                }
            }
        }catch (\Exception $ex) {
            return response()->json(
                [
              'status' => 'error',
              'error' => $ex->getMessage(),
              'line' => $ex->getLine()
            ],
                416
            );
        }

        return response()->json(
            [
          'status' => 'error',
          'error' => 'Rut no encontrado en el curso.'
        ],
            204
        );
    }

    public function syncActivitiesUsers ($IdCurso)
    {
        $ejecucion = false;
        $actividadesUsers = array();
        $curso = Course::where("id_course_moodle", $IdCurso)->first();
        if(!isset($curso))
            {
                return response()->json(['success' => false, 'error' => 'Curso no se encuentra en el sistema.'], 500);
            }
        $course_users = CourseRegisteredUser::where("course_id", $curso["id"])->get();
        $cant_users = count($course_users);
        $vueltas = round (($cant_users)/100, 0, PHP_ROUND_HALF_UP);
        $id_moodle_missed = array();
        $id_reg_user_missed = array();
        $this->loginMoodle();
        try {
            for ($INDEX = 0; $INDEX <= $vueltas; $INDEX++)
            {
                $url = $this->base_url . "/grade/report/grader/index.php?id=$IdCurso&page=$INDEX";
                $html = $this->runCurl($url); 
                curl_close($this->ch_actual);
                $doc = new \DOMDocument();
                libxml_use_internal_errors(true);
                $doc->loadHTML($html);
                $ids = array();
                $tables = $doc -> getElementsByTagName("table");
                foreach ($tables as $table)
                    {
                        $idtables = $table -> getAttribute("id");
                        if ($idtables != "user-grades")
                            {
                                continue;
                            }
                        $actividades = array ();
                        $trs = $table -> getElementsByTagName("tr");
                        foreach ($trs as $tr)
                        {
                            $classTr = $tr -> getAttribute("class");
                            if ($classTr == "heading")
                            {
                                $ths = $tr -> getElementsByTagName("th");
                                foreach ($ths as $th)
                                {
                                    $classTh = $th -> getAttribute("class");
                                    if (strpos ($classTh, "item catlevel2") !== false || strpos ($classTh, "item catlevel1") !== false)
                                    {
                                        $ArrayClase = explode (" ", $classTh );
                                        $as = $th -> getElementsByTagName("a");
                                        foreach ($as as $a)
                                        {
                                            $classA = $a -> getAttribute("class");
                                            if ($classA == "gradeitemheader")
                                            {
                                                $nombre = $a -> getAttribute("title");
                                                $href = $a -> getAttribute("href");

                                                $parts1 = parse_url($href, PHP_URL_QUERY);
                                                $partes = explode ("=", $parts1);
                                                if (strpos($partes[1], "&itemnumber") !== false)
                                                {
                                                    $p = explode ("&", $partes[1]);
                                                    $partes[1] = $p[0];
                                                }
                                                $idmod = $partes[1];

                                                $Classactividades = array();
                                                $Classactividades["id_actividad_moodle"] = $idmod;
                                                $Classactividades["nombre"] = $nombre;
                                                $Classactividades["id_curso"] = $curso["id"];

                                                $actividades[$ArrayClase[3]] = $Classactividades;
                                            }
                                        }
                                    }
                                }
                            }
                            elseif ($classTr == "")
                            {
                                if ($tr -> hasAttribute("id"))
                                {
                                    $idTR = $tr -> getAttribute("id");
                                    if (strpos ($idTR, "fixed_user") !== false)
                                    {
                                        $ths = $tr -> getElementsByTagName("th");
                                        $IdUser = "";
                                        $Nombre = "";
                                        $RUT = "";
                                        $EMAIL = "";
                                        foreach ($ths as $th)
                                        {
                                            $as = $th  -> getElementsByTagName("a");
                                            $num = 0;
                                            foreach ($as as $a)
                                            {
                                                if ($num == 0)
                                                {
                                                    $href = $a -> getAttribute("href");
                                                    $parts1 = parse_url($href, PHP_URL_QUERY);
                                                    $partes = explode ("=", $parts1);
                                                    $IdUser = $partes[0];
                                                }
                                                elseif ($num == 1)
                                                {
                                                    $href = $a -> getAttribute("href");
                                                    $parts1 = parse_url($href, PHP_URL_QUERY);
                                                    $partes = explode ("=", $parts1);
                                                    if (strpos($partes[1], "&course") !== false)
                                                    {
                                                        $partes[1] = substr($partes[1], 0, strlen($partes[1]) - strlen ("&course")) ;
                                                    }
                                                    $IdUser = $partes[1];
                                                    $Nombre = $a -> nodeValue;
                                                }
                                                $num++;
                                            }
                                        }
                                        $tds = $tr -> getElementsByTagName("td");
                                        $Columnas = 0;
                                        foreach ($tds as $td)
                                        {
                                            switch ($Columnas) 
                                            {
                                                case 1:
                                                    $RUT = $td -> nodeValue;
                                                    break;
                                                case 2:
                                                    $EMAIL = $td -> nodeValue;
                                                    break;
                                                default :
                                                    $ClassTd = $td -> getAttribute("class");
                                                    $ArrayClase  = explode(" ", $ClassTd);
                                                    if (isset($actividades ['cat'])) {
                                                        break;
                                                    }
                                                    
                                                    if (isset($actividades [$ArrayClase[1]]))
                                                        {
                                                            $Califica = $td -> nodeValue;
                                                            $rUserId = RegisteredUser::where("id_registered_moodle", $IdUser)->first();
                                                            if(isset($rUserId->id)){
                                                                $rUserId = $rUserId->id;
                                                            }else{
                                                                $id_moodle_missed[] = $IdUser;
                                                                continue;
                                                            }
                                                            $courseUserId = CourseRegisteredUser::where("registered_user_id", $rUserId)
                                                                            ->where("course_id", $curso["id"])
                                                                            ->first();
                                                            if(isset($courseUserId->id)){
                                                                $courseUserId = $courseUserId->id;   
                                                            }else{
                                                                $id_reg_user_missed[] = $rUserId;
                                                                continue;
                                                            }
                                                                      
                                                            $activityMoodleId = $actividades[$ArrayClase[1]]["id_actividad_moodle"];
                                                            $activityId = Activity::where("id_activity_moodle", $activityMoodleId)
                                                                            ->where("section_id", "!=", 9)
                                                                            ->first();
                                                            if(isset($activityId->id)){
                                                                $activityId = $activityId->id;
                                                            }else{
                                                                continue;
                                                            }
                                                            $activityUser = ActivityCourseRegisteredUser::where("course_registered_user_id", $courseUserId)
                                                                            ->where("activity_id", $activityId)
                                                                            ->first();
                                                            $estado = "";
                                                            if($Califica == "-"){
                                                                $estado = "Sin entrega";
                                                            }else{
                                                                $estado = "Finalizado";
                                                            }

                                                            if(isset($activityUser->id)){
                                                                $activityUser->status_moodle = $estado;
                                                                $activityUser->qualification_moodle = $Califica;
                                                                $activityUser->save();
                                                            }else{
                                                                $activityUserNew = new ActivityCourseRegisteredUser();
                                                                $activityUserNew->activity_id = $activityId;
                                                                $activityUserNew->course_registered_user_id = $courseUserId;
                                                                $activityUserNew->status_moodle = $estado;
                                                                $activityUserNew->qualification_moodle = $Califica;
                                                                $activityUserNew->save();
                                                            }
                                                        }
                                                    break;
                                            } 
                                            $Columnas++;
                                        }
                                    }
                                }
                            }
                        }
                    }
                $ejecucion = true;
            }
        }catch (\Exception $ex) {
            return response()->json(
                [
              'status' => 'error',
              'error' => $ex->getMessage(),
              'line' => $ex->getLine()
            ],
                416
            );
        }

        if($ejecucion == true){
            return response()->json(
                [
                'status' => 'ok',
                'ids_moodle_missed' => array_unique($id_moodle_missed),
                'ids_registered_user_missed' => array_unique($id_reg_user_missed),
              ],
                201
            );
        }
    }

    public function runCurl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, $this->agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieFile);
        curl_setopt($ch, CURLOPT_VERBOSE, "");
        set_time_limit(0);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        $result = curl_exec($ch);
        if(curl_exec($ch) === false)
        {
            echo 'Curl error: ' . curl_error($ch);
            return;
        }
        $this->ch_actual = $ch;

        return $result;
    }

    public static function detectBrowser() 
    {
        if(empty($_SERVER['HTTP_USER_AGENT'])) {
            return "Mozilla/5.0 (X11; Linux x86_64; rv:60.0) Gecko/20100101 Firefox/60.0";
        }
        return $_SERVER['HTTP_USER_AGENT'];
    }

    protected function connectionPost ($path, $postfields)
    {
        echo "<br>".$path."<br>";
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_USERAGENT, $this->$agent);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($ch, CURLOPT_TIMEOUT, 0);
         curl_setopt($ch, CURLOPT_COOKIEFILE, $this -> cookieFile);
         curl_setopt($ch, CURLOPT_COOKIEJAR, $this -> cookieFile);
         curl_setopt($ch, CURLOPT_VERBOSE, $this -> debug);
         curl_setopt($ch, CURLINFO_HEADER_OUT, true);
         if ($this -> debug)
            curl_setopt($ch, CURLOPT_STDERR, $this -> debugHandle);
         curl_setopt($ch, CURLOPT_URL, $path);
         curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
         curl_setopt($ch, CURLOPT_POST, 1);
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
         curl_setopt($ch, CURLOPT_HEADER, 1);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

         return $ch;
    }

    public static function arreglo($str) {
        echo '<pre>';
        print_r($str);
        echo '</pre>';
    }
}
