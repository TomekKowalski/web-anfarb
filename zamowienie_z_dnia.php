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
        <!--<script src="js_web/script_ilosc_do_druku.js" async></script>-->
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
             <!--
	<script>	
		$(function() {
		$( "#datepicker" ).datepicker();
		});
	</script>
             -->
	
</head>

<body>
<?PHP



print'<DIV class="do_tabeli">';

print"<TABLE  cellpadding = '0'  cellspacing = '0' border = '0' style='width: 100%; height: 100%;'>";   
    print"<tr>";
        print"<td align=center>";
            require_once "zalogowany_banery.php";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";
            print'<DIV id="panel_filtr_ilosc_do_druku" class="mniejszy_panel">';
                            print'<FORM ACTION="index.php" METHOD=POST>';
                            print'<INPUT TYPE="submit" VALUE="Strona startowa" CLASS="btn">';
                            print'</FORM>';                                  
                    
                            ////////////koniec przycisk i nazwa odbiorcy////////////////
                            print'<br>';
                            /////////////przycisk data wybierz/////////////////////////
                            print "<B><font class='opis_paneli'>Zamówienia z dnia</font></B><br><br>";

                            print'<FORM ACTION="zamowienie_z_dnia.php" METHOD=POST>';
                            print '<INPUT TYPE="hidden" NAME="co" VALUE="opcja">';

                                print'<div align=center>';
                                    print"<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 style='width: 70%;'>";
                                        print"<TR>";
                                            print"<TD class='td_pole_daty'>";  
                                                if($_POST['data_data'] == "")
                                                {
                                                   $data_miesiac_p=date("m");
                                                   $data_dzien_p=date("d");
                                                   $data_rok_p=date("Y");
                                                   $data = $data_rok_p."-".$data_miesiac_p."-".$data_dzien_p;
                                                   //$data = $data_miesiac_p."/".$data_dzien_p."/".$data_rok_p;
                                                }else{
                                                  $data = $_POST['data_data'];
                                                }
                                                //print"<input class='text_box' type=\"text\" id=\"datepicker\" name=\"data_data\" value=\"$data\" style='width: 95%;'>";
                                                print"<input class='text_box' type='date' name='data_data' value='".$data."'>";

                                            print"</TD>"; 
                                            print"<TD class='td_pole_spacja'></TD>";
                                            print"<TD class='td_pole_przycisk'>";
                                                print'<INPUT TYPE="submit" VALUE="Wybierz" CLASS="btn">'; 
                                            print"</TD>";
                                        print"</TR>";
                                    print"</TABLE>";
                                print'</div>';
                            print'</FORM>';
                                ////////////////////koniec dol kontener wklesly //////////////////////
                        print'</div>';
            print"</td>";
    print"</tr>"; 
print"</TABLE>";
print"</DIV>";
print"<div align=center>";
            print"<TABLE cellpadding = '0'  cellspacing = '0' border = '0' style='width: 98%; height: 100%;'>";               
                print"<tr>";
                    print"<td align=center>";
  
                                ///////////////////koniec przycisk data wybierz///////////////////
                            require_once 'class.Polocz.php';
                            $polocz = new Polocz();

                                /////////wyswietlanie po wybraniu/////////////

                            if($_POST['co']=='opcja')
                            {

                                    ////////////////wyszukiwanie z danego dnia /////////////////////////////
                                    $data_razem=$_POST['data_data'];                                                                 
                                    print"<br/><B><font size=3 color=#00004d>$data_razem</font></B><br/>"; 
                                    $polocz->open(); 
                                    mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                                    $wynik = mysql_query("SELECT * FROM ZAMOWIENIA_TAB WHERE Data LIKE '$data_razem' AND Nr_parti NOT LIKE '%usuniete%' ORDER BY Odbiorca_zamowienia;") or die ("zle pytanie");
                                    $polocz->close();
                                print"<DIV ALIGN=center>";

                                    print"<TABLE>";
                                        print"<TR bgcolor = #6666ff><TD id='td_kolor' width=10%><B>ARTYKUŁ</B></TD><TD id='td_kolor' width=2%><B>ILOŚĆ</B></TD><TD id='td_kolor' width=5%><B> M./SZT. </B></TD><TD id='td_kolor' width=5%><B>NR PARTI</B></TD><TD id='td_kolor' width=15%><B>WZÓR</B></TD><TD id='td_kolor' width=43%><B>UWAGI</B></TD><TD id='td_kolor' width=10%><B>STATUS</B></TD><TD id='td_kolor' width=10%><B>PLANOWANA DATA ODBIORU</B></TD></TR>";

                                            $temp_zamowienie = 0;
                                            $temp_odbiorca = "";
                                            $ilosc_sztuk = 0;
                                            $ilosc_metrow = 0;
                                            $ktory_wiersz = 0;

                                            while($rekord = mysql_fetch_assoc($wynik)){



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

                                              $status_wpis_do_zeszytu = $rekord['Status_wpis_do_zeszytu'];

                                              $planowana_data_odbioru = $rekord['Planowana_data_odbioru'];

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
                                                    print"<TR><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='black'>Odbiorca:</font></B></TD><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='black'>$odbiorca_zamowienia</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>\n";
                                                    $temp_odbiorca = $odbiorca_zamowienia;

                                              }


                                              if($temp_zamowienie != $zamowienie_nr)
                                              {
                                                            $kolor = '#B8B8B8';
                                                    print"<TR><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>Zamówienie nr..</font></B></TD><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>$zamowienie_nr</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD bgcolor=$kolor><B><font size='4' color='blue'>Data..</font></B></TD><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>$data</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>\n";

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
                                              if($status == 'DO AKCEPTACJI')
                                              {
                                                $kolor = '#ffe6e6';
                                              }
                                            if($status == 'ZALICZKA')
                                            {
                                                $kolor = '#DCDCDC';
                                            }




                                        print"<TR><TD id='td_kolor' bgcolor=$kolor>$artykul_zamowienia</TD><TD id='td_kolor' align='right' bgcolor=$kolor>$ilosc</TD><TD id='td_kolor' align = 'center' bgcolor=$kolor>$status_metrow</TD><TD id='td_kolor' bgcolor=$kolor>$nr_parti</TD><TD id='td_kolor' bgcolor=$kolor><a href='WZORY_JPG_WSZYSTKIE/$wzor.jpg' data-lightbox='$wzor.jpg' data-title='$wzor'><div id='td_wzor".$ktory_wiersz."' class=''>$wzor</div></a></TD><TD id='td_kolor' bgcolor=$kolor>$uwagi</TD><TD id='td_kolor' bgcolor=$kolor>$status</TD><TD id='td_kolor' align=center bgcolor=$kolor>$planowana_data_odbioru</TD></TR>\n";
                                        $ktory_wiersz ++;

                                        }

                                    print"</TABLE>";
                                print"</DIV>";
                            }
                            else{
                                    ////////////////////////////////////////////////// 
  
                            }
                            print'<br>';
                            
                    print"</td>";
                print"</tr>";
            print"</TABLE>";
print"</DIV>";

print"<br><br><br><br><br><br><br><br><br><br><br><br><br>";
print '<DIV id="panel_dolny_ilosc_do_druku" class="dolny_do_tabeli">';
                            print '<DIV class="mniejszy_panel">';

                                $ilosc_metrow = $ilosc_metrow/45;
                                $ilosc_sztuk += $ilosc_metrow;

                                print "<B><font class='opis_paneli'>Do druku :  "; echo (int)"$ilosc_sztuk"; print"   sztuk</font></B><br>";

                                print'<FORM ACTION="wykres_ile_do_druku.php" METHOD=POST>';
                                print'<INPUT TYPE="submit" VALUE="Wykres" CLASS="btn">';
                                print'</FORM>';                          
                            print "</DIV>";
print"</DIV>";



?>

    <figure id="miniatura_zdjecia"></figure>

</body>
</html>
