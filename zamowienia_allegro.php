<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
        $zalogowany = $_SESSION['imie_nazwisko'];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl" xml:lang="pl">
<head>
	
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
            <script src = "js/jquery-1.11.0.min.js"> </script>
            <script src = "js/lightbox.min.js"> </script>
            <link href="css/lightbox.css" rel="stylesheet"/>
            <link rel="Stylesheet" media="print" type="text/css" href="dodruku.css" />
            <link href="css_wyglad_strony/style.css" rel="stylesheet" type="text/css"> 
            <link href="css_wyglad_strony/mobile_style.css" rel="stylesheet" type="text/css">
    <title>Zamówienia drukarnia</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="/resources/demos/style.css">
	<script>	
		$(function() {
		$( "#datepicker" ).datepicker();
		});
	</script>
        <script>	
		$(function() {
		$( "#datepicker02" ).datepicker();
		});
	</script>
	  
</head>
<body>
<?PHP

//print"<DIV class='panel_glowny'>";


print"<DIV class='do_tabeli'>";
       
        require_once 'class.Polocz.php';
        $polocz = new Polocz();
        $polocz->open();
        mysql_select_db("ZAMOWIENIA_ALLEGRO") or die ("nie ma zamowienia_allegro");
        $lista_nazwa_produktu = mysql_query("SELECT Nazwa_produktu FROM PRODUKTY_TAB ORDER BY Nazwa_produktu") or die ("zle pytanie nazwa produktu");
        $polocz->close();
        while($rekord_nazwa_produktu = mysql_fetch_assoc($lista_nazwa_produktu))
        {
            $nazwa_produktu[$i] = $rekord_nazwa_produktu['Nazwa_produktu'];
            $i++;   
        }
        $polocz->open();
        mysql_select_db("ZAMOWIENIA_ALLEGRO") or die ("nie ma zamowienia_allegro");
        $lista_dostawca = mysql_query("SELECT Nazwa_dostawcy FROM DOSTAWCA_TAB ORDER BY Nazwa_dostawcy") or die ("zle pytanie dostawcy");
        $polocz->close();
        while($rekord_dostawca = mysql_fetch_assoc($lista_dostawca))
        {
            $dostawcy[$i] = $rekord_dostawca['Nazwa_dostawcy'];
            $i++;   
        }
        $polocz->open();
        mysql_select_db("ZAMOWIENIA_ALLEGRO") or die ("nie ma zamowienia_allegro");
        $lista_kategori = mysql_query("SELECT Nazwa_kategori_dostawcy FROM KATEGORIA_DOSTAWCY_TAB ORDER BY Nazwa_kategori_dostawcy") or die ("zle pytanie dostawcy");
        $polocz->close();
        while($rekord_kategori = mysql_fetch_assoc($lista_kategori))
        {
            $kategoria[$i] = $rekord_kategori['Nazwa_kategori_dostawcy'];
            $i++;   
        }
        $polocz->open();
        mysql_select_db("ZAMOWIENIA_ALLEGRO") or die ("nie ma zamowienia_allegro");
        $lista_status = mysql_query("SELECT Nazwa_statusu FROM STATUS_ZAMOWIENIA_TAB ORDER BY Nazwa_statusu") or die ("zle pytanie dostawcy");
        $polocz->close();
        while($rekord_status = mysql_fetch_assoc($lista_status))
        {
            $statusy[$i] = $rekord_status['Nazwa_statusu'];
            $i++;   
        }
        if(isset($_POST['przycisk_szukaj']))///wcisniety przycisk szukaj
        {
            $filtr_nazwa_produktu_klucz = htmlspecialchars($_POST['filtr_nazwa_produktu_tex']);
            $filtr_dostawca_klucz = htmlspecialchars($_POST['filtr_dostawca_tex']);
            $filtr_kategoria_klucz = htmlspecialchars($_POST['filtr_kategoria_tex']);
            $filtr_status_klucz = htmlspecialchars($_POST['filtr_status_tex']);
            
            //$filtr_wzor = htmlspecialchars($_POST['filtr_wzor_tex']);
            //$_SESSION['odbiorca_wybrany_przy_zapisywaniu'] = "";
            //print"filtr wzor :";
            //print_r($filtr_klient);
            foreach($nazwa_produktu as $klucz => $wartosc)
            {
                //print"wchodzi_klucz.$klucz.=.$wartosc.<br>";
                if($klucz == $filtr_nazwa_produktu_klucz)
                {
                    $nazwa_produktu_wybrany = htmlspecialchars($wartosc);
                    //print"wchodzi";
                }
            }
            foreach($dostawcy as $klucz => $wartosc)
            {
                //print"wchodzi_klucz.$klucz.=.$wartosc.<br>";
                if($klucz == $filtr_dostawca_klucz)
                {
                    $dostawca_wybrany = htmlspecialchars($wartosc);
                    //print"wchodzi";
                }
            }
            foreach($kategoria as $klucz => $wartosc)
            {
                //print"wchodzi_klucz.$klucz.=.$wartosc.<br>";
                if($klucz == $filtr_kategoria_klucz)
                {
                    $kategoria_wybrana = htmlspecialchars($wartosc);
                    //print"wchodzi";
                }
            }
            foreach($statusy as $klucz_t => $wartosc_t)
            {
                //print"wchodzi_klucz.$klucz.=.$wartosc.<br>";
                if($klucz_t == $filtr_status_klucz)
                {
                    $status_wybrany = htmlspecialchars($wartosc_t);
                    //print"wchodzi";
                }
            }
            /*
            if($filtr_wzor != "")
            {
                $odbiorca_wybrany = "";
            }
             * 
             */
        }      
        
        
print"<TABLE cellpadding = '0'  cellspacing = '0' border = '0' style='width: 100%; height: 100%;'>";
    print"<tr>";
        print"<td align=center>";
            require_once "zalogowany_banery.php";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";  
            print"<DIV class='wiekszy_panel'>";
            print'<FORM ACTION="index.php" METHOD=POST>';
            print'<INPUT TYPE="submit" VALUE="Strona startowa" CLASS="btn">';
            print'</FORM>';       
        
            print "<br><B><font class='opis_paneli'>Zamówienia Allegro</font></B><br><br>";
  
            
                print'<FORM METHOD=POST>';
                
                    print"<div align=center>";
                    print"<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 style='width: 90%; height: 100%;'>";
                        print"<TR>";
                                                       
                            print"<TD valign=bottom style='width: 25%; text-align: left;'>";
                                print'<B><font class="opis_texbox">NAZWA PRODUKTU</font></B><br/>';                              
                                print'<SELECT class="opis_select" NAME="filtr_nazwa_produktu_tex" style="width: 98%;">';  
                                    
                                        //print("<OPTION VALUE=''>".'');
                                    foreach($nazwa_produktu as $klucz => $wartosc)
                                    {
                                        print("<OPTION VALUE=\"$klucz\">".$wartosc); 
                                    }
                                    if(isset($_POST['przycisk_szukaj']))///wcisniety przycisk szukaj
                                    {
                                        print("<OPTION SELECTED VALUE=\"$filtr_nazwa_produktu_klucz\">$nazwa_produktu_wybrany</OPTION>");   
                                    }
                                    
                                print'</SELECT>';
                            print"</TD>";                            
                            print"<TD valign=bottom style='width: 25%; text-align: left;'>"; 
                                print'<B><font class="opis_texbox">DOSTAWCA</font></B><br/>';
                                print'<SELECT class="opis_select" NAME="filtr_dostawca_tex" style="width: 98%;">';  
                                    
                                        //print("<OPTION VALUE=''>".'');
                                    foreach($dostawcy as $klucz_d => $wartosc_d)
                                    {
                                        print("<OPTION VALUE=\"$klucz_d\">".$wartosc_d); 
                                    }
                                    if(isset($_POST['przycisk_szukaj']))///wcisniety przycisk szukaj
                                    {
                                        print("<OPTION SELECTED VALUE=\"$filtr_dostawca_klucz\">$dostawca_wybrany</OPTION>");   
                                    }
                                    
                                print'</SELECT>';
                            print"</TD>";  
                            print"<TD valign=bottom style='width: 25%; text-align: left;'>"; 
                                print'<B><font class="opis_texbox">KATEGORIA</font></B><br/>';
                                print'<SELECT class="opis_select" NAME="filtr_kategoria_tex" style="width: 98%;">';  
                                    
                                        //print("<OPTION VALUE=''>".'');
                                    foreach($kategoria as $klucz_k => $wartosc_k)
                                    {
                                        print("<OPTION VALUE=\"$klucz_k\">".$wartosc_k); 
                                    }
                                    if(isset($_POST['przycisk_szukaj']))///wcisniety przycisk szukaj
                                    {
                                        print("<OPTION SELECTED VALUE=\"$filtr_kategoria_klucz\">$kategoria_wybrana</OPTION>");   
                                    }
                                    
                                print'</SELECT>';
                            print"</TD>"; 
                            print"<TD valign=bottom style='width: 25%; text-align: left;'>"; 
                                print'<B><font class="opis_texbox">STATUS</font></B><br/>';
                                print'<SELECT class="opis_select" NAME="filtr_status_tex" style="width: 98%;">';  
                                    
                                        //print("<OPTION VALUE=''>".'');
                                    foreach($statusy as $klucz_t => $wartosc_t)
                                    {
                                        print("<OPTION VALUE=\"$klucz_t\">".$wartosc_t); 
                                    }
                                    if(isset($_POST['przycisk_szukaj']))///wcisniety przycisk szukaj
                                    {
                                        print("<OPTION SELECTED VALUE=\"$filtr_status_klucz\">$status_wybrany</OPTION>");   
                                    }
                                    
                                print'</SELECT>';
                            print"</TD>";
                            
                        print"</TR>";
                        print"<TR>";
                            print"<TD valign=bottom style='width: 11%; text-align: right;'>";
                                if (isset($_POST['checkbox_data'])) 
                                {
                                    print '<input type="checkbox" NAME="checkbox_data" VALUE="false" checked><B><font class="opis_texbox"> DATA :</font></B>';
                                }
                                else 
                                {
                                    print '<input type="checkbox" NAME="checkbox_data" VALUE="true"><B><font class="opis_texbox"> DATA :</font></B>';
                                }
                            print"</TD>";
                            print"<TD valign=bottom style='width: 12%; text-align: left;'>";
                                if($_POST['data_od'] == "")
                                {
                                    $data_miesiac_p=date("m");
                                    $data_dzien_p=date("d");
                                    $data_rok_p=date("Y");
                                    $data_wybrana_od = $data_rok_p."-".$data_miesiac_p."-".$data_dzien_p;
                                }else{
                                    $data_wybrana_od = $_POST['data_od'];
                                }
                                
                                print'<B><font class="opis_texbox">DATA OD</font></B><br/>';
                                print"<input class='text_box' type='date' name='data_od' value='".$data_wybrana_od."'>";
                               
                               
                                
                            print"</TD>";                             
                            print"<TD valign=bottom style='width: 12%; text-align: left;'>";
                                if($_POST['data_do'] == "")
                                {
                                    $data_miesiac_p=date("m");
                                    $data_dzien_p=date("d");
                                    $data_rok_p=date("Y");
                                    //$data_wybrana_do = $data_miesiac_p."/".$data_dzien_p."/".$data_rok_p;
                                    $data_wybrana_do = $data_rok_p."-".$data_miesiac_p."-".$data_dzien_p;
                                }else{
                                    $data_wybrana_do = $_POST['data_do'];
                                }
                                print'<B><font class="opis_texbox">DATA DO</font></B><br/>';
                                print"<input class='text_box' type='date' name='data_do' value='".$data_wybrana_do."'>";
                                
                            print"</TD>";                 
                            print"<TD valign=bottom style='width: 5%; text-align: center;'>";
                                print "";
                                print'<INPUT TYPE="submit" NAME="przycisk_szukaj" VALUE="Szukaj" CLASS="btn" style="width: 100%;">';  
                            print"</TD>";
                        print"</tr>";
                    print"</TABLE>";
                    print"</div>";
                print"</div>";
                print"</FORM>";                   
                         	
                                ////////////koniec textbox filtrowanie  ///////////////////////////       
        print"</td>";       
    print"</tr>";
print"</TABLE>";
        
print"</DIV>";
    
print"<div align=center>";
            print"<TABLE border = '0' style='width: 95%; height: 100%;'>";
                print"<TR><TD id='td_kolor' width=29% bgcolor = #6666ff><B>NAZWA PRODUKTU</B></TD><TD id='td_kolor' width=2% bgcolor = #6666ff><B>ILOŚĆ</B></TD><TD id='td_kolor' width=10% bgcolor = #6666ff><B>SZT./OP./L</B></TD><TD id='td_kolor' width=10% bgcolor = #6666ff><B>CENA</B></TD><TD id='td_kolor' width=10% bgcolor = #6666ff><B>SUMA</B></TD><TD id='td_kolor' width=10% bgcolor = #6666ff><B>DOSTAWCA</B></TD><TD id='td_kolor' width=10% bgcolor = #6666ff><B>KATEGORIA</B></TD><TD id='td_kolor' width=10% bgcolor = #6666ff><B>STATUS</B></TD><TD id='td_kolor' width=5% bgcolor = #6666ff><B>FAKTURA</B></TD><TD id='td_kolor' width=2% bgcolor = #6666ff><B>FAKTURA KSIĘ.</B></TD><TD id='td_kolor' width=2% bgcolor = #6666ff><B>FAKTURA E P</B></TD></TR>";
                if(isset($_POST['przycisk_szukaj']))///wcisniety przycisk szukaj
                {
                    $polocz->open();
                    mysql_select_db("ZAMOWIENIA_ALLEGRO") or die ("nie ma zamowienia_drukarnia");                      
                    //$wynik = mysql_query("SELECT ID_odrobienia_wzorow, Klient, IF((SELECT Wzory_zamowienia FROM ZAMOWIENIA_TAB WHERE Uwagi LIKE '%$filtr_wzor%' LIMIT 1),(SELECT Wzory_zamowienia FROM ZAMOWIENIA_TAB WHERE Uwagi LIKE '$filtr_wzor' LIMIT 1),"") AS Numer_wzoru, Nazwa_wzoru_konwertowanie, Nazwa_wzoru_poprawianie, Projektantka, Uwagi, Data FROM ODROBIENIA_WZOROW_TAB WHERE Nazwa_wzoru_konwertowanie LIKE '$filtr_wzor' OR Nazwa_wzoru_poprawianie LIKE '$filtr_wzor'") or die ("zle pytanie");
                    //$wynik = mysql_query("(SELECT Nazwa_wzoru_konwertowanie FROM ODROBIENIA_WZOROW_TAB WHERE Nazwa_wzoru_konwertowanie LIKE '%$filtr_wzor%' OR Nazwa_wzoru_poprawianie LIKE '%$filtr_wzor%')") or die ("zle pytanie");

                    if (isset($_POST['checkbox_data'])) ///uwzględniaj datę
                    {
                        $wynik = mysql_query("SELECT * FROM view_zamowienia_dzialow WHERE Nazwa_produktu LIKE '%$wybrana_nazwa_artykulu%' AND Nazwa_dostawcy LIKE '%$dostawca_wybrany%' AND Nazwa_kategori_dostawcy LIKE '%$kategoria_wybrana%' AND Nazwa_statusu LIKE '%$status_wybrany%' AND Data_zamowienia >= '$data_wybrana_od' AND Data_zamowienia <= '$data_wybrana_do' ORDER BY Data_zamowienia, Nazwa_dzialy_produkcji, Nazwa_dostawcy, Nazwa_kategori_dostawcy, Nazwa_statusu, Nazwa_produktu") or die ("błąd zapytania");
                        $polocz->close();
                    } else {
                        $wynik = mysql_query("SELECT * FROM view_zamowienia_dzialow WHERE Nazwa_produktu LIKE '%$wybrana_nazwa_artykulu%' AND Nazwa_dostawcy LIKE '%$dostawca_wybrany%' AND Nazwa_kategori_dostawcy LIKE '%$kategoria_wybrana%' AND Nazwa_statusu LIKE '%$status_wybrany%' ORDER BY Data_zamowienia, Nazwa_dzialy_produkcji, Nazwa_dostawcy, Nazwa_kategori_dostawcy, Nazwa_statusu, Nazwa_produktu") or die ("błąd zapytania");
                        $polocz->close();
                    }

                    $data_dzisiaj=date("Y-m-d");
                    $data_zamowienia_zapamietaj = "";
                    $dzial_produkcji_zapamietaj = "";
                    $suma_allegro = 0;
                    $suma_dostawcy = 0;
                    while($rekord = mysql_fetch_assoc($wynik))
                    {
                        $data_zamowienia = $rekord['Data_zamowienia'];
                        $dzial_produkcji = $rekord['Nazwa_dzialy_produkcji'];                     
                        $nazwa_produktu_do_wyswietlenia = $rekord['Nazwa_produktu'];
                        $ilosc_produktow = $rekord['Ilosc_produktow'];
                        $sztuki_opakowania_litry = $rekord['Sztuki_opakowania_litry'];
                        $cena_produktu = $rekord['Cena_produktu'];                  
                        $suma_do_zaplaty = $rekord['Suma_do_zaplaty'];
                        $nazwa_dostawcy = $rekord['Nazwa_dostawcy'];
                        $nazwa_kategori = $rekord['Nazwa_kategori_dostawcy'];
                        $nazwa_statusu = $rekord['Nazwa_statusu'];
                        $faktura = $rekord['Faktura'];
                        $faktura_ksiegowosc = $rekord['Faktura_wyslana_do_ksiegowosci'];
                        $faktura_E_P = $rekord['Faktura_E_P'];
                        
                        if($nazwa_kategori == "Allegro")
                        {
                            $suma_allegro += $suma_do_zaplaty;
                        }
                        if($nazwa_kategori == "Dostawcy")
                        {
                            $suma_dostawcy += $suma_do_zaplaty;
                        }
                        

                        if($data_zamowienia_zapamietaj != $data_zamowienia)
                        {
                            $kolor = '#B8B8B8';
                            print"<TR><TD id='td_kolor' bgcolor=$kolor><b><font size='4' color='blue'>$data_zamowienia</font></b></TD><TD id='td_kolor' align = 'left' bgcolor=$kolor></TD><TD id='td_kolor' align = 'left' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' align='center' bgcolor=$kolor></TD><TD id='td_kolor' align='center' bgcolor=$kolor></TD><TD id='td_kolor' align='center' bgcolor=$kolor></TD><TD id='td_kolor' align='center' bgcolor=$kolor></TD><TD id='td_kolor' align='center' bgcolor=$kolor></TD><TD id='td_kolor' align='center' bgcolor=$kolor></TD>";

                            $data_zamowienia_zapamietaj = $data_zamowienia;
                        }
                        if($dzial_produkcji_zapamietaj != $dzial_produkcji)
                        {
                            $kolor = '#33FF66';
                            print"<TR><TD id='td_kolor' bgcolor=$kolor><b><font size='3' color='red'>$dzial_produkcji</font></b></TD><TD id='td_kolor' align = 'left' bgcolor=$kolor></TD><TD id='td_kolor' align = 'left' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' align='center' bgcolor=$kolor></TD><TD id='td_kolor' align='center' bgcolor=$kolor></TD><TD id='td_kolor' align='center' bgcolor=$kolor></TD><TD id='td_kolor' align='center' bgcolor=$kolor></TD><TD id='td_kolor' align='center' bgcolor=$kolor></TD><TD id='td_kolor' align='center' bgcolor=$kolor></TD>";

                            $dzial_produkcji_zapamietaj = $dzial_produkcji;
                        }

                        $kolor = '#FFFFFF';
                        
                        if($nazwa_statusu == "Zamówione")
                        {
                            $kolor = '#CCFFFF';
                        }
                        if($nazwa_statusu == "Dostarczone")
                        {
                            $kolor = '#FFFF66';
                        }
                        
                        
                        print"<TR><TD id='td_kolor' bgcolor=$kolor>$nazwa_produktu_do_wyswietlenia</TD><TD id='td_kolor' align = 'center' bgcolor=$kolor>$ilosc_produktow</TD><TD id='td_kolor' align = 'center' bgcolor=$kolor>$sztuki_opakowania_litry</TD><TD id='td_kolor' align = 'right' bgcolor=$kolor>$cena_produktu</TD><TD id='td_kolor' align = 'right' bgcolor=$kolor>$suma_do_zaplaty</TD><TD id='td_kolor' align='center' bgcolor=$kolor>$nazwa_dostawcy</TD><TD id='td_kolor' align='center' bgcolor=$kolor>$nazwa_kategori</TD><TD id='td_kolor' align='center' bgcolor=$kolor>$nazwa_statusu</TD><TD id='td_kolor' align='center' bgcolor=$kolor>$faktura</TD><TD id='td_kolor' align='center' bgcolor=$kolor>$faktura_ksiegowosc</TD><TD id='td_kolor' align='center' bgcolor=$kolor>$faktura_E_P</TD>";


                    }
                }
                print"</TR>";
            print"</TABLE>";  
            
            
        
        
print"</DIV>";

print"<br><br><br><br><br><br><br><br><br><br><br><br><br>";

print '<DIV id="panel_dolny_ilosc_do_druku" class="dolny_do_tabeli">';
                        print '<DIV class="mniejszy_panel">';
                            print "<B><font class='opis_paneli'>Allegro :  "; echo number_format(floatval($suma_allegro), 2); print"   zł</font></B><br>"; 
                            print "<B><font class='opis_paneli'>Dostawcy :  "; echo number_format(floatval($suma_dostawcy), 2); print"   zł</font></B><br>"; 
                            
                            //print "<B><font class='opis_paneli'>Allegro :  "; echo (int)"$suma_allegro"; print"   zł</font></B><br>"; 
                             
                                                     
                        print "</DIV>";
print"</DIV>";

?>        
        
</body>




