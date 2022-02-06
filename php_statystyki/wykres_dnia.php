
<?php


	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}

	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl" xml:lang="pl">
<head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <meta http-equiv="Content-Type" content="text/html; charset="iso-8859-2" />
      <meta charset="ISO-8859-1">
      <script src = "../js/jquery-1.11.0.min.js"> </script>
      <script src = "../js/lightbox.min.js"> </script>
      <link href="../css/lightbox.css" rel="stylesheet"/>
      <link href="../css_wyglad_strony/style.css" rel="stylesheet" type="text/css"> 
      <link href="../css_wyglad_strony/mobile_style.css" rel="stylesheet" type="text/css">
      <link rel="Stylesheet" media="print" type="text/css" href="dodruku.css" />
      <title>Zamówienia drukarnia</title>
      
      <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
       <script src="//code.jquery.com/jquery-1.10.2.js"></script>
       <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
       <link rel="stylesheet" href="/resources/demos/style.css">
	   
	   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	   
    <script type="text/javascript">
	/*
		$dwa = 2;
		$trzy = 3;
      google.charts.load('current', {packages: ['corechart', 'line']});
	  google.charts.setOnLoadCallback(drawLineColors);
	  
	  function drawLineColors() {
      var data = new google.visualization.DataTable();
      data.addColumn('number', 'X');
      data.addColumn('number', 'SZTUKI DO DRUKU');
      //data.addColumn('number', 'Cats');

	  /*
      data.addRows([
        [0, 0, 0],    [1, 10, 5],   [2, 23, 15],  [3, 17, 9],   [4, 18, 10],  [5, 9, 5],
        [6, 11, 3],   [7, 27, 19],  [8, 33, 25],  [9, 40, 32],  [10, 32, 24], [11, 35, 27],
        [12, 30, 22], [13, 40, 32], [14, 42, 34], [15, 47, 39], [16, 44, 36], [17, 48, 40],
        [18, 52, 44], [19, 54, 46], [20, 42, 34], [21, 55, 47], [22, 56, 48], [23, 57, 49],
        [24, 60, 52], [25, 50, 42], [26, 52, 44], [27, 51, 43], [28, 49, 41], [29, 53, 45],
        [30, 55, 47], [31, 60, 52], [32, 61, 53], [33, 59, 51], [34, 62, 54], [35, 65, 57],
        [36, 62, 54], [37, 58, 50], [38, 55, 47], [39, 61, 53], [40, 64, 56], [41, 65, 57],
        [42, 63, 55], [43, 66, 58], [44, 67, 59], [45, 69, 61], [46, 69, 61], [47, 70, 62],
        [48, 72, 64], [49, 68, 60], [50, 66, 58], [51, 65, 57], [52, 67, 59], [53, 70, 62],
        [54, 71, 63], [55, 72, 64], [56, 73, 65], [57, 75, 67], [58, 70, 62], [59, 68, 60],
        [60, 64, 56], [61, 60, 52], [62, 65, 57], [63, 67, 59], [64, 68, 60], [65, 69, 61],
        [66, 70, 62], [67, 72, 64], [68, 75, 67], [69, 80, 72], [70, 3, 3]
      ]);
	  */
	  /*
	  data.addRows([[0, 0],[$dwa, $trzy]]);

      var options = {
        hAxis: {
          title: 'Data godzina'
        },
        vAxis: {
          title: 'Ilość'
        },
        //colors: ['#a52714', '#097138']
		colors: ['#097138']
      };
	  var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
	  

	  
	*/

      
    </script>
		
  <script>
  $(function() {
 	$( "#datepicker" ).datepicker();
 	$( "#datepicker2" ).datepicker();   
     });
  </script>
	 
	 
</head>

<body>


<DIV class='panel_glowny'>

<TABLE  cellpadding = '0'  cellspacing = '0' border = '0' style='width: 100%; height: 100%;'>
    <tr>
        <td align=center>
            <?php require_once "../zalogowany_banery.php";?>
        </td>
    </tr>
    <tr>
        <td align=center>
            <TABLE cellpadding = '0'  cellspacing = '0' border = '0' width=98% height=100%>
                <tr>
                    <td align=center>               
                        <DIV id="panel_filtr_ilosc_do_druku" class="mniejszy_panel">
                            <FORM ACTION="../index.php" METHOD=POST>
                                <INPUT TYPE="submit" VALUE="Strona startowa" CLASS="btn">
                            </FORM>                                  
                    
                            <!--////////////koniec przycisk i nazwa odbiorcy////////////////-->
                            <br>
                            <!--/////////////przycisk data wybierz/////////////////////////-->
                            <B><font class='opis_paneli'>WPISANE / WYDRUKOWANE</font></B><br><br>

                            <FORM ACTION="wykres_dnia.php" METHOD=POST>                               
                                <div align=center>
                                    <TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 style='width: 70%;'>
                                        <TR>
                                            <TD class='td_pole_daty'>
                                                <?php
                                                if($_POST['data_data'] == "")
                                                {
                                                   $data_miesiac_p=date("m");
                                                   $data_dzien_p=date("d");
                                                   $data_rok_p=date("Y");
                                                   $data = $data_rok_p."-".$data_miesiac_p."-".$data_dzien_p;                                
                                                }else{
                                                  $data = $_POST['data_data'];
                                                }
                                                print"<input class='text_box' type='date' name='data_data' value='".$data."'>";
                                                ?>

                                            </TD> 
                                            <TD class='td_pole_spacja'></TD>
                                            <TD class='td_pole_przycisk'>
                                                <INPUT TYPE="submit" VALUE="Wybierz" CLASS="btn">
                                            </TD>
                                        </TR>
                                    </TABLE>
                                </div>
                            </FORM>                              
                        </div>                     
                    </td>
                </tr>            
                <tr>
                    <td align=center>  
                           <!-- ///////////////////koniec przycisk data wybierz///////////////////-->
                        
                            <!--////dane do ilosci do druku///////////////////////-->
                        <?php
                        if($_POST['data_data'] == "")
                        {
                           $data_miesiac_p=date("m");
                           $data_dzien_p=date("d");
                           $data_rok_p=date("Y");
                           $data_wybrana = $data_rok_p."-".$data_miesiac_p."-".$data_dzien_p;
                        }else{
                          $data_wybrana = $_POST['data_data'];
                        }
                        require_once '../class.Polocz.php';
                        $polocz = new Polocz();
                        $polocz->open();
                        mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                        $polocz->close();
                        
                        $polocz->open();
                        $wynik = mysql_query("SELECT * FROM `SZTUKI_DO_DRUKU_TAB` WHERE `Data_wpisu` = '$data_wybrana';") or die ("zle pytanie_zakres");
                        $polocz->close();
                        for($l = 0; $l < 24; $l++)
                        {
                            $tab_godzina_wpisu[$l] = $l;
                            $tab_godzina[$l] = $l;
                            $tab_ilosc_do_druku[$l] = 0;
                        }
                        $i = 0;
                        $ilosc_partie_damaz = 0;
                        while($rekord = mysql_fetch_assoc($wynik))
                        {	
                            $tab_data_wpisu[$i] = $rekord['Data_wpisu'];
                            $tab_godzina_wpisu[$i] = $rekord['Godzina_wpisu'];
                            $tab_ilosc_do_druku[$i] = $rekord['Ilosc_sztuk'];  
                            $tab_godzina[$i] = substr($tab_godzina_wpisu[$i], 0, 2); 
                            
                            print"<div id='tab_ilosc_do_druku".$i."' style='display: none;'>".$tab_ilosc_do_druku[$i]."</div>";
                            print"<div id='tab_godzina".$i."' style='display: none;'>".$tab_godzina[$i]."</div>";
                        
                            $i++;
                        }
                        for($M = $i; $M < 24; $M++)
                        {
                            //$tab_ilosc_do_druku[$M] = $tab_ilosc_do_druku[$i-1];
                        } 
                            ////////////dane do ilosci wydrukowane/////////////////
                        $polocz->open();
                        $wynik_wydrukowane = mysql_query("SELECT * FROM `SZTUKI_WYDRUKOWANE_TAB` WHERE `Data_wpisu` = '$data_wybrana';") or die ("zle pytanie_zakres");
                        $polocz->close();
                        for($l = 0; $l < 24; $l++)
                        {
                            $tab_godzina_wpisu_wydrukowane[$l] = $l;
                            $tab_godzina_wydrukowane[$l] = $l;
                            $tab_ilosc_wydrukowane[$l] = 0;
                        }
                        $i = 0;
                        $ilosc_partie_damaz = 0;
                        while($rekord = mysql_fetch_assoc($wynik_wydrukowane))
                        {
                            $tab_data_wpisu_wydrukowane[$i] = $rekord['Data_wpisu'];
                            $tab_godzina_wpisu_wydrukowane[$i] = $rekord['Godzina_wpisu'];
                            $tab_ilosc_do_druku_wydrukowane[$i] = $rekord['Ilosc_sztuk']; 
                            $tab_godzina_wydrukowane[$i] = substr($tab_godzina_wpisu_wydrukowane[$i], 0, 2);	  
                            
                           //print"<div id='tab_ilosc_do_druku_wydrukowane".$i."'>".$tab_ilosc_do_druku_wydrukowane[$i]."</div><br>";
                            //print"<div id='tab_godzina_wydrukowane".$i."'>".$tab_godzina_wydrukowane[$i]."</div>";
                        
                            $i++;
                        } 
                        for($M = $i; $M < 24; $M++)
                        {
                            $tab_ilosc_do_druku_wydrukowane[$M] = $tab_ilosc_do_druku_wydrukowane[$i-1];
                        }
                            //////////////////tabela z wykresem ////////////////////////////////
                        ?>
                        <br><B><font size='5' color='blue'>Wykres: Ile sztuk do druku</font></B><br><br>                       
                        <div id="chart_div" style="width: 1000px; height: 500px"></div>
                        </br>
                        <br><B><font size='5' color='blue'>Wykres: Ile sztuk wydrukowane</font></B><br><br>
                        <div id="chart_div2" style="width: 1000px; height: 500px"></div>
                           <!-- ////////////////koniec tabeli z wykresem /////////////////////-->
                    </td>
                </tr>
                <tr>
                    <td align=center>
                        <TABLE cellpadding = '0'  cellspacing = '0' border = '0'>
                            <tr>
                                <td height='40'>
                                </td>
                            </tr>
                        </TABLE> 
                    </td>
                </tr>
                <tr>
                    <td align=center>
                        <TABLE>
                            <TR>
                                <TD>  
                                    <TABLE>
                                        <TR bgcolor = #6666ff><TD id='td_kolor' width=100px><B>DATA WPISU</B></TD><TD id='td_kolor' width=10px><B>GODZINA WPISU</B></TD><TD id='td_kolor' width=150px><B>ILOŚĆ     DO DRUKU</B></TD></TR>
                                        <?PHP
                                        $ilosc_tab = count($tab_data_wpisu); 
                                        for($j=0; $j<$ilosc_tab; $j++)
                                        {  
                                            $kolor = '#FFFFFF';
                                            print"<TR><TD id='td_kolor' bgcolor=$kolor>$tab_data_wpisu[$j]</TD><TD id='td_kolor' bgcolor=$kolor>$tab_godzina_wpisu[$j]</TD><TD id='td_kolor' bgcolor=$kolor align=center>$tab_ilosc_do_druku[$j]</TD></TR>";
                                        } 
                                        ?>
                                    </TABLE>      
                                </TD>
                                <TD width = 10>
                                </TD>
                                <TD>      
                                    <TABLE>
                                        <TR bgcolor = #6666ff><TD id='td_kolor' width=100px><B>DATA WPISU</B></TD><TD id='td_kolor' width=10px><B>GODZINA WPISU</B></TD><TD id='td_kolor' width=150px><B>ILOŚĆ WYDRUKOWANA</B></TD></TR>
                                        <?PHP
                                        $ilosc_tab = count($tab_data_wpisu_wydrukowane); 
                                        for($j=0; $j<$ilosc_tab; $j++)
                                        {  
                                            $kolor = '#FFFFFF';
                                            print"<TR><TD id='td_kolor' bgcolor=$kolor>$tab_data_wpisu_wydrukowane[$j]</TD><TD id='td_kolor' bgcolor=$kolor>$tab_godzina_wpisu_wydrukowane[$j]</TD><TD id='td_kolor' bgcolor=$kolor align=center>$tab_ilosc_do_druku_wydrukowane[$j]</TD></TR>";
                                        } 
                                        ?>
                                    </TABLE>      
                                </TD>
                            </TR>
                        </TABLE>
                    </td>
                </tr>  
            </TABLE>
        </td>
    </tr>
    <tr>
        <td align=center height=50px>
        </td>
    </tr>
</TABLE>

</DIV>
    
    <div id="info_temp"></div>




<script type="text/javascript">

        
        var tablica_godzina = [];
        var tablica_ilosc = [];
         
         ///////przepisanie tablicy php do javaScript//////////////
        var n = 0;
        while(document.getElementById("tab_godzina"+n+""))
        {
            tablica_godzina.push(document.getElementById("tab_godzina"+n+"").value);
            tablica_ilosc.push(document.getElementById("tab_ilosc_do_druku"+n+"").value);
            n++;
        }		
				
        google.charts.load('current', {packages: ['corechart', 'line']});
	google.charts.setOnLoadCallback(drawLineColors);
	  
        function drawLineColors() {
            var data = new google.visualization.DataTable();
            data.addColumn('number', 'X');
            data.addColumn('number', 'SZTUKI DO DRUKU');
            //data.addColumn('number', 'WYDRUKOWANE');
       
            for(var i=0; i<24; i++)
            {
                data.addRows([[tablica_godzina[i], tablica_ilosc[i]]]);
            }
     	  
            var options = {
              hAxis: {
                title: 'Godzina'
              },
              vAxis: {
                title: 'Ilość'
              },
              //colors: ['#a52714', '#097138']
                      colors: ['#097138']
            };
            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
            chart.draw(data, options);
     
        }

	  
	  
      
</script>

    
    
    
<script type="text/javascript">

        //var info_temp = document.getElementById("info_temp");
        var tablica_godzina = [];
        //var tablica_ilosc = [];
        var tablica_wydrukowane = [];
          
          ///////przepisanie tablicy php do javaScript//////////////
         /*
        var k = 0;
        while(document.getElementById("tab_godzina"+k+""))
        {
            tablica_godzina.push(document.getElementById("$tab_godzina"+k+"").value);
            tablica_wydrukowane.push(document.getElementById("tab_ilosc_do_druku_wydrukowane"+k+"").value);
            k++;
        }
      
         for(var i=0; i<tablica_godzina.length; i++)
         {
             info_temp.innerHTML += "wartosc = " + tablica_godzina[i] + "<br>";
         }
    */
    
    
         
	  
	  
			tablica_godzina[0] = <?echo $tab_godzina[0]?>;
			tablica_ilosc[0] = <?echo $tab_ilosc_do_druku[0]?>;
			tablica_godzina[1] = <?echo $tab_godzina[1]?>;
			tablica_ilosc[1] = <?echo $tab_ilosc_do_druku[1]?>;
			tablica_godzina[2] = <?echo $tab_godzina[2]?>;
			tablica_ilosc[2] = <?echo $tab_ilosc_do_druku[2]?>;
			tablica_godzina[3] = <?echo $tab_godzina[3]?>;
			tablica_ilosc[3] = <?echo $tab_ilosc_do_druku[3]?>;
			tablica_godzina[4] = <?echo $tab_godzina[4]?>;
			tablica_ilosc[4] = <?echo $tab_ilosc_do_druku[4]?>;
			tablica_godzina[5] = <?echo $tab_godzina[5]?>;
			tablica_ilosc[5] = <?echo $tab_ilosc_do_druku[5]?>;
			tablica_godzina[6] = <?echo $tab_godzina[6]?>;
			tablica_ilosc[6] = <?echo $tab_ilosc_do_druku[6]?>;
			tablica_godzina[7] = <?echo $tab_godzina[7]?>;
			tablica_ilosc[7] = <?echo $tab_ilosc_do_druku[7]?>;
			tablica_godzina[8] = <?echo $tab_godzina[8]?>;
			tablica_ilosc[8] = <?echo $tab_ilosc_do_druku[8]?>;
			tablica_godzina[9] = <?echo $tab_godzina[9]?>;
			tablica_ilosc[9] = <?echo $tab_ilosc_do_druku[9]?>;
			tablica_godzina[10] = <?echo $tab_godzina[10]?>;
			tablica_ilosc[10] = <?echo $tab_ilosc_do_druku[10]?>;
			tablica_godzina[11] = <?echo $tab_godzina[11]?>;
			tablica_ilosc[11] = <?echo $tab_ilosc_do_druku[11]?>;
			tablica_godzina[12] = <?echo $tab_godzina[12]?>;
			tablica_ilosc[12] = <?echo $tab_ilosc_do_druku[12]?>;
			tablica_godzina[13] = <?echo $tab_godzina[13]?>;
			tablica_ilosc[13] = <?echo $tab_ilosc_do_druku[13]?>;
			tablica_godzina[14] = <?echo $tab_godzina[14]?>;
			tablica_ilosc[14] = <?echo $tab_ilosc_do_druku[14]?>;
			tablica_godzina[15] = <?echo $tab_godzina[15]?>;
			tablica_ilosc[15] = <?echo $tab_ilosc_do_druku[15]?>;
			tablica_godzina[16] = <?echo $tab_godzina[16]?>;
			tablica_ilosc[16] = <?echo $tab_ilosc_do_druku[16]?>;
			tablica_godzina[17] = <?echo $tab_godzina[17]?>;
			tablica_ilosc[17] = <?echo $tab_ilosc_do_druku[17]?>;
			tablica_godzina[18] = <?echo $tab_godzina[18]?>;
			tablica_ilosc[18] = <?echo $tab_ilosc_do_druku[18]?>;
			tablica_godzina[19] = <?echo $tab_godzina[19]?>;
			tablica_ilosc[19] = <?echo $tab_ilosc_do_druku[19]?>;
			tablica_godzina[20] = <?echo $tab_godzina[20]?>;
			tablica_ilosc[20] = <?echo $tab_ilosc_do_druku[20]?>;
			tablica_godzina[21] = <?echo $tab_godzina[21]?>;
			tablica_ilosc[21] = <?echo $tab_ilosc_do_druku[21]?>;
			tablica_godzina[22] = <?echo $tab_godzina[22]?>;
			tablica_ilosc[22] = <?echo $tab_ilosc_do_druku[22]?>;
			tablica_godzina[23] = <?echo $tab_godzina[23]?>;
			tablica_ilosc[23] = <?echo $tab_ilosc_do_druku[23]?>;
                        
                        
                        tablica_wydrukowane[0] = <?echo $tab_ilosc_do_druku_wydrukowane[0]?>;
                        tablica_wydrukowane[1] = <?echo $tab_ilosc_do_druku_wydrukowane[1]?>;
                        tablica_wydrukowane[2] = <?echo $tab_ilosc_do_druku_wydrukowane[2]?>;
                        tablica_wydrukowane[3] = <?echo $tab_ilosc_do_druku_wydrukowane[3]?>;
                        tablica_wydrukowane[4] = <?echo $tab_ilosc_do_druku_wydrukowane[4]?>;
                        tablica_wydrukowane[5] = <?echo $tab_ilosc_do_druku_wydrukowane[5]?>;
                        tablica_wydrukowane[6] = <?echo $tab_ilosc_do_druku_wydrukowane[6]?>;
                        tablica_wydrukowane[7] = <?echo $tab_ilosc_do_druku_wydrukowane[7]?>;
                        tablica_wydrukowane[8] = <?echo $tab_ilosc_do_druku_wydrukowane[8]?>;
                        tablica_wydrukowane[9] = <?echo $tab_ilosc_do_druku_wydrukowane[9]?>;
                        tablica_wydrukowane[10] = <?echo $tab_ilosc_do_druku_wydrukowane[10]?>;
                        tablica_wydrukowane[11] = <?echo $tab_ilosc_do_druku_wydrukowane[11]?>;
                        tablica_wydrukowane[12] = <?echo $tab_ilosc_do_druku_wydrukowane[12]?>;
                        tablica_wydrukowane[13] = <?echo $tab_ilosc_do_druku_wydrukowane[13]?>;
                        tablica_wydrukowane[14] = <?echo $tab_ilosc_do_druku_wydrukowane[14]?>;
                        tablica_wydrukowane[15] = <?echo $tab_ilosc_do_druku_wydrukowane[15]?>;
                        tablica_wydrukowane[16] = <?echo $tab_ilosc_do_druku_wydrukowane[16]?>;
                        tablica_wydrukowane[17] = <?echo $tab_ilosc_do_druku_wydrukowane[17]?>;
                        tablica_wydrukowane[18] = <?echo $tab_ilosc_do_druku_wydrukowane[18]?>;
                        tablica_wydrukowane[19] = <?echo $tab_ilosc_do_druku_wydrukowane[19]?>;
                        tablica_wydrukowane[20] = <?echo $tab_ilosc_do_druku_wydrukowane[20]?>;
                        tablica_wydrukowane[21] = <?echo $tab_ilosc_do_druku_wydrukowane[21]?>;
                        tablica_wydrukowane[22] = <?echo $tab_ilosc_do_druku_wydrukowane[22]?>;
                        tablica_wydrukowane[23] = <?echo $tab_ilosc_do_druku_wydrukowane[23]?>;
                        
		
		
		
		
		
		
		
		
		
		
		//dwa = 2;
		//trzy = 3;
        google.charts.load('current', {packages: ['corechart', 'line']});
        google.charts.setOnLoadCallback(drawLineColors);
	  
	function drawLineColors(){
            var data = new google.visualization.DataTable();
            data.addColumn('number', 'X');
            //data.addColumn('number', 'SZTUKI DO DRUKU');
            data.addColumn('number', 'WYDRUKOWANE');

	
          
            for(var i=0; i<24; i++)
            {
                data.addRows([[tablica_godzina[i], tablica_wydrukowane[i]]]);
            }          

            var options = {
              hAxis: {
                title: 'Godzina'
              },
              vAxis: {
                title: 'Ilość'
              },
              //colors: ['#a52714', '#097138']
                      colors: ['#a52714']
            };
            var chart = new google.visualization.LineChart(document.getElementById('chart_div2'));
            chart.draw(data, options);
           
        }

	  
	  
      
</script>



</body>
</html>
