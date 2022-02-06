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
                                    <TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 style='width: 35%;'>
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
                        <DIV class="centrowanie">
                            <!--
                            <TABLE style="width: 80%">
                                <TR bgcolor = #6666ff><TD id='td_kolor' class='regaly_td_font' style='width: 5%;'><B>Lp.</B></TD><TD id='td_kolor' class='regaly_td_font' style='width: 60%;'><B>KLIENT</B></TD><TD id='td_kolor' class='regaly_td_font' style='width: 20%;'><B>METRY</B></TD><TD id='td_kolor' class='regaly_td_font' style='width: 15%;'><B> % </B></TD></TR>
                                -->   
                                    <?PHP
                                        pobierz_dane_metry_miesiace($miesiac, $_POST['maszyna']);
                                    /*
                                        require_once '../class.Polocz.php';
                                        $polocz = new Polocz();
                                        
                                        $polocz->open(); 
                                        mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");                                  
                                        $wynik_suma = mysql_query("SELECT sum(METRY_RAPORTY_ZMIANA) AS 'metry_suma' FROM view_wszystko_metry_raporty_sztuki WHERE Odbiorca_zamowienia != '' AND Data BETWEEN '$data_od' AND '$data_do';") or die ("zle pytanie zamowienia sumy");                                                                                              
                                        
                                        $polocz->close();
                                        
                                        while($rekord_suma = mysql_fetch_assoc($wynik_suma)){
                                            $suma_metrow = $rekord_suma['metry_suma'];
                                        }                                       
                                        
                                        $polocz->open(); 
                                        mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");                                  
                                        $wynik = mysql_query("SELECT Odbiorca_zamowienia AS 'Odbiorca', sum(METRY_RAPORTY_ZMIANA) AS 'Ilość_metrów' FROM view_wszystko_metry_raporty_sztuki WHERE Odbiorca_zamowienia != '' AND Data BETWEEN '$data_od' AND '$data_do' GROUP BY `Odbiorca_zamowienia` ORDER BY sum(`METRY_RAPORTY_ZMIANA`) DESC;") or die ("zle pytanie zamowienia");                                                                                              
                                       
                                        $polocz->close();
                                        
                                         
                                        $lp = 1;
                                        while($rekord = mysql_fetch_assoc($wynik)){
                                            
                                            $klient = $rekord['Odbiorca'];
                                            $metry = $rekord['Ilość_metrów'];
                                            
                                            $procent = (100 * $metry)/$suma_metrow;
                                            $procent = round($procent, 2);
                                            
                                            if($lp % 2)
                                            {
                                                $kolor = '#FFFFFF';
                                            }else{
                                                $kolor = '#F0FFFF';
                                            }                              
                                            
                                            print"<TR><TD id='td_kolor' align = 'center' bgcolor=$kolor>$lp</TD><TD id='td_kolor' bgcolor=$kolor>$klient</TD><TD id='td_kolor' align='right' bgcolor=$kolor>$metry</TD><TD id='td_kolor' align = 'center' bgcolor=$kolor>$procent %</TD></TR>\n";
                                            $lp ++;
                                            
                                        }
                                    
                                    */
                                    ?>
                            <!--</TABLE>-->
                        </DIV>           
                    </td>
                </tr>
            </TABLE>
            
                          
 
<DIV class="dolny_do_tabeli" id="niedrukuj"></DIV>

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
    var_dump($wybrany_miesiac);
    print"<br>";
    var_dump($maszyna);
    print"<br>";
    
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
        var_dump($szukaj_od);
        print"do ";
        var_dump($szukaj_do);
        print"<br>";
        
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
        var_dump($suma_metrow);
        print"<br>";
        $suma_metrow = 0;
    }
    
    
}


?>
