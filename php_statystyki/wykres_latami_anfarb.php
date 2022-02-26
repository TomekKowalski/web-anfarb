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
                            <B><font class='opis_paneli'>KILOGRAMY AN-FARB ROK</font></B><br><br>
                            <!--
                            <FORM ACTION="wykres_latami_anfarb.php" METHOD=POST>
                                <INPUT TYPE="hidden" NAME="co" VALUE="opcja">

                                <div align=center>
                                    
                                    <TABLE class="pole_comboBox">
                                        <TR>
                                            <TD class='td_pole_comboBox_statystyki'>
                                                
                                            </TD>                                                
                                            <TD class='td_pole_spacja'></TD>
                                            <TD class='td_pole_przycisk'>
                                                <INPUT TYPE="submit" VALUE="Wybierz" CLASS="btn"> 
                                            </TD>
                                        </TR>
                                    </TABLE>
                                </div>
                            </FORM>
                            -->
                               <!-- ////////////////////koniec dol kontener wklesly ////////////////////// -->
                        </div>
            </td>
    </tr> 
</TABLE>
</DIV>

<div align=center>              
            <TABLE cellpadding = '0'  cellspacing = '0' border = '0' style='width: 98%; height: 100%;'>               
                <tr>
                    <td align="center">
                        <DIV align="center">
                            <div id="pole_wykres_lewy_panel"></div>
                            <div id="chart_div_lata"></div>
                            <div id="pole_checkbox">
                                <br><br><br><br><br><br>
                                <input id="zaznacz_wszystko" type="checkbox" name="checkbox" value="1"/> Zaznacz wszystko
                                <br><br>    
                                <?PHP
                                            
                                    for($i = 2016; $i<2023; $i++)
                                    {
                                        print'<input id="check'.$i.'" type="checkbox" NAME="'.$i.'" VALUE="'.$i.'"/>  '.$i.'';
                                        print'<br>';
                                    }
                                ?>
                                <!--<input id="check2014" type="checkbox" NAME="2014" VALUE="2014" checked=checked>  2014-->
                                       
                                
                            </div>
                       
                              
                                    <?PHP
                                    
                                    /*
                                        pobierz_dane_metry_rok("2013");
                                        pobierz_dane_metry_rok("2014");
                                        pobierz_dane_metry_rok("2015");
                                     * 
                                     */
                                        pobierz_dane_metry_rok("2016");
                                        pobierz_dane_metry_rok("2017");
                                        pobierz_dane_metry_rok("2018");
                                        pobierz_dane_metry_rok("2019");
                                        pobierz_dane_metry_rok("2020");                                                                      
                                        pobierz_dane_metry_rok("2021");
                                        pobierz_dane_metry_rok("2022");                                   
                                    ?>                           
                        </DIV>           
                    </td>
                </tr>
            </TABLE>
            
                          
 
<DIV class="dolny_do_tabeli" id="niedrukuj"></DIV>

<DIV id="info_temp"></DIV>

<script type="text/javascript">
  
        var checkZaznaczWszystko = document.getElementById("zaznacz_wszystko");
        var checkBoxs = [];
        var n = 2016;
        while(document.getElementById("check"+n+""))
        {
            checkBoxs.push(document.getElementById("check"+n+""));
            n++;
        } 
        ///////////klikniecie checkBox zaznacz wszystko //////////////////////
        checkZaznaczWszystko.onclick = function()
        {
            if(document.getElementById("zaznacz_wszystko").checked === true)
            {           
                for(var i=0; i<checkBoxs.length; i++)
                {
                    //document.getElementById(checkBoxs[i].id).checked = true;
                    checkBoxs[i].checked = true;
                }
            }
            if(document.getElementById("zaznacz_wszystko").checked === false)
            {
                for(var i=0; i<checkBoxs.length; i++)
                {
                    //document.getElementById(checkBoxs[i].id).checked = false;
                    checkBoxs[i].checked = false;
                }
            }
            rysuj_wykres();
        }; 
        checkBoxs[5].checked = true;
        checkBoxs[6].checked = true;
        
        /////////////klikniecie pojedynczego checkBox ////////////
        for(var i=0; i<checkBoxs.length; i++)
        {
            checkBoxs[i].onclick = function()
            {          
                rysuj_wykres();
            };
        }
        
        
    rysuj_wykres();
   
function rysuj_wykres()
{
    var info = document.getElementById("info_temp");
    
    
    //var tab_miesiac = ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"];
    var tab_miesiac = ["Sty.", "Lut", "Mar.", "Kwi.", "Maj", "Cze.", "Lip.", "Sie.", "Wrz.", "Paz.", "Lis.", "Gru."];
   
    //var tab_miesiac = [1,2,3,4,5,6,7,8,9,10,11,12];
    //var tab_kg_rok = document.getElementById("tab_kg_rok20210");
    //info.innerHTML = tab_metry_rok.innerHTML;
    
    //var tab_suma_kg2013 = [];
    //var tab_suma_kg2014 = [];
    //var tab_suma_kg2015 = [];
    var tab_suma_kg2016 = [];
    var tab_suma_kg2017 = [];
    var tab_suma_kg2018 = [];
    var tab_suma_kg2019 = [];
    var tab_suma_kg2020 = [];
    var tab_suma_kg2021 = [];
    var tab_suma_kg2022 = [];
    
    /*
    if(this.checkBoxs[0].checked === true)
    {
        var n = 0;   
        while(document.getElementById("tab_kg_rok2013"+n+""))
        {
            var wartosc_metry = document.getElementById("tab_kg_rok2013"+n+"");

            tab_suma_kg2013.push(parseInt(wartosc_metry.innerHTML));
            n++;
        }
    }
    if(this.checkBoxs[1].checked === true)
    {
        var n = 0;   
        while(document.getElementById("tab_kg_rok2014"+n+""))
        {
            var wartosc_metry = document.getElementById("tab_kg_rok2014"+n+"");

            tab_suma_kg2014.push(parseInt(wartosc_metry.innerHTML));
            n++;
        }
    }
    if(this.checkBoxs[2].checked === true)
    {
        var n = 0;   
        while(document.getElementById("tab_kg_rok2015"+n+""))
        {
            var wartosc_metry = document.getElementById("tab_kg_rok2015"+n+"");

            tab_suma_kg2015.push(parseInt(wartosc_metry.innerHTML));
            n++;
        }
    }
         * 
     */
    if(this.checkBoxs[0].checked === true)
    {
        var n = 0;   
        while(document.getElementById("tab_kg_rok2016"+n+""))
        {
            var wartosc_metry = document.getElementById("tab_kg_rok2016"+n+"");

            tab_suma_kg2016.push(parseInt(wartosc_metry.innerHTML));
            n++;
        }
    }
    if(this.checkBoxs[1].checked === true)
    {
        var n = 0;   
        while(document.getElementById("tab_kg_rok2017"+n+""))
        {
            var wartosc_metry = document.getElementById("tab_kg_rok2017"+n+"");

            tab_suma_kg2017.push(parseInt(wartosc_metry.innerHTML));
            n++;
        }
    }
    if(this.checkBoxs[2].checked === true)
    {
        var n = 0;   
        while(document.getElementById("tab_kg_rok2018"+n+""))
        {
            var wartosc_metry = document.getElementById("tab_kg_rok2018"+n+"");

            tab_suma_kg2018.push(parseInt(wartosc_metry.innerHTML));
            n++;
        }
    }
    if(this.checkBoxs[3].checked === true)
    {
        var n = 0;   
        while(document.getElementById("tab_kg_rok2019"+n+""))
        {
            var wartosc_metry = document.getElementById("tab_kg_rok2019"+n+"");

            tab_suma_kg2019.push(parseInt(wartosc_metry.innerHTML));
            n++;
        }
    }
    if(this.checkBoxs[4].checked === true)
    {
        var n = 0;   
        while(document.getElementById("tab_kg_rok2020"+n+""))
        {
            var wartosc_metry = document.getElementById("tab_kg_rok2020"+n+"");

            tab_suma_kg2020.push(parseInt(wartosc_metry.innerHTML));
            n++;
        }
    }
    if(this.checkBoxs[5].checked === true)
    {
        var n = 0;   
        while(document.getElementById("tab_kg_rok2021"+n+""))
        {
            var wartosc_metry = document.getElementById("tab_kg_rok2021"+n+"");

            tab_suma_kg2021.push(parseInt(wartosc_metry.innerHTML));
            n++;
        }
    }
    if(this.checkBoxs[6].checked === true)
    {
        var n = 0;   
        while(document.getElementById("tab_kg_rok2022"+n+""))
        {
            var wartosc_metry = document.getElementById("tab_kg_rok2022"+n+"");

            tab_suma_kg2022.push(parseInt(wartosc_metry.innerHTML));
            n++;
        }
    }
    
    google.charts.load('current', {packages: ['corechart', 'line']});
    google.charts.setOnLoadCallback(drawLineColors);
    
    function drawLineColors() {
            var data = new google.visualization.DataTable();
            //data.addColumn('number', 'X');
            data.addColumn('string', 'X');
            data.addColumn('number', '2016');
            data.addColumn('number', '2017');
            data.addColumn('number', '2018');
            data.addColumn('number', '2019');
            data.addColumn('number', '2020');
            data.addColumn('number', '2021');
            data.addColumn('number', '2022');
            //data.addColumn('number', 'WYDRUKOWANE');
       
            for(var i=0; i<12; i++)
            {
                data.addRows([[tab_miesiac[i], 
                        tab_suma_kg2016[i],
                        tab_suma_kg2017[i],
                        tab_suma_kg2018[i],
                        tab_suma_kg2019[i],
                        tab_suma_kg2020[i], 
                        tab_suma_kg2021[i], 
                        tab_suma_kg2022[i]]]);
            }
     	  
            var options = {
              hAxis: {
                title: 'Miesiące'
              },
              vAxis: {
                title: 'Ilość'
              },              
                colors: ['#0000FF','#000000', '#FF6600', '#FFFF00', '#097138', '#a52714', '#000066']
            };
            var chart = new google.visualization.LineChart(document.getElementById('chart_div_lata'));
            chart.draw(data, options);
     
        }
}
    
    //info.innerHTML = tab_suma_metry2021[0];
    
    
     // var chart = new google.visualization.ColumnChart(document.getElementById("chart_div_lata"));
     // chart.draw(data, options);
    
  </script>

</body>
</html>

<?PHP

function pobierz_dane_metry_rok($rok)
{
    //var_dump($wybrany_miesiac);
    //print"<br>";
    //var_dump($maszyna);
    //print"<br>";
    
    require_once '../class.Polocz.php';
    $polocz = new Polocz();
      
    $suma_metrow = 0;
   
    for($i=0; $i<12; $i++)
    {
        if ($i<9)
        {
                $szukaj_od = (string)$rok."-0".(string)($i + 1)."-01 00:00:00";
                $szukaj_do = (string)$rok."-0".(string)($i + 1)."-31 23:59:59";

        }
        if ($i >= 9)
        {
                $szukaj_od = (string)$rok."-".(string)($i + 1)."-01 00:00:00";
                $szukaj_do = (string)$rok."-".(string)($i + 1)."-31 23:59:59";

        }
        
        /*
        var_dump($szukaj_od);
        print"do ";
        var_dump($szukaj_do);
        print"<br>";
         * 
         */
        
        
        
        
        //$zapytanieSQL = "SELECT ID_Wzory_drukarnia_tab FROM DRUKARNIA_TAB WHERE DRUKARNIA_TAB.Data_produkcji >= '$szukaj_od' AND DRUKARNIA_TAB.Data_produkcji <= '$szukaj_do' AND (DRUKARNIA_TAB.Maszyna = '$maszyna_Renoir_1' OR DRUKARNIA_TAB.Maszyna = '$maszyna_Renoir_2' OR DRUKARNIA_TAB.Maszyna = '$maszyna_COLORS_4' OR DRUKARNIA_TAB.Maszyna = '$maszyna_COLORS_5' OR DRUKARNIA_TAB.Maszyna = '$maszyna_COLORS_6');";
        $zapytanieSQL = "SELECT SUM(Waga) AS Suma_kg FROM KARTA_TAB WHERE Data_przyjecia >= '$szukaj_od' AND Data_przyjecia <= '$szukaj_do';";
        
        
        $polocz->open(); 
        mysql_select_db("PRODUKCJA_FARBIARNIA") or die ("nie ma drukarnia baza");                                  
        $wynik_suma = mysql_query($zapytanieSQL) or die ("zle pytanie suma kilogramow");                                                                                              

        $polocz->close();

        while($rekord_suma = mysql_fetch_assoc($wynik_suma)){
            
            $suma = $rekord_suma['Suma_kg'];
            $suma_kilogramow = (int)$suma;
            
            /*
            $notes = $rekord_suma['ID_Wzory_drukarnia_tab'];
            $pozycja = strpos($notes, "razem");
            $notes = substr($notes, $pozycja+5, strlen($notes)-$pozycja);
            $pozycja = strpos($notes, "m");
            $notes = substr($notes, 0, $pozycja);
            $suma_metrow += (int)$notes;
             * 
             */
            //var_dump($pozycja); print" = "; var_dump($notes);
            //print"<br>";
        }  
        //var_dump($suma_kilogramow);
        //print"<br>";
        
        //print"<div id='tab_metry_miesiace".$i."' style='display: none;'>".$suma_metrow."</div>";
        print"<div id='tab_kg_rok".$rok."".$i."' style='display: none;'>".$suma_kilogramow."</div>";
                          
        $suma_kilogramow = 0;        
    }
    
    
}


?>
