<?php
  require_once('functions.php');
  $dbd =db();

//======================Excel==============================

  if(isset($_POST["updateFacultyMain"])){
    $name = mysqli_real_escape_string($dbd,$_POST["name"]);
    $json = mysqli_real_escape_string($dbd,$_POST["json"]); 
    $nowdate = date("Y-m-d H:i:s");

    $q = "INSERT INTO `app_schedule` (name, schedule_main, update_main) VALUES 
      ('{$name}', '{$json}', '{$nowdate}') ON DUPLICATE KEY UPDATE 
      `schedule_main` = '{$json}', `update_main` = '{$nowdate}'";
    if (!mysqli_query($dbd, $q)){
      exit('Ошибка изменения '.mysqli_error($dbd));
    } else {
        exit('Расписание сохранено!');
    }
  }

  if(isset($_POST["updateFacultyRait"])){
    $name = mysqli_real_escape_string($dbd,$_POST["name"]);
    $json = mysqli_real_escape_string($dbd,$_POST["json"]); 
    $nowdate = date("Y-m-d H:i:s");

    $q = "INSERT INTO `app_schedule` (name, schedule_rait, update_rait) VALUES 
      ('{$name}', '{$json}', '{$nowdate}') ON DUPLICATE KEY UPDATE 
      `schedule_rait` = '{$json}', `update_rait` = '{$nowdate}'";
    if (!mysqli_query($dbd, $q)){
      exit('Ошибка изменения '.mysqli_error($dbd));
    } else {
        exit('Расписание сохранено!');
    }
  }

  if(isset($_POST["updateFacultyExam"])){
    $name = mysqli_real_escape_string($dbd,$_POST["name"]);
    $json = mysqli_real_escape_string($dbd,$_POST["json"]); 
    $nowdate = date("Y-m-d H:i:s");

    $q = "INSERT INTO `app_schedule` (name, schedule_exam, update_exam) VALUES 
      ('{$name}', '{$json}', '{$nowdate}') ON DUPLICATE KEY UPDATE 
      `schedule_exam` = '{$json}', `update_exam` = '{$nowdate}'";
    if (!mysqli_query($dbd, $q)){
      exit('Ошибка изменения '.mysqli_error($dbd));
    } else {
        exit('Расписание сохранено!');
    }
  }

  if(isset($_POST["updateTimetableNOSU"])){
    $json = mysqli_real_escape_string($dbd,$_POST["json"]); 
    $nowdate = date("Y-m-d H:i:s");

    $q = "UPDATE `app_schedule` SET `schedule_main` = '{$json}', `update_main` = '{$nowdate}' WHERE name = 'СОГУ'";
    if (!mysqli_query($dbd, $q)){
      exit('Ошибка изменения '.mysqli_error($dbd));
    } else {
        exit('График сохранен!');
    }
  }

//======================Login==============================

  if(isset($_POST["getFaculties"])){
    $q = "SELECT name FROM app_schedule";
    $res = mysqli_query($dbd, $q);
    $arr = array();
    while ($mass = mysqli_fetch_array($res)){
      if ($mass[0] <> "СОГУ") {
        array_push($arr, $mass[0]);
      }
    }
    if (!mysqli_query($dbd, $q)){
      exit('Ошибка изменения '.mysqli_error($dbd));
    } else {
        header('Access-Control-Allow-Origin: *');
        exit(json_encode($arr));
    }
  }

  if(isset($_POST["getScheduleMain"])){
    $name = mysqli_real_escape_string($dbd,$_POST["name"]);

    $arr = array();

    $q = "SELECT schedule_main, update_main FROM app_schedule WHERE name = '{$name}'";
    $res = mysqli_query($dbd, $q);
    $mass = mysqli_fetch_array($res);

    if (!mysqli_query($dbd, $q)){
      exit('Ошибка изменения '.mysqli_error($dbd));
    } else {
      array_push($arr, $mass["schedule_main"]);
      array_push($arr, $mass["update_main"]);
    }
    
    header('Access-Control-Allow-Origin: *');
    exit(json_encode($arr));
  }

//======================Main==============================

  if(isset($_POST["getSchedule"])){
    $name = mysqli_real_escape_string($dbd,$_POST["name"]);

    $arr = array();

    if(isset($_POST["updateMain"])){
      $q = "SELECT schedule_main, update_main FROM app_schedule WHERE name = '{$name}'";
      $res = mysqli_query($dbd, $q);
      $mass = mysqli_fetch_array($res);

      if (!mysqli_query($dbd, $q)){
        exit('Ошибка изменения '.mysqli_error($dbd));
      } else {
        $arr["scheduleMain"] = $mass["schedule_main"];
        $arr["updateMain"] = $mass["update_main"];
      }
    }

    if(isset($_POST["updateRait"])){
      $q = "SELECT schedule_rait, update_rait FROM app_schedule WHERE name = '{$name}'";
      $res = mysqli_query($dbd, $q);
      $mass = mysqli_fetch_array($res);

      if (!mysqli_query($dbd, $q)){
        exit('Ошибка изменения '.mysqli_error($dbd));
      } else {
        $arr["scheduleRait"] = $mass["schedule_rait"];
        $arr["updateRait"] = $mass["update_rait"];
      }
    }

    if(isset($_POST["updateExam"])){
      $q = "SELECT schedule_exam, update_exam FROM app_schedule WHERE name = '{$name}'";
      $res = mysqli_query($dbd, $q);
      $mass = mysqli_fetch_array($res);

      if (!mysqli_query($dbd, $q)){
        exit('Ошибка изменения '.mysqli_error($dbd));
      } else {
        $arr["scheduleExam"] = $mass["schedule_exam"];
        $arr["updateExam"] = $mass["update_exam"];
      }
    }

    if(isset($_POST["updateTimetable"])){
      $q = "SELECT schedule_main, update_main FROM app_schedule WHERE name = 'СОГУ'";
      $res = mysqli_query($dbd, $q);
      $mass = mysqli_fetch_array($res);

      if (!mysqli_query($dbd, $q)){
        exit('Ошибка изменения '.mysqli_error($dbd));
      } else {
        $arr["scheduleTimetable"] = $mass["schedule_main"];
        $arr["updateTimetable"] = $mass["update_main"];
      }
    }
    
    header('Access-Control-Allow-Origin: *');
    exit(json_encode($arr));
  }

  if(isset($_POST["getScheduleForTeacher"])){
    $arr = array();

    $arr["scheduleMain"] = "[";
    $q = "SELECT schedule_main FROM app_schedule WHERE name <> 'СОГУ'";
    $res = mysqli_query($dbd, $q);
    while ($mass = mysqli_fetch_array($res)){
      $arr["scheduleMain"].= $mass["schedule_main"].",";
    }
    $arr["scheduleMain"].="]";
    if (!mysqli_query($dbd, $q)){
      exit('Ошибка изменения '.mysqli_error($dbd));
    }

    $arr["scheduleRait"] = "[";
    $q = "SELECT schedule_rait FROM app_schedule WHERE name <> 'СОГУ'";
    $res = mysqli_query($dbd, $q);
    while ($mass = mysqli_fetch_array($res)){
      $arr["scheduleRait"].= $mass["schedule_rait"].",";
    }
    $arr["scheduleRait"].="]";
    if (!mysqli_query($dbd, $q)){
      exit('Ошибка изменения '.mysqli_error($dbd));
    } 

    $arr["scheduleExam"] = "[";
    $q = "SELECT schedule_exam FROM app_schedule WHERE name <> 'СОГУ'";
    $res = mysqli_query($dbd, $q);
    while ($mass = mysqli_fetch_array($res)){
      $arr["scheduleExam"].= $mass["schedule_exam"].",";
    }
    $arr["scheduleExam"].="]";
    if (!mysqli_query($dbd, $q)){
      exit('Ошибка изменения '.mysqli_error($dbd));
    } 

    $q = "SELECT schedule_main, update_main FROM app_schedule WHERE name = 'СОГУ'";
    $res = mysqli_query($dbd, $q);
    $mass = mysqli_fetch_array($res);
    if (!mysqli_query($dbd, $q)){
      exit('Ошибка изменения '.mysqli_error($dbd));
    } else {
      $arr["scheduleTimetable"] = $mass["schedule_main"];
      $arr["updateTimetable"] = $mass["update_main"];
    }
    
    $arr["updateSchedule"] = date("Y-m-d H:i:s");

    exit(json_encode($arr));
  }

  if(isset($_POST["updateScheduleForTeacher"])){
    $update_schedule = mysqli_real_escape_string($dbd, $_POST["update_schedule"]);
    $update_timetable = mysqli_real_escape_string($dbd, $_POST["update_timetable"]);

    $arr = array();

    $arr["scheduleMain"] = "[";
    $q = "SELECT schedule_main, update_main FROM app_schedule WHERE name <> 'СОГУ'";
    $res = mysqli_query($dbd, $q);
    while ($mass = mysqli_fetch_array($res)){
      if ($update_schedule < $mass['update_main']){
        $arr["scheduleMain"].= $mass["schedule_main"].",";
      }     
    }
    $arr["scheduleMain"].="]";
    if (!mysqli_query($dbd, $q)){
      exit('Ошибка изменения '.mysqli_error($dbd));
    }

    $arr["scheduleRait"] = "[";
    $q = "SELECT schedule_rait, update_rait FROM app_schedule WHERE name <> 'СОГУ'";
    $res = mysqli_query($dbd, $q);
    while ($mass = mysqli_fetch_array($res)){
      if ($update_schedule < $mass['update_rait']){
        $arr["scheduleRait"].= $mass["schedule_rait"].",";
      }
    }
    $arr["scheduleRait"].="]";
    if (!mysqli_query($dbd, $q)){
      exit('Ошибка изменения '.mysqli_error($dbd));
    } 

    $arr["scheduleExam"] = "[";
    $q = "SELECT schedule_exam, update_exam FROM app_schedule WHERE name <> 'СОГУ'";
    $res = mysqli_query($dbd, $q);
    while ($mass = mysqli_fetch_array($res)){
      if ($update_schedule < $mass['update_exam']){
        $arr["scheduleExam"].= $mass["schedule_exam"].",";
      } 
    }
    $arr["scheduleExam"].="]";
    if (!mysqli_query($dbd, $q)){
      exit('Ошибка изменения '.mysqli_error($dbd));
    } 

    $q = "SELECT schedule_main, update_main FROM app_schedule WHERE name = 'СОГУ'";
    $res = mysqli_query($dbd, $q);
    $mass = mysqli_fetch_array($res);
    if (!mysqli_query($dbd, $q)){
      exit('Ошибка изменения '.mysqli_error($dbd));
    } else {
      if ($update_timetable < $mass['update_main']){
        $arr["scheduleTimetable"] = $mass["schedule_main"];
        $arr["updateTimetable"] = $mass["update_main"];
      }
    }
    
    $arr["updateSchedule"] = date("Y-m-d H:i:s");

    exit(json_encode($arr));
  }

  if(isset($_POST["updateChecking"])){
    //если есть name - значит студент, иначе преподаватель
    if (isset($_POST["name"])) {
      $name = mysqli_real_escape_string($dbd, $_POST["name"]);
      $update_main = mysqli_real_escape_string($dbd, $_POST["update_main"]);
      $update_rait = mysqli_real_escape_string($dbd, $_POST["update_rait"]);
      $update_exam = mysqli_real_escape_string($dbd, $_POST["update_exam"]);
      $update_timetable = mysqli_real_escape_string($dbd, $_POST["update_timetable"]);

      $q = "SELECT update_main, update_rait, update_exam FROM app_schedule WHERE name = '{$name}'";
      $res = mysqli_query($dbd, $q);
      $mass = mysqli_fetch_array($res);
      if (!mysqli_query($dbd, $q)){
        exit('Ошибка изменения '.mysqli_error($dbd));
      } else {
          $q1 = "SELECT update_main FROM app_schedule WHERE name = 'СОГУ'";
          $res1 = mysqli_query($dbd, $q1);
          $mass1 = mysqli_fetch_array($res1);
          $resString = "";
          if ($update_main < $mass['update_main']) {
            $resString.="&updateMain=some";
          }
          if ($update_rait < $mass['update_rait']) {
            $resString.="&updateRait=some";
          }
          if ($update_exam < $mass['update_exam']) {
            $resString.="&updateExam=some";
          }
          if ($update_timetable < $mass1['update_main']) {
            $resString.="&updateTimetable=some";
          }
          if ($resString == ""){
            $resString = 'NO';
          }
          exit($resString);
      }
    }
    else{
      $update_schedule = mysqli_real_escape_string($dbd, $_POST["update_schedule"]);
      $update_timetable = mysqli_real_escape_string($dbd, $_POST["update_timetable"]);

      $q1 = "SELECT update_main FROM app_schedule WHERE name = 'СОГУ'";
      $res1 = mysqli_query($dbd, $q1);
      $mass1 = mysqli_fetch_array($res1);

      if ($update_timetable < $mass1['update_main']) {
        exit('YES');
      }

      $q = "SELECT update_main, update_rait, update_exam FROM app_schedule";
      $res = mysqli_query($dbd, $q);
      while ($mass = mysqli_fetch_array($res)){
        if ($update_schedule < $mass['update_main'] || 
            $update_schedule < $mass['update_rait'] ||
            $update_schedule < $mass['update_exam']) 
        {
            exit('YES');
        }
      }
      if (!mysqli_query($dbd, $q)){
        exit('Ошибка изменения '.mysqli_error($dbd));
      } else {
          exit('NO');
      }
    }
    
  }

//======================Desire of Teacher==============================

if(isset($_POST["updateDesire"])){
  $name = mysqli_real_escape_string($dbd,$_POST["name"]);
  $faculty = mysqli_real_escape_string($dbd,$_POST["faculty"]);
  $code = mysqli_real_escape_string($dbd,$_POST["code"]);
  $json = mysqli_real_escape_string($dbd,$_POST["json"]); 
  $nowdate = date("Y-m-d H:i:s");
  
  if ($code === "000000")
  {
     $q = "INSERT INTO `app_schedule_users` (name, faculty_id, desire, desire_date) VALUES 
  ('{$name}', (SELECT a.id FROM app_schedule a WHERE a.name = '{$faculty}') , '{$json}', '{$nowdate}')
  ON DUPLICATE KEY UPDATE desire='{$json}', desire_date = '{$nowdate}'";
    if (!mysqli_query($dbd, $q)){
      exit('Error occured '.mysqli_error($dbd));
    } else {
        exit('SAVED');
    }
  }
  else 
  {
    exit('NOT');
  }
}



  exit('Not good');
?>