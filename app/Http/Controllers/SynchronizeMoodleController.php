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
            $users_not_found = [];
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

                            // Buscamos usuario por su ID Moodle, Si no lo encuentra podría ser usuario nuevo y debemos buscar por rut
                            $rUser = RegisteredUser::where("id_registered_moodle", $IdUser)->first();

                            if(!isset($rUser->id))
                            {
                                $rUser = RegisteredUser::where("rut", strtoupper($rut))->first();
                                if(!isset($rUser->id))
                                {
                                    $users_not_found[] = strtoupper($rut);
                                    continue;
                                }
                            }

                            $rUser->id_registered_moodle = isset($IdUser) ? $IdUser : null;
                            $rUser->rut_registered_moodle = isset($rut) ? strtoupper($rut) : null;
                            $rUser->name_registered_moodle = isset($name) ? $name : null;
                            $rUser->email_registered_moodle = isset($email) ? $email : null;
                            $rUser->save();
                            $userCurso = CourseRegisteredUser::where("registered_user_id", $rUser->id)
                                            ->where("course_id", $curso->id)
                                            ->first();
                            if(isset($userCurso))
                            {
                                $userCurso->last_access_registered_moodle = $ultacceso;
                                $userCurso->is_sincronized = 1;
                                $userCurso->save();
                            }
                            $cont_users++;
                        }
                    }
                }
            }
            return response()->json(
                [
                'status' => 'ok',
                'users_not_found' => $users_not_found,
                'cont_users' => $cont_users,
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

    public function syncActivitiesUsers($IdCurso)
    {
        $actividadesUsers = array();
        $data = array();
        $curso = Course::where("id_course_moodle", $IdCurso)->first();
        if(!isset($curso))
        {
            return response()->json(['success' => false, 'error' => 'Curso no se encuentra en el sistema.'], 500);
        }
        $id_moodle_missed = array();
        $id_reg_user_missed = array();
        $this->loginMoodle();
        try {
            $actividades = Activity::where("course_id", $curso->id)
                            ->where("section_id", "!=", 9)
                            ->get();
            foreach($actividades as $actividad)
            {
                switch ($actividad["type"]) {
                    case 'Tareas':
                        $data["tareas"][$actividad["id_activity_moodle"]] = $this->buscarCalificacionesTareas($curso->id, $actividad["id_activity_moodle"]);
                        break;
                    case 'Foros':
                        $data["foros"][$actividad["id_activity_moodle"]] = $this->buscarCalificacionesForos($curso->id, $actividad["id_activity_moodle"]);
                        break;
                    case 'Cuestionarios':
                        $data["cuestionarios"][$actividad["id_activity_moodle"]] = $this->buscarCalificacionesCuestionarios($curso->id, $actividad["id_activity_moodle"]);
                        break;
                    //TODO : Revisar funcionamiento script que obtiene calificaciones de encuestas.
                    /*case 'Encuestas':
                        $this->buscarCalificacionesEncuestas($actividad["id_activity_moodle"]);
                        break;*/
                }
            }

            foreach ($data as $tipo => $dataTipo) {
                foreach ($dataTipo as $idActivityMoodle => $values) {
                    foreach ($values as $value) {
                        $rUserId = RegisteredUser::where("id_registered_moodle", $value["id_user_moodle"])->first();
                        if(isset($rUserId->id)){
                            $rUserId = $rUserId->id;
                        }else{
                            $id_moodle_missed[] = $value["id_user_moodle"];
                            continue;
                        }
                        $courseUserId = CourseRegisteredUser::where("registered_user_id", $rUserId)
                                        ->where("course_id", $curso->id)
                                        ->first();
                        if(isset($courseUserId->id)){
                            $courseUserId = $courseUserId->id;   
                        }else{
                            $id_reg_user_missed[] = $rUserId;
                            continue;
                        }
                                  
                        $activityId = Activity::where("id_activity_moodle", $idActivityMoodle)
                                        ->where("section_id", "!=", 9)
                                        ->first();
                        if(isset($activityId->id)){
                            $activityId = $activityId->id;
                        }else{
                            continue;
                        }

                        $activityUser = ActivityCourseRegisteredUser::where("course_registered_user_id", $courseUserId)
                                        ->where("activity_id", $idActivityMoodle)
                                        ->first();
                        
                        if(isset($activityUser->id)){
                            $activityUser->status_moodle = $value["estado"];
                            $activityUser->qualification_moodle = $value["calificacion"];
                            $activityUser->save();
                        }else{
                            $activityUserNew = new ActivityCourseRegisteredUser();
                            $activityUserNew->activity_id = $activityId;
                            $activityUserNew->course_registered_user_id = $courseUserId;
                            $activityUserNew->status_moodle = $value["estado"];
                            $activityUserNew->qualification_moodle = isset($value["calificacion"]) ? $value["calificacion"] : "";
                            $activityUserNew->save();
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
            'status' => 'ok',
            'ids_moodle_missed' => array_unique($id_moodle_missed),
            'ids_registered_user_missed' => array_unique($id_reg_user_missed),
          ],
            201
        );   
    }

    public function buscarCalificacionesTareas ($idCurso, $IdActividadMoodle)
    {
        $Ejecucion = true;
        $actividadesUsers = array();
        $url = $this->base_url . "/mod/assign/view.php?id=$IdActividadMoodle&action=grading";
        $html = $this->runCurl($url);
        if (strpos ($html, 'class="errormessage"') !== false)
        {
            $Ejecucion = false;
            return array();
        }
        
        $pos = strpos ($html, "Nada que mostrar");
        if ($pos !== false)
        {
            return array();
        }

        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($html);
        $tables = $doc->getElementsByTagName("table");

        foreach ($tables as $table)
        {
            $classtable = $table -> getAttribute ("class");
            if (!($classtable == "flexible generaltable generalbox") !== false)
            {
                continue;
            }
            $trs = $table->getElementsByTagName("tr");
            foreach ($trs as $tr)
            {
                $aux = [];
                $classtr = $tr -> getAttribute("class");
                if ($classtr == "" || $classtr == "emptyrow")
                {
                    continue;
                }
                $IdUsr = 0;
                $arruser = explode(" ", $classtr);
                for ($i = 0; $i < count($arruser); $i++)
                {
                    if (strpos($arruser[$i], "user") !== false)
                        {
                            $IdUsr = substr($arruser[$i], 4);
                            $aux["id_user_moodle"] = $IdUsr;
                        }
                }
                
                $tds = $tr -> getElementsByTagName("td");
                $postd = 0;
                $Estado = "";
                foreach ($tds as $td)
                {
                    if ($postd == 5)
                    {
                        $Estado = "";
                        $divs = $td -> getElementsByTagName("div");
                        foreach ($divs as $div)
                        {
                            $classdiv = $div -> getAttribute("class");
                            if ($classdiv == "submissiongraded")
                                $Estado = $div -> nodeValue;
                            elseif ($classdiv == "submissionstatussubmitted")
                                $Estado = $div -> nodeValue;
                            elseif ($classdiv == "submissionstatus")
                                $Estado = $div -> nodeValue;
                            elseif ($classdiv == "submissionstatusnew")
                                $Estado = $div -> nodeValue;
                        }
                        $ultimo="";
                        $arrayCalif = array ("No entregado", "Borrador (no enviado)", "Sin entrega", "Enviado para calificar", "Calificado");
                        $arrayC = array();
                        for ($i = 0; $i < count($arrayCalif); $i++)
                        {
                            if (stripos ($arrayCalif[$i], $Estado) !== false)
                                {
                                    $ultimo = $arrayCalif[$i];
                                    $arrayC [] =  $arrayCalif[$i];
                                    $aux["estado"] = $ultimo;
                                }
                        }
                    }
                    if ($postd == 6)
                    {
                        $Califica = $td -> nodeValue;
                        if (strpos($Califica, "Calificación") !== false)
                            $Califica = substr ($Califica, strlen("Calificación"));
                        if (strpos ($Califica, "Calificación") !== false)
                            $Califica = substr ($Califica, strlen("Calificación"));
                        $aux["calificacion"] = $Califica;
                    }
                    $postd++;
                }
                $actividadesUsers[] = $aux;
            }
        }
        return $actividadesUsers;
    }


    public function buscarCalificacionesForos ($idCurso, $IdActividadMoodle)
    {
        $Ejecucion = false;
        $actividadesUsers = array();

        $curso = Course::find($idCurso);

        $posrol = 0;
        $Roles = array (4, 5);
        $NameRol = array("Tutor", "Estudiante");
        foreach ($Roles as $Rol)
        {
            $url = $this->base_url . "/report/participation/index.php?id=" . $curso->id_course_moodle . "&instanceid=". $IdActividadMoodle . "&roleid=$Rol&timefrom=0&perpage=1000&action=post";
            $html = $this->runCurl($url);
            
            $doc = new \DOMDocument();
            libxml_use_internal_errors(true);
            $doc->loadHTML($html);
            $tables = $doc -> getElementsByTagName("table");
            foreach ($tables as $table)
            {
                $classtable = $table -> getAttribute ("class");
                if ($classtable != "flexible generaltable generalbox reporttable")
                {
                    continue;
                }
                $trs = $table -> getElementsByTagName("tr");
                $rowtr = 0;
                foreach ($trs as $tr)
                {
                    $aux = [];
                    if($tr->getAttribute("class")=="emptyrow")
                    {
                        continue;
                    }
                    if(!$tr->childNodes->length > 1)
                    {
                        continue;
                    }
                    if ($rowtr == 0)
                    {
                        $rowtr++;
                        continue;
                    }
                    $tds = $tr -> getElementsByTagName("td");
                    $coltr = 0;
                    foreach ($tds as $td)
                    {
                        if ($td -> childNodes->length == null || $td -> childNodes->length == "" || $td -> childNodes->length == 0)
                        {
                            $coltr ++;
                            continue;
                        }

                        if ($coltr == 0)
                        {
                            $a = $td -> firstChild;
                            $userhref = $a -> getAttribute("href");
                            $parts1 = parse_url($userhref);
                            parse_str($parts1['query'], $query1);

                            $idUser = $query1['id'];
                            $aux["id_user_moodle"] = $idUser;
                        }

                        if ($coltr == 1 && isset($idUser))
                        {
                            $aux["estado"] = $td->nodeValue;
                        }
                        $coltr++;
                    }
                    
                    if ($idUser > 0)
                    {
                        $actividadesUsers[] = $aux;
                    }
                    $rowtr++;
                }
            }
            $posrol++;
        }
        $Ejecucion = true;
        return $actividadesUsers;
    }

    public function buscarCalificacionesCuestionarios ($idCurso, $IdActividadMoodle)
    {
        $Ejecucion = false;
        $actividadesUsers = array();

        $url = $this->base_url . "/mod/quiz/report.php?id=$IdActividadMoodle&mode=overview&pagesize=1000&stateabandoned=1&stateoverdue=1&stateinprogress=1&attempts=enrolled_any";
        $html = $this->runCurl($url);
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($html);
        $tables = $doc -> getElementsByTagName("table");
        foreach ($tables as $table)
        {
            $idtable = $table -> getAttribute("id");
            if ($idtable != "attempts")
            {                        
                continue;
            }
            $trs = $table -> getElementsByTagName("tr");
            $rowtr = 0;
            $idUser = "";
            foreach ($trs as $tr)
            {
                $aux = [];  
                if($tr->getAttribute("class")=="emptyrow")
                 {
                    continue;
                 }
                if(!$tr->childNodes->length > 1)
                {
                    continue;
                }

                if ($rowtr == 0)
                    {
                        $rowtr++;
                        continue;
                    }                
                $tds = $tr -> getElementsByTagName("td");
                $coltr = 0;
                foreach ($tds as $td)
                {     
                    if ($td -> childNodes->length == null || $td -> childNodes->length == "" || $td -> childNodes->length == 0)
                        {
                            $coltr ++;
                            continue;
                        }

                    if ($coltr == 1)
                    {
                        $as = $td -> getElementsByTagName("a");
                        foreach ($as as $a)
                        {
                            $userhref = $a -> getAttribute("href");
                            $parts1 = parse_url($userhref);
                            parse_str($parts1['query'], $query1);
                            $iduser =$query1['id'];
                            $aux["id_user_moodle"] = $iduser;
                        }
                    }
                    if ($coltr == 5)
                    {
                        $aux["estado"] = $td->nodeValue;
                    }
                    if ($coltr == 9){
                        $aux["calificacion"] = $td->nodeValue;
                    }
                    $coltr++;
                }

                if ($iduser > 0)
                {
                    if(isset($aux["id_user"]))
                    {
                        if(!isset($aux["calificacion"]))
                        {
                            $aux["calificacion"] = "";
                        }
                        $actividadesUsers[] = $aux;
                    }
                }
                $rowtr++;
            }
        }
        $Ejecucion = true;
        return $actividadesUsers;
    }

    /*public function buscarCalificacionesEncuestas ($IdActividad)
    {

    }*/

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
