<?
	if (is_array($HTTP_GET_VARS)) extract($HTTP_GET_VARS);
	if (is_array($HTTP_POST_VARS)) extract($HTTP_POST_VARS);
	if (is_array($HTTP_SERVER_VARS)) extract($HTTP_SERVER_VARS); 
	if (is_array($HTTP_COOKIE_VARS)) extract($HTTP_COOKIE_VARS); 
	if (is_array($HTTP_POST_FILES)) extract($HTTP_POST_FILES); 
	if (is_array($HTTP_ENV_VARS)) extract($HTTP_ENV_VARS); 




	if(empty($site)){
		
		$site = "domainshop.com";

	}

	if($site == "germanium.net")
	{

		$db_host = "db1480.perfora.net";
		$db_user = "dbo245585812";
		$db_passwd = "puchonA5678";
		$db_name = "db245585812";


		$dbConn = mysql_connect($db_host,$db_user,$db_passwd);
		mysql_select_db($db_name);

		//echo $dbConn;

	}
	else if($site == "germaniumusa.com")
	{

		$db_host = "db1524.perfora.net";
		$db_user = "dbo248135632";
		$db_passwd = "AWQa7wTe";
		$db_name = "db248135632";

		$dbConn = mysql_connect($db_host,$db_user,$db_passwd);
		mysql_select_db($db_name);
	}
	else if($site == "egermanium.com")
	{

		$db_host = "db1554.perfora.net";
		$db_user = "dbo251222853";
		$db_passwd = "puchonA5678";
		$db_name = "db251222853";

		$dbConn = mysql_connect($db_host,$db_user,$db_passwd);
		mysql_select_db($db_name);
	}
	else if($site == "magicdoctor.com")
	{

		$db_host = "localhost";
		$db_user = "root";
		$db_passwd = "puchonA12";
		$db_name = "germanium03";

		$dbConn = mysql_connect($db_host,$db_user,$db_passwd);
		mysql_select_db($db_name);
	}
	else if($site == "germaniumnara.com")
	{

		$db_host = "db1535.perfora.net";
		$db_user = "dbo248987115";
		$db_passwd = "QZnKDXWs";
		$db_name = "db248987115";

		$dbConn = mysql_connect($db_host,$db_user,$db_passwd);
		mysql_select_db($db_name);
	}
	else if($site == "domainshop.com")
	{

		$db_host = "localhost";
		$db_user = "root";
		$db_passwd = "puchonA12";
		$db_name = "domainshop_v2";

		$dbConn = mysql_connect($db_host,$db_user,$db_passwd);
		mysql_select_db($db_name);
	}
	else if($site == "capitalcard.com")
	{

		$db_host = "localhost";
		$db_user = "root";
		$db_passwd = "puchonA12";
		$db_name = "capitalcard";

		$dbConn = mysql_connect($db_host,$db_user,$db_passwd);
		mysql_select_db($db_name);
	}
	else if($site == "germaniumgermany.com")
	{

		$db_host = "db2181.perfora.net";
		$db_user = "dbo312420997";
		$db_passwd = "puchonA12";
		$db_name = "db312420997";

		$dbConn = mysql_connect($db_host,$db_user,$db_passwd);
		mysql_select_db($db_name);
	}
	else if($site == "germaniumlatin.com")
	{

		$db_host = "db2181.perfora.net";
		$db_user = "dbo312421559";
		$db_passwd = "puchonA12";
		$db_name = "db312421559";

		$dbConn = mysql_connect($db_host,$db_user,$db_passwd);
		mysql_select_db($db_name);
	}
	else if($site == "germaniumjapan.com")
	{

		$db_host = "db1929.perfora.net";
		$db_user = "dbo289878612";
		$db_passwd = "puchonA12";
		$db_name = "db289878612";

		$dbConn = mysql_connect($db_host,$db_user,$db_passwd);
		mysql_select_db($db_name);
	}
	else if($site == "germaniumchina.com")
	{
		$db_host = "db2243.perfora.net";
		$db_user = "dbo315264542";
		$db_passwd = "puchonA12";
		$db_name = "db315264542";

		$dbConn = mysql_connect($db_host,$db_user,$db_passwd);
		mysql_select_db($db_name);
	}
	else if($site == "germaniumtaiwan.com")
	{

		$db_host = "db2236.perfora.net";
		$db_user = "dbo315264554";
		$db_passwd = "puchonA12";
		$db_name = "db315264554";

		$dbConn = mysql_connect($db_host,$db_user,$db_passwd);
		mysql_select_db($db_name);
	}
	else if($site == "germaniumfrance.com")
	{

		$db_host = "db2385.perfora.net";
		$db_user = "dbo323615122";
		$db_passwd = "puchonA12";
		$db_name = "db323615122";

		$dbConn = mysql_connect($db_host,$db_user,$db_passwd);
		mysql_select_db($db_name);
	}

  // 날자 세팅
  if(!$year) $year=date("Y");
  if(!$month) $month=date("m");
  if(!$day) $day=date("d");

  // 사용자 IP 얻어옴
  $user_ip=$REMOTE_ADDR;
  $referer=$HTTP_REFERER;

  // 오늘의 날자 구함
  $today=mktime(0,0,0,$month,$day,$year);
  $yesterday=mktime(0,0,0,$month,$day,$year)-3600*24;

  // 이번달의 첫번째 날자 구함
  $month_start=mktime(0,0,0,$month,1,$year);

  // 이번달의 마지막 날자 구함
  $lastdate=01;
  while (checkdate($month,$lastdate,$year)): 
    $lastdate++;  
  endwhile;
  $lastdate=mktime(0,0,0,$month,$lastdate,$year);

  if(!$no)$no=1;
?>

<!-- 헤더부분과 날짜 입력 부분 -->
<html>
<head>
   <title>ZeroPHP</title>
   <meta http-equiv=Content-Type content=text/html; charset=EUC-KR>
   <link rel=StyleSheet HREF='./count/zerophp.css' type='text/css' title='ZZAGN CSS'>
 <script>
	function choose_state(str){
		
		if(str == 'germanium.net' || str == 'germaniumkr.com' || str == 'germaniumnara.com' || str == 'egermanium.com' || str == 'capitalfinance.com' || str == 'magicdoctor.com' || str == 'egermanium.com' || str == 'germaniumlatin.com' || str == 'germaniumjapan.com' || str == 'germaniumgermany.com' || str == 'germaniumchina.com' || str == 'germaniumtaiwan.com' || str == 'germaniumfrance.com')
		{
			location.replace('http://www.' + str + '/admin_status.php?site=' + str);
		}
		else
		{
			location.replace('http://www.domainshop.com/admin_status.php?site=' + str);
		}

	}
</script>
</head>
<body topmargin='0'  leftmargin='0' marginwidth='0' marginheight='0'>
<form method=post action=<? echo $PHP_SELF; ?>>
<input type=hidden name=no value=<? echo $no; ?>>
<table border=0 cellpading=0 cellspacing=0>
<tr>
	<td align=right height=35>이동 : 
	<select name=site onChange="choose_state(this.options[this.selectedIndex].value)">
		<option value="germanium.net" <? if($site == "germanium.net") echo "selected"; ?>>Germanium.net
		<option value="germaniumkr.com" <? if($site == "germaniumkr.com") echo "selected"; ?>>Germaniumkr.com
		<option value="magicdoctor.com" <? if($site == "magicdoctor.com") echo "selected"; ?>>Magicdoctor.com
		<option value="germaniumnara.com" <? if($site == "germaniumnara.com") echo "selected"; ?>>Germaniumnara.com
		<option value="domainshop.com" <? if($site == "domainshop.com") echo "selected"; ?>>Domainshop.com
		<option value="capitalcard.com" <? if($site == "capitalcard.com") echo "selected"; ?>>Capitalcard.com
		<option value="egermanium.com" <? if($site == "egermanium.com") echo "selected"; ?>>eGermanium.com
		<option value="germaniumlatin.com" <? if($site == "germaniumlatin.com") echo "selected"; ?>>germaniumlatin.com
		<option value="germaniumjapan.com" <? if($site == "germaniumjapan.com") echo "selected"; ?>>germaniumjapan.com
		<option value="germaniumgermany.com" <? if($site == "germaniumgermany.com") echo "selected"; ?>>germaniumgermany.com
		<option value="capitalfinance.com" <? if($site == "capitalfinance.com") echo "selected"; ?>>capitalfinance.com
		<option value="germaniumchina.com" <? if($site == "germaniumchina.com") echo "selected"; ?>>germaniumchina.com
		<option value="germaniumtaiwan.com" <? if($site == "germaniumtaiwan.com") echo "selected"; ?>>germaniumtaiwan.com
		<option value="germaniumfrance.com" <? if($site == "germaniumfrance.com") echo "selected"; ?>>germaniumfrance.com
	</select></td>
</tr>
<tr>
   <td align=right width=100% height=74 background=./count/image/title.gif valign=bottom>
<?
   for($i=1;$i<=6;$i++)
   {
    echo"<a href=$PHP_SELF?no=$i&year=$year&month=$month&day=$day&site=$site><img src=./count/image/button$i.gif border=0 align=absmiddle></a><font size=1>&nbsp;</font>";
   }
?>
   </td>
</tr>
<tr>
    <td align=center background=./count/image/date.gif width=417 height=31>
        Year : <input type=text name=year value=<? echo $year; ?> size=4 maxlength=4 style='background-color:eeeeee; border:1 solid black;height:16'> &nbsp;&nbsp;
        Month : <input type=text name=month value=<? echo $month; ?> size=2 maxlength=2 style='background-color:eeeeee; border:1 solid black;height:16'> &nbsp;&nbsp;
        Day : <input type=text name=day value=<? echo $day; ?> size=2 maxlength=2 style='background-color:eeeeee; border:1 solid black;height:16'> &nbsp;&nbsp;
        <input type=image src=./count/image/move.gif border=0 align=absmiddle></td>
</tr>
<tr>
<td background=./count/image/bar<? echo $no; ?>.gif height=20>&nbsp;</td> 
</tr>
<!-- --------------------------- -->

<?

//-------------------------- 카운터 수 구해옴 -----------------------------//
  // 전체
  $total=mysql_fetch_array(mysql_query("select unique_counter, pageview from counter_main where no=1", $dbConn));
  $count[total_hit]=$total[0];
  $count[total_view]=$total[1];

  // 오늘 카운터 읽어오는 부분
  $detail=mysql_fetch_Array(mysql_query("select unique_counter, pageview from counter_main where date='$today'", $dbConn));
  $count[today_hit]=$detail[0];
  $count[today_view]=$detail[1];

  // 어제 카운터 읽어오는 부분
  $detail=mysql_fetch_Array(mysql_query("select unique_counter, pageview from counter_main where date='$yesterday'", $dbConn));
  $count[yesterday_hit]=$detail[0];
  $count[yesterday_view]=$detail[1];

  // 최고 카운터 읽어오는 부분
  $detail=mysql_fetch_Array(mysql_query("select max(unique_counter), max(pageview) from counter_main where no>1", $dbConn));
  $count[max_hit]=$detail[0];
  $count[max_view]=$detail[1];

  // 최저 카운터 읽어오는 부분
  $detail=mysql_fetch_Array(mysql_query("select min(unique_counter), min(pageview) from counter_main where no>1 and date<$today", $dbConn));
  $count[min_hit]=$detail[0];
  $count[min_view]=$detail[1];


//-----------------------------------------------------------------------------
// 전체카운터 (1)
//-----------------------------------------------------------------------------
if($no=="1") 
{
  echo"
       <tr>
          <td height=40>
             &nbsp; <img src=./count/image/arrow.gif border=0 align=absmiddle> 전체 방문자수 : $count[total_hit] &nbsp;&nbsp;&nbsp;
             <br>&nbsp; <img src=./count/image/arrow.gif border=0 align=absmiddle> 전체 페이지뷰 : $count[total_view]
          </td>
       </tr>
       <tr> 
          <td height=40>
             &nbsp; <img src=./count/image/arrow.gif border=0 align=absmiddle> 오늘 방문자수 : $count[today_hit] &nbsp;&nbsp;&nbsp;
             <br>&nbsp; <img src=./count/image/arrow.gif border=0 align=absmiddle> 오늘 페이지뷰 : $count[today_view]
          </td>
       </tr>
       <tr>
          <td height=40>
             &nbsp; <img src=./count/image/arrow.gif border=0 align=absmiddle> 어제 방문자수 : $count[yesterday_hit] &nbsp;&nbsp;&nbsp;
             <br>&nbsp; <img src=./count/image/arrow.gif border=0 align=absmiddle> 어제 페이지뷰 : $count[yesterday_view]
          </td>
       </tr>
       <tr>
          <td height=40>
             &nbsp; <img src=./count/image/arrow.gif border=0 align=absmiddle> 최고 방문자수 : $count[max_hit] &nbsp;&nbsp;&nbsp;
             <br>&nbsp; <img src=./count/image/arrow.gif border=0 align=absmiddle> 최고 페이지뷰 : $count[max_view]
          </td>
       </tr>
       <tr>
          <td height=40>
             &nbsp; <img src=./count/image/arrow.gif border=0 align=absmiddle> 최저 방문자수 : $count[min_hit] &nbsp;&nbsp;&nbsp;
             <br>&nbsp; <img src=./count/image/arrow.gif border=0 align=absmiddle> 최저 페이지뷰 : $count[min_view]
          </td>
       </tr>";
}

//-----------------------------------------------------------------------------
// 오늘 시간대별 카운터 (2)
//-----------------------------------------------------------------------------
elseif($no=="2")
{
  echo"
       <tr>
           <td height=25>
               &nbsp; <img src=./count/image/arrow.gif border=0 align=absmiddle> $month 월 $day 일 방문자수 : $count[today_hit]
               <br>&nbsp;  <img src=./count/image/arrow.gif border=0 align=absmiddle>  $month 월 $day 일 페이지뷰 : $count[today_view]
           </td>
       </tr>
       <tr>
           <td height=30 align=center>

           <table width=380 border=0 cellpadding=1 cellspacing=0>";
  
  $max=1;
  for($i=0;$i<24;$i++)
  {
   $time1=mktime($i,0,0,$month,$day,$year);
   $time2=mktime($i,59,59,$month,$day,$year);
   $temp=mysql_fetch_array(mysql_query("select count(*) from counter_ip where date>='$time1' and date<='$time2'", $dbConn));
   $time_count[$i]=$temp[0];
   if($max<$time_count[$i]) $max=$time_count[$i];
  }
 
  for($i=0;$i<24;$i++)
  {
   $per1=(int)($time_count[$i]/$max*100);
   if($per1>100)$per1=99;
   echo"
         <tr>
            <td width=50>- $i 시 </td>
            <td align=left><img src=./count/image/bars1.gif border=0 width=$per1% height=10 alt='$i시 방문자수 : $time_count[$i]'></td>
            <td width=80>&nbsp; <font color=blue>Unique $time_count[$i] </td>
         </tr>";
  }

  echo"
         </table>
           </td>
        </tr>
        ";
}

//-----------------------------------------------------------------------------
// 주간별 카운터 (3)
//-----------------------------------------------------------------------------
elseif($no=="3")
{
 $start_day=$day;
 while(date('l',mktime(0,0,0,$month,$start_day,$year))!='Sunday')
 {
  $start_day--;
 }
 $last_day=$day;
 while(date('l',mktime(0,0,0,$month,$last_day,$year))!='Saturday')
 {
  $last_day++;
 }

 $start_time=mktime(0,0,0,$month,$start_day,$year);
 $last_time=mktime(23,59,59,$month,$last_day,$year);
 
 $detail=mysql_fetch_Array(mysql_query("select sum(unique_counter), sum(pageview) from counter_main where date>=$start_time and date<=$last_time", $dbConn));
 $count[week_hit]=$detail[0];
 $count[week_view]=$detail[1];

  echo"
       <tr>
           <td height=25>
               &nbsp; <img src=./count/image/arrow.gif border=0 align=absmiddle> $month 월 $start_day ~ $last_day 일 방문자수 : $count[week_hit]
               <br>&nbsp;  <img src=./count/image/arrow.gif border=0 align=absmiddle>  $month 월 $start_day ~ $last_day 일 페이지뷰 : $count[week_view]
           </td>
       </tr>
       <tr>
           <td height=30 align=center>

           <table width=380 border=0 cellpadding=1 cellspacing=0>";

  $max1=1;
  $max2=1;
  for($i=0;$i<7;$i++)
  {
   $time=mktime(0,0,0,$month,$start_day+$i,$year);
   $temp=mysql_fetch_array(mysql_query("select unique_counter, pageview from counter_main where date='$time'", $dbConn));
   $time_count1[$i]=$temp[0];
   if($max1<$time_count1[$i]) $max1=$time_count1[$i];
   $time_count2[$i]=$temp[1];
   if($max2<$time_count2[$i]) $max2=$time_count2[$i];
  }

  $week=array("일요일","월요일","화요일","수요일","목요일","금요일","토요일");
  for($i=0;$i<7;$i++)
  {
   $per1=(int)($time_count1[$i]/$max1*100+1);
   $per2=(int)($time_count2[$i]/$max2*100+1);
   if($per1>100)$per1=99;
   if($per2>100)$per2=99;
   echo"
         <tr>
            <td width=60>- $week[$i] </td>
            <td align=left><img src=./count/image/bars1.gif border=0 width=$per1% height=10 alt='$week[$i] 방문자수 : $time_count1[$i]'><br>
                           <img src=./count/image/bars2.gif border=0 width=$per2% height=10 alt='$week[$i] 페이지뷰 : $time_count2[$i]'> 
            </td>
            <td width=120>&nbsp; <font color=blue>Unique : $time_count1[$i]<br>&nbsp; <font color=Red>PageView : $time_count2[$i]</td>
         </tr>";
  }

  echo"
         </table>
           </td>
        </tr>
        ";
}

//-----------------------------------------------------------------------------
// 월간카운터 (4)
//-----------------------------------------------------------------------------
elseif($no=="4")  
{
  $total_month_counter=mysql_fetch_array(mysql_query("select sum(unique_counter), sum(pageview) from counter_main where date>='$month_start' and date<='$lastdate'", $dbConn));

  echo"
       <tr>
           <td height=25>
               &nbsp; <img src=./count/image/arrow.gif border=0 align=absmiddle> $month 월 방문자수 : $total_month_counter[0]
               <br>&nbsp;  <img src=./count/image/arrow.gif border=0 align=absmiddle>  $month 월 페이지뷰 : $total_month_counter[1]
           </td>
       </tr>
       <tr>
           <td height=30 align=center>
           
           <table width=380 border=0 cellpadding=1 cellspacing=0>
      ";

  // 이번달 카운터 (각각)
  $max=mysql_fetch_array(mysql_query("select max(unique_counter), max(pageview) from counter_main where date>='$month_start' and date<='$lastdate'",$dbConn));
  $month_counter=mysql_query("select date, unique_counter, pageview from counter_main where date>='$month_start' and date<='$lastdate'",$dbConn); 
  while($data=mysql_fetch_array($month_counter))
  {
   $per1=$data[unique_counter]/$max[0]*100;
   $per2=$data[pageview]/$max[1]*100;
   echo"
         <tr>
            <td width=50>- ".date("d 일",$data[date])." </td>
            <td width=220 align=left><img src=./count/image/bars1.gif border=0 width=$per1% height=10 alt='Unique : $data[unique_counter]'><br>
                <img src=./count/image/bars2.gif border=0 width=$per2% height=10 alt='PageView : $data[pageview]'></td>
            <td width=140>&nbsp; <font color=blue>Unique : $data[unique_counter]</font><br>&nbsp; <font color=red>PageView : $data[pageview]</td>
         </tr>";
  }

  echo"   
         </table>
           </td>
        </tr>
        ";
}

//-----------------------------------------------------------------------------
// 년간카운터 (5)
//-----------------------------------------------------------------------------
elseif($no=="5")
{
  $year_start=mktime(0,0,0,1,1,$year);
  $year_last=mktime(23,59,59,12,31,$year);
  $total_year_counter=mysql_fetch_array(mysql_query("select sum(unique_counter), sum(pageview) from counter_main where date>='$year_start' and date<='$year_last'", $dbConn));

  echo"
       <tr>
           <td height=25>
               &nbsp; <img src=./count/image/arrow.gif border=0 align=absmiddle> $year 년 방문자수 : $total_year_counter[0]
               <br>&nbsp;  <img src=./count/image/arrow.gif border=0 align=absmiddle> $year 년 페이지뷰 : $total_year_counter[1]
           </td>
       </tr>
       <tr>
           <td height=30 align=center>

           <table width=380 border=0 cellpadding=1 cellspacing=0>
      ";

  // 이번달 카운터 (각각)
$max1=1;
  $max2=1;
  for($i=0;$i<7;$i++)
  {
   $time=mktime(0,0,0,$month,$start_day+$i,$year);
   $temp=mysql_fetch_array(mysql_query("select unique_counter, pageview from counter_main where date='$time'", $dbConn));
   $time_count1[$i]=$temp[0];
   if($max1<$time_count1[$i]) $max1=$time_count1[$i];
   $time_count2[$i]=$temp[1];
   if($max2<$time_count2[$i]) $max2=$time_count2[$i];
  }


  $mmax=array("31","28","31","30","31","30","31","31","30","31","30","31");
  $max=1;
  $max2=1;
  for($i=0;$i<12;$i++)
  {
   $sdate=mktime(0,0,0,$i+1,1,$year);
   $edate=mktime(0,0,0,$i+1,$mmax[$i],$year);
   $year_counter=mysql_query("select sum(unique_counter), sum(pageview) from counter_main where date>='$sdate' and date<='$edate'",$dbConn);
   $temp=mysql_fetch_array($year_counter);
   $time_count1[$i]=$temp[0];
   if($max1<$time_count1[$i]) $max1=$time_count1[$i];
   $time_count2[$i]=$temp[1];
   if($max2<$time_count2[$i]) $max2=$time_count2[$i];
  }
  
  for($i=0;$i<12;$i++)
  {
   $per1=(int)($time_count1[$i]/$max1*100+1);
   $per2=(int)($time_count2[$i]/$max2*100+1);
   if($per1>100)$per1=99;
   if($per2>100)$per2=99;
   $j=$i+1;
   echo"
         <tr>
            <td width=60>- $j 월 </td>
            <td align=left><img src=./count/image/bars1.gif border=0 width=$per1% height=10 alt='$week[$i] 방문자수 : $time_count1[$i]'><br>
                           <img src=./count/image/bars2.gif border=0 width=$per2% height=10 alt='$week[$i] 페이지뷰 : $time_count2[$i]'>
            </td>
            <td width=120>&nbsp; <font color=blue>Unique : $time_count1[$i]<br>&nbsp; <font color=Red>PageView : $time_count2[$i]</td>
         </tr>"; 
  }

  echo"  
         </table>
           </td>
        </tr>
        ";
}

//-----------------------------------------------------------------------------
// 접속자 방문경로?(6)
//-----------------------------------------------------------------------------
elseif($no=="6")  
{
  echo "<tr><td>";
  $ip=mysql_query("select referer, hit from counter_referer where date='$today' order by hit desc", $dbConn);
  while($data=mysql_fetch_array($ip))
  {
   if(strlen($data[referer])>40) 
   {
    $temp=substr($data[referer],0,40);
    $text="$temp..."; 
   }
   else $text=$data[referer];
   if(!eregi("Typing or Bookmark", $data[referer])) $data[referer]="<a href=$data[referer] target=_blank>$text</a>";
   echo "&nbsp;&nbsp;&nbsp; - $data[referer] ($data[hit])<br>";
  }
  echo"</td></tr>";
}

//-----------------------------------------------------------------------------
//  하단부분
//-----------------------------------------------------------------------------
  echo"
        <tr>
            <td align=center height=30 bgcolor=#dddddd><a href=http://zerophp.com target=_blank><b>Created by ZeroPHP.com</b></a></td>
        </tr>
        </table></form>";

?>
