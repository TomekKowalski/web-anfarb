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
        <meta http-equiv="Content-Type" content="text/html; charset="iso-8859-2" />
        <script src = "js/jquery-1.11.0.min.js"> </script>
        <script src = "js/lightbox.min.js"> </script>
        <script src="js_web/script_miniatura_zdjecia.js" async></script>
        <link href="css/lightbox.css" rel="stylesheet"/>
        <link href="css_wyglad_strony/style.css" rel="stylesheet" type="text/css">
        <title>Zamowienia drukarnia</title>
	  
</head>

<body>

<?PHP

print"<DIV class='panel_glowny'>";

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
                    print"<td align=center>";
	
                        require_once 'class.Polocz.php';
                        $polocz = new Polocz();

                        //$odbiorca = $_GET['odbiorca'];
                        $odbiorca = "OGANES HMAJAK";

                        if($odbiorca == "")
                        {
                                $odbiorca = $_POST['odbiorca_po_edycji'];
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
                        $data=date("Y-m-d");

                        if($data_zamowienia !== $data)
                        {
                                $zamowienie_nr++;
                        }
 	


                        if(isset($_POST['Dodaj']))///dopisywanie nowego wiersza
                        {                        
                                if($_POST['artykul'])  
                                {
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
                                               // print_r($wzor)
                                        $uwagi_na_temat_wzoru = "";
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

                                        $query = "INSERT INTO ZAMOWIENIA_TAB VALUES('$odbiorca','$numer_zamowienia','$zamowienie_nr','$data','$artykul','$ilosci','$metry_lub_sztuki','','$wzor','$uwagi','DO AKCEPTACJI','$ilosc_wierszy','0','','$zalogowany');";

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
                        if($_POST['co'] == 'usun')  
                        {
                                  $nr_wiersza_dousuniecia = $_POST['usuwaj'];
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


                                  $wzor = "";
                                  $uwagi = "";
                                  $_POST['wzory'] = "";		
                              $_POST['uwagi'] = "";
                        }

                        ///////////koniec usuwania wiersza/////////////////////////////////////////////////////////////////
                        print"<DIV class='mniejszy_panel'>";

                            print'<FORM ACTION="index.php" METHOD=POST>';
                            print'<INPUT TYPE="submit" VALUE="Zamówienia" CLASS="btn">';
                            print'</FORM>';

                            print "<br><B><font size='5' color='blue'>Nowe zamówienie $odbiorca</font></B><br><br>";
                        print"</div>";
                            ///////////////wyswietlanie tabeli //////////////////////////////////////
                    print"</td>";
                print"</tr>";
            print"</TABLE>";

        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";
            print'<a href="#dopisywanie_zamowien">';
                print"<B><font size='1' color='blue'>NOWY WIERSZ</font></B><br><br>";
            print'</a>'; 
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";                             
            print"<TABLE border = '0' style='width: 95%; height: 100%;'>";
                print"<TR><TD id='td_kolor' width=10% bgcolor = #6666ff><B>ARTYKUŁ</B></TD><TD id='td_kolor' width=2% bgcolor = #6666ff><B>ILOŚĆ</B></TD><TD id='td_kolor' width=5% bgcolor = #6666ff><B> M./SZT. </B></TD><TD id='td_kolor' width=5% bgcolor = #6666ff><B>NR PARTI</B></TD><TD id='td_kolor' width=15% bgcolor = #6666ff><B>WZÓR</B></TD><TD id='td_kolor' width=33% bgcolor = #6666ff><B>UWAGI</B></TD><TD id='td_kolor' width=10% bgcolor = #6666ff><B>STATUS</B></TD><TD id='td_kolor' width=10% bgcolor = #6666ff></TD><TD id='td_kolor' width=10% bgcolor = #6666ff></TD></TR>";
                    $kolor = '#B8B8B8';
                print"<TR><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>Zamówienie nr..</font></B></TD><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>$zamowienie_nr</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>Data..</font></B></TD><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>$data</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>";
        
                    $polocz->open();
                        mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                        $wynik = mysql_query("SELECT * FROM ZAMOWIENIA_TAB WHERE Odbiorca_zamowienia = '$odbiorca' AND Data = '$data' AND Zamowienie_nr = '$zamowienie_nr'") or die ("zle pytanie");

                    $polocz->close();
                    $ktory_wiersz = 0;
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
                        print"<TR><TD id='td_kolor' bgcolor=$kolor>$artykul_zamowienia</TD><TD id='td_kolor' align='right' bgcolor=$kolor>$ilosc</TD><TD id='td_kolor' align = 'center' bgcolor=$kolor>$status_metrow</TD><TD id='td_kolor' bgcolor=$kolor>$nr_parti</TD><TD id='td_kolor' bgcolor=$kolor><a href='WZORY_JPG_WSZYSTKIE/$wzor_baza.jpg' data-lightbox='$wzor_baza.jpg' data-title='$wzor_baza'><div id='td_wzor".$ktory_wiersz."' class=''>$wzor_baza</div></a></TD><TD id='td_kolor' bgcolor=$kolor>$uwagi_baza</TD><TD id='td_kolor' bgcolor=$kolor>$status</TD>";                          
                                $ktory_wiersz ++;
                            print"<TD id='td_kolor' bgcolor=$kolor align=center>";
                            
                                if($nr_parti == "")/// PRZYCISK EDYCJA/////////////////
                                {
                                    if($status == 'DO AKCEPTACJI') 
                                    {
                                        print"<a href = 'formularz_edycja_oganes.php?nr_wiersza=$nr_wiersza'>"; 
                                        print'<INPUT TYPE="submit" VALUE="Edytuj" CLASS="btn">';
                                        print'</a>';
                                    }

                                }
                             
                             
                            print"</TD>";                          		
                            print"<TD id='td_kolor' bgcolor=$kolor align=center>";                           
                                if($status == 'DO AKCEPTACJI') ////////PRZYCISK USUN
                                {
                                        print '<FORM METHOD="POST">';
                                        print '<INPUT TYPE="hidden" NAME="usuwaj" VALUE="'.$nr_wiersza.'">';
                                        print '<INPUT TYPE="hidden" NAME="co" VALUE="usun">';

                                        print'<INPUT TYPE="submit" VALUE="X Usuń" CLASS="btn">';
                                        print '</FORM>';				
                                }
                            print"</TD>";		
                        print"</TR>";
  
                    }
            print"</TABLE>";
            
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";

            print"<TABLE  cellpadding = '0'  cellspacing = '0' border = '0' style='width: 100%; height: 100%;'>";
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
            print'<a id="dopisywanie_zamowien">'; ////etykieta przeniesienia
                print"<B><font size='1' color='blue'>NOWY WIERSZ</font></B><br>";
            print'</a>';  ////etykieta przeniesienia
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";                       
              ////////////////////////////////////////////////////////////////////////
                print"<div class='wiekszy_panel'>";
                    print '<FORM ACTION="formularz_nowe_zamowienie_oganes.php#dopisywanie_zamowien" METHOD="POST"><br>    ';
                    print '<INPUT TYPE="hidden" NAME="co" VALUE="dodaj">';
                    print '<TABLE border=0 style="width: 100%; height: 100%;">';
                        print '<TR><TD style="width: 30%; text-align: left;"><B><font size=3 color=#00004d>Artykul:</font></B></TD><TD style="width: 5%; text-align: left;"><B><font size=3 color=#00004d>Ilość:</font></B></TD><TD style="width: 10%; text-align: left;"><B><font size=3 color=#00004d>metry/sztuki</font></B></TD><TD style="width: 30%; text-align: left;"><B><font size=3 color=#00004d>Wzory:</font></B></TD><TD style="width: 25%; text-align: left;"><B><font size=3 color=#00004d>Uwagi:</font></B></TD></TR>';
                        print '<TR>';
                            print'<TD VALIGN="top" style="text-align: left;">';

                            if(isset($_POST['szukaj_artykul_przycisk']))///klikniety przycisk szukaj artykul
                            {	
                                    $_SESSION['zapamietany_artykul'] = $_POST['szukaj_artykul'];

                                                    //$artykul = $_POST['artykul']; 		   		
                                            $ilosci = htmlspecialchars($_POST['ilosc']);		
                                                    $metry_lub_sztuki = htmlspecialchars($_POST['metry_sztuki']);		
                                            $wzor = htmlspecialchars($_POST['wzory']);		
                                            $uwagi = htmlspecialchars($_POST['uwagi']);

                                                    /*
                                                    print"artykul :".$artykul;
                                                    print'<br>';
                                                    print"ilosc :".$ilosci;
                                                    print'<br>';
                                                    print"metry :".$metry_lub_sztuki;
                                                    print'<br>';
                                                    print"wzor :".$wzor;
                                                    print'<br>';
                                                    print"uwagi :".$uwagi;
                                                    */

                                    //print"wchodzi szukany artykul : ".$_SESSION['zapamietany_artykul'];

                            }

                            if(isset($_POST['szukaj_wzor_przycisk']))///klikniety przycisk szukaj wzor
                            {	
                                    //$_SESSION['zapamietany_artykul'] = $_POST['szukaj_artykul'];

                                                    $artykul = $_POST['artykul']; 

                                            $ilosci = htmlspecialchars($_POST['ilosc']);		
                                                    $metry_lub_sztuki = htmlspecialchars($_POST['metry_sztuki']);		
                                            $wzor = "";		
                                            $uwagi = htmlspecialchars($_POST['uwagi']);


                                                    /*
                                                    print"artykul :".$artykul;
                                                    print'<br>';
                                                    print"ilosc :".$ilosci;
                                                    print'<br>';
                                                    print"metry :".$metry_lub_sztuki;
                                                    print'<br>';
                                                    print"wzor :".$wzor;
                                                    print'<br>';
                                                    print"uwagi :".$uwagi;
                                                    */

                                    //print"wchodzi szukany artykul : ".$_SESSION['zapamietany_artykul'];

                            }


                                ///combobox artykul///


                            print'<SELECT NAME="artykul" style="width: 98%;">';

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

                                   // $lista_szukaj_artykul = mysql_query("SELECT Nazwa_artykul FROM ARTYKUL_TAB WHERE Nazwa_artykul LIKE '%$szukany_artykul%' ORDER BY Nazwa_artykul;") or die ("zle pytanie");
                                    $lista_szukaj_artykul = mysql_query("SELECT Artykul_zamowienia FROM ZAMOWIENIA_TAB WHERE Odbiorca_zamowienia = 'OGANES HMAJAK' AND Artykul_zamowienia LIKE '%$szukany_artykul%' GROUP BY Artykul_zamowienia ORDER BY Artykul_zamowienia;") or die ("zle pytanie");

                                    $polocz->close();

                                    while($rekord_szukaj_artykul = mysql_fetch_assoc($lista_szukaj_artykul))
                                    {
                                            $artykuly_wyszukane[$i] = $rekord_szukaj_artykul['Artykul_zamowienia'];
                                            print("<OPTION VALUE=\"$artykuly_wyszukane[$i]\">".$artykuly_wyszukane[$i]);
                                            $i++;   
                                    }
                            print'</SELECT>';

	
                                ///koniec combobox artykul///

                            print '</TD>';

                            if (isset($_POST['checkbox_zapamietaj'])||isset($_POST['szukaj_artykul_przycisk'])||isset($_POST['szukaj_wzor_przycisk'])) 
                            {
                                print '<TD VALIGN="top" style="text-align: left;"><INPUT style="width: 88%;" TYPE="text" NAME="ilosc" VALUE="'.$ilosci.'"></TD>';
                            }else
                            {
                                print '<TD VALIGN="top" style="text-align: left;"><INPUT style="width: 88%;" TYPE="text" NAME="ilosc"></TD>';
                            }

                            print '<TD VALIGN="top">';
                            ///combobox metry sztuki///

                            $metry_sztuki = array('0' => 'sztuk', '1' => 'metr(y)', '2' => 'raport(y)');


                                print'<SELECT NAME="metry_sztuki" style="width: 98%;">';
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
                            print '<TD VALIGN="top" style="text-align: left;">';

                                if ($_POST['checkbox_zapamietaj'] != "" || $_POST['co'] == 'usun' || isset($_POST['Dodaj']))
                                {
                                        $wzor = "";
                                        $uwagi = "";
                                        $_POST['wzory'] = "";		
                                    $_POST['uwagi'] = "";
                                }
                                combobox_wzory($wzor);
                            print '</TD>';
                            print '<TD VALIGN="top" style="text-align: left;">';
                                print '<INPUT TYPE="hidden" NAME="uwagi">';
                                print "<textarea NAME=uwagi cols=50 rows=3 style='margin-bottom: 5px; font-size: 18px; width: 95%;'>$uwagi</textarea>";
                            print '</TD>';
                        print '</TR>';
                            ////////////////////////checkbox zapamietaj////////////////////////////////
                        print '<TR>';

                            if (isset($_POST['checkbox_zapamietaj'])) 
                            {
                                print '<TD style="text-align: left;"><br><input type="checkbox" NAME="checkbox_zapamietaj" VALUE="true" checked><B><font size=3 color=#00004d> Zapamiętaj artykuł, ilosć,  metry/sztuki </font></B></TD>';
                            }else{
                                print '<TD style="text-align: left;"><br><input type="checkbox" NAME="checkbox_zapamietaj" VALUE="true"><B><font size=3 color=#00004d> Zapamiętaj artykuł, ilosć,  metry/sztuki </font></B></TD>';
                            }
                            print '<TD></TD>';
                            print '<TD></TD>';
                            print '<TD style="text-align: left;">';
                                 print'<INPUT TYPE="submit" NAME="Dodaj" VALUE="Dodaj do zamówienia" CLASS="btn">';                               
                            print'</TD>';
                            print '<TD></TD>';
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
                            print '<TD style="text-align: left;">';
                                ////////////////////wybieranie szukania artykulu//////////////////////////
                                print '<INPUT TYPE="hidden" NAME="co" VALUE="szukany_artykul">';
                                print '<br><INPUT style="width: 30%;" TYPE="text" NAME="szukaj_artykul" size="15" VALUE="'.$szukany_artykul_zapamietany.'">  ';
                                print '<INPUT TYPE="submit" NAME="szukaj_artykul_przycisk" VALUE="szukaj artykuł" CLASS="btn">';
                                ///////////////////////////////////////////////////////////////////////////
                            print '</TD>';
                            print'<TD></TD><TD></TD>';
                            print'<TD style="text-align: left;">';
                                //////////////////szukanie wzorow/////////////////////////////////////////
                                print '<INPUT TYPE="hidden" NAME="co" VALUE="szukany_wzor">';
                                print '<br><INPUT style="width: 30%;" TYPE="text" NAME="szukaj_wzor" size="15" VALUE="'.$szukany_wzor_zapamietany.'">  ';
                                print '<INPUT TYPE="submit" NAME="szukaj_wzor_przycisk" VALUE="szukaj wzór" CLASS="btn">';

                                ///////////////////////////////////////////////////////////////////////
                            print'</TD>';
                            print'<TD></TD>';
                        print '</TR>';
                    print '</TABLE>';
                    print '</FORM>';
                print"</div>";
                ////////////////////koniec dol kontener wklesly //////////////////////
        print"</td>";
    print"</tr>";  
print"</TABLE>";


print"</DIV>";


function combobox_wzory($wzor_wyswietl)
{
	
	if($_POST['co'] == 'szukany_wzor')///klikniety przycisk szukaj artykul
	{
		$_SESSION['zapamietany_wzor'] = $_POST['szukaj_wzor'];
	}
	
	$szukany_wzor_baza = $_SESSION['zapamietany_wzor'];
	
        /*
	if($szukany_wzor_baza == "")
	{
		$szukany_wzor_baza = "szukaj";
	}
         
         */

        require_once 'class.Polocz.php';
        $polocz = new Polocz();
        $polocz->open();
            mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
  
        mysql_select_db("DRUKARNIA_BAZA") or die ("nie ma poloczenia drukarnia baza");
        $lista_wzory = mysql_query("SELECT Nazwa_wzoru_drukarnia FROM WZORY_DRUKARNIA_OGANES_TAB WHERE Nazwa_wzoru_drukarnia LIKE '%$szukany_wzor_baza%' ORDER BY Nazwa_wzoru_drukarnia;") or die ("zle pytanie");

        $polocz->close();

            ///combobox wzory///
        print'<SELECT NAME="wzory" style="width: 98%;">';

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
    <figure id="miniatura_zdjecia"></figure>
</body>
</html>
