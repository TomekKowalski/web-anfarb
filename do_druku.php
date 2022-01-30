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
<?PHP
/*
<meta charset="utf-8">
  */
  
      
print'<DIV class="do_tabeli">';
print"<TABLE  cellpadding = '0'  cellspacing = '0' border = '0' style='width: 100%; height: 100%;'>";
    print"<tr>";
        print"<td align=center>";
            require_once "zalogowany_banery.php";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";
                        require_once 'class.Polocz.php';
                        $polocz = new Polocz();
                        $polocz->open();
                        mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                        $lista_odbiorca = mysql_query("SELECT DISTINCT * FROM ODBIORCA_TAB ORDER BY Nazwa_odbiorca") or die ("zle pytanie");
                        $polocz->close();
            /////////przycisk i nazwa odbiorcy/////////////////////
                        print'<DIV id="panel_filtr_ilosc_do_druku" class="mniejszy_panel">';           
                            print'<FORM ACTION="index.php" METHOD=POST>';
                            print'<INPUT TYPE="submit" VALUE="Strona startowa" CLASS="btn">';
                            print'</FORM>';
                            print "<br><B><font class='opis_paneli'>Ilość sztuk do druku</font></B><br><br>";
                                ////////////////comboBox artykul //////////////////////////////
                            print"<TABLE cellpadding = '0'  cellspacing = '0' border = '0' style='width: 100%;'>";
                                print"<tr>";
                                    print"<td style='width: 80%;'>";
                                        print'<FORM ACTION="do_druku.php" METHOD=POST>';
                                        print '<INPUT TYPE="hidden" NAME="co" VALUE="artykul">';
                                        print'<SELECT class="opis_select" NAME="art_wybrany" style="width: 95%;">';
                                            $polocz->open();
                                            mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                                            $lista_szukaj_artykul = mysql_query("SELECT Nazwa_artykul FROM ARTYKUL_TAB WHERE Nazwa_artykul LIKE '%$szukany_artykul%' ORDER BY Nazwa_artykul;") or die ("zle pytanie");
                                            $polocz->close();
                                            while($rekord_szukaj_artykul = mysql_fetch_assoc($lista_szukaj_artykul)){
                                               $artykuly_wyszukane[$i] = $rekord_szukaj_artykul['Nazwa_artykul'];
                                               print("<OPTION VALUE=\"$artykuly_wyszukane[$i]\">".$artykuly_wyszukane[$i]);
                                               $i++;   
                                            }  
                                        print'</SELECT>';
                                    print"</td>";
                                    print"<td style='width: 20%;'>";
                                        print'<INPUT TYPE="submit" VALUE="Wybierz artykuł" CLASS="btn">';
                                        print'</FORM>';
                                    print"</td>";
                                print"</tr>";
                            print"</TABLE>"; 
                            
                        print"</DIV>";
        
        print"</td>";
    print"</tr>";
print"</TABLE>";
print"</DIV>";
    
    print"<div align=center>";
            print"<TABLE cellpadding = '0'  cellspacing = '0' border = '0' style='width: 98%; height: 100%;'>";
                print"<tr>";
                    print"<td>";
                        
                          
                        if($_POST['co'] == 'artykul')
                        {
                            $artykul = $_POST['art_wybrany'];
                            $status_do_druku = "DO DRUKU";
                            $polocz->open();
                            $wynik = mysql_query("SELECT * FROM ZAMOWIENIA_TAB WHERE Status_zamowienia = '$status_do_druku' AND Artykul_zamowienia = '$artykul' ORDER BY Odbiorca_zamowienia;") or die ("zle pytanie");
                            $polocz->close();
                            print"<B><font size=3 color=#00004d>$artykul</font></B><br/>";
                        }else{
                            $status_do_druku = "DO DRUKU";
                            $polocz->open();
                            $wynik = mysql_query("SELECT * FROM ZAMOWIENIA_TAB WHERE Status_zamowienia = '$status_do_druku' ORDER BY Odbiorca_zamowienia;") or die ("zle pytanie");
                            $polocz->close();
                            print"<B><font size=3 color=#00004d>$artykul</font></B><br/>";
                        }
                        print"<TABLE>";
                            print"<TR bgcolor = #6666ff><TD id='td_kolor' width=2%><B>ARTYKUŁ</B></TD><TD id='td_kolor' width=2%><B>ILOŚĆ</B></TD><TD id='td_kolor' width=2%><B> M./SZT. </B></TD><TD id='td_kolor' width=5%><B>NR PARTI</B></TD><TD id='td_kolor' width=2%><B>WZÓR</B></TD><TD id='td_kolor' width=2%><B>UWAGI</B></TD><TD id='td_kolor' width=2%><B>STATUS</B></TD><TD id='td_kolor' width=2%><B>DATA ZAMÓWIENIA DZIANINY</B></TD><TD id='td_kolor' width=2%><B>DATA PRZYSŁANIA DZIANINY</B></TD></TR>";
                                $temp_zamowienie = 0;
                                $temp_odbiorca = "";
                                $k=0;
                                $ilosc_sztuk = 0;
                                $ilosc_metrow = 0;
                                $ktory_wiersz = 0;
                                while($rekord = mysql_fetch_assoc($wynik))
                                { 
                                    $odbiorca_zamowienia = $rekord['Odbiorca_zamowienia'];
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
                                        //////////////zliczanie sztuk / metrow ////////////////////////////
                                    if($status_metrow == "sztuk")
                                    {
                                      $ilosc_sztuk += $ilosc;      
                                    }
                                    if(($status_metrow == "raport(y)") || ($status_metrow == "metr(y)"))
                                    {
                                      $ilosc_metrow += $ilosc;
                                    }
                                    $kolor = '#FFFFFF'; 
                                    if($temp_odbiorca != $odbiorca_zamowienia)
                                    {
                                        $kolor = '#33FF66';                                       
                                        print"<TR><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='black'>Odbiorca:</font></B></TD><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='black'>$odbiorca_zamowienia</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>";
                                        $temp_odbiorca = $odbiorca_zamowienia;
                                    }
                                    if($temp_zamowienie != $zamowienie_nr)
                                    {
                                        $kolor = '#B8B8B8';
                                        print"<TR><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>Zamówienie nr..</font></B></TD><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>$zamowienie_nr</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD bgcolor=$kolor><B><font size='4' color='blue'>Data..</font></B></TD><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>$data</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>";
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
                                    if($status == 'MAGAZYN_DAMAZ')
                                    {
                                      $kolor = '#00CC33';
                                    }
                            print"<TR><TD id='td_kolor' bgcolor=$kolor>$artykul_zamowienia</TD><TD id='td_kolor' align='right' bgcolor=$kolor>$ilosc</TD><TD id='td_kolor' align = 'center' bgcolor=$kolor>$status_metrow</TD><TD id='td_kolor' bgcolor=$kolor>$nr_parti</TD><TD id='td_kolor' bgcolor=$kolor><a href='WZORY_JPG_WSZYSTKIE/$wzor.jpg' data-lightbox='$wzor.jpg' data-title='$wzor'><div id='td_wzor".$ktory_wiersz."' class=''>$wzor</div></a></TD><TD id='td_kolor' bgcolor=$kolor>$uwagi</TD><TD id='td_kolor' bgcolor=$kolor>$status</TD>";	
                                    $ktory_wiersz ++;
                                    /////////////////pola do wpisywania daty alertow//////////////////////////
                                    $polocz->open();
                                    $wynik_data_zamowienia_dzianiny = mysql_query("SELECT `Data_zamowienia_dzianiny` FROM `ALERTY_TAB` WHERE `ID_nr_wiersza` = '$nr_wiersza'") or die ("zle pytanie data zamowienia dzianiny");
                                    $rekord_data_zamowienia_dzianiny = mysql_fetch_assoc($wynik_data_zamowienia_dzianiny);
                                    $data_zamowienia_dzianiny = $rekord_data_zamowienia_dzianiny['Data_zamowienia_dzianiny'];
                                    $polocz->close();
                                print"<TD id='td_kolor' align=center bgcolor=$kolor>$data_zamowienia_dzianiny</TD>";
                                    $polocz->open();
                                    $wynik_data_przyslania_dzianiny = mysql_query("SELECT `Data_przyslania_dzianiny` FROM `ALERTY_TAB` WHERE `ID_nr_wiersza` = '$nr_wiersza'") or die ("zle pytanie data przyslania_dzianiny");
                                    $rekord_data_przyslania_dzianiny = mysql_fetch_assoc($wynik_data_przyslania_dzianiny);
                                    $data_przyslania_dzianiny = $rekord_data_przyslania_dzianiny['Data_przyslania_dzianiny'];
                                    $polocz->close();
                                print"<TD id='td_kolor' align=center bgcolor=$kolor>$data_przyslania_dzianiny</TD>";
                            print"</TR>";       
                                    $k++;
                                }
                        print"</TABLE>"; 
                            $ilosc_metrow = $ilosc_metrow/45;
                            $ilosc_sztuk += $ilosc_metrow;

                        
                    print"</td>";
                print"</tr>";  
            print"</TABLE>";
    print"</DIV>";  
    print"<br><br><br><br><br><br><br><br><br><br><br><br><br>";
print '<DIV id="panel_dolny_ilosc_do_druku" class="dolny_do_tabeli">';
                        print '<DIV class="mniejszy_panel">';
                            print "<B><font class='opis_paneli'>Do druku :  "; echo (int)"$ilosc_sztuk"; print"   sztuk</font></B><br>"; 
                            /*
                            print'<FORM ACTION="wykres_ile_do_druku.php" METHOD=POST>';
                            print'<INPUT TYPE="submit" VALUE="Wykres" CLASS="btn">';
                            print'</FORM>';
                             * 
                             */	                          
                        print "</DIV>";
print"</DIV>";

?>

    <figure id="miniatura_zdjecia"></figure>

</body>
</html>
