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
        <link href="css/lightbox.css" rel="stylesheet"/>
        <link href="css_wyglad_strony/style.css" rel="stylesheet" type="text/css">
        <link href="css_wyglad_strony/mobile_style.css" rel="stylesheet" type="text/css">
            <link rel="Stylesheet" media="print" type="text/css" href="dodruku.css" />
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
        
</head>

<body>
<?PHP

print'<DIV class="panel_glowny">';

print"<TABLE cellpadding = '0'  cellspacing = '0' border = '0' style='width: 100%; height: 100%;'>";
    print"<tr>";
        print"<td align=center>";
            require_once "zalogowany_banery.php";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>"; 
            print'<DIV class="mniejszy_panel">';
                require_once 'class.Polocz.php';
                $polocz = new Polocz();
                $polocz->open();
                mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                $polocz->close();                     
                print'<FORM ACTION="index.php" METHOD=POST>';
                print'<INPUT TYPE="submit" VALUE="Strona strartowa" CLASS="btn">';
                print'</FORM>';                                    
                print "<br><B><font class='opis_paneli'>Data przyjęcia<br> do magazynu DAMAZ</font></B><br><br>";
                    /////////////////////przycisk data /////////////////////////////////////

                    ////////////pod tym wstaw tabele////////////////////////////////////
                        print'<FORM ACTION="magazyn_damaz.php" METHOD=POST>';
                        print '<INPUT TYPE="hidden" NAME="co" VALUE="opcja">';
                        print'<div align=center>';
                            print"<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 style='width: 70%;'>";
                                print"<TR>";
                                    print"<TD style='width: 80%;'>";
                                        if($_POST['data_data'] == "")
                                        {
                                            $data_miesiac_p=date("m");
                                            $data_dzien_p=date("d");
                                            $data_rok_p=date("Y");
                                            $data = $data_miesiac_p."/".$data_dzien_p."/".$data_rok_p;	
                                        }
                                        else
                                        {
                                            $data = $_POST['data_data'];
                                        }
                                        print"<input class='text_box' type=\"text\" id=\"datepicker\" name=\"data_data\" value=\"$data\" style='width: 90%;'>"; 
                                    print"</TD>";                          
                                    print"<TD style='width: 20%;'>";  
                                        print'<INPUT TYPE="submit" VALUE="Wybierz" CLASS="btn">'; 
                                    print"</TD>"; 
                                print"</TR>";
                            print"</TABLE>";
                        print'</FORM>';
                        print'</div>';
                             //////////////////////koniec przycisk data///////////////////////////////////
            print'</div>';
        print"</td>";
    print"</tr>";
print'</TEBLE>';
print"</DIV>";
print'<DIV>';
print"<TABLE cellpadding = '0'  cellspacing = '0' border = '0' style='width: 100%; height: 100%;'>";
    print"<tr>";
        print"<td align=center>"; 
            /////////wyswietlanie po wybraniu/////////////
            if($_POST['co']=='opcja')
            {
                ////////////////wyszukiwanie z danego dnia /////////////////////////////
                $data=$_POST['data_data'];
                $data_miesiac = substr($data,0, 2);
                $data_dzien = substr($data,3, 2);
                $data_rok = substr($data,6, 5);
                $data_razem = $data_miesiac."/".$data_dzien."/".$data_rok;
                $data_wyswietl = $data_rok."-".$data_miesiac."-".$data_dzien;
                print"<B><font size=3 color=#00004d>$data_wyswietl</font></B><br/>";
                $polocz->open();
                $wynik = mysql_query("SELECT * FROM ZAMOWIENIA_TAB, MAGAZYN_DAMAZ_TAB WHERE MAGAZYN_DAMAZ_TAB.Data_magazynowania LIKE '$data_razem' AND ZAMOWIENIA_TAB.Nr_wiersza = MAGAZYN_DAMAZ_TAB.Nr_wiersza ORDER BY Odbiorca_zamowienia;") or die ("zle pytanie");
                $polocz->close();
                print"<TABLE style='width: 100%; height: 100%;'>";
                    print"<TR bgcolor = #6666ff><TD id='td_kolor' width=2%><B>ARTYKUŁ</B></TD><TD id='td_kolor' width=2%><B>ILOŚĆ</B></TD><TD id='td_kolor' width=5%><B> M./SZT. </B></TD><TD id='td_kolor' width=5%><B>NR PARTI</B></TD><TD id='td_kolor' style='width: auto;'><B>WZÓR</B></TD><TD id='td_kolor' width=2%><B>UWAGI</B></TD><TD id='td_kolor' width=2%><B>STATUS</B></TD><TD id='td_kolor' width=2%><B>PLANOWANA DATA ODBIORU</B></TD></TR>";
                        $temp_zamowienie = 0;
                        $temp_odbiorca = "";
                        while($rekord = mysql_fetch_assoc($wynik))
                        { 
                            $odbiorca_zamowienia = $rekord['Odbiorca_zamowienia'];
                            $artykul_zamowienia = $rekord['Artykul_zamowienia'];
                            $ilosc = $rekord['Ilosc_szt_metrow'];
                            $status_metrow = $rekord['Status_metrow'];
                            $nr_parti = $rekord['Nr_parti'];
                            $wzor = $rekord['Wzory_zamowienia'];
                            $uwagi = utf8_encode($rekord['Uwagi']);
                            $status = $rekord['Status_zamowienia'];
                            $zamowienie_nr = $rekord['Zamowienie_nr'];
                            $data = $rekord['Data'];
                            $status_wpis_do_zeszytu = $rekord['Status_wpis_do_zeszytu'];
                            $planowana_data_odbioru = $rekord['Planowana_data_odbioru'];
                            $kolor = '#FFFFFF';
                            if($temp_odbiorca != $odbiorca_zamowienia)
                            {
                                $kolor = '#33FF66';
                                print"<TR><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='black'>Odbiorca:</font></B></TD><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='black'>$odbiorca_zamowienia</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>";
                                $temp_odbiorca = $odbiorca_zamowienia;   	
                            }
                            if($temp_zamowienie != $zamowienie_nr)
                            {
                                $kolor = '#B8B8B8';
                                print"<TR><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>Zamówienie nr..</font></B></TD><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>$zamowienie_nr</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD bgcolor=$kolor><B><font size='4' color='blue'>Data..</font></B></TD><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>$data</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>";      
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
                                $kolor = '#CCFFCC';
                            }
  
                    print"<TR><TD id='td_kolor' bgcolor=$kolor>$artykul_zamowienia</TD><TD id='td_kolor' align='right' bgcolor=$kolor>$ilosc</TD><TD id='td_kolor' align = 'center' bgcolor=$kolor>$status_metrow</TD><TD id='td_kolor' bgcolor=$kolor>$nr_parti</TD><TD id='td_kolor' bgcolor=$kolor><a href='WZORY_JPG_WSZYSTKIE/$wzor.jpg' data-lightbox='$wzor.jpg' data-title='$wzor'>$wzor</a></TD><TD id='td_kolor' bgcolor=$kolor>$uwagi</TD><TD id='td_kolor' bgcolor=$kolor>$status</TD><TD id='td_kolor' align=center bgcolor=$kolor>$planowana_data_odbioru</TD></TR>";
                        }
                print"</TABLE>";
            }
        print"</td>";
    print"</tr>"; 
    print"<tr>";
        print"<td align=center height=50px>";
        print"</td>";
    print"</tr>";
print"</TABLE>";
print"</div>";




?>

</body>
</html>
