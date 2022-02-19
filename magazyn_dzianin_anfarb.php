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
        <script src = "js/jquery-1.11.0.min.js"> </script>
        <script src = "js/lightbox.min.js"> </script>
        <script src="js_web/script_miniatura_zdjecia.js" async></script>
        <link href="css/lightbox.css" rel="stylesheet"/>     
	<link rel="Stylesheet" media="print" type="text/css" href="dodruku.css" />
        <link href="css_wyglad_strony/style.css" rel="stylesheet" type="text/css">
        <link href="css_wyglad_strony/mobile_style.css" rel="stylesheet" type="text/css">
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
            <?PHP require_once "zalogowany_banery.php"; ?>
        </td>
    </tr>
        <tr>
            <td align=center>
                <!--<DIV class="mniejszy_panel">-->
                <DIV id="panel_filtrowanie" class="wiekszy_panel">
                    
                            <FORM ACTION="index.php" METHOD=POST>
                                <INPUT TYPE="submit" VALUE="Strona startowa" CLASS="btn">
                            </FORM>                                  
                    
                             <!--////////////koniec przycisk i nazwa odbiorcy////////////////-->
                            <br>
                            <!--/////////////przycisk data wybierz/////////////////////////-->
                            <B><font class='opis_paneli'>MAGAZYN DZIANINY AN-FARB</font></B><br><br>

                            <FORM ACTION="magazyn_dzianin_anfarb.php" METHOD=POST>                               
                                <div align=center>
                                    <TABLE class="pole_comboBox">
                                        <TR>
                                            <!--<TD class='td_pole_spacja'><B><font class="opis_texbox">NR PARTI: </font></B></TD>-->
                                            <TD class='td_pole_opis'>
                                                <?PHP
                                                $nr_parti_wybrany = $_POST['nr_parti'];
                                                print "<B><font class='opis_texbox'>NR PARTI:</font></B>";
                                                print"<input class='text_box' type='text' name='nr_parti' value='".$nr_parti_wybrany."'>";
                                                ?>
                                            </TD>   
                                            <TD class='td_pole_spacja'><B><font class="opis_texbox"></font></B></TD>
                                            <TD class='td_pole_opis'>
                                                <?PHP
                                                  
                                                $artykul_wybrany = $_POST['artykul'];
                                                print "<B><font class='opis_texbox'>ARTYKUŁ:</font></B>";
                                                print"<input class='text_box' type='text' name='artykul' value='".$artykul_wybrany."'>";
                                                ?>
                                            </TD>   
                                            <TD class='td_pole_spacja'></TD>
                                            <TD class='td_pole_przycisk_botton'>
                                                <B><font class='opis_texbox'></font></B>
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
            <TABLE cellpadding = '0'  cellspacing = '0' border = '0' style='width: 98%; height: 100%;'>               
                <tr>
                    <td align="center">
                        <DIV align="center">
                            <TABLE width=80%>
                                <TR bgcolor = #6666ff><TD id='td_kolor' class='regaly_td_font' style='width: 5%;'><B>Lp.</B></TD><TD id='td_kolor' class='regaly_td_font' style='width: 10%;'><B>NR PARTI</B></TD><TD id='td_kolor' class='regaly_td_font' style='width: 30%;'><B>ARTYKKUŁ</B></TD><TD id='td_kolor' class='regaly_td_font' style='width: 10%;'><B>ILOŚĆ SZTUK</B></TD><TD id='td_kolor' class='regaly_td_font' style='width: 5%;'><B>W / ZAPAS</B></TD><TD id='td_kolor' class='regaly_td_font' style='width: 30%;'><B>UWAGI</B></TD><TD id='td_kolor' class='regaly_td_font' style='width: 10%;'><B>TOKA / WÓZEK</B></TD></TR>
                                    <?PHP
                                        require_once 'class.Polocz.php';
                                        $polocz = new Polocz();
                                        
                                        /*
                                        $polocz->open(); 
                                        mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");                                  
                                        $wynik_suma = mysql_query("SELECT sum(METRY_RAPORTY_ZMIANA) AS 'metry_suma' FROM view_wszystko_metry_raporty_sztuki WHERE Artykul_zamowienia != '' AND Artykul_zamowienia != 'Zamówienie nr..' AND Artykul_zamowienia != 'ZZZZ' AND Artykul_zamowienia != 'test 2020' AND Artykul_zamowienia != 'wwwww' AND Artykul_zamowienia != 'DZIANINA PES/T' AND Artykul_zamowienia NOT LIKE 'TKANINA%' AND Artykul_zamowienia != '200 BAWEŁNA' AND Artykul_zamowienia NOT LIKE '%VISKOZA' AND Data BETWEEN '$data_od' AND '$data_do';") or die ("zle pytanie zamowienia sumy");                                                                                              
                                        $polocz->close();
                                        
                                        while($rekord_suma = mysql_fetch_assoc($wynik_suma)){
                                            $suma_metrow = $rekord_suma['metry_suma'];
                                        }
                                         * 
                                         */
                                        
                                        $polocz->open(); 
                                        mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");                                  
                                        $wynik = mysql_query("SELECT Nr_parti, Artykul, Ilosc, Wykorzystane_zapas, Uwagi, Data, Korekta_na_strone, Toka_wozek FROM view_magazyn_dzianin_napawania WHERE Status = '1' and Artykul NOT LIKE '%VISKOZA%' AND Artykul NOT LIKE '%TKANINA%' AND Toka_wozek != 'REGAŁ' AND Nr_parti LIKE '$nr_parti_wybrany%' AND Artykul LIKE '$artykul_wybrany%' GROUP BY ID_Karta_nr ORDER BY Artykul;") or die ("zle pytanie zamowienia");                                                                                              
                                        //$wynik = mysql_query("SELECT Nr_parti FROM view_magazyn_dzianin_napawania;") or die ("zle pytanie zamowienia");                                                                                              
                                        //$wynik = mysql_query("SELECT N.Nr_parti AS Nr_parti, N.Artykul AS Artykul, N.Ilosc AS Ilosc, N.Wykorzystane_zapas AS Wykorzystane_zapas, N.Uwagi AS Uwagi, N.Data AS Data, N.Korekta AS Korekta, W.Wykorzystane AS Wykorzystane FROM (view_magazyn_dzianin_napawania N LEFT JOIN view_magazyn_dzianin_suma_wykorzystane W ON N.Nr_parti = W.Nr_parti) WHERE N.Status = '1' and N.Artykul NOT LIKE '%VISKOZA%' AND N.Artykul NOT LIKE '%TKANINA%' AND N.Toka_wozek != 'REGAŁ' AND N.Nr_parti LIKE '$nr_parti_wybrany%' AND N.Artykul LIKE '$artykul_wybrany%' GROUP BY N.ID_Karta_nr ORDER BY N.Artykul;") or die ("zle pytanie zamowienia");                                                                                              
                                        
                                        $polocz->close();
                                        
                                        $lp = 1;
                                        while($rekord = mysql_fetch_assoc($wynik)){
                                            
                                            //var_dump($rekord);
                                            $nr_parti = $rekord['Nr_parti'];                                 
                                            $artykul = $rekord['Artykul'];
                                            $ilosc = $rekord['Ilosc'];
                                            $wykorzystane_zapas = $rekord['Wykorzystane_zapas'];
                                            $uwagi = $rekord['Uwagi'];
                                            $rok = $rekord['Data'];
                                            $korekta = $rekord['Korekta_na_strone'];
                                            $toka_wozek = $rekord['Toka_wozek'];
                                            
                                            
                                            
                                            $ilosc_do_wyswietlenia = (int)($ilosc - $korekta);
                                            
                                            /*
                                            print"<br>";
                                            print"ROK = "; var_dump($rok);
                                            print"NR PARTI = "; var_dump($nr_parti);
                                            print"ARTYKUL = "; var_dump($artykul);
                                            print"wykorzystane = "; var_dump($suma_metrow);
                                            print"ilosc = "; var_dump($ilosc);
                                            print"ilosc_do_wyswietlenia = "; var_dump($ilosc_do_wyswietlenia);
                                             * 
                                             */
                                            
                                            /*
                                            $procent = (100 * $metry)/$suma_metrow;
                                            $procent = round($procent, 2);
                                            */
                                            if($lp % 2)
                                            {
                                                $kolor = '#FFFFFF';
                                            }else{
                                                $kolor = '#F0FFFF';
                                            }  
                                            print"<TR><TD id='td_kolor' align = 'center' bgcolor=$kolor>$lp</TD><TD id='td_kolor' bgcolor=$kolor>$nr_parti</TD><TD id='td_kolor' align='left' bgcolor=$kolor>$artykul</TD><TD id='td_kolor' align = 'center' bgcolor=$kolor>$ilosc_do_wyswietlenia</TD><TD id='td_kolor' align = 'center' bgcolor=$kolor>$wykorzystane_zapas</TD><TD id='td_kolor' align = 'left' bgcolor=$kolor>$uwagi</TD><TD id='td_kolor' align = 'left' bgcolor=$kolor>$toka_wozek</TD></TR>\n";
                                            $lp ++;
                                            
                                        }
                                    
                                    
                                    ?>
                            </TABLE>
                        </DIV>          
                    </td>
                </tr>
            </TABLE> 
<DIV class="dolny_do_tabeli" id="niedrukuj"></DIV>

</body>
</html>
