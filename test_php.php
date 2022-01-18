<?php
  error_reporting(0); //不顯示錯誤
  
  $link = mysqli_connect("localhost","root","","test");  //連線
  if(mysqli_connect_errno()) {echo '與資料庫連線失敗';exit;} //測試連線是否成功
  if(!mysqli_set_charset($link,"utf8")){echo '設定失敗';} //設定萬國碼
  
  if($_POST['username'])
  {
    $user = $_POST['username'];     //接收帳號
    $password = $_POST['password'];  //接收密碼
    
    $sql = "SELECT * FROM `users` WHERE `username` = '".$user."' AND 
            `password` = '".$password."'";
    $result = mysqli_query($link, $sql);       //收尋帳密

     if(mysqli_num_rows($result) == 1)
     { //帳密正確
       $sql = "SELECT * FROM `game_data`"; //SQL 抓出所有的資料
       $result = mysqli_query($link, $sql); //執行SQL
       $game_array = array();
       while($data=mysqli_fetch_array($result,MYSQLI_ASSOC)) 
       {
         $my_array = array('Date'=>$data['Date'],'Alliance'=>$data['Alliance']
         ,'Visitors'=>$data['Visitors'],'Home team'=>$data['Home team'],'First half'=>$data['First half'],'All_Game'=>$data['All_Game'],
         'Remarks'=>$data['Remarks'],'number'=>$data['number']);
         array_push($game_array,$my_array);
       }
     }else //帳密錯誤
     {
       $game_array[0]="帳密錯誤";
     }
     echo json_encode($game_array); //封成json回傳
  }
?>