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
        <script src="../js_web/script_miniatura_zdjecia.js" async></script>
        <link href="../css/lightbox.css" rel="stylesheet"/>     
	<link rel="Stylesheet" media="print" type="text/css" href="dodruku.css" />
        <link href="../css_wyglad_strony/style.css" rel="stylesheet" type="text/css">
        <link href="../css_wyglad_strony/mobile_style.css" rel="stylesheet" type="text/css">
        <title>Zamówienia drukarnia</title>
      
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	   
         <link rel="stylesheet" href="/resources/demos/style.css">
             	
</head>

<body>
    
<DIV class="do_tabeli" id="niedrukuj">

<TABLE  cellpadding = '0'  cellspacing = '0' border = '0' style='width: 100%; height: 100%;'> 
    <tr>
        <td align=center>
            <?PHP require_once "../zalogowany_banery.php"; ?>
        </td>
    </tr>
        <tr>
            <td align=center>
                <!--<DIV class="mniejszy_panel">-->
                <DIV id="panel_filtrowanie" class="wiekszy_panel">
                    
                            <FORM ACTION="../index.php" METHOD=POST>
                                <INPUT TYPE="submit" VALUE="Strona startowa" CLASS="btn">
                            </FORM>                                  
                    
                             <!--////////////koniec przycisk i nazwa odbiorcy////////////////-->
                            <br>
                            <!--/////////////przycisk data wybierz/////////////////////////-->
                            <B><font class='opis_paneli'>METRY MIESIĄCE</font></B><br><br>

                            <FORM ACTION="wykres_miesiace.php" METHOD=POST>
                                <INPUT TYPE="hidden" NAME="co" VALUE="opcja">

                                <div align=center>
                                    <!--<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 style='width: 35%;'>-->
                                    <TABLE class="pole_comboBox">
                                        <TR>
                                            <TD class='td_pole_comboBox_statystyki'>
                                                <?PHP
                                                    combobox_maszyny($_POST['maszyna']);
                                                ?>
                                            </TD>   
                                            <TD class='td_pole_spacja'></TD>
                                            <TD class='td_pole_comboBox_statystyki'>
                                                <?PHP
                                                    combobox_miesiace($_POST['miesiac']);
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
                               <!-- ////////////////////koniec dol kontener wklesly ////////////////////// -->
                        </div>
            </td>
    </tr> 
</TABLE>
</DIV>

<div align=center>   
            <?PHP 
                $miesiac = $_POST['miesiac'];               
                if($miesiac == "")
                {
                    print"<br/><B><font size=3 color=#00004d>Styczeń</font></B><br/><br>"; 
                }else{
                    print"<br/><B><font size=3 color=#00004d>$miesiac</font></B><br/><br>"; 
                }
            ?>
             
            
            <TABLE cellpadding = '0'  cellspacing = '0' border = '0' style='width: 98%; height: 100%;'>               
                <tr>
                    <td align="center">
                        <DIV align="center">
                            <div id="chart_div_miesiace" style="width: 80%; height: 530px"></div>
                       
                              
                                    <?PHP
                                        pobierz_dane_metry_miesiace($miesiac, $_POST['maszyna']);                                   
                                    ?>                           
                        </DIV>           
                    </td>
                </tr>
            </TABLE>
            
                          
 
<DIV class="dolny_do_tabeli" id="niedrukuj"></DIV>

<DIV id="info_temp"></DIV>

<script type="text/javascript">
    
    var info = document.getElementById("info_temp");
    var tab_lata = [2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022];
    //var tab_suma_metry = [1,2,3,4,5,6,7,8,9,10];
    var tab_suma_metry = [];
    var n = 0;
    
    
    while(document.getElementById("tab_metry_miesiace"+n+""))
    {
        wartosc_metry = document.getElementById("tab_metry_miesiace"+n+"");
        
        tab_suma_metry.push(parseInt(wartosc_metry.innerHTML));
        
        n++;
    }
    
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        
      var kolor = "gold";
      var data = google.visualization.arrayToDataTable([
        ["Element", "Metry", { role: "style" } ],       
        ["2013", tab_suma_metry[0], kolor],
        ["2014", tab_suma_metry[1], kolor],
        ["2015", tab_suma_metry[2], kolor],
        ["2016", tab_suma_metry[3], kolor],
        ["2017", tab_suma_metry[4], kolor],
        ["2018", tab_suma_metry[5], kolor],
        ["2019", tab_suma_metry[6], kolor],
        ["2020", tab_suma_metry[7], kolor],
        ["2021", tab_suma_metry[8], kolor],
        ["2022", tab_suma_metry[9], kolor]
        
        
        
      ]);
      
      
        
      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Metry wydrukowane rok / miesiąc",
        //width: 1200,
        //height: 400,
        bar: {groupWidth: "80%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("chart_div_miesiace"));
      chart.draw(view, options);
    }
  </script>

</body>
</html>

<?PHP

function combobox_miesiace($wybrany_miesiac)
{
    $tab_miesiac = array("Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień");
    
    print'<SELECT class="opis_select" NAME="miesiac" style="width: 100%;">';
    
        for( $i=0; $i< 12; $i++)
        {
            print"<OPTION VALUE=".$tab_miesiac[$i].">".$tab_miesiac[$i]."</OPTION>";
        }
        if($wybrany_miesiac != "")
        {
            print"<OPTION SELECTED VALUE=".$wybrany_miesiac.">".$wybrany_miesiac."</OPTION>";
			
        }    
    print'</SELECT>';   
}
function combobox_maszyny($wybrana_maszyna)
{
    $tab_maszyna = array("razem_(Reactive)");
    
    print'<SELECT class="opis_select" NAME="maszyna" style="width: 100%;">';
    
        for( $i=0; $i< 1; $i++)
        {
            print"<OPTION VALUE=".$tab_maszyna[$i].">".$tab_maszyna[$i]."</OPTION>";
        }
        if($wybrana_maszyna != "")
        {
            print"<OPTION SELECTED VALUE=".$wybrana_maszyna.">".$wybrana_maszyna."</OPTION>";
			
        }    
    print'</SELECT>';   
}
function pobierz_dane_metry_miesiace($wybrany_miesiac, $maszyna)
{
    //var_dump($wybrany_miesiac);
    //print"<br>";
    //var_dump($maszyna);
    //print"<br>";
    
    require_once '../class.Polocz.php';
    $polocz = new Polocz();
    
    $maszyna_Renoir_1 = "Renoir 1 (Reactive)";
    $maszyna_Renoir_2 = "Renoir 2 (Reactive)";
    $maszyna_COLORS_4 = "COLORS-4 (Reactive)";
    $maszyna_COLORS_5 = "COLORS-5 (Reactive)";
    $maszyna_COLORS_6 = "COLORS-6 (Reactive)";

    if($wybrany_miesiac == "")
    {
        $wybrany_miesiac = "Styczeń";
    }
    if($maszyna == "")
    {
        $maszyna = "razem_(Reactive)";
    }
    $rok = 2013;
    for($i=0; $i<10; $i++)
    {
        if($wybrany_miesiac == "Styczeń")
        {
            $szukaj_od =  (string)($rok + $i)."0101";
            $szukaj_do =  (string)($rok + $i)."0131";
        }
        if($wybrany_miesiac == "Luty")
        {
            $szukaj_od =  (string)($rok + $i)."0201";
            $szukaj_do =  (string)($rok + $i)."0231";
        }
        if($wybrany_miesiac == "Marzec")
        {
            $szukaj_od =  (string)($rok + $i)."0301";
            $szukaj_do =  (string)($rok + $i)."0331";
        }
        if($wybrany_miesiac == "Kwiecień")
        {
            $szukaj_od =  (string)($rok + $i)."0401";
            $szukaj_do =  (string)($rok + $i)."0431";
        }
        if($wybrany_miesiac == "Maj")
        {
            $szukaj_od =  (string)($rok + $i)."0501";
            $szukaj_do =  (string)($rok + $i)."0531";
        }
        if($wybrany_miesiac == "Czerwiec")
        {
            $szukaj_od =  (string)($rok + $i)."0601";
            $szukaj_do =  (string)($rok + $i)."0631";
        }
        if($wybrany_miesiac == "Lipiec")
        {
            $szukaj_od =  (string)($rok + $i)."0701";
            $szukaj_do =  (string)($rok + $i)."0731";
        }
        if($wybrany_miesiac == "Sierpień")
        {
            $szukaj_od =  (string)($rok + $i)."0801";
            $szukaj_do =  (string)($rok + $i)."0831";
        }
        if($wybrany_miesiac == "Wrzesień")
        {
            $szukaj_od =  (string)($rok + $i)."0901";
            $szukaj_do =  (string)($rok + $i)."0931";
        }
        if($wybrany_miesiac == "Październik")
        {
            $szukaj_od =  (string)($rok + $i)."1001";
            $szukaj_do =  (string)($rok + $i)."1031";
        }
        if($wybrany_miesiac == "Listopad")
        {
            $szukaj_od =  (string)($rok + $i)."1101";
            $szukaj_do =  (string)($rok + $i)."1131";
        }
        if($wybrany_miesiac == "Grudzień")
        {
            $szukaj_od =  (string)($rok + $i)."1201";
            $szukaj_do =  (string)($rok + $i)."1231";
        }
        //var_dump($szukaj_od);
        //print"do ";
        //var_dump($szukaj_do);
        //print"<br>";
        
        if($maszyna == "razem_(Reactive)")
        {
            $zapytanieSQL = "SELECT ID_Wzory_drukarnia_tab FROM DRUKARNIA_TAB WHERE DRUKARNIA_TAB.Data_produkcji >= '$szukaj_od' AND DRUKARNIA_TAB.Data_produkcji <= '$szukaj_do' AND (DRUKARNIA_TAB.Maszyna = '$maszyna_Renoir_1' OR DRUKARNIA_TAB.Maszyna = '$maszyna_Renoir_2' OR DRUKARNIA_TAB.Maszyna = '$maszyna_COLORS_4' OR DRUKARNIA_TAB.Maszyna = '$maszyna_COLORS_5' OR DRUKARNIA_TAB.Maszyna = '$maszyna_COLORS_6');";
        }
        
        $polocz->open(); 
        mysql_select_db("DRUKARNIA_BAZA") or die ("nie ma drukarnia baza");                                  
        $wynik_suma = mysql_query($zapytanieSQL) or die ("zle pytanie suma metrow");                                                                                              

        $polocz->close();

        while($rekord_suma = mysql_fetch_assoc($wynik_suma)){
            $notes = $rekord_suma['ID_Wzory_drukarnia_tab'];
            $pozycja = strpos($notes, "razem");
            $notes = substr($notes, $pozycja+5, strlen($notes)-$pozycja);
            $pozycja = strpos($notes, "m");
            $notes = substr($notes, 0, $pozycja);
            $suma_metrow += (int)$notes;
            //var_dump($pozycja); print" = "; var_dump($notes);
            //print"<br>";
        }  
        //var_dump($suma_metrow);
        //print"<br>";
        
        print"<div id='tab_metry_miesiace".$i."' style='display: none;'>".$suma_metrow."</div>";
                           
        $suma_metrow = 0;
    }
    
    
}


?>
