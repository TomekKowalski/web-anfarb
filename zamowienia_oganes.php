<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany_hmajak']))
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
      <link href="css_wyglad_strony/style.css" rel="stylesheet" type="text/css">
      <link rel="Stylesheet" media="print" type="text/css" href="dodruku.css" />
      <title>Zamówienia drukarnia</title>
	  
</head>

<body>
<?PHP

print"<DIV class='do_tabeli'>";

print"<TABLE cellpadding = '0'  cellspacing = '0' border = '0' style='width: 100%; height: 100%;'>";
    print"<tr>";
        print"<td align=center>";
            require_once "zalogowany_banery.php";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";
            print"<TABLE cellpadding = '0'  cellspacing = '0' border = '0' style='width: 100%; height: 100%;'>";
                print"<tr>";
                    print"<td align = center>";
                        require_once 'class.Polocz.php';
                        $polocz = new Polocz();
                        $polocz->open();
                        mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                        $lista_odbiorca = mysql_query("SELECT DISTINCT * FROM ODBIORCA_TAB ORDER BY Nazwa_odbiorca") or die ("zle pytanie");
                        $polocz->close();
                            ////////////wyszukiwanie wszystkich wybranego odbiorcy
                        $rok = array('2013' => '2013','2014' => '2014', '2015' => '2015', '2016' => '2016', '2017' => '2017', '2018' => '2018', '2019' => '2019', '2020' => '2020', '2021' => '2021', '2022' => '2022');
                        $wybrany_rok = "2022";
                        $wybrany_rok_combobox = "2022";
                        $status = array('' => '','DO AKCEPTACJI' => 'DO AKCEPTACJI', 'DO DRUKU' => 'DO DRUKU', 'STABILIZACJA' => 'STABILIZACJA');
                        
                        if($_POST['filtr_uwagi'])
                        {		
                            $_SESSION['filtr_uwagi'] = htmlspecialchars($_POST['filtr_uwagi_tex']);
                            $_SESSION['filtr_wzor'] = htmlspecialchars($_POST['filtr_wzor_tex']);
                            $odbiorca = $_SESSION['odbiorca'];
                            $wybrany_rok = $_SESSION['rok'];
                            //$wybrany_status = $_SESSION['status'];
                            $filtr_uwagi = $_SESSION['filtr_uwagi'];
                            $filtr_wzor = $_SESSION['filtr_wzor'];  
                            $wybrany_status_combobox = htmlspecialchars($_POST['status_filtr']);
                            $wybrany_status = $wybrany_status_combobox;
                            if($_POST['rok_filtr_uwagi'])
                            {               
                                $wybrany_rok = $_POST['rok_filtr_uwagi'];
                                $_SESSION['rok'] = $wybrany_rok;
                                $wybrany_rok_combobox = $wybrany_rok;
                            } 
                            else
                            {
                                $wybrany_rok = "2022";
                                $wybrany_rok_combobox = "2022";
                            }
                        }
                        $odbiorca = "CZECHY";
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
                        
                    print"</td>";
                print"</tr>";
                print"<tr>";
                    print"<td align = center height = 20px>";
                    print"</td>";
                print"</tr>";
                print"<tr>";
                    print"<td align = center>";
                        print"<DIV id='panel_filtrowanie' class='wiekszy_panel'>";
                        print"<div align=center>";
                        print "<br><B><font size='5' color='blue'>$odbiorca</font></B><br><br>";
                        //print"<div id='testHmajak01'>Test</div>'";
                        ////////////text box do filtrowania uwag /////////////////////////// 
                        print'<FORM ACTION="zamowienia_oganes.php" METHOD=POST>';
                        print"<TABLE id=niedrukuj CELLPADDING=0 CELLSPACING=0 BORDER=0 style='width: 90%; height: 100%;'>";
                            print"<TR>";                      
                                print"<TD style='width: 35%; text-align: left;'>"; 
                                    print'<B><font size=2 color=#00004d>WZÓR</font></B><br/>';
                                    print '<INPUT style="width: 95%;" TYPE="text" NAME="filtr_wzor_tex" VALUE="'.$filtr_wzor.'">'; 
                                print"</TD>";              
                                print"<TD style='width: 35%; text-align: left;'>";
                                    print'<B><font size=2 color=#00004d>UWAGI</font></B><br/>';
                                    print '<INPUT style="width: 95%" TYPE="text" NAME="filtr_uwagi_tex" VALUE="'.$filtr_uwagi.'">'; 
                                print"</TD>"; 
                                print"<TD valign=bottom style='width: 10%; text-align: left;'>";                                   
                                    print'<B><font size=2 color=#00004d>STATUS</font></B><br/>';
                                    print'<SELECT NAME="status_filtr" style="width: 95%;">';
                                        print"<OPTION SELECTED VALUE=\"$wybrany_status_combobox\">$wybrany_status_combobox</OPTION>";
                                        foreach($status as $klucz => $wartosc)
                                        {
                                            print("<OPTION VALUE=\"$klucz\">".$wartosc);
                                        }
                                    print'</SELECT>'; 
                                print"</TD>";
                                print"<TD valign=bottom style='width: 5%; text-align: left;'>";
                                    ////////////combobox 02//////////////////
                                    print'<SELECT NAME="rok_filtr_uwagi" style="width: 98%;">';
                                        print"<OPTION SELECTED VALUE='$wybrany_rok_combobox'>$wybrany_rok_combobox</OPTION>";
                                        foreach($rok as $klucz => $wartosc)
                                        {
                                            print("<OPTION VALUE=\"$klucz\">".$wartosc);
                                        }
                                    print'</SELECT>'; 
                                print"</TD>"; 
                                print"<TD valign=bottom style='width: 1%; text-align: left;'>";
                                print"</TD>";
                                print"<TD valign=bottom style='width: 4%; text-align: left;'>";
                                    print "";
                                    print'<INPUT style="width: 100%;" TYPE="submit" NAME="filtr_uwagi" VALUE="Filtruj" CLASS="btn">';  
                                print"</TD>";  
                                print"<TD valign=bottom style='width: 1%; text-align: left;'>";
                                print"</TD>";  
                                
                            print'</FORM>';
                                print"<TD valign=bottom style='width: 9%; text-align: right;'>";                               
                                    print'<FORM ACTION="formularz_nowe_zamowienie_oganes.php" METHOD=POST>';                                                           
                                        print'<INPUT style="width: 100%;" TYPE="submit" VALUE="Nowe zamowienie" CLASS="btn">';                           
                                    print'</FORM>';
                                 
                                 
                                print"</TD>";
                            print"</TR>";
                        print"</TABLE>";
                        print"</div>";
                        print"</div>";
                    print"</td>";
                print"</tr>";              
            print"</TABLE>";
        print"</td>";
    print"</tr>";   
print"</TABLE>";
print"</DIV>";

                    print"<div align=center>";
                        print"<TABLE BORDER=0 style='width: 98%; height: 100%;'>";
                            ////////////////początek tabeli/////////////////////////
                            print"<TR bgcolor = #6666ff><TD id='td_kolor' width=10%><B>ARTYKUŁ</B></TD><TD id='td_kolor' width=2%><B>ILOŚĆ</B></TD><TD id='td_kolor' width=5%><B> M./SZT. </B></TD><TD id='td_kolor' width=5%><B>NR PARTI</B></TD><TD id='td_kolor' width=15%><B>WZÓR</B></TD><TD id='td_kolor' width=43%><B>UWAGI</B></TD></TR>\n";
                            $temp_zamowienie = 0;
                            $k=0;
                            $w=0;
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
                                //$nr_parti = $rekord['Nr_parti'];
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
                                    print"<TR><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>Zamówienie nr..</font></B></TD><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>$zamowienie_nr</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD bgcolor=$kolor><B><font size='4' color='blue'>Data..</font></B></TD><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>$data</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>";
                                    $temp_zamowienie = $zamowienie_nr; 	
                                }
                                $kolor = '#FFFFFF';
                                if($status == 'MAGAZYN_DAMAZ')
                                {
                                    $kolor = '#00CC33';
                                }
                                if($status == 'DO AKCEPTACJI')
                                {
                                    $kolor = '#ffe6e6';
                                }
                                if($status == 'STABILIZACJA')
                                {
                                    $kolor = '#99FF99';   
                                }
                                print"<TR><TD id='td_kolor' bgcolor=$kolor>$artykul_zamowienia</TD><TD id='td_kolor' align='right' bgcolor=$kolor>$ilosc</TD><TD id='td_kolor' align = 'center' bgcolor=$kolor>$status_metrow</TD><TD id='td_kolor' bgcolor=$kolor>$nr_parti</TD><TD id='td_kolor' bgcolor=$kolor><a href='WZORY_JPG_WSZYSTKIE/$wzor.jpg' data-lightbox='$wzor.jpg' data-title='$wzor'><div id='td_wzor".$ktory_wiersz."' class=''>$wzor</div></a></TD><TD id='td_kolor' bgcolor=$kolor>$uwagi</TD>";	
                                print"</TR>";  
                                $ktory_wiersz ++;
                            }
                        print"</TABLE>";
                    print"</div>";
print"<DIV class='dolny_do_tabeli'>";
print"</DIV>";
 print"<br><br><br><br><br><br><br><br><br><br><br><br><br>"

//print"<div id='testHmajak'>Test: <br></div>";
?>
    <figure id="miniatura_zdjecia"></figure>    
</body>
</html>
