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
            return response()->json(['success' => false, 'error' => 'La url no retornó datos. URL: $url'], 500);
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
                                                // Guardamos su último acceso
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
            return response()->json(['success' => false, 'error' => 'La url no retornó datos. URL: $url'], 500);
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

    public function finalizacionActividad ($IdCurso, $start = 0, $vueltas = 50)
    {
        $this->loginMoodle();
        echo "<br>finalizacion Actividad MINEDUC ($start)".
        $url = $this->base_url . "report/progress/index.php?course=$IdCurso&perpage=1000&start=$start";
        echo "<br>";
        if ($start > $vueltas)
            {
                // Si ya va en la 3a vuelta sale
                return array ();
            }

        $html = $this->runCurl($url);
        // print_r($html);exit;
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($html);
        $tables = $doc->getElementsByTagName("table");
        print_r($tables);
        if ($tables == null)
            {
                return response()->json(['success' => false, 'error' => 'No hay tablas de matriculacion.'], 500);
                return;
            }

        $curso = Course::where("id_course_moodle", $IdCurso)->first();
        if(!isset($curso)){
            echo "<br>Curso no encontrado.";
            return;
        }

        //echo "<table>";
        $ClassActividades = array ();
        $ClassActividadesMatriculados = array ();
        $ClassMatriculadosCursos = array ();

        foreach ($tables as $table)
        {
            echo 'ENTRO';
            print_r($table);
            $firstTR = false;
            $idTable = $table -> getAttribute("id");
            $pos = strpos ($idTable, "completion-progress");
            if ($pos !== false)
                {
                    $trs = $table->getElementsByTagName("tr");
                    $contatr = 0;
                    
                    foreach ($trs as $tr)
                    {
                        $contatr++;
                        if (!$firstTR)
                            {
                                $firstTR = true;
                                // Estanos en el primer renglon, hay que buscar las actividades aqui
                                $ths = $tr -> getElementsByTagName("th");
                                $contath = 0;
                                foreach ($ths as $th)
                                {
                                    switch ($contath)
                                    {
                                        case 0:
                                            // Es la columna de nombre y apellido, IGNORAR
                                            // <th scope="col" class="completion-sortchoice">
                                            //  <a href="./?course=31&amp;sort=firstname&amp;silast=all&amp;sifirst=all">Nombre</a> / Apellido(s)
                                            //</th>
                                            break;
                                        case 1:
                                            // Columna RUT
                                            break;
                                        case 2:
                                            // Es la columna de correo, IGNORAR
                                            // <th scope="col" class="completion-identifyfield">Direcci�n de correo</th>
                                            break;
                                        default:
                                            // son las columnas de actividades, OBTENEER LA INFO
                                            //<th scope="col" class="">
                                            //  <a href="https://www.abiescra2019.cl/mod/lesson/view.php?id=2867" title="Introducci�n">
                                            //      <img src="https://www.abiescra2019.cl/theme/image.php/bootstrap/lesson/1556053835/icon" alt="Lecci�n" />
                                            //      <span class="completion-activityname">Introducci�n</span>
                                            //  </a>
                                            //</th>
                                            $TAGA = $th -> childNodes->item(0);
                                            //echo "<br> Nombre actividad: ".
                                            $NameAct = $TAGA -> getAttribute("title");
                                            //echo "<br> href actividad: ".
                                            $href = $TAGA -> getAttribute("href");

                                            $posId = strpos ($href, "php?id=");
                                            if ($posId !== false)
                                                $idact = substr ($href, $posId + strlen ("php?id="));
                                            else
                                                $idact = "";

                                            echo '<br>actividad: ';
                                            echo $idact;
                                            echo '<br>href: ';
                                            echo $href;
                                            echo '<br>NameAct: ';
                                            echo $NameAct;

                                            $aux["id_actividad"] = $idact;
                                            $aux["href"] = $href;
                                            $aux["name_actividad"] = $NameAct;

                                            // $Classactividad = new Classactividades($db);
                                            // $Classactividad -> setidmod ($idact);
                                            // $Classactividad -> sethref($href);
                                            // $Classactividad -> setClassCursos ($Classcursos);
                                            // $Classactividad -> setnombre (trim($NameAct));
                                            // $Classactividad -> setrevisar ("1");

                                            $ClassActividades[] = $aux;

                                            break;
                                    }
                                    $contath++;
                                }
                            }
                        else
                            {
                                // No es el primer renglon, vamos a buscar los registros de los usuarios
                                $contath = 0;

                                // $Classinscritos = new Classinscritos($db);
                                // $Classinscritos -> setClassCurso($Classcursos);

                                $idUser = "";
                                $rut = "";
                                $email = "";
                                $contath = 0;
                                $Contaact = 0;
                                foreach ($tr -> childNodes as $td)
                                {
                                    switch ($contath)
                                    {
                                        case 0:
                                            // nombre apellido
                                            //<a href="https://www.abiescra2019.cl/user/view.php?id=32&amp;course=31">Claudia Alejandra Alarc�n Lazo</a>
                                            //echo "<br>TAGA: ".
                                            $Nombre= $td -> childNodes->item(0)->nodeValue;
                                            //echo "<br> HREF Nombre: ".
                                            $href = $td -> childNodes->item(0)-> getAttribute ("href");
                                            //echo "<br>POS INI IDUSER: ".
                                            $posIdini = strpos ($href, "?id=");
                                            //echo "<br>POS FIN IDUSER: ".
                                            $posIdFin = strpos ($href, "&");
                                            //echo "<br>IdUser: ".
                                            $iduser = substr ($href, $posIdini + strlen ("?id="), $posIdFin - ($posIdini + strlen ("?id=")));

                                            $aux2["nombre"] = $Nombre;
                                            $aux2["href"] = $href;
                                            $aux2["iduser"] = $iduser;
                                            // $Classinscritos -> setnombre($Nombre);
                                            // $Classinscritos -> setiduser($iduser);
                                            // $Classinscritos -> setidperfil (5);
                                            // $Classinscritos -> setPerfil ("Estudiante");
                                            break;
                                        case 1:
                                            // RUT
                                            $RUT =  $td -> nodeValue;
                                            // $Classinscritos -> setrut($RUT);
                                            $aux2["rut"] = $RUT;
                                            break;
                                        case 2:
                                            // <td>claudia.alarcon@gmail.com</td>
                                            //echo "<br>Email: ".
                                            $Email = $td -> childNodes->item(0)->nodeValue;
                                            $aux2["Email"] = $Email;
                                            // $Classinscritos -> setemail($Email);
                                            break;
                                        default:
                                            $Classtd = trim($td -> getAttribute ("class"));
                                            if ($Classtd == "completion-progresscell")
                                                {
                                                    // <td class="completion-progresscell ">
                                                    //  <img src="https://www.abiescra2019.cl/theme/image.php/bootstrap/core/1556053835/i/completion-manual-n"
                                                    //      alt="No finalizado"
                                                    //      title="Claudia Alejandra Alarc�n Lazo, Introducci�n: No finalizado " />
                                                    // </td>
                                                    /** O BIEN */
                                                    //
                                                    //<td class="completion-progresscell ">
                                                    //  <img src="https://www.abiescra2019.cl/theme/image.php/bootstrap/core/1556053835/i/completion-auto-y"
                                                    //      alt="Finalizado"
                                                    //      title="Rosa Adriana Alvarado Thimeos, Actividad 2: �Cu�l es mi situaci�n inicial al comenzar el curso Abies 2.0?: Finalizado mi�rcoles, 13 de marzo de 2019, 20:54" />
                                                    //</td>
                                                    //echo "<br>Estado Original:".
                                                    $Estado = $td -> childNodes->item(0)-> getAttribute("alt");
                                                    //echo "<br>Estado Sin Nombre:".
                                                    $Estado = substr ($Estado, strlen ($Nombre)+2);
                                                    //echo "<br>Estado Sin Actividad:".
                                                    // $Estado = substr ($Estado, strlen ($ClassActividades[$Contaact] -> getnombre())+2);
                                                    /*
                                                    if ($strpos($Estado, "No finalizado") !== false)
                                                    {
                                                        // Es estado NO finalizado
                                                        $tiempoestado = "";
                                                    }
                                                    else
                                                    {
                                                        // Estado Finalizado
                                                        $tiempoestado = substr ($Estado, strlen("Finalizado"));
                                                        $Estado = "Finalizado";
                                                    }
                                                    */

                                                    // echo '<br>href: ';
                                                    // echo $href;
                                                    // echo '<br>$NameAct: ';
                                                    // echo $NameAct;

                                                    // $Classinscritoactividad = new Classinscritoactividad ($db);
                                                    // $Classinscritoactividad -> setClassActividad ($ClassActividades[$Contaact] );
                                                    // $Classinscritoactividad -> setClassinscrito($Classinscritos);
                                                    // $Classinscritoactividad -> setEstado("");
                                                    // $Classinscritoactividad -> setcalificacion ("");
                                                    // $Classinscritoactividad -> settimemodified ("");
                                                    // $Classinscritoactividad -> setultact ("");
                                                    // $Classinscritoactividad -> setfinalizado ($Estado);

                                                    $aux2["cont_act"] = $Contaact;
                                                    $aux2["estado"] = $Estado;

                                                    $ClassActividadesMatriculados [] = $aux2;
                                                }
                                            $Contaact++;
                                            break;
                                    }
                                $contath++;
                                }
                            }
                            $contatr++;
                    }
                }
        }
        $start += 25;
        $arrtmp = $this -> finalizacionActividad ($IdCurso, $start, $vueltas);

        echo 'IMPRIMO:';
        echo '<pre>';
        print_r($ClassActividadesMatriculados);
        echo '</pre>';
        // return array_merge($ClassActividadesMatriculados, $arrtmp);
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
