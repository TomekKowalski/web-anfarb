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

        <script src = "js/jquery-1.11.0.min.js"> </script>
        <script src = "js/lightbox.min.js"> </script>
        <link href="css/lightbox.css" rel="stylesheet"/>   
        <link href="css_wyglad_strony/style.css" rel="stylesheet" type="text/css">
        <link href="css_wyglad_strony/mobile_style.css" rel="stylesheet" type="text/css">
        <title>Zamowienia drukarnia</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="/resources/demos/style.css">
	<script>	
		$(function() {
		$( "#datepicker" ).datepicker();
		});
	</script>
	  
</head>

<body>



<DIV class="panel_glowny">


<TABLE cellpadding = 0  cellspacing = 0 border = 0 style="width: 100%; height: 100%;">
    <tr>
        <td align=center height=5px>
        </td>
    </tr>
    <tr>
        <td align=center>
            <?PHP require_once "zalogowany_banery.php"; ?>
<?PHP
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";

            print"<TABLE cellpadding = '0'  cellspacing = '0' border = '0' style='width=90% height=100%'>";
                print"<tr>";
                    print"<td align=center>";
	
                        require_once 'class.Polocz.php';
                        $polocz = new Polocz();
                        
                                //print"ZAPISZ = ";
                                //var_dump($_POST['co']);
                        $data=date("Y-m-d");
                        $odbiorca = $_GET['odbiorca'];
                        if(isset($_POST['szukaj_wzor_przycisk']))///klikniety przycisk szukaj wzor
                        {	
                                    
                            $odbiorca = $_POST['wybrany_klient'];
                            //print"odbiorca : ";
                            //print_r($odbiorca);
                        }
                        else{
                            //$odbiorca = $_GET['odbiorca'];
                        }
                        if(isset($_POST['szukaj_artykul_przycisk']))///klikniety przycisk szukaj wzor
                        {	
                                    
                            $odbiorca = $_POST['wybrany_klient'];
                            //print"odbiorca : ";
                            //print_r($odbiorca);
                        }
                        else{
                            //$odbiorca = $_GET['odbiorca'];
                        }
                        if($_POST['przycisk_zmien_status'])
                        {                            
                            $data_przycisk_zapisu = $_POST['data_przycisk_zapisz'];                          
                            $data_razem = $data_przycisk_zapisu;
                            $data = $data_razem;
                                                          
                                $check_nr_wiersza = $_POST['zmien_status'];
                                                                     
                                        $polocz->open();
                                        mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");

                                        $status_do_zmiany = mysql_query("SELECT Status_zamowienia FROM ZAMOWIENIA_TAB WHERE Nr_wiersza = '$check_nr_wiersza';") or die ("nie wiem jaki odbiorca");
                                        $rekord_status_do_zmiany = mysql_fetch_assoc($status_do_zmiany);
                                        $status_do_zmiany_sprawdzony = $rekord_status_do_zmiany['Status_zamowienia'];
                                        
                                        $polocz->close();
                                        
                                        $odbiorca = $_POST['wybrany_klient'];
                                        
                                        if($odbiorca === "OGANES HMAJAK")
                                        {
                                            if($status_do_zmiany_sprawdzony == "DO DRUKU")
                                            {
                                                $polocz->open();
                                                $query_status = "UPDATE ZAMOWIENIA_TAB SET Status_zamowienia = 'DO AKCEPTACJI' WHERE Nr_wiersza = '$check_nr_wiersza';";
                                                $wynik_status = mysql_query($query_status);
                                                $polocz->close();
                                            }
                                            if($status_do_zmiany_sprawdzony == "DO AKCEPTACJI")
                                            {
                                                $polocz->open();
                                                $query_status = "UPDATE ZAMOWIENIA_TAB SET Status_zamowienia = 'DO DRUKU' WHERE Nr_wiersza = '$check_nr_wiersza';";
                                                $wynik_status = mysql_query($query_status);
                                                $polocz->close();
                                            }
                                        }else{
                                            if($status_do_zmiany_sprawdzony == "DO DRUKU")
                                            {
                                                $polocz->open();
                                                $query_status = "UPDATE ZAMOWIENIA_TAB SET Status_zamowienia = 'ZALICZKA' WHERE Nr_wiersza = '$check_nr_wiersza';";
                                                $wynik_status = mysql_query($query_status);
                                                $polocz->close();
                                            }
                                            if($status_do_zmiany_sprawdzony == "ZALICZKA")
                                            {
                                                $polocz->open();
                                                $query_status = "UPDATE ZAMOWIENIA_TAB SET Status_zamowienia = 'DO DRUKU' WHERE Nr_wiersza = '$check_nr_wiersza';";
                                                $wynik_status = mysql_query($query_status);
                                                $polocz->close();
                                            }
                                        }                                  
                        }                      
                        if($odbiorca == "")
                        {
                            if($_POST['odbiorca_po_edycji'])
                            {
                               $odbiorca = $_POST['odbiorca_po_edycji'];
                            }
                            if($_POST['przycisk_zmien_status'] || $_POST['przycisk_usuwaj'] || $_POST['Dodaj'])
                            {
                               $odbiorca = $_POST['wybrany_klient']; 
                               //print"wchodzi przycisk : ";
                               //print_r($odbiorca);
                            }
                        }
                        $data_B=date("Y");
  
                        $polocz->open();
                        mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");

                        $numer_zamowienia = mysql_query("SELECT Zamowienie_nr, Data FROM ZAMOWIENIA_TAB WHERE Odbiorca_zamowienia = '$odbiorca' AND Data LIKE '$data_B%' ORDER BY Data") or die ("zle pytanie");

                        $polocz->close();
                        while($rekord_nr = mysql_fetch_assoc($numer_zamowienia))
                                {
                                        $zamowienie_nr = $rekord_nr['Zamowienie_nr'];
                                        $data_zamowienia = $rekord_nr['Data']; 
                                }
                        
                        $data_dzisiaj=date("Y-m-d");
                        
                        //print_r($zamowienie_nr);

                        if($data_zamowienia !== $data)
                        {
                                $zamowienie_nr++;
                        }
                        if($_POST['data']=='wyszukiwanie_po_dacie')
                            {
                                    $odbiorca = $_POST['wybrany_klient'];
                                    ////////////////wyszukiwanie z danego dnia /////////////////////////////
                                    $data=$_POST['data_data'];


                                    /*
                                    $data_miesiac = substr($data,0, 2);
                                    $data_dzien = substr($data,3, 2);
                                    $data_rok = substr($data,6, 5);

                                    $data_razem = $data_rok."-".$data_miesiac."-".$data_dzien;
                                    $data = $data_razem;
                                     * 
                                     */
                                    //print"data_razem: ";
                                    //print_r($data_razem);
                            }
 	


                        if(isset($_POST['Dodaj']))///dopisywanie nowego wiersza
                        {
                                if($_POST['artykul'])  
                                {
                                    $status_wybrany = $_POST['combo_status'];
                                                                      
                                    $zamowienie_nr = $_POST['zamowienie_nr'];
                                    $odbiorca = $_POST['wybrany_klient']; 
                                        $polocz->open();
                                        //mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");

                                        mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                                        $licz_wiersze = mysql_query("SELECT Nr_wiersza FROM ZAMOWIENIA_TAB ORDER BY Nr_wiersza;") or die ("nie wiem ile wierszy");

                                        $polocz->close();
                                        while($rekord = mysql_fetch_assoc($licz_wiersze))
                                        {
                                                $ilosc_wierszy = $rekord['Nr_wiersza'];
                                        }
                                        $ilosc_wierszy++;

                                        $data=date("Y-m-d");
                                        $czas=date("H:i");




                                                $artykul = $_POST['artykul'];


                                        $ilosci = htmlspecialchars($_POST['ilosc']);
                                                $ilosci = (int)$ilosci;


                                                $metry_lub_sztuki = htmlspecialchars($_POST['metry_sztuki']);

                                        $wzor = htmlspecialchars($_POST['wzory']);


                                        $uwagi = htmlspecialchars($_POST['uwagi']);

                                        ///////////sprawdz nr wzoru ////////////////////////////
                                        $polocz->open();

                                        mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                                        $nr_wzoru_wg_uwagi = mysql_query("SELECT Wzory_zamowienia FROM ZAMOWIENIA_TAB WHERE Uwagi LIKE '%$uwagi%' ORDER BY Nr_wiersza DESC;") or die ("nie moge sprawdzic wzoru");

                                        $polocz->close();
                                        $rekord_wzor = mysql_fetch_assoc($nr_wzoru_wg_uwagi);

                                                $wzor_pobrany_z_uwag = $rekord_wzor['Wzory_zamowienia'];

                                               // print"Wzor oryginal: ";
                                               // print_r($wzor);
                                        if($wzor == "")
                                        {
                                            $wzor = $wzor_pobrany_z_uwag;
                                            if($wzor_pobrany_z_uwag != "")
                                            {
                                                print "<font size='5' color='red'>Uwaga wzór: ".$wzor." został dodany automatycznie !!<br></font>";
                                                $uwagi_na_temat_wzoru = "Uwaga wzór: ".$wzor." został dodany automatycznie !!";                             
                                            }
                                        }
                                        /*
                                         print"<br>Wzor wg uwag: ";
                                         print_r($wzor);
                                         print"<br>Wzor pobrany z uwag: ";
                                         print_r($wzor_pobrany_z_uwag); 
                                         print"<br>rekord wzor :";
                                         print_r($rekord_wzor); 

                                         */
                                        ////////koniec sprawdz nr wzoru /////////////////////////



                                        $numer_zamowienia = date("Y");

                                        $polocz->open();
                                        mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");

                                        //$query = "INSERT INTO ZAMOWIENIA_TAB VALUES('$odbiorca','$numer_zamowienia','$zamowienie_nr','$data','$artykul','$ilosci','$metry_lub_sztuki','','$wzor','$uwagi','DO DRUKU','$ilosc_wierszy','0','', '$zalogowany');";
                                        $query = "INSERT INTO ZAMOWIENIA_TAB VALUES('$odbiorca','$numer_zamowienia','$zamowienie_nr','$data','$artykul','$ilosci','$metry_lub_sztuki','','$wzor','$uwagi','$status_wybrany','$ilosc_wierszy','0','', '$zalogowany');";

                                        $wynik = mysql_query($query);

                                        $rodzaj_zmiany = "".$artykul."  ".$ilosci."  ".$metry_lub_sztuki."  ".$wzor."  ".$uwagi."";
                                        $data_czas = "".$data."  ".$czas."";


                                        $query2 = "INSERT INTO HISTORIA_ZMIAN_TAB (`data_zmiany`, `uzytkownik`, `rodzaj_zmiany`, `id_wiersza_zamowienia`) VALUES('$data_czas', '$zalogowany', '$rodzaj_zmiany', '$ilosc_wierszy')";
                                        $wynik2 = mysql_query($query2);
                                        $polocz->close();
                                }else
                                {
                                  print"<DIV ALIGN=center>";

                                        print "<font size='4' color='red'>musisz wybrać artykuł<br></font>";

                                  print"</DIV>";
                                }
                        }
                                    //////////////////////////////////////koniec dopisywania wiersza////////////////////////////////////////////////////

                                    /////////////usuwanie wiersza//////////////////////////////////////
                        //if($_POST['co'] == 'usun') 
                        if($_POST['przycisk_usuwaj'])
                        {
                                  //print"usuwaj ????";
                                  $nr_wiersza_dousuniecia = $_POST['usuwaj'];
                                  //print"wiersz do usuniecia = ";
                                  //print "$nr_wiersza_dousuniecia";
                                  
                                  
                                  $polocz->open();
                                    mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");

                                  $odbiorca_zamowienia = mysql_query("SELECT Odbiorca_zamowienia FROM ZAMOWIENIA_TAB WHERE Nr_wiersza = '$nr_wiersza_dousuniecia';") or die ("nie wiem jaki odbiorca");
                                  $rekord_odbiorca = mysql_fetch_assoc($odbiorca_zamowienia);
                                  $odbiorca_usuwanie = $rekord_odbiorca['Odbiorca_zamowienia'];

                                  //print "  $odbiorca_usuwanie";

                                  $query_usuwanie = "UPDATE ZAMOWIENIA_TAB SET Odbiorca_zamowienia = '', Nr_parti = 'usuniete z .$odbiorca_usuwanie', Status_zamowienia = 'WYDRUKOWANE' WHERE Nr_wiersza = '$nr_wiersza_dousuniecia';";
                                  $wynik_usuwanie = mysql_query($query_usuwanie);

                                  $polocz->close();
                                  
                                  $odbiorca = $odbiorca_usuwanie;
                                  

                                  $wzor = "";
                                  $uwagi = "";
                                  $_POST['wzory'] = "";		
                              $_POST['uwagi'] = "";                                                                 
                        }

                        ///////////koniec usuwania wiersza/////////////////////////////////////////////////////////////////
                        //print"<DIV ALIGN=center>";

                            
                            ///////////////wyswietlanie tabeli //////////////////////////////////////
                    print"</td>";
                print"</tr>";
            print"</TABLE>";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";
            print'<div class="mniejszy_panel">';
                print'<div align=center>';
                    print"<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 style='width: 95%; height: 100%;'>";
                        print"<TR>";
                            print"<TD style='width: 49%;'>"; 
                                print'<FORM ACTION="wybierz_odbiorce.php" METHOD=POST>';
                                print "<INPUT TYPE=hidden NAME=wybrany_klient_nowe_zamowienie VALUE='$odbiorca'>";
                                print'<INPUT style="width: 100%;" TYPE="submit" NAME="wroc_do_odbiorcy" VALUE="Wróć do zamówienia" CLASS="btn">';
                                print'</FORM>';
                            print"</TD>";
                            print"<TD style='width: 2%;'>"; 
                            print"</TD>";
                            print"<TD style='width: 49%;'>";
                                print'<FORM ACTION="index.php" METHOD=POST>';
                                print'<INPUT style="width: 100%;" TYPE="submit" VALUE="Strona startowa" CLASS="btn">';
                                print'</FORM>';
                            print"</TD>";
                        print"</TR>";
                    print"</TABLE>";
                print'</div>';

                print "<br><B><font class='opis_paneli'>Nowe zamówienie $odbiorca</font></B><br><br>";

                print'<FORM METHOD=POST>';
                print '<INPUT TYPE="hidden" NAME="data" VALUE="wyszukiwanie_po_dacie">';
                print "<INPUT TYPE=hidden NAME=wybrany_klient VALUE='$odbiorca'>";
                    print'<div align=center>';
                                        print"<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 style='width: 90%; height: 100%;'>";
                                            print"<TR>";
                                                //print"<TD style='width: 80%;'>"; 
                                                print"<TD class='td_pole_daty'>";
                                                    if($_POST['data_data'] == "")
                                                    {
                                                       $data_miesiac_p=date("m");
                                                       $data_dzien_p=date("d");
                                                       $data_rok_p=date("Y");
                                                       //$data_wybrana = $data_miesiac_p."/".$data_dzien_p."/".$data_rok_p;
                                                       $data_wybrana = $data_rok_p."-".$data_miesiac_p."-".$data_dzien_p;
                                                    }else{
                                                       $data_wybrana = $_POST['data_data'];
                                                    }
                                                    if($_POST['przycisk_zmien_status'])
                                                    {
                                                       $data_wybrana = $data_przycisk_zapisu;
                                                    }
                                                    //print"<input class='text_box' style='width: 90%;' type=\"text\" id=\"datepicker\" name=\"data_data\" value=\"$data_wybrana\">";
                                                    print"<input class='text_box' type='date' name='data_data' value='".$data_wybrana."'>";                                                   
                                                print"</TD>";  
                                                print"<TD class='td_pole_spacja'></TD>";
                                                print"<TD class='td_pole_przycisk'>";
                                                    //print'<INPUT style="width: 100%;" TYPE="submit" VALUE="Wybierz" CLASS="btn">'; 
                                                    print'<INPUT TYPE="submit" VALUE="Wybierz" CLASS="btn">';
                                                print"</TD>";
                                            print"</TR>";
                                        print"</TABLE>";
                    print'</div>';
                print'</FORM>';
                                  ////////////////////koniec dol kontener wklesly //////////////////////
                print'<a href="#dopisywanie_zamowien">';
                    print"<br><B><font size='1' color='blue'>NOWY WIERSZ</font></B>";
                print'</a>'; 
            print'</div>';
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";
 	
            print'<TABLE style="width: 95%; height: 100%;">';
                print"<TR><TD id='td_kolor' width=10% bgcolor = #6666ff><B>ARTYKUŁ</B></TD><TD id='td_kolor' width=2% bgcolor = #6666ff><B>ILOŚĆ</B></TD><TD id='td_kolor' width=5% bgcolor = #6666ff><B> M./SZT. </B></TD><TD id='td_kolor' width=5% bgcolor = #6666ff><B>NR PARTI</B></TD><TD id='td_kolor' width=15% bgcolor = #6666ff><B>WZÓR</B></TD><TD id='td_kolor' width=20% bgcolor = #6666ff><B>UWAGI</B></TD><TD id='td_kolor' width=10% bgcolor = #6666ff><B>STATUS</B></TD><TD id='td_kolor' width=5% bgcolor = #6666ff></TD><TD id='td_kolor' width=5% bgcolor = #6666ff></TD><TD id='td_kolor' width=5% bgcolor = #6666ff></TD></TR>";
                if($data != $data_dzisiaj)
                {  
                    $zamowienie_nr = "";
                }               
                $kolor = '#B8B8B8';
                print"<TR><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>Zamówienie nr..</font></B></TD><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>$zamowienie_nr</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>Data..</font></B></TD><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>$data</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>";
                    //print"<br>data: ";
                    //print_r($data);
                    //print"<br>";
                    //print_r($data_dzisiaj);
                    $polocz->open();
                        mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                        if($data == $data_dzisiaj)
                        {
                            $wynik = mysql_query("SELECT * FROM ZAMOWIENIA_TAB WHERE Odbiorca_zamowienia = '$odbiorca' AND Data = '$data' AND Zamowienie_nr = '$zamowienie_nr'") or die ("zle pytanie");
                        }
                        if($data != $data_dzisiaj)
                        {
                            $wynik = mysql_query("SELECT * FROM ZAMOWIENIA_TAB WHERE Odbiorca_zamowienia = '$odbiorca' AND Data = '$data'") or die ("zle pytanie data");
                        }

                    $polocz->close();
                    $k = 1;
                    while($rekord = mysql_fetch_assoc($wynik))
                    {
    
                                $artykul_zamowienia = $rekord['Artykul_zamowienia'];
                                $ilosc = $rekord['Ilosc_szt_metrow'];
                                $status_metrow = $rekord['Status_metrow'];
                                $nr_parti = $rekord['Nr_parti'];
                                $wzor_baza = $rekord['Wzory_zamowienia'];
                                $uwagi_baza = $rekord['Uwagi'];
                                $status = $rekord['Status_zamowienia'];

                                $zamowienie_nr = $rekord['Zamowienie_nr'];

                                $data = $rekord['Data'];

                                $nr_wiersza = $rekord['Nr_wiersza'];
                                $nr_wiersza_dla_check = $rekord['Nr_wiersza'];

                                $status_wpis_do_zeszytu = $rekord['Status_wpis_do_zeszytu'];

                                $planowana_data_odbioru = $rekord['Planowana_data_odbioru'];


                                $kolor = '#FFFFFF';
                                if($status_wpis_do_zeszytu == '1')
                                {
                                        $kolor = '#CCFFFF';
                                }
                                if($status == 'WYDRUKOWANE')
                                {
                                        $kolor = '#FFFF66';
                                }
                                if($status == 'DO AKCEPTACJI')
                                {
                                        $kolor = '#ffe6e6';
                                }
                                if($status == 'ZALICZKA')
                                {
                                        $kolor = '#DCDCDC';
                                }
                        print"<TR><TD id='td_kolor' bgcolor=$kolor>$artykul_zamowienia</TD><TD id='td_kolor' align='right' bgcolor=$kolor>$ilosc</TD><TD id='td_kolor' align = 'center' bgcolor=$kolor>$status_metrow</TD><TD id='td_kolor' bgcolor=$kolor>$nr_parti</TD><TD id='td_kolor' bgcolor=$kolor><a href='WZORY_JPG_WSZYSTKIE/$wzor_baza.jpg' data-lightbox='$wzor_baza.jpg' data-title='$wzor_baza'>$wzor_baza</a></TD><TD id='td_kolor' bgcolor=$kolor>$uwagi_baza</TD><TD id='td_kolor' bgcolor=$kolor>$status</TD>";
                            

                            //print"<TD border='0'></TD>";  
                            
                            print"<TD id='td_kolor' align=center bgcolor=$kolor>";                           
                                if($nr_parti == "")/// PRZYCISK EDYCJA/////////////////
                                {
                                    if($data == $data_dzisiaj)
                                    {
                                        print"<a href = 'formularz_edycja.php?nr_wiersza=$nr_wiersza'>"; 
                                        print'<INPUT TYPE="submit" VALUE="Edytuj" CLASS="btn">';
                                        print'</a>';
                                    }

                                }                                                      
                            print"</TD>";		
                            print"<TD id='td_kolor' align=center bgcolor=$kolor>";
                                print'<FORM ACTION="formularz_nowe_zamowienie.php" METHOD=POST>'; 
                                print "<INPUT TYPE=hidden NAME=wybrany_klient VALUE='$odbiorca'>";
                                //print '<INPUT TYPE="hidden" NAME="usuwaj" VALUE="'.$nr_wiersza.'">';
                                if($nr_parti == "") ////////PRZYCISK USUN
                                {
                                    if($data == $data_dzisiaj)
                                    {
                                        //print '<FORM ACTION="formularz_nowe_zamowienie.php" METHOD="POST">';
                                        print '<INPUT TYPE="hidden" NAME="usuwaj" VALUE="'.$nr_wiersza.'">';
                                         //print '<INPUT TYPE="hidden" NAME="usun_wiersz" VALUE="usun">';

                                        print'<INPUT TYPE="submit" NAME="przycisk_usuwaj" VALUE="X Usuń" CLASS="btn">';
                                        
                                    }
                                }
                                print '</FORM>';
                             
                            print"</TD>";
                            print"<TD id='td_kolor' align=center bgcolor=$kolor>";
                            
                                
                                print'<FORM ACTION="formularz_nowe_zamowienie.php" METHOD=POST>'; 
                                //print '<INPUT TYPE="hidden" NAME="numer_parti_zapisz" VALUE="'.$wybrany_nr_parti.'">';
                                //print '<INPUT TYPE="hidden" NAME="co" VALUE="zapisz">';
                                //print "<INPUT TYPE=hidden NAME=wielkosc_tab VALUE=$k>";             
                                print "<INPUT TYPE=hidden NAME=wybrany_klient VALUE='$odbiorca'>";
                                print "<INPUT TYPE=hidden NAME=data_przycisk_zapisz VALUE='$data_wybrana'>";
                                ////////checkboox////////////
                                if($nr_parti == "") ////////PRZYCISK zmien status
                                {
                                    
                                        print '<INPUT TYPE="hidden" NAME="zmien_status" VALUE="'.$nr_wiersza_dla_check.'">';
                                         

                                        print'<INPUT TYPE="submit" NAME="przycisk_zmien_status" VALUE="Zmień status" CLASS="btn">';
                                        
                                    
                                }
                                                   
                                print"</FORM>";
                                /*
                                if($nr_parti == "") ////////CHECKBOX
                                {
                                    $tab_nr_wiersza[$k]=$nr_wiersza_dla_check;
                                    print '<input type=checkbox NAME=nr_wiersza['.$k.'] VALUE='.$nr_wiersza_dla_check.'>';
                                }
                                    
                                if($status == 'DO AKCEPTACJI')
                                {
                                    print '<input type=checkbox NAME=nr_wiersza_check['.$k.'] VALUE='.$nr_wiersza.'>';
                                }
                                if($status == 'DO DRUKU')
                                {
                                    print '<input type=checkbox NAME=nr_wiersza_check['.$k.'] VALUE='.$nr_wiersza.' checked>';
                                }
                                  * 
                                  */
                                    
                                     
                                
                            print"</TD>";
                        print"</TR>";
                        $k++;
  
                    }
                    print"<tr>";
                        print"<td></td>";
                        print"<td></td>";
                        print"<td></td>";
                        print"<td></td>";
                        print"<td></td>";
                        print"<td></td>";
                        print"<td></td>";
                        print"<td></td>";
                        print"<td align=center>";                   
                        print"</td>";
                    print"</tr>";
            print"</TABLE>";
            
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";

            print'<TABLE cellpadding = 0  cellspacing = 0 border = 0 width=100% height=100%>';
            print"<tr><td align=center height=30px>";
            print"</td></tr>";
            print"</TABLE>";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";
            if($uwagi_na_temat_wzoru != "")
            {               
                print "<font size='5' color='red'>".$uwagi_na_temat_wzoru."<br></font>";                               
            }
                
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";
            if($data == $data_dzisiaj)
            {    
                print'<a id="dopisywanie_zamowien">';
                    print"<B><font size='1' color='blue'>NOWY WIERSZ</font></B>";
                print'</a>';
                    
                        print '<FORM METHOD="POST">';
                        print "<INPUT TYPE=hidden NAME=zamowienie_nr VALUE='$zamowienie_nr'>";                    
                        print '<INPUT TYPE="hidden" NAME="co" VALUE="dodaj">';
                        print "<INPUT TYPE=hidden NAME=wybrany_klient VALUE='$odbiorca'>";
                    print'<div class="wiekszy_panel">';
                        print '<TABLE border=0 style="width: 100%; height: 100%;">';
                            print '<TR><TD style="width: 30%; text-align: left;"><B><font class="opis_texbox">Artykul:</font></B></TD><TD style="width: 5%; text-align: left;"><B><font class="opis_texbox">Ilość:</font></B></TD><TD style="width: 5%; text-align: left;"><B><font class="opis_texbox">m./szt.</font></B></TD><TD style="width: 30%; text-align: left;"><B><font class="opis_texbox">Wzory:</font></B></TD><TD style="width: 30%; text-align: left;"><B><font class="opis_texbox">Uwagi:</font></B></TD></TR>';
                            print '<TR>';
                                print'<TD VALIGN="top">';

                                if(isset($_POST['szukaj_artykul_przycisk']))///klikniety przycisk szukaj artykul
                                {	
                                    $_SESSION['zapamietany_artykul'] = $_POST['szukaj_artykul'];

                                                    //$artykul = $_POST['artykul']; 		   		
                                            $ilosci = htmlspecialchars($_POST['ilosc']);		
                                                    $metry_lub_sztuki = htmlspecialchars($_POST['metry_sztuki']);		
                                            $wzor = htmlspecialchars($_POST['wzory']);		
                                            $uwagi = htmlspecialchars($_POST['uwagi']);                                                
                                }

                                if(isset($_POST['szukaj_wzor_przycisk']))///klikniety przycisk szukaj wzor
                                {	
                                    //$_SESSION['zapamietany_artykul'] = $_POST['szukaj_artykul'];
                                            
                                                    $artykul = $_POST['artykul']; 
                                            $odbiorca = $_POST['wybrany_klient'];
                                            //print_r($odbiorca);
                                            $ilosci = htmlspecialchars($_POST['ilosc']);		
                                            $metry_lub_sztuki = htmlspecialchars($_POST['metry_sztuki']);		
                                            $wzor = "";		
                                            $uwagi = htmlspecialchars($_POST['uwagi']);
                                }


                                ///combobox artykul///


                                print'<SELECT class="opis_select" NAME="artykul" style="width: 100%;">';

                                    if (isset($_POST['checkbox_zapamietaj'])||isset($_POST['szukaj_wzor_przycisk'])) 
                                    {
                                    print("<OPTION SELECTED VALUE=\"$artykul\">$artykul</OPTION>");


                                    }else
                                    {			
                                            print'<OPTION SELECTED VALUE="">-&gt; :';
                                    }

                                    $szukany_artykul = $_SESSION['zapamietany_artykul'];

                                    $polocz->open();
                                    mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");

                                    $lista_szukaj_artykul = mysql_query("SELECT Nazwa_artykul FROM ARTYKUL_TAB WHERE Nazwa_artykul LIKE '%$szukany_artykul%' ORDER BY Nazwa_artykul;") or die ("zle pytanie");

                                    $polocz->close();

                                    while($rekord_szukaj_artykul = mysql_fetch_assoc($lista_szukaj_artykul))
                                    {
                                            $artykuly_wyszukane[$i] = $rekord_szukaj_artykul['Nazwa_artykul'];
                                            print("<OPTION VALUE=\"$artykuly_wyszukane[$i]\">".$artykuly_wyszukane[$i]);
                                            $i++;   
                                    }
                                print'</SELECT>';

	
                                ///koniec combobox artykul///

                                print '</TD>';

                                if (isset($_POST['checkbox_zapamietaj'])||isset($_POST['szukaj_artykul_przycisk'])||isset($_POST['szukaj_wzor_przycisk'])) 
                                {
                                    print '<TD VALIGN="top"><INPUT class="text_box" TYPE="text" NAME="ilosc" VALUE="'.$ilosci.'" style="width: 90%;"></TD>';
                                }else
                                {
                                    print '<TD VALIGN="top"><INPUT class="text_box" TYPE="text" NAME="ilosc" style="width: 90%;"></TD>';
                                }

                                print '<TD VALIGN="top">';
                                ///combobox metry sztuki///

                                $metry_sztuki = array('0' => 'sztuk', '1' => 'metr(y)', '2' => 'raport(y)');


                                    print'<SELECT class="opis_select" NAME="metry_sztuki" style="width: 100%;">';
                                        if (isset($_POST['checkbox_zapamietaj'])||isset($_POST['szukaj_artykul_przycisk'])||isset($_POST['szukaj_wzor_przycisk']))////jest zaznaczony checkbox////////////
                                        {
                                                print("<OPTION VALUE=\"$metry_lub_sztuki\">$metry_lub_sztuki</OPTION>");
                                        }else
                                        {
                                                print'<OPTION SELECTED VALUE="">-&gt; :';
                                        }

                                        for($i = 0; $i<3; $i++)
                                        {
                                                print("<OPTION VALUE=\"$metry_sztuki[$i]\">".$metry_sztuki[$i]);
                                        }  
                                    print'</SELECT>';
                                    ///koniec combobox metry sztuki///
                                print '</TD>';
                                print '<TD VALIGN="top">';

                                    if ($_POST['checkbox_zapamietaj'] != "" || $_POST['co'] == 'usun' || isset($_POST['Dodaj']))
                                    {
                                            $wzor = "";
                                            $uwagi = "";
                                            $_POST['wzory'] = "";		
                                        $_POST['uwagi'] = "";
                                    }
                                    combobox_wzory($wzor);
                                print '</TD>';
                                print '<TD VALIGN="top">';
                                    print '<INPUT TYPE="hidden" NAME="uwagi">';
                                    print "<textarea NAME=uwagi cols=50 rows=3 style='width: 95%; font-size: 18px;'>$uwagi</textarea>";    
                                print '</TD>';
                            print '</TR>';
                                ////////////////////////checkbox zapamietaj////////////////////////////////
                            print '<TR>';

                                if (isset($_POST['checkbox_zapamietaj'])) 
                                {
                                    print '<TD align=left><br><input type="checkbox" NAME="checkbox_zapamietaj" VALUE="true" checked><B><font size=3 color=#00004d> Zapamiętaj artykuł, ilosć,  metry/sztuki </font></B></TD>';
                                }else{
                                    print '<TD align=left><br><input type="checkbox" NAME="checkbox_zapamietaj" VALUE="true"><B><font size=3 color=#00004d> Zapamiętaj artykuł, ilosć,  metry/sztuki </font></B></TD>';
                                }
                                print '<TD></TD>';
                                print '<TD></TD>';
                                print '<TD align=left><INPUT TYPE="submit" NAME="Dodaj" VALUE="Dodaj" CLASS="btn"></TD>';
                                print '<TD>';
                                
                                    print'<SELECT class="opis_select" NAME="combo_status" style="width: 50%;">';
                                        
                                                //print("<OPTION VALUE=\"$metry_lub_sztuki\">$metry_lub_sztuki</OPTION>");
                                                print"<OPTION VALUE='ZALICZKA'>ZALICZKA</OPTION>";
                                                print"<OPTION VALUE='DO DRUKU'>DO DRUKU</OPTION>";
                                                print"<OPTION SELECTED VALUE='ZALICZKA'>ZALICZKA</OPTION>";
                                        
                                                              
                                                if($status_wybrany != "")
                                                {
                                                    print"<OPTION SELECTED VALUE='$status_wybrany'>$status_wybrany</OPTION>";
                                                }
                                        
                                                //print("<OPTION VALUE=\"$metry_sztuki[$i]\">".$metry_sztuki[$i]);
                                          
                                    print'</SELECT>';                              
                                print'</TD>';
                            print '</TR>';
                            ////////////////////////koniec checkbox zapamietaj////////////////////////////////
                            $szukany_artykul_zapamietany = $_SESSION['zapamietany_artykul'];
                            $szukany_wzor_zapamietany = $_SESSION['zapamietany_wzor'];

                            if($szukany_wzor_zapamietany == "")
                            {
                                    //$szukany_wzor_zapamietany = "szukaj";
                                    $szukany_wzor_zapamietany = "";

                            }
                            print '<TR>';
                                print '<TD align=left>';
                                    ////////////////////wybieranie szukania artykulu//////////////////////////
                                    print '<INPUT TYPE="hidden" NAME="co" VALUE="szukany_artykul">';
                                    print '<br><INPUT class="text_box" TYPE="text" NAME="szukaj_artykul" style="width: 40%;" VALUE="'.$szukany_artykul_zapamietany.'">  ';
                                    print '<INPUT TYPE="submit" NAME="szukaj_artykul_przycisk" VALUE="szukaj artykuł" CLASS="btn">';
                                    ///////////////////////////////////////////////////////////////////////////
                                print '</TD>';
                                print'<TD></TD><TD></TD>';
                                print'<TD align=left>';
                                    //////////////////szukanie wzorow/////////////////////////////////////////
                                    print '<INPUT TYPE="hidden" NAME="co" VALUE="szukany_wzor">';
                                    print '<br><INPUT class="text_box" TYPE="text" NAME="szukaj_wzor" style="width: 40%;" VALUE="'.$szukany_wzor_zapamietany.'">  ';                           
                                    print '<INPUT TYPE="submit" NAME="szukaj_wzor_przycisk" VALUE="szukaj wzór" CLASS="btn">';

                                    ///////////////////////////////////////////////////////////////////////
                                print'</TD>';
                                print'<TD></TD>';
                            print '</TR>';
                        print '</TABLE>';
                    print'</div>';
                        print '</FORM>'; 
                    
            }
                ////////////////////koniec dol kontener wklesly //////////////////////
        print"</td>";
    print"</tr>";  
print"</TABLE>";

print'</DIV>';


function combobox_wzory($wzor_wyswietl)
{
	
	if($_POST['co'] == 'szukany_wzor')///klikniety przycisk szukaj artykul
	{
		$_SESSION['zapamietany_wzor'] = $_POST['szukaj_wzor'];
	}
	
	$szukany_wzor_baza = $_SESSION['zapamietany_wzor'];
	
	if($szukany_wzor_baza == "")
	{
		$szukany_wzor_baza = "szukaj";
	}

        require_once 'class.Polocz.php';
        $polocz = new Polocz();
        $polocz->open();
            mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
  
        mysql_select_db("DRUKARNIA_BAZA") or die ("nie ma poloczenia drukarnia baza");
        $lista_wzory = mysql_query("SELECT Nazwa_wzoru_drukarnia FROM WZORY_DRUKARNIA_TAB WHERE Nazwa_wzoru_drukarnia LIKE '%$szukany_wzor_baza%' ORDER BY Nazwa_wzoru_drukarnia;") or die ("zle pytanie");

        $polocz->close();

            ///combobox wzory///
        print'<SELECT class="opis_select" NAME="wzory" style="width: 100%;">';

			if ($wzor_wyswietl != "") 
			{
				print"wchodzi wzor".$wzor_wyswietl;
    			print("<OPTION SELECTED VALUE=\"$wzor_wyswietl\">$wzor_wyswietl</OPTION>");
				
				
			}else
			{			
				print'<OPTION SELECTED VALUE="">-&gt; :';
							
			}
	//print'<OPTION SELECTED VALUE="">-&gt; :';
  
		while($rekord_wzor = mysql_fetch_assoc($lista_wzory))
		{
			$wzory[$i] = "";
			$wzory[$i] = $rekord_wzor['Nazwa_wzoru_drukarnia'];
			$wzory[$i] = substr($wzory[$i], 0, 50);
  
			print("<OPTION VALUE=\"$wzory[$i]\">".$wzory[$i]);  
			$i++;  
    
		}
		
   print'</SELECT>';
///koniec combobox wzory///

}


?>
</body>
</html>
