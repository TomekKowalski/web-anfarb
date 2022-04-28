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

print"<DIV class='panel_glowny'>";
       
        require_once 'class.Polocz.php';
        $polocz = new Polocz();
        $polocz->open();
        mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
        $lista_odbiorca = mysql_query("SELECT Nazwa_odbiorca FROM ODBIORCA_TAB ORDER BY Nazwa_odbiorca") or die ("zle pytanie");
        $polocz->close();
        while($rekord_odbiorca = mysql_fetch_assoc($lista_odbiorca))
        {
            $odbiorcy[$i] = $rekord_odbiorca['Nazwa_odbiorca'];
            $i++;   
        }
        if(isset($_POST['przycisk_szukaj']))///wcisniety przycisk szukaj
        {
            $filtr_klient_klucz = htmlspecialchars($_POST['filtr_klient_tex']);
            $filtr_wzor = htmlspecialchars($_POST['filtr_wzor_tex']);
            $_SESSION['odbiorca_wybrany_przy_zapisywaniu'] = "";
            //print"filtr wzor :";
            //print_r($filtr_klient);
            foreach($odbiorcy as $klucz => $wartosc)
            {
                //print"wchodzi_klucz.$klucz.=.$wartosc.<br>";
                if($klucz == $filtr_klient_klucz)
                {
                    $odbiorca_wybrany = htmlspecialchars($wartosc);
                    //print"wchodzi";
                }
            }
            if($filtr_wzor != "")
            {
                $odbiorca_wybrany = "";
            }
        }      
        
        if(isset($_POST['przycisk_zapisz']))///wcisniety przycisk zapisz
        {
            $zapisz_klient_klucz = htmlspecialchars($_POST['dodaj_klient_tex']);
            $wzor_wyslany_do_zapisania = htmlspecialchars($_POST['dodaj_wzor_wyslany_tex']);
            //$wzor_poprawiany_do_zapisania = htmlspecialchars($_POST['dodaj_wzor_poprawiany_tex']);
            $uwagi_do_zapisania = htmlspecialchars($_POST['dodaj_uwagi_tex']);          
            $kto_zalogowany = $_SESSION['imie_nazwisko'];
            //print"filtr wzor :";
            //print_r($filtr_klient);
            //print_r($wzor_wyslany_do_zapisania);
            
            foreach($odbiorcy as $klucz => $wartosc)
            {
                //print"wchodzi_klucz.$klucz.=.$wartosc.<br>";
                if($klucz == $zapisz_klient_klucz)
                {
                    $odbiorca_wybrany_do_zapisania = htmlspecialchars($wartosc);
                    if($odbiorca_wybrany_do_zapisania != "")
                    {
                        $_SESSION['odbiorca_wybrany_przy_zapisywaniu'] = $odbiorca_wybrany_do_zapisania;
                    }
                    else 
                    {
                        $odbiorca_wybrany_do_zapisania = $_SESSION['odbiorca_wybrany_przy_zapisywaniu'];
                    }
                    //print"wchodzi";
                }
            }
            
        } 
        if($_POST['przycisk_usuwaj'])
        {
                                  //print"usuwaj ????";
            $nr_wiersza_dousuniecia = $_POST['usuwaj'];
                                  //print"wiersz do usuniecia = ";
                                  //print "$nr_wiersza_dousuniecia";
                                  
                                  
            $polocz->open();
            mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
            $query_usuwanie = mysql_query("DELETE FROM WYSLANE_WZORY_DO_KLIENTA_TAB WHERE ID_wyslane_wzory = '$nr_wiersza_dousuniecia'") or die ("zle zapytanie usuwania");
            $wynik_usuwanie = mysql_query($query_usuwanie);
            $polocz->close();
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
        
            print "<br><B><font class='opis_paneli'>Wzory wysłane do klienta</font></B><br><br>";
  
            if(isset($_POST['przycisk_zapisz']))///wcisniety przycisk zapisz
            {
                $data_miesiac_zapis=date("m");
                $data_dzien_zapis=date("d");
                $data_rok_zapis=date("Y");
                $data_do_zapisania_razem = $data_rok_zapis."-".$data_miesiac_zapis."-".$data_dzien_zapis;
                if($odbiorca_wybrany_do_zapisania == "")
                {
                    print "<font size='5' color='red'>Uwaga brak klienta do zapisania !!<br></font>";
                }
                
                if($wzor_wyslany_do_zapisania != "")
                {
                    
                    $polocz->open();
                    mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia"); 
                    $wynik = mysql_query("SELECT "
                            . "Nazwa_wzoru_wyslanego "
                            . "FROM WYSLANE_WZORY_DO_KLIENTA_TAB "
                            . "WHERE Nazwa_wzoru_wyslanego = '$wzor_wyslany_do_zapisania'") or die ("zle pytanie wzor konwertowanie");             
                    $polocz->close();
                    while($rekord = mysql_fetch_assoc($wynik))
                    {                                           
                        $filtr_wzor = $rekord['Nazwa_wzoru_wyslanego'];
                    }
                    if($filtr_wzor != "")
                    {
                        print "<font size='5' color='red'>Uwaga Wzór: $filtr_wzor jest już zapisany w bazie !!<br></font>";
                    }
                    
                }
                
                 
                /*
                if($wzor_poprawiany_do_zapisania != "")
                {
                    $polocz->open();
                    mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia"); 
                    $wynik = mysql_query("SELECT "
                            . "Nazwa_wzoru_poprawianie "
                            . "FROM ODROBIENIA_WZOROW_TAB "
                            . "WHERE Nazwa_wzoru_poprawianie = '$wzor_poprawiany_do_zapisania'") or die ("zle pytanie wzor poprawiany");             
                    $polocz->close();
                    while($rekord = mysql_fetch_assoc($wynik))
                    {                                           
                        $filtr_wzor = $rekord['Nazwa_wzoru_poprawianie'];
                    }
                    if($filtr_wzor != "")
                    {
                        print "<font size='5' color='red'>Uwaga Wzór: $filtr_wzor jest już zapisany w bazie !!<br></font>";
                    }                   
                }
                 * 
                 */
                if($odbiorca_wybrany_do_zapisania != "" && $filtr_wzor == "")
                {
                    //if($wzor_konwertowany_do_zapisania != "")
                    //{
                        //print"<br><br> wchodzi zapis konwertowany";
                        
                        if($wzor_wyslany_do_zapisania != "")
                        {
                            
                            $polocz->open();
                            mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                            $query = "INSERT INTO WYSLANE_WZORY_DO_KLIENTA_TAB(Klient, Nazwa_wzoru_wyslanego, Projektantka, Uwagi, Data) VALUES ('$odbiorca_wybrany_do_zapisania','$wzor_wyslany_do_zapisania','$kto_zalogowany','$uwagi_do_zapisania','$data_do_zapisania_razem')";
                            $wynik = mysql_query($query);
                            $polocz->close();                           
                        }
                        else
                        {
                            print "<font size='5' color='red'>Uwaga Nie podano wzoru do zapisania !!<br></font>";
                        }
                        /*
                        if($wzor_poprawiany_do_zapisania != "")
                        {
                            $polocz->open();
                            mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                            $query = "INSERT INTO ODROBIENIA_WZOROW_TAB(Klient, Nazwa_wzoru_konwertowanie, Nazwa_wzoru_poprawianie, Projektantka, Uwagi, Data) VALUES ('$odbiorca_wybrany_do_zapisania','','$wzor_poprawiany_do_zapisania','$kto_zalogowany','$uwagi_do_zapisania','$data_do_zapisania_razem')";                   
                            $wynik = mysql_query($query);
                            $polocz->close();
                        }
                         * 
                         */
                    //}                 
                    
                }
            }
                print'<FORM METHOD=POST>';
                
                    print"<div align=center>";
                    print"<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 style='width: 90%; height: 100%;'>";
                        print"<TR>";
                            print"<TD valign=top style='width: 11%; text-align: left;'>";
                                print '<input type="checkbox" NAME="checkbox_wzor_nr" VALUE="false"><B><font class="opis_texbox"> WZÓR NR </font></B>';
                            print"</TD>";                           
                            print"<TD valign=bottom style='width: 30%; text-align: left;'>";
                                print'<B><font class="opis_texbox">KLIENT</font></B><br/>';                              
                                print'<SELECT class="opis_select" NAME="filtr_klient_tex" style="width: 98%;">';  
                                    
                                    foreach($odbiorcy as $klucz => $wartosc)
                                    {
                                        print("<OPTION VALUE=\"$klucz\">".$wartosc); 
                                    }
                                    if(isset($_POST['przycisk_szukaj']))///wcisniety przycisk szukaj
                                    {
                                        print("<OPTION SELECTED VALUE=\"$filtr_klient_klucz\">$odbiorca_wybrany</OPTION>");   
                                    }
                                print'</SELECT>';
                            print"</TD>";                            
                            print"<TD valign=bottom style='width: 30%; text-align: left;'>"; 
                                print'<B><font class="opis_texbox">WZÓR</font></B><br/>';
                                print '<INPUT class="text_box" style="width: 95%;" TYPE="text" NAME="filtr_wzor_tex" VALUE="'.$filtr_wzor.'">';
                            print"</TD>";                            
                            print"<TD valign=bottom style='width: 12%; text-align: left;'>";
                                if($_POST['data_od'] == "")
                                {
                                    $data_miesiac_p=date("m");
                                    $data_dzien_p=date("d");
                                    $data_rok_p=date("Y");
                                    //$data_wybrana_od = $data_miesiac_p."/".$data_dzien_p."/".$data_rok_p;
                                    $data_wybrana_od = $data_rok_p."-".$data_miesiac_p."-".$data_dzien_p;
                                }else{
                                    $data_wybrana_od = $_POST['data_od'];
                                }
                                
                                print'<B><font class="opis_texbox">DATA OD</font></B><br/>';
                                //print"<input class='text_box' style=\"width: 80%;\" type=\"text\" id=\"datepicker\" name=\"data_od\" value=\"$data_wybrana_od\">";
                                print"<input class='text_box' type='date' name='data_od' value='".$data_wybrana_od."'>";
                               
                                /*
                                //////konvertowanie daty 2021/07/04  na 2021-07-04
                                $data_miesiac = substr($data_wybrana_od,0, 2);
                                $data_dzien = substr($data_wybrana_od,3, 2);
                                $data_rok = substr($data_wybrana_od,6, 5);

                                $data_razem = $data_rok."-".$data_miesiac."-".$data_dzien;
                                $data_wybrana_od = $data_razem;
                                 * 
                                 */
                                
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
                                //print"<input class='text_box' style=\"width: 80%;\" type=\"text\" id=\"datepicker02\" name=\"data_do\" value=\"$data_wybrana_do\">";
                                print"<input class='text_box' type='date' name='data_do' value='".$data_wybrana_do."'>";
                                /*
                                 //////konvertowanie daty 2021/07/04  na 2021-07-04
                                $data_miesiac = substr($data_wybrana_do,0, 2);
                                $data_dzien = substr($data_wybrana_do,3, 2);
                                $data_rok = substr($data_wybrana_do,6, 5);

                                $data_razem = $data_rok."-".$data_miesiac."-".$data_dzien;
                                $data_wybrana_do = $data_razem;
                                 * 
                                 */
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
    print"<tr>";
        print"<td height=20>";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";
            print"<TABLE>";
                print"<tr>";
                    print"<td>";
                        print'<a href="#dopisywanie_wzoru">';
                            print"<B><font size='1' color='blue'>DOPISZ WZÓR</font></B>";
                        print'</a>';
                    print"</td>";
                    print"<td width=10>";
                    print"</td>";
                    print"<td>";
                        print'<a href="#statystyki">';
                            print"<B><font size='1' color='blue'>STATYSTYKI</font></B>";
                        print'</a>';
                    print"</td>";
                print"</tr>";
            print"</TABLE>";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td height=20>";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";
            print"<TABLE border = '0' style='width: 95%; height: 100%;'>";
                print"<TR><TD id='td_kolor' width=10% bgcolor = #6666ff><B>KLIENT</B></TD><TD id='td_kolor' width=10% bgcolor = #6666ff><B>WZÓR NR</B></TD><TD id='td_kolor' width=20% bgcolor = #6666ff><B>WZÓR WYSŁANY DO KLIENTA</B></TD><TD id='td_kolor' width=10% bgcolor = #6666ff><B>UWAGI</B></TD><TD id='td_kolor' width=10% bgcolor = #6666ff><B>PROJEKTANTKA</B></TD><TD id='td_kolor' width=10% bgcolor = #6666ff><B>DATA</B></TD><TD id='td_kolor' width=10% bgcolor = #6666ff></TD></TR>";
                $polocz->open();
                mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");                      
                //$wynik = mysql_query("SELECT ID_odrobienia_wzorow, Klient, IF((SELECT Wzory_zamowienia FROM ZAMOWIENIA_TAB WHERE Uwagi LIKE '%$filtr_wzor%' LIMIT 1),(SELECT Wzory_zamowienia FROM ZAMOWIENIA_TAB WHERE Uwagi LIKE '$filtr_wzor' LIMIT 1),"") AS Numer_wzoru, Nazwa_wzoru_konwertowanie, Nazwa_wzoru_poprawianie, Projektantka, Uwagi, Data FROM ODROBIENIA_WZOROW_TAB WHERE Nazwa_wzoru_konwertowanie LIKE '$filtr_wzor' OR Nazwa_wzoru_poprawianie LIKE '$filtr_wzor'") or die ("zle pytanie");
                //$wynik = mysql_query("(SELECT Nazwa_wzoru_konwertowanie FROM ODROBIENIA_WZOROW_TAB WHERE Nazwa_wzoru_konwertowanie LIKE '%$filtr_wzor%' OR Nazwa_wzoru_poprawianie LIKE '%$filtr_wzor%')") or die ("zle pytanie");
               
                if($filtr_wzor != "")
                {
                    $wynik = mysql_query("SELECT "
                                . "ID_wyslane_wzory, "
                                . "Klient, "
                                //. "IF((SELECT Wzory_zamowienia FROM ZAMOWIENIA_TAB WHERE Uwagi LIKE '%$filtr_wzor%' LIMIT 1),(SELECT Wzory_zamowienia FROM ZAMOWIENIA_TAB WHERE Uwagi LIKE '%$filtr_wzor%' LIMIT 1),'') AS Numer_wzoru, "
                                //. "IF((SELECT Wzory_zamowienia FROM ZAMOWIENIA_TAB WHERE Uwagi LIKE '%(SELECT Nazwa_wzoru_konwertowanie FROM ODROBIENIA_WZOROW_TAB WHERE Nazwa_wzoru_konwertowanie LIKE '%$filtr_wzor%' OR Nazwa_wzoru_poprawianie LIKE '%$filtr_wzor%')%' LIMIT 1),(SELECT Wzory_zamowienia FROM ZAMOWIENIA_TAB WHERE Uwagi LIKE '%(SELECT Nazwa_wzoru_konwertowanie FROM ODROBIENIA_WZOROW_TAB WHERE Nazwa_wzoru_konwertowanie LIKE '%$filtr_wzor%' OR Nazwa_wzoru_poprawianie LIKE '%$filtr_wzor%')%' LIMIT 1),'') AS Numer_wzoru, "                           
                                . "Nazwa_wzoru_wyslanego, Projektantka, Uwagi, Data "
                            . "FROM WYSLANE_WZORY_DO_KLIENTA_TAB "
                            . "WHERE Nazwa_wzoru_wyslanego LIKE '%$filtr_wzor%'") or die ("zle pytanie");             
                    $polocz->close();
                }
                else{
                    $wynik = mysql_query("SELECT "
                                . "ID_wyslane_wzory, "
                                . "Klient, "
                                . "Nazwa_wzoru_wyslanego, Projektantka, Uwagi, Data "
                            . "FROM WYSLANE_WZORY_DO_KLIENTA_TAB "
                            . "WHERE Klient LIKE '$odbiorca_wybrany%' AND Data >= '$data_wybrana_od' AND Data <= '$data_wybrana_do'") or die ("zle pytanie odbiorca");             
                    $polocz->close();
                }
                $data_dzisiaj=date("Y-m-d");
                while($rekord = mysql_fetch_assoc($wynik))
                {
                    $nr_wiersza = $rekord['ID_wyslane_wzory'];
                    $klient = $rekord['Klient'];                     
                    $nazwa_wzoru_wyslanego = $rekord['Nazwa_wzoru_wyslanego'];
                    //$nazwa_wzoru_poprawianie = $rekord['Nazwa_wzoru_poprawianie'];
                    $uwagi = $rekord['Uwagi'];
                    $projektantka_baza = $rekord['Projektantka'];                  
                    $data = $rekord['Data'];
                    
                    /*
                    $dlugosc = strlen($nazwa_wzoru_konvertowanie);
                    if($dlugosc < 20)
                    {
                        $pierwsza_czesc = substr($nazwa_wzoru_konvertowanie, 0,10);
                        $druga_czesc = substr($nazwa_wzoru_konvertowanie, 10,$dlugosc - 10);
                    }
                    if($dlugosc >= 20 || $dlugosc < 30)
                    {
                        $pierwsza_czesc = substr($nazwa_wzoru_konvertowanie, 0,10);
                        $druga_czesc = substr($nazwa_wzoru_konvertowanie, 10, 10);
                        $trzecia_czesc = substr($nazwa_wzoru_konvertowanie, 20, 10);
                    }
                    
                    print_r($pierwsza_czesc); print" : "; print_r($druga_czesc); print" : "; print_r($trzecia_czesc);
                    print"<br>";
                     * 
                     */
                    
                    if (isset($_POST['checkbox_wzor_nr'])) 
                    {
                        $polocz->open();
                        mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia"); 
                        $wynik_nr_wzoru = mysql_query("SELECT Wzory_zamowienia FROM ZAMOWIENIA_TAB WHERE Uwagi LIKE '%$nazwa_wzoru_wyslanego%' LIMIT 1") or die ("zle pytanie nr wzoru");
                        $polocz->close();
                        while($rekord_nr_wzoru = mysql_fetch_assoc($wynik_nr_wzoru))
                        {
                            $numer_wzoru = $rekord_nr_wzoru['Wzory_zamowienia'];
                        }

                        if($projektantka_baza == $zalogowany)
                        {
                            $polocz->open();
                            mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia"); 
                            $wynik_nr_wzoru = mysql_query("SELECT Wzory_zamowienia FROM ZAMOWIENIA_TAB WHERE Uwagi LIKE '%$nazwa_wzoru_wyslanego%' LIMIT 1") or die ("zle pytanie nr wzoru");
                            $polocz->close();
                            while($rekord_nr_wzoru = mysql_fetch_assoc($wynik_nr_wzoru))
                            {
                                $numer_wzoru = $rekord_nr_wzoru['Wzory_zamowienia'];
                            }                       
                        }
                    }
                     
                    $ilosc_wzorow++;
                    if($nazwa_wzoru_konvertowanie != "")
                    {
                        $ilosc_wzorow_konwertowanych++;
                    }
                    if($nazwa_wzoru_poprawianie != "")
                    {
                        $ilosc_wzorow_poprawianych++;
                    }
                    if($projektantka_baza == "Marcela")
                    {
                        $ilosc_wzorow_Marcela++;
                    }
                    if($projektantka_baza == "Marta")
                    {
                        $ilosc_wzorow_Marta++;
                    }
                    if($projektantka_baza == "Ola")
                    {
                        $ilosc_wzorow_Ola++;
                    }
                    if($projektantka_baza == "Aleksandra")
                    {
                        $ilosc_wzorow_Aleksandra++;
                    }
                    if($projektantka_baza == "Martyna")
                    {
                        $ilosc_wzorow_Martyna++;
                    }
                        
                        
                    
                    $kolor = '#FFFFFF';
                    print"<TR><TD id='td_kolor' bgcolor=$kolor>$klient</TD><TD id='td_kolor' align='left' bgcolor=$kolor><a href='WZORY_JPG_WSZYSTKIE/$numer_wzoru.jpg' data-lightbox='$numer_wzoru.jpg' data-title='$numer_wzoru'>$numer_wzoru</a></TD><TD id='td_kolor' align = 'left' bgcolor=$kolor>$nazwa_wzoru_wyslanego</TD><TD id='td_kolor' bgcolor=$kolor>$uwagi</TD><TD id='td_kolor' bgcolor=$kolor>$projektantka_baza</TD><TD id='td_kolor' align='center' bgcolor=$kolor>$data</TD>";
                        print"<TD id='td_kolor' align=center bgcolor=$kolor>";
                                print'<FORM ACTION="wzory_wyslane_do_klienta.php" METHOD=POST>'; 
                                //print "<INPUT TYPE=hidden NAME=wybrany_klient VALUE='$odbiorca'>";
                                //print '<INPUT TYPE="hidden" NAME="usuwaj" VALUE="'.$nr_wiersza.'">';
                                if($projektantka_baza == $zalogowany) ////////PRZYCISK USUN
                                {    
                                    if($data == $data_dzisiaj)
                                    {
                                        print '<INPUT TYPE="hidden" NAME="usuwaj" VALUE="'.$nr_wiersza.'">';
                                             //print '<INPUT TYPE="hidden" NAME="usun_wiersz" VALUE="usun">';

                                        print'<INPUT TYPE="submit" NAME="przycisk_usuwaj" VALUE="X Usuń" CLASS="btn">';              
                                    }
                                }
                                print '</FORM>';                          
                        print"</TD>";
                         
                }
                print"</TR>";
            print"</TABLE>";   
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td height=30>";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";
            print"<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 style='width: 100%; height: 100%;'>";
                print"<tr>";
                    print"<td align=center>";
                        print'<a id="dopisywanie_wzoru">';
                            print"<B><font size='1' color='blue'>DOPISZ WZÓR</font></B><br>";
                        print'</a>'; 
                    print"</td>";
                print"</tr>";
                print"<tr>";
                    print"<td>";
                        ////////////text box dopisywanie wzorow /////////////////////////// 
                            print'<FORM METHOD=POST>';
                            print"<DIV class='wiekszy_panel'>";
                                print"<div align=center>";
                                print"<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 style='width: 90%; height: 100%;'>";
                                    print"<TR>";
                                        print"<TD valign=bottom style='width: 24%;'>";
                                            print'<B><font class="opis_texbox">KLIENT</font></B><br/>';                              
                                            print'<SELECT class="opis_select" NAME="dodaj_klient_tex" style="width: 95%;">';  

                                                foreach($odbiorcy as $klucz => $wartosc)
                                                {
                                                    print("<OPTION VALUE=\"$klucz\">".$wartosc); 
                                                }
                                                if(isset($_POST['przycisk_zapisz']))///wcisniety przycisk szukaj
                                                {
                                                    print("<OPTION SELECTED VALUE=\"$filtr_klient_klucz\">$odbiorca_wybrany_do_zapisania</OPTION>");   
                                                }
                                            print'</SELECT>';

                                        print"</TD>";           
                                        print"<TD style='width: 48%;'>";
                                            print'<B><font class="opis_texbox">WZÓR WYSŁANY DO KLIENTA</font></B><br/>';
                                            print '<INPUT class="text_box" style="width: 95%;" TYPE="text" NAME="dodaj_wzor_wyslany_tex" VALUE="">';                
                                        print"</TD>"; 
                                        /*
                                        print"<TD valign=bottom style='width: 24%;'>";
                                            print'<B><font class="opis_texbox">WZÓR POPRAWIANY</font></B><br/>';
                                            print '<INPUT class="text_box" style="width: 95%;" TYPE="text" NAME="dodaj_wzor_poprawiany_tex" VALUE="">';                
                                        print"</TD>"; 
                                         * 
                                         */                                      
                                        print"<TD valign=bottom style='width: 24%;'>";
                                            print'<B><font class="opis_texbox">UWAGI</font></B><br/>';
                                            print '<INPUT class="text_box" style="width: 95%;" TYPE="text" NAME="dodaj_uwagi_tex" VALUE="">';                
                                        print"</TD>";                                       
                                        print"<TD valign=bottom style='width: 4%;'>";
                                            print "";
                                            print'<INPUT style="width: 100%;" TYPE="submit" NAME="przycisk_zapisz" VALUE="Zapisz" CLASS="btn">';  
                                        print"</TD>";
                                    print"</TR>";
                                print"</TABLE>";
                                print"</FORM>";
                                print"</div>";
                            print"</div>";    
                    print"</td>";
                print"</tr>";
            print"</TABLE>";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td height=30>";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";
            print"<TABLE>";
                print"<tr>";
                    print"<td align=left>";
                        print'<a id="statystyki">';
                            print"<B><font size='1' color='blue'>STATYSTYKI</font></B><br>";
                        print'</a>'; 
                    print"</td>";
                print"</tr>";
                print"<tr>";
                    print"<td>";
                        //print"<TABLE border = '0' width=20% height=100%>";
                        print"<TABLE>";
                            print"<TR><TD id='td_kolor' width=10% bgcolor = #5F9F9F><B>NAZWA</B></TD><TD id='td_kolor' width=5% bgcolor = #5F9F9F><B>ILOŚC SZT.</B></TD></TR>";
                            $kolor = '#FFFFFF';
                            print"<TR><TD id='td_kolor' bgcolor=$kolor>Wzory razem</TD><TD id='td_kolor' align=center bgcolor=$kolor>$ilosc_wzorow</TD></TR>";
                            //print"<TR><TD id='td_kolor' bgcolor=$kolor>Wzory konwertowane</TD><TD id='td_kolor' align=center bgcolor=$kolor>$ilosc_wzorow_konwertowanych</TD></TR>";
                            //print"<TR><TD id='td_kolor' bgcolor=$kolor>Wzory poprawiane</TD><TD id='td_kolor' align=center bgcolor=$kolor>$ilosc_wzorow_poprawianych</TD></TR>";
                            //print"<TR><TD id='td_kolor' bgcolor=$kolor>Marcela</TD><TD id='td_kolor' align=center bgcolor=$kolor>$ilosc_wzorow_Marcela</TD></TR>";
                            print"<TR><TD id='td_kolor' bgcolor=$kolor>Marta</TD><TD id='td_kolor' align=center bgcolor=$kolor>$ilosc_wzorow_Marta</TD></TR>";
                            print"<TR><TD id='td_kolor' bgcolor=$kolor>Ola</TD><TD id='td_kolor' align=center bgcolor=$kolor>$ilosc_wzorow_Ola</TD></TR>";
                            print"<TR><TD id='td_kolor' bgcolor=$kolor>Aleksandra</TD><TD id='td_kolor' align=center bgcolor=$kolor>$ilosc_wzorow_Aleksandra</TD></TR>";           
                            print"<TR><TD id='td_kolor' bgcolor=$kolor>Martyna</TD><TD id='td_kolor' align=center bgcolor=$kolor>$ilosc_wzorow_Martyna</TD></TR>";                              
                        print"</TABLE>";
                    print"</td>";
                print"</tr>";
            print"</TABLE>";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td height=30>";
        print"</td>";
    print"</tr>";
print"</TABLE>";
        
print"</DIV>";
?>        
        
</body>




