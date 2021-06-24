<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mensaje SIGAF</title>
</head>
<style>
  * {
    padding: 0;
    margin: 0;
  }

  .container {
    display: flex;
    justify-content: center;
  }
</style>

<body>
  <div>
    Estimado(a) {{ $data['fullname'] }}
    {!! $data['body'] !!}
  </div style="margin-top: 20px;">
  Saludos cordiales,
  <div>
  </div>
  <footer style="margin-top: 20px;">
    <div style="text-align: center;">
      Coordinación Curso b-Learning
    </div>
    <div style="text-align: center;">
      {{ $data['course'] }}
    </div>
    <div style="text-align: center;">
      Instituto de Informática Educativa - Universidad de La Frontera
    </div>
    <div style="text-align: center;">
      <strong>Correo electrónico:</strong> {{ $data['emailCourse'] }}
    </div>
    <div style="text-align: center;">
      <strong>Fono contacto:</strong> 45 2781958
    </div>
      <div style="text-align: center;">
          <img src="<?php echo asset('/storage/wspcursos.png')?>"/>
      </div>
      <div style="text-align: center;">
          <img src="{{public_path('/storage/wspcursos.png')}}"/>
      </div>
      <div style="text-align: center;">
          <img src="{{asset('/storage/wspcursos.png')}}"/>
      </div>
      <div style="text-align: center;">
          <img src="http://sigaf.iie.cl/backend-sigaf/public/storage/wspcursos.png"/>
      </div>
  </footer>
</body>

</html>
