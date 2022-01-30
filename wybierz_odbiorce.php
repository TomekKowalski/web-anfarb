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
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
    <script src = "js/jquery-1.11.0.min.js"> </script>
    <script src = "js/lightbox.min.js"> </script>
    <!--<script src="js_web/script_wybierz_odbiorce.js" async></script>-->
    <script src="js_web/script_miniatura_zdjecia.js" async></script>
    <link href="css/lightbox.css" rel="stylesheet"/>
    <link rel="Stylesheet" media="print" type="text/css" href="dodruku.css" />
    <link href="css_wyglad_strony/style.css" rel="stylesheet" type="text/css">
    <link href="css_wyglad_strony/mobile_style.css" rel="stylesheet" type="text/css">
      <title>Zamówienia drukarnia</title>
	  
</head>

<body>

<?PHP
                        require_once 'class.Polocz.php';
                        $polocz = new Polocz();
                        $polocz->open();
                        mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                        $lista_odbiorca = mysql_query("SELECT DISTINCT * FROM ODBIORCA_TAB ORDER BY Nazwa_odbiorca") or die ("zle pytanie");
                        $polocz->close(); 
                        while($rekord_odbiorca = mysql_fetch_assoc($lista_odbiorca))
                        {
                            $odbiorcy[$i] = $rekord_odbiorca['Nazwa_odbiorca'];
                            $i++;   
                        }
                        $rok = array('2013' => '2013','2014' => '2014', '2015' => '2015', '2016' => '2016', '2017' => '2017', '2018' => '2018', '2019' => '2019', '2020' => '2020', '2021' => '2021', '2022' => '2022');
                        $status = array('DO AKCEPTACJI' => 'DO AKCEPTACJI', 'DO DRUKU' => 'DO DRUKU', 'WYDRUKOWANE' => 'WYDRUKOWANE', 'MAGAZYN_DAMAZ' => 'MAGAZYN_DAMAZ', 'ZALICZKA' => 'ZALICZKA');

if(!$_POST['opcja'] && !$_POST['opcja02'])  ///NIE wyswietla gdy jest wybrany klient
{
print'<DIV class="panel_glowny">';
}

if($_POST['opcja'] || $_POST['opcja02'])
{ 
    
                            if(!$_POST['zapisz_uwagi'])
                            {
                                foreach($odbiorcy as $klucz => $wartosc)
                                {
                                    if($klucz == $_POST['opcja_odbiorca'])
                                    {
                                        $odbiorca = htmlspecialchars($wartosc);				
                                    }
                                }
                            }
                            if($_POST['rok'])
                            {
                                foreach($rok as $klucz_rok => $wartosc_rok)
                                {
                                    if($klucz_rok == $_POST['rok'])
                                    {
					$wybrany_rok = htmlspecialchars($wartosc_rok);
                                    }
                                }   
                            }else
                            {
                                $wybrany_rok = '2022';
                                if($_POST['rok_filtr_uwagi'])
                                {                       
                                    $wybrany_rok = $_POST['rok_filtr_uwagi'];                      
                                }          
                            }
                            if($_POST['rok_filtr_uwagi'])
                            {               
                                $wybrany_rok = $_POST['rok_filtr_uwagi'];                
                            } 
                                ////////////////////////////////////////////
                            if($_POST['status'])
                            {
                                foreach($status as $klucz_status => $wartosc_status)
                                {
                                    if($klucz_status == $_POST['status'])
                                    {
                                        $wybrany_status = htmlspecialchars($wartosc_status);
                                    }
                                }                                 
                            }
                            
                            if(!$_POST['filtr_uwagi'])
                            {                
                                if($_POST['zapisz_uwagi'])
                                {
                                    $odbiorca = $_SESSION['odbiorca'];
                                    zapisywanie_uwag();
                                }
                                $_SESSION['odbiorca'] = $odbiorca;
                                $_SESSION['rok'] = $wybrany_rok;
                                $_SESSION['status'] = $wybrany_status;	
                            }	
                            if($_POST['filtr_uwagi'])
                            {
                                //print"wchodzi filtr uwagi bez!";
                                $_SESSION['filtr_uwagi'] = $_POST['filtr_uwagi_tex'];
                                $_SESSION['filtr_wzor'] = $_POST['filtr_wzor_tex'];
                                $odbiorca = $_SESSION['odbiorca'];
                                $wybrany_rok = $_SESSION['rok'];
                                $wybrany_status = $_SESSION['status'];
                                $filtr_uwagi = $_SESSION['filtr_uwagi'];
                                $filtr_wzor = $_SESSION['filtr_wzor'];		
                                if($_POST['rok_filtr_uwagi'])
                                {
                                    $wybrany_rok = $_POST['rok_filtr_uwagi'];
                                    $_SESSION['rok'] = $wybrany_rok;                     
                                }               
                            }
                            if($_POST['zmien_status_zaliczka'])
                            {
                                zmiana_statusu();
                                /*
                                $_SESSION['odbiorca'] = $odbiorca;
                                $_SESSION['rok'] = $wybrany_rok;
                                $_SESSION['status'] = $wybrany_status;
                                 * 
                                 */
                                
                            }
                            if($odbiorca == "")
                            {
                                $odbiorca = $_SESSION['odbiorca_nowe_zamowienie'];
                            }
                            
                            ////////////wyszukiwanie wszystkich wybranego odbiorcy
                            if(($wybrany_rok == "") && ($wybrany_status == ""))
                            {
                                $polocz->open();
                                mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                                $wynik = mysql_query("SELECT * FROM ZAMOWIENIA_TAB WHERE Odbiorca_zamowienia = '$odbiorca' AND Uwagi LIKE '%$filtr_uwagi%' AND Wzory_zamowienia LIKE '%$filtr_wzor%' ORDER BY Data") or die ("zle pytanie odbiorca 1");

                                $wynik_ile_wierszy = mysql_query("SELECT COUNT(*) FROM ZAMOWIENIA_TAB WHERE Odbiorca_zamowienia = '$odbiorca' AND Uwagi LIKE '%$filtr_uwagi%' AND Wzory_zamowienia LIKE '%$filtr_wzor%' ORDER BY Data") or die ("zle pytanie odbiorca 2");		
                                $rekord_ile_wierszy = mysql_fetch_assoc($wynik_ile_wierszy);
                                $ile_wierszy = $rekord_ile_wierszy['COUNT(*)'];
                                $polocz->close();
                            }
                            ////////////wyszukiwanie  wybranego odbiorcy i roku////////////
                            if((!$wybrany_rok == "") && ($wybrany_status == ""))
                            {  
                                $polocz->open();
                                mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                                $wynik = mysql_query("SELECT * FROM ZAMOWIENIA_TAB WHERE Odbiorca_zamowienia = '$odbiorca' AND Data LIKE '$wybrany_rok%' AND Uwagi LIKE '%$filtr_uwagi%' AND Wzory_zamowienia LIKE '%$filtr_wzor%' ORDER BY Data") or die ("zle pytanie odbiorca 3");

                                $wynik_ile_wierszy = mysql_query("SELECT COUNT(*) FROM ZAMOWIENIA_TAB WHERE Odbiorca_zamowienia = '$odbiorca' AND Data LIKE '$wybrany_rok%' AND Uwagi LIKE '%$filtr_uwagi%' AND Wzory_zamowienia LIKE '%$filtr_wzor%' ORDER BY Data") or die ("zle pytanie odbiorca 4");		
                                $rekord_ile_wierszy = mysql_fetch_assoc($wynik_ile_wierszy);
                                $ile_wierszy = $rekord_ile_wierszy['COUNT(*)'];
                                $polocz->close();
                            }
                            ////////////wyszukiwanie  wybranego odbiorcy i STATUS////////////
                            if(($wybrany_rok == "") && (!$wybrany_status == ""))
                            {
                                $polocz->open();
                                mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                                $wynik = mysql_query("SELECT * FROM ZAMOWIENIA_TAB WHERE Odbiorca_zamowienia = '$odbiorca' AND Status_zamowienia = '$wybrany_status' AND Uwagi LIKE '%$filtr_uwagi%' AND Wzory_zamowienia LIKE '%$filtr_wzor%' ORDER BY Data") or die ("zle pytanie odbiorca 5");

                                $wynik_ile_wierszy = mysql_query("SELECT COUNT(*) FROM ZAMOWIENIA_TAB WHERE Odbiorca_zamowienia = '$odbiorca' AND Status_zamowienia = '$wybrany_status' AND Uwagi LIKE '%$filtr_uwagi%' AND Wzory_zamowienia LIKE '%$filtr_wzor%' ORDER BY Data") or die ("zle pytanie odbiorca 6");
                                $rekord_ile_wierszy = mysql_fetch_assoc($wynik_ile_wierszy);
                                $ile_wierszy = $rekord_ile_wierszy['COUNT(*)'];          
                                $polocz->close();
                            }
                            ////////////wyszukiwanie  wybranego odbiorcy status rok////////////
                            if((!$wybrany_rok == "") && (!$wybrany_status == ""))
                            {
                                $polocz->open();
                                mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                                $wynik = mysql_query("SELECT * FROM ZAMOWIENIA_TAB WHERE Odbiorca_zamowienia = '$odbiorca' AND Status_zamowienia = '$wybrany_status' AND Data LIKE '$wybrany_rok%' AND Uwagi LIKE '%$filtr_uwagi%' AND Wzory_zamowienia LIKE '%$filtr_wzor%' ORDER BY Data") or die ("zle pytanie odbiorca 7");

                                $wynik_ile_wierszy = mysql_query("SELECT COUNT(*) FROM ZAMOWIENIA_TAB WHERE Odbiorca_zamowienia = '$odbiorca' AND Status_zamowienia = '$wybrany_status' AND Data LIKE '$wybrany_rok%' AND Uwagi LIKE '%$filtr_uwagi%' AND Wzory_zamowienia LIKE '%$filtr_wzor%' ORDER BY Data") or die ("zle pytanie odbiorca 8");
                                $rekord_ile_wierszy = mysql_fetch_assoc($wynik_ile_wierszy);
                                $ile_wierszy = $rekord_ile_wierszy['COUNT(*)'];
                                $polocz->close();
                            }
?>                         
<?PHP
    print'<DIV class="do_tabeli">';                       
    require_once "zalogowany_banery.php";
   // print"<br>";       
        print'<div id="panel_wybierz_odbiorce_fix" class="panel_1ogowanie">';
            print'<DIV align=center>';
                        /////////przycisk i nazwa odbiorcy/////////////////////
                        print"<TABLE id=niedrukuj cellpadding = '0'  cellspacing = '0' border = '0'>";
                            print"<tr>";
                                print"<td>";
                                    print'<FORM ACTION="wybierz_odbiorce.php" METHOD=POST>';
                                    print'<INPUT TYPE="submit" VALUE="Wyszukaj odbiorce" CLASS="btn">';
                                    print'</FORM>';
                                print"</td>";
                                print"<td>";
                                    print"                                        ";
                                print"</td>";
                                print"<TD width='3' border='0'>";
                                print"</TD>";
                                print"<td>";
                                    print"<a href = 'galeria_zd.php?odbiorca=".$odbiorca."'>";
                                    print'<INPUT TYPE="submit" VALUE="Galeria" CLASS="btn">';
                                    print"</a>";
                                print"</td>";
                                print"<TD width='3' border='0'>";
                                print"</TD>";
                                print"<td>";
                                    if($_SESSION['uprawnienia'] != "grafika")
                                    {
                                        print"<a href = 'formularz_nowe_zamowienie.php?odbiorca=$odbiorca'>";
                                        print'<INPUT TYPE="submit" VALUE="Nowe zamowienie" CLASS="btn">';
                                        print"</a>";
                                    }
                                print"</td>";
                            print"</tr>";
                        print"</TABLE>";
                        print'<br>';
                        print "<B><font class='opis_paneli'>$odbiorca</font></B><br>";
                        print'<FORM ACTION="wybierz_odbiorce.php" METHOD=POST>';
                        print '<INPUT TYPE="hidden" NAME="opcja02" VALUE="opcja">';
                            ////////////text box do filtrowania uwag /////////////////////////// 
                        print'<TABLE id=niedrukuj CELLPADDING=0 CELLSPACING=0 BORDER=0 style=" width: 100%; height: 100%";>';
                            //print"<TR height=2 bgcolor=#004d26><TD width=2></TD ><TD width=10></TD><TD></TD><TD width=15></TD><TD></TD><TD></TD><TD></TD><TD width=15></TD><TD></TD><TD width=5></TD><TD></TD><TD width=10></TD><TD width=2 bgcolor=#e6fff2></TD></TR>";
                            //print"<TR height=10><TD width=2 bgcolor=#004d26></TD><TD width=10></TD><TD></TD><TD width=15></TD><TD></TD><TD></TD><TD></TD><TD width=15></TD><TD></TD><TD width=5></TD><TD></TD><TD width=10></TD><TD width=2 bgcolor=#e6fff2></TD></TR>";
                            print"<TR>";
                                //print"<TD width=2 bgcolor=#004d26></TD><TD width=10></TD>";
                                print"<TD style='width: 40%;'>"; 
                                    print'<B><font class="opis_texbox">WZÓR</font></B><br/>';
                                    print '<INPUT class="text_box" style="width: 95%"; TYPE="text" NAME="filtr_wzor_tex" VALUE="'.$filtr_wzor.'">';
                                print"</TD>";                                        
                                print"<TD style='width: 40%;'>";
                                    print'<B><font class="opis_texbox">UWAGI</font></B><br/>';
                                    print '<INPUT class="text_box" style="width: 95%"; TYPE="text" NAME="filtr_uwagi_tex" VALUE="'.$filtr_uwagi.'">';
                                print"</TD>";                                
                                print"<TD valign=bottom style='width: 10%;'>";
                                        ////////////combobox 02//////////////////
                                    print'<SELECT class="opis_select" NAME="rok_filtr_uwagi" style="width: 95%;">';
                                       //print'<OPTION SELECTED VALUE="">-&gt; '.$wybrany_rok.'';
                                        print"<OPTION SELECTED VALUE='$wybrany_rok'>$wybrany_rok</OPTION>";
                                        foreach($rok as $klucz => $wartosc)
                                        {
                                            print("<OPTION VALUE=\"$klucz\">".$wartosc);
                                        }
                                    print'</SELECT>';
                                print"</TD>";                               
                                print"<TD valign=bottom style='width: 10%;'>";
                                    print "";
                                    print'<INPUT TYPE="submit" NAME="filtr_uwagi" VALUE="Filtruj" CLASS="btn" style="width: 100%;">';  
                                print"</TD>";
                                //print"<TD width=10></TD><TD></TD><TD width=2 bgcolor=#e6fff2></TD>";
                            print"</TR>";
                            //print"<TR height=10><TD width=2 bgcolor=#004d26></TD><TD width=10></TD><TD></TD><TD width=15></TD><TD></TD><TD></TD><TD></TD><TD width=15></TD><TD></TD><TD width=5></TD><TD></TD><TD width=10></TD><TD width=2 bgcolor=#e6fff2></TD></TR>";
                            //print"<TR height=2 bgcolor=#e6fff2><TD width=2 bgcolor=#004d26></TD><TD width=10></TD><TD width=15></TD><TD></TD><TD></TD><TD></TD><TD></TD><TD width=15></TD><TD></TD><TD width=5></TD><TD></TD><TD width=10></TD><TD width=2 bgcolor=#e6fff2></TD></TR>";
                        print"</TABLE>";	
                                ////////////koniec textbox filtrowanie uwagi  ///////////////////////////
            print'</DIV>';    
        print'</DIV>';
    print'</DIV>';
}

                        
print'<TABLE border="0" style="width: 100%; height: 100%;">';   
    print'</tr>';
    if(!$_POST['opcja'] && !$_POST['opcja02'])  ///NIE wyswietla gdy jest wybrany klient
    {
    print'<tr>';
        print'<td style="align-items: left">';
            require_once "zalogowany_banery.php";
        print'</td>';
    print'</tr>';
    }
    print'<tr>';
        print'<td align=center>';
         /////////wyswietlanie po wybraniu///////////// 
        
        if($_POST['opcja'] || $_POST['opcja02'])
        {           
            print"<TABLE cellpadding = '0'  cellspacing = '0' border = '0' width=95% height=100%>";
                print"<tr>";
                    print"<td align=center>";
                        
                              
                            
                            
                    print"</td>";
                print"</tr>";
                print"<tr>";
                    print"<td align=center>";
                        
                    print"</td>";
                print"</tr>";              
                print"<tr>";
                    print"<td align=center height=30px>";
                    print"</td>";
                print"</tr>";
                print"<tr>";
                    print"<td align=center>";                      
                            ////////////////początek tabeli/////////////////////////
                        print"<TABLE style='width: 100%; height: 100%;'>";
                            print"<TR bgcolor = #6666ff><TD id='td_kolor' width=2%><B>ARTYKUŁ</B></TD><TD id='td_kolor' width=2%><B>ILOŚĆ</B></TD><TD id='td_kolor' width=5%><B> M./SZT. </B></TD><TD id='td_kolor' width=5%><B>NR PARTI</B></TD><TD id='td_kolor' width=2%><B>WZÓR</B></TD><TD id='td_kolor' width=3%><B>UWAGI</B></TD><TD id='td_kolor' width=10%><B>STATUS</B></TD><TD id='td_kolor' width=2%><B>DATA ZAMÓWIENIA DZIANINY</B></TD><TD id='td_kolor' width=10%><B>DATA PRZYSŁANIA DZIANINY</B></TD><TD id='td_kolor' width=2%><B>DATA DRUKOWANIA</B></TD><TD id='td_kolor' width=10%><B>DATA STABILIZACJI</B></TD><TD id='td_kolor' width=2%><B>PLANOWANA DATA ODBIORU</B></TD><TD id='td_kolor' width=2%><B>DATA MAGAZYN DAMAZ</B></TD><TD id='td_kolor' width=2%><B>UWAGI DAMAZ</B></TD></TR>";
                            $temp_zamowienie = 0;
                            $k=0;
                            $w=0;
                            $ile_wierszy_status_zaliczka = 0;
                            $suma_wierszy = $ile_wierszy - 100;
                            if($suma_wierszy >= 0)
                            {
                                $od_ktorego_wiersza = $suma_wierszy;
                            }else{
                                $od_ktorego_wiersza = 0;
                            }
                            $ktory_wiersz = 0;
                            while($rekord = mysql_fetch_assoc($wynik))
                            {
                                $artykul_zamowienia = $rekord['Artykul_zamowienia'];
                                $ilosc = $rekord['Ilosc_szt_metrow'];
                                $status_metrow = $rekord['Status_metrow'];
                                $nr_parti = $rekord['Nr_parti'];
                                $wzor = $rekord['Wzory_zamowienia'];
                                $uwagi = $rekord['Uwagi'];
                                $status = $rekord['Status_zamowienia']; 
                                $zamowienie_nr = $rekord['Zamowienie_nr'];
                                $data = $rekord['Data'];
                                $nr_wiersza = $rekord['Nr_wiersza'];
                                $status_wpis_do_zeszytu = $rekord['Status_wpis_do_zeszytu'];
                                $planowana_data_odbioru = $rekord['Planowana_data_odbioru'];
                                $kolor = '#FFFFFF';
                                if($temp_zamowienie != $zamowienie_nr)
                                {
                                    $kolor = '#B8B8B8';
                                    print"<TR><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>Zamówienie nr..</font></B></TD><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>$zamowienie_nr</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD bgcolor=$kolor><B><font size='4' color='blue'>Data..</font></B></TD><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>$data</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>\n";  
                                    $temp_zamowienie = $zamowienie_nr;  	
                                }
                                $kolor = '#FFFFFF';
                                if($status_wpis_do_zeszytu == '1')
                                {
                                    $kolor = '#CCFFFF';
                                }
                                if($status == 'WYDRUKOWANE')
                                {
                                    $kolor = '#FFFF66';   
                                }
                                if($status == 'STABILIZACJA')
                                {
                                    $kolor = '#99FF99';   
                                }
                                if($status == 'MAGAZYN_DAMAZ')
                                {
                                    $kolor = '#00CC33'; 
                                }
                                if($status == 'DO AKCEPTACJI')
                                {
                                    $kolor = '#ffe6e6';
                                }
                                if($status == 'ZALICZKA')
                                {
                                        $kolor = '#DCDCDC';
                                }
                                
                                    $tab_nr_wiersza_status[$k]=$nr_wiersza;
                                    $tab_sprawdz_status[$k]=$status;
                                    $ile_wierszy_status_zaliczka ++;
                                print"<TR><TD id='td_kolor' bgcolor=$kolor>$artykul_zamowienia</TD><TD id='td_kolor' align='right' bgcolor=$kolor>$ilosc</TD><TD id='td_kolor' align = 'center' bgcolor=$kolor>$status_metrow</TD><TD id='td_kolor' bgcolor=$kolor>$nr_parti</TD><TD id='td_kolor' bgcolor=$kolor><a href='WZORY_JPG_WSZYSTKIE/$wzor.jpg' data-lightbox='$wzor.jpg' data-title='$wzor'><div id='td_wzor".$ktory_wiersz."' class=''>$wzor</div></a></TD><TD id='td_kolor' bgcolor=$kolor>$uwagi</TD>";
                                    print"<TD id='td_kolor' bgcolor=$kolor>$status</TD>";
                                    
                                    $ktory_wiersz ++;
                                    /////////////////pola do wpisywania daty alertow//////////////////////////	
                                $polocz->open();
                                mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                                $wynik_data_zamowienia_dzianiny = mysql_query("SELECT `Data_zamowienia_dzianiny` FROM `ALERTY_TAB` WHERE `ID_nr_wiersza` = '$nr_wiersza'") or die ("zle pytanie data zamowienia dzianiny");
                                $rekord_data_zamowienia_dzianiny = mysql_fetch_assoc($wynik_data_zamowienia_dzianiny);
                                $data_zamowienia_dzianiny = $rekord_data_zamowienia_dzianiny['Data_zamowienia_dzianiny'];
                                print"<TD id='td_kolor' align=center bgcolor=$kolor>$data_zamowienia_dzianiny</TD>";
                                    //////////////////ALERT DATA PRZYSLANIA DZIANINY/////////////////////////////////
                                $wynik_data_przyslania_dzianiny = mysql_query("SELECT `Data_przyslania_dzianiny` FROM `ALERTY_TAB` WHERE `ID_nr_wiersza` = '$nr_wiersza'") or die ("zle pytanie data przyslania_dzianiny");
                                $rekord_data_przyslania_dzianiny = mysql_fetch_assoc($wynik_data_przyslania_dzianiny);
                                $data_przyslania_dzianiny = $rekord_data_przyslania_dzianiny['Data_przyslania_dzianiny'];
                                $polocz->close();
                                print"<TD id='td_kolor' align=center bgcolor=$kolor>$data_przyslania_dzianiny</TD>";
                                    /////////////////ALERT DATA WYDRUKOWANIA DZIANINY///////////////////////////////
                                $polocz->open();
                                mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                                $wynik_data_wydrukowania = mysql_query("SELECT `Data_wydrukowania_dzianiny` FROM `ALERTY_TAB` WHERE `ID_nr_wiersza` = '$nr_wiersza'") or die ("zle pytanie Data_wydrukowania_dzianiny");
                                $rekord_data_wydrukowania = mysql_fetch_assoc($wynik_data_wydrukowania);
                                $data_wydrukowania = $rekord_data_wydrukowania['Data_wydrukowania_dzianiny'];
                                $polocz->close();	
                                $kolor = '#FFFFFF';
                                if($data_wydrukowania != '')
                                {
                                    $kolor = '#FFFF66';  
                                }
                                if($status == 'WYDRUKOWANE')
                                {
                                    $kolor = '#FFFF66';   
                                }
                                if($status == 'STABILIZACJA')
                                {
                                    $kolor = '#99FF99';   
                                }
                                if($status == 'MAGAZYN_DAMAZ')
                                {
                                    $kolor = '#00CC33';  
                                }
                                print"<TD id='td_kolor' align=center bgcolor=$kolor>$data_wydrukowania</TD>";
                                    ////////////////ALERT DATA STABILIZACJI DZIANINY///////////////////////////////
                                $polocz->open();
                                mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                                $wynik_data_stabilizacji_dzianiny = mysql_query("SELECT `Data_stabilizacji_dzianiny` FROM `ALERTY_TAB` WHERE `ID_nr_wiersza` = '$nr_wiersza'") or die ("zle pytanie Data_stabilizacji_dzianiny");
                                $rekord_data_stabilizacji_dzianiny = mysql_fetch_assoc($wynik_data_stabilizacji_dzianiny);
                                $data_stabilizacji_dzianiny = $rekord_data_stabilizacji_dzianiny['Data_stabilizacji_dzianiny'];
                                $polocz->close();
                                $kolor = '#FFFFFF';
                                if($data_stabilizacji_dzianiny != '')
                                {
                                    $kolor = '#99FF99';
                                }
                                if($status == 'STABILIZACJA')
                                {
                                    $kolor = '#99FF99';   
                                }
                                if($status == 'MAGAZYN_DAMAZ')
                                {
                                    $kolor = '#00CC33'; 
                                }
                                print"<TD id='td_kolor' align=center bgcolor=$kolor>$data_stabilizacji_dzianiny</TD>";
                                print"<TD id='td_kolor' align=center bgcolor=$kolor>$planowana_data_odbioru</TD>";
                                $polocz->open();
                                mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                                $wynik_data_magazyn_damaz = mysql_query("SELECT `Data_magazynowania` FROM `MAGAZYN_DAMAZ_TAB` WHERE `Nr_wiersza` = '$nr_wiersza'") or die ("zle pytanie data_magazyn_damaz");
                                $rekord_data_magazyn_damaz = mysql_fetch_assoc($wynik_data_magazyn_damaz);
                                $data_magazyn_damaz = $rekord_data_magazyn_damaz['Data_magazynowania'];
                                $polocz->close();	
                                if($data_magazyn_damaz != "")
                                {
                                    $dzien;
                                    $miesiac;
                                    $rok;
                                    $dzien = substr($data_magazyn_damaz,3,2);
                                    $miesiac = substr($data_magazyn_damaz,0,2);
                                    $rok = substr($data_magazyn_damaz,6,4);
                                    $data_magazyn_damaz = $rok."-".$miesiac."-".$dzien;
                                }		
                                $kolor = '#FFFFFF';
                                if($data_magazyn_damaz != '')
                                {
                                    $kolor = '#00CC33';
                                }
                                if($status == 'MAGAZYN_DAMAZ')
                                {
                                    $kolor = '#00CC33'; 
                                }
                                    /////////////////kolor ALERT MAGAZYN DAMAZ ///////////////////////////////
                                if($data_magazyn_damaz == "")
                                {
                                    $polocz->open();
                                    mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                                    $wynik_nr_wiersza_k = mysql_query("SELECT `Nr_wiersza` FROM `ZAMOWIENIA_TAB` WHERE `Nr_wiersza` = '$nr_wiersza' AND date(now()) < adddate(`Data`, 21)") or die ("zle pytanie nr_wiersza_k");
                                    $rekord_nr_wiersza_k = mysql_fetch_assoc($wynik_nr_wiersza_k);
                                    $nr_wiersza_k = $rekord_nr_wiersza_k['Nr_wiersza'];
                                    $polocz->close();
                                }
                                if($nr_wiersza_k != "")
                                {
                                    $kolor = '#006633';
                                }
                                if($nr_wiersza_k == "")
                                {
                                    $kolor = '#FF0033';
                                }
                                if($data_magazyn_damaz != '')
                                {
                                    $kolor = '#00CC33';
                                }	
                                print"<TD id='td_kolor' align=center bgcolor=$kolor>$data_magazyn_damaz</TD>";
                                $kolor = '#FFFFFF';
                                if($data_magazyn_damaz != '')
                                {
                                    $kolor = '#00CC33';
                                }
                                if($status == 'MAGAZYN_DAMAZ')
                                {
                                    $kolor = '#00CC33'; 
                                }	
                                $polocz->open();
                                mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                                $wynik_uwagi = mysql_query("SELECT Uwagi_damaz FROM UWAGI_DAMAZ_TAB WHERE ID_nr_wiersza = '$nr_wiersza'") or die ("zle pytanie");
                                $rekord_uwagi = mysql_fetch_assoc($wynik_uwagi);
                                $uwagi_damaz = $rekord_uwagi['Uwagi_damaz'];
                                $polocz->close();
                                if($k >= $od_ktorego_wiersza)
                                {
                                    ///////////pole do wpisywania uwag damaz /////////////////////
                                    print"<TD align='center' id='td_kolor'>";		
                                        $tab_nr_wiersza[$w]=$nr_wiersza;
                                        print '<textarea NAME=uwagi_zapisz['.$w.'] cols=30 rows=2 margin-bottom: 5px>'.$uwagi_damaz.'</textarea>';			
                                        $w++;
                                    print"</TD>";
                                }else{
                                    print"<TD align='center' id='td_kolor' bgcolor=$kolor>$uwagi_damaz</TD>";
                                }
                                $k++;	
                            print"</TR>";  
                            }
                        //print"</TABLE>";
                        
                    //print"</td>";
                //print"</tr>";
                //print"<tr>";
                    //print"<td align=center>"; 
                        //print"<TABLE border=1 style='width: 100%; height: 100%;'>";
                            //print"<TR><TD width=2%></TD><TD width=2%></TD><TD width=5%></TD><TD width=5%></TD><TD width=2%></TD><TD width=3%></TD><TD width=10%></TD><TD width=2%></TD><TD width=10%></TD><TD width=2%></TD><TD width=10%></TD><TD width=2%></TD><TD width=2%></TD><TD width=2%></TD></TR>";
                            print"<TR><TD width=2%></TD><TD width=2%></TD><TD width=5%></TD><TD width=5%></TD><TD width=2%></TD><TD width=3%></TD>";
                            print"<TD width=10%>";
                                print "<INPUT TYPE=hidden NAME=wielkosc_tab_status_zaliczka VALUE=$ile_wierszy_status_zaliczka>";
                                for($i=0; $i<$ile_wierszy_status_zaliczka; $i++)
                                {
                                    print "<INPUT TYPE=hidden NAME=pobrany_nr_wiersza_status_zaliczka[$i] VALUE=$tab_nr_wiersza_status[$i]>";
                                    print "<INPUT TYPE=hidden NAME=pobrany_status_zaliczka[$i] VALUE=$tab_sprawdz_status[$i]>";
                                    
                                }
                                print'<br>';
                                print'<INPUT TYPE="submit" NAME="zmien_status_zaliczka" VALUE="Zmień status" CLASS="btn">';
                                print'<br>';
                            print"</TD>";
                            print"<TD width=2%></TD><TD width=10%></TD><TD width=2%></TD><TD width=10%></TD><TD width=2%></TD><TD width=2%></TD>";
                            
                            //print"<TR><TD width=10%></TD><TD width=2%></TD><TD width=5%></TD><TD width=5%></TD><TD width=15%></TD><TD width=43%></TD><TD width=10%></TD>";
                                print"<TD  width=2%>";
                                    print "<INPUT TYPE=hidden NAME=wielkosc_tab VALUE=$w>";
                                    for($i=0; $i<$w; $i++)
                                    {
                                        print "<INPUT TYPE=hidden NAME=pobrany_nr_wiersza[$i] VALUE=$tab_nr_wiersza[$i]>";				
                                    }
                                    print'<br>';
                                    print'<INPUT TYPE="submit" NAME="zapisz_uwagi" VALUE="Zapisz" CLASS="btn">';
                                    print'<br>';
                                print"</TD>";                               
                            print"</TR>";	
                        print"</TABLE>";
                        print'</FORM>';                      
                    print"</td>";
                print"</tr>";
            print"</TABLE>";
		//////////koniec wyświtlania tabeli zamówienia klienta////////////////
    }else
    { 
                /////wyswietlanie strony startowej KONTENERY !!!//////////////
    //////////////////kontener przyciski drukarnia////////////////////////////////////////////
            print'<div class="panel_1ogowanie">';
                require_once "wybierz_odbiorce.kontener_wybierz_odbiorce.php";
            print'</div>';
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";        
                //////////////////kontener przyciski drukarnia////////////////////////////////////////////
            print'<div class="panel_1ogowanie">';
                require_once "wybierz_odbiorce.kontener_drukarnia.php";
            print'</div>';
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";
                //////////////////kontener przyciski ZAMOWIENIA DAMAZ////////////////////////////////////////////
  
                if($_SESSION['uprawnienia'] == "marketing" || $_SESSION['uprawnienia'] == "kierownik" || $_SESSION['uprawnienia'] == "admin_strona")
                { 
                    print'<div class="panel_1ogowanie">';
                        require_once "wybierz_odbiorce.kontener_zamowienia_damaz.php";
                    print'</div>';
                }
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";  
                    //////////////////kontener przyciski DAMAZ////////////////////////////////////////////
                if($_SESSION['uprawnienia'] != "grafika")
                {  
                    print'<div class="panel_1ogowanie">';
                        require_once "wybierz_odbiorce.kontener_damaz.php";
                    print'</div>';
                }
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";       
                //////////////////kontener przyciski biuro projektowe////////////////////////////////////////////
                if($_SESSION['uprawnienia'] == "grafika" || $_SESSION['uprawnienia'] == "admin" || $_SESSION['uprawnienia'] == "admin_strona")
                { 
                    print'<div class="panel_1ogowanie">';
                        require_once "wybierz_odbiorce.kontener_biuro_projektowe.php";
                    print'</div>';
                }

    } 
        print"</td>";
    print"</tr>"; 
print"</TABLE>";


if(!$_POST['opcja'] && !$_POST['opcja02'])  ///NIE wyswietla gdy jest wybrany klient
{
print"</DIV>";
}else{
   print'<DIV class="dolny_do_tabeli">';
   print'</DIV>';
   print"<br><br><br><br><br><br><br><br><br><br><br><br><br>";
}

function zapisywanie_uwag()
{
	$ilosc = $_POST['wielkosc_tab'];
	for($i=0; $i<$ilosc; $i++)
	{
            $ID_nr_wiersza = $_POST['pobrany_nr_wiersza'][$i];
            $uwagi_do_zapisania = htmlspecialchars($_POST['uwagi_zapisz'][$i]);
		
            require_once 'class.Polocz.php';
            $polocz = new Polocz();
            $polocz->open();
            mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
            $wynik_nr_wiersza = mysql_query("SELECT ID_nr_wiersza FROM UWAGI_DAMAZ_TAB WHERE ID_nr_wiersza = '$ID_nr_wiersza'") or die ("zle pytanie zapisywanie uwagi");
            $rekord_nr_wiersza = mysql_fetch_assoc($wynik_nr_wiersza);
            $ID_nr_wiersza_uwagi = $rekord_nr_wiersza['ID_nr_wiersza'];
            if($ID_nr_wiersza_uwagi == "")
            {
                $query_uwagi = "INSERT INTO UWAGI_DAMAZ_TAB VALUES('$ID_nr_wiersza', '$uwagi_do_zapisania');";
                $wynik_uwagi = mysql_query($query_uwagi);
            }else{
                $query = "UPDATE UWAGI_DAMAZ_TAB SET Uwagi_damaz = '$uwagi_do_zapisania' WHERE ID_nr_wiersza = '$ID_nr_wiersza';";
                $wynik = mysql_query($query);
            }
            $polocz->close();
	}	
}
function zmiana_statusu()
{
    $ilosc = $_POST['wielkosc_tab_status_zaliczka'];
    
    require_once 'class.Polocz.php';
    $polocz = new Polocz();
    
    for($i=0; $i<=$ilosc; $i++)
    {
            $ID_nr_wiersza = $_POST['pobrany_nr_wiersza_status_zaliczka'][$i];
            $status_zaliczka = $_POST['pobrany_status_zaliczka'][$i];
            //print"<br>funkcja zmiana statusu";
            if($status_zaliczka == 'ZALICZKA')
            {
                //print"<br>funkcja zmiana statusu";

                //print_r($ID_nr_wiersza); print_r($status_zaliczka);
                       
                
                $polocz->open();
                mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                $query = "UPDATE ZAMOWIENIA_TAB SET Status_zamowienia = 'DO DRUKU' WHERE Nr_wiersza = '$ID_nr_wiersza';";
                $wynik = mysql_query($query);
                $polocz->close();  
            }
            
                
    }
}


?>
    <figure id="miniatura_zdjecia"></figure>
</body>
</html>
