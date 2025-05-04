<?php

//inicia la sesion
session_start();

//elimina todas las variables de la sesion
session_unset();

//destruye todo
session_destroy();

header("Location: ../views/usuario/agendarCita.php");
exit();