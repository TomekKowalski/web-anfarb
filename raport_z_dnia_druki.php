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
    
<DIV class="do_tabeli" id="niedrukuj">

<TABLE  cellpadding = '0'  cellspacing = '0' border = '0' style='width: 100%; height: 100%;'> 
    <tr>
        <td align=center>
            <?PHP require_once "zalogowany_banery.php"; ?>
        </td>
    </tr>
        <tr>
            <td align=center>
                <DIV class="mniejszy_panel">
                            <FORM ACTION="index.php" METHOD=POST>
                                <INPUT TYPE="submit" VALUE="Strona startowa" CLASS="btn">
                            </FORM>                                  
                    
                             <!--////////////koniec przycisk i nazwa odbiorcy////////////////-->
                            <br>
                            <!--/////////////przycisk data wybierz/////////////////////////-->
                            <B><font class='opis_paneli'>Raport z dnia druki</font></B><br><br>

                            <FORM ACTION="raport_z_dnia_druki.php" METHOD=POST>
                                <INPUT TYPE="hidden" NAME="co" VALUE="opcja">

                                <div align=center>
                                    <TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 style='width: 70%;'>
                                        <TR>
                                            <TD class='td_pole_daty'>
                                                <?PHP
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
                                                                  
                                    print"<br/><B><font size=3 color=#00004d>Raport z dnia $data_razem druki</font></B><br/><br>"; 
                                    $polocz->open(); 
                                    mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                                    
                                    if($data_razem < "2021-10-31")
                                    {
                                       $wynik = mysql_query("SELECT Z.Odbiorca_zamowienia, Z.Artykul_zamowienia, Z.Ilosc_szt_metrow, Z.Status_metrow, Z.Data, K.uzytkownik FROM (ZAMOWIENIA_TAB Z LEFT JOIN view_kto_wpisal_zamowienie K ON Z.Nr_wiersza = K.id_wiersza_zamowienia) WHERE Z.Data LIKE '$data_razem' AND Z.Nr_parti NOT LIKE '%usuniete%' ORDER BY K.uzytkownik;") or die ("zle pytanie zamowienia");                        
                                    }
                                    else 
                                    {
                                        $wynik = mysql_query("SELECT Z.Odbiorca_zamowienia, Z.Artykul_zamowienia, Z.Ilosc_szt_metrow, Z.Status_metrow, Z.Data, Z.Kto_wpisal, Z.Status_zamowienia FROM ZAMOWIENIA_TAB Z WHERE Z.Data LIKE '$data_razem' AND Z.Nr_parti NOT LIKE '%usuniete%' AND Z.Artykul_zamowienia NOT LIKE '%BT2424%' ORDER BY Z.Kto_wpisal, Z.Odbiorca_zamowienia;") or die ("zle pytanie zamowienia");                        
                                  
                                        //print"data powyzej";
                                    }
                                    
                                    $polocz->close();
                                print"<DIV ALIGN=center>";

                                    print"<TABLE width=80%>";
                                        print"<TR bgcolor = #6666ff><TD id='td_kolor' style='width: 50%;'><B>ARTYKUŁ</B></TD><TD id='td_kolor' style='width: 15%;'><B>ILOŚĆ</B></TD><TD id='td_kolor' style='width: 15%;'><B> M./SZT. </B></TD><TD id='td_kolor' style='width: 20%;'><B> UWAGI </B></TD></TR>";

                                            $temp_zamowienie = 0;
                                            $temp_odbiorca = "";
                                            $ilosc_sztuk = 0;
                                            $ilosc_metrow = 0;
                                            $opis_sztuki = "";
                                            
                                            $licz_rekordy = 0;
                                            
                                            $temp_uzytkownik = "";
                                            $temp_ilosc_sztuk_uzytkownik = 0;
                                            $temp_ilosc_metrow_uzytkownik = 0;

                                            while($rekord = mysql_fetch_assoc($wynik)){



                                              $odbiorca_zamowienia = $rekord['Odbiorca_zamowienia'];
                                              
                                              $artykul_zamowienia = $rekord['Artykul_zamowienia'];
                                              $ilosc = $rekord['Ilosc_szt_metrow'];
                                              $status_metrow = $rekord['Status_metrow'];
                                              
                                                if($data_razem < "2021-10-31")
                                                {
                                                    $uzytkownik = $rekord['uzytkownik'];
                                                }
                                                else 
                                                {
                                                    $uzytkownik = $rekord['Kto_wpisal'];
                                                }
                                              
                                                $data = $rekord['Data'];

                                                if($uzytkownik == "OGANES_HMAJAK")
                                                {
                                                    $uzytkownik = "Mariusz";
                                                }
                                                $status_zamowienia = $rekord['Status_zamowienia'];
                                                
                                                if($status_zamowienia === "ZALICZKA")
                                                {
                                                    $status_zamowienia = "CZEKA NA ZALICZKĘ";
                                                }
                                                else
                                                {
                                                    $status_zamowienia = "";
                                                }
                                                
                                              
                                               

                                              
                                              //////////////zliczanie sztuk / metrow ////////////////////////////
                                              if($odbiorca_zamowienia != "PAKAITA" && $odbiorca_zamowienia != "ROKIET" && $odbiorca_zamowienia != "PRÓBY DRUKU" && $odbiorca_zamowienia != "CANORRA" && $odbiorca_zamowienia != "MADRES" && $odbiorca_zamowienia != "ZZZ" && $odbiorca_zamowienia != "PRZYGOTOWANIE PRODUKCJI" && $uzytkownik != "TOMEK-DRUKARNIA" && $uzytkownik != "ASIA-DRUKARNIA" && $uzytkownik != "DRUK-Kasia" && $uzytkownik != "" && $artykul_zamowienia != 'DZIANINA PES/T')
                                              {

                                                
                                                if($temp_odbiorca_suma_1 != $odbiorca_zamowienia)
                                                {
                                                    //podliczanie metrow szt odbiorcy
                                                    if($licz_rekordy != 0)
                                                    {
                                                        $temp_ilosc_metrow_odbiorca = $temp_ilosc_metrow_odbiorca/45;
                                                        $temp_ilosc_sztuk_odbiorca += $temp_ilosc_metrow_odbiorca;
                                                        
                                                        
                                                        if($temp_ilosc_sztuk_odbiorca < 1)
                                                        {
                                                            $opis_sztuki_odbiorca = "sztuk";
                                                        }
                                                        if($temp_ilosc_sztuk_odbiorca >= 1)
                                                        {
                                                            $opis_sztuki_odbiorca = "sztuka";
                                                        }
                                                        if($temp_ilosc_sztuk_odbiorca >= 2 && $temp_ilosc_sztuk_odbiorca < 5)
                                                        {
                                                            $opis_sztuki_odbiorca = "sztuki";
                                                        }
                                                        if($temp_ilosc_sztuk_odbiorca > 5)
                                                        {
                                                            $opis_sztuki_odbiorca = "sztuk";
                                                        }
                                                        
                                                        $kolor = '#FFFACD';
                                                              //print"<TR><TD id='td_kolor' bgcolor=$kolor><B><font style= 'size:4; color:blue;'>$odbiorca_zamowienia</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>\n";
                                                        //print"<TR><TD id='td_kolor' bgcolor=$kolor><B><font style= 'font-size:18px; color:red;'>$odbiorca_zamowienia</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>\n";
                                                        print"<TR><TD id='td_kolor' bgcolor=$kolor align=right></TD><TD id='td_kolor' bgcolor=$kolor align=center><B><font size='4' color='#708090'>Suma:  "; echo (int)"$temp_ilosc_sztuk_odbiorca"; print"  $opis_sztuki_odbiorca</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>\n";
                                                        
                                                        $temp_ilosc_metrow_odbiorca = 0;
                                                        $temp_ilosc_sztuk_odbiorca = 0;
                                                    }           

                                                    $temp_odbiorca_suma_1 = $odbiorca_zamowienia;

                                                }
                                                

                                                $kolor = '#FFFFFF';                                                                

                                                if($temp_uzytkownik != $uzytkownik)
                                                {
                                                    
                                                    
                                                    if($licz_rekordy != 0)
                                                    {
                                                        $temp_ilosc_metrow_uzytkownik = $temp_ilosc_metrow_uzytkownik/45;
                                                        $temp_ilosc_sztuk_uzytkownik += $temp_ilosc_metrow_uzytkownik;
                                                        
                                                        if($temp_ilosc_sztuk_uzytkownik < 1)
                                                        {
                                                            $opis_sztuki = "sztuk";
                                                        }
                                                        if($temp_ilosc_sztuk_uzytkownik >= 1)
                                                        {
                                                            $opis_sztuki = "sztuka";
                                                        }
                                                        if($temp_ilosc_sztuk_uzytkownik >= 2 && $temp_ilosc_sztuk_uzytkownik < 5)
                                                        {
                                                            $opis_sztuki = "sztuki";
                                                        }
                                                        if($temp_ilosc_sztuk_uzytkownik > 5)
                                                        {
                                                            $opis_sztuki = "sztuk";
                                                        }
                                                        
                                                        
                                                        
                                                        //print_r($temp_ilosc_sztuk_uzytkownik); print"<br>";
                                                        $kolor = '#F3E5F5';
                                                        print"<TR><TD id='td_kolor' bgcolor=$kolor align=right></TD><TD id='td_kolor' bgcolor=$kolor align=center><B><font size='4' color='black'>Razem:  "; echo (int)"$temp_ilosc_sztuk_uzytkownik"; print"  $opis_sztuki</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>\n";
                                                        
                                                        $temp_ilosc_metrow_uzytkownik = 0;
                                                        $temp_ilosc_sztuk_uzytkownik = 0;
                                                    }
                                                    if($uzytkownik == "Jacek Kęska")
                                                    {
                                                        $uzytkownik_do_wyswietlenia = "Jacek";
                                                    }
                                                    else{
                                                        $uzytkownik_do_wyswietlenia = $uzytkownik;
                                                    }
                                                    //$kolor = '#CC0033';
                                                    $kolor = '#99CCCC';
                                                    //print"<TR><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>$uzytkownik</font></B></TD><TD id='td_kolor' bgcolor=$kolor>$uzytkownik</TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>\n";
                                                    print"<TR><TD id='td_kolor' style='background-color:$kolor; text-align: right;'><B><font style= 'font-size:22px; color:#003366;'>$uzytkownik_do_wyswietlenia</font></B></TD><TD id='td_kolor' style='background-color:$kolor;'></TD><TD id='td_kolor' style='background-color:$kolor;'></TD><TD id='td_kolor' style='background-color:$kolor;'></TD></TR>\n";
                                                    
                                                    $temp_uzytkownik = $uzytkownik;
                                                }
                                                
                                                if($status_metrow == "sztuk")
                                                {
                                                  $ilosc_sztuk += $ilosc; 
                                                  $temp_ilosc_sztuk_uzytkownik += $ilosc;
                                                  $temp_ilosc_sztuk_odbiorca += $ilosc;
                                                  //print_r($temp_ilosc_sztuk_uzytkownik); print"<br>";
                                                }
                                                if(($status_metrow == "raport(y)") || ($status_metrow == "metr(y)"))
                                                {
                                                  $ilosc_metrow += $ilosc;
                                                  $temp_ilosc_metrow_uzytkownik += $ilosc;
                                                  $temp_ilosc_metrow_odbiorca += $ilosc;
                                                  //print_r($temp_ilosc_metrow_uzytkownik); print"<br>";
                                                }
                                                
                                                $licz_rekordy++;
                                                
                                                $kolor = '#FFFFFF';
                                                if($temp_odbiorca != $odbiorca_zamowienia)
                                                {
                                                    
                                                      $kolor = '#33FF66';
                                                      //print"<TR><TD id='td_kolor' bgcolor=$kolor><B><font style= 'size:4; color:blue;'>$odbiorca_zamowienia</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>\n";
                                                      print"<TR><TD id='td_kolor' bgcolor=$kolor><B><font style= 'font-size:18px; color:red;'>$odbiorca_zamowienia</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>\n";
                                                      
                                                      $temp_odbiorca = $odbiorca_zamowienia;
                                                     

                                                }
                                                
                                                $kolor = '#FFFFFF';
                                                    
                                                if($status_zamowienia === "CZEKA NA ZALICZKĘ")
                                                {
                                                   $kolor = '#C0C0C0'; 
                                                }



                                              print"<TR><TD id='td_kolor' bgcolor=$kolor>$artykul_zamowienia</TD><TD id='td_kolor' align='right' bgcolor=$kolor>$ilosc</TD><TD id='td_kolor' align = 'center' bgcolor=$kolor>$status_metrow</TD><TD id='td_kolor' align = 'center' bgcolor=$kolor>$status_zamowienia</TD></TR>\n";
                                              
                                              
                                            }                                             
                                        }
                                        if($ilosc != 0 && $temp_ilosc_sztuk_uzytkownik == 0 && $status_metrow == "sztuk")
                                        {
                                            $temp_ilosc_sztuk_uzytkownik = $ilosc;
                                        }
                                        else
                                        {
                                            $temp_ilosc_metrow_uzytkownik = $temp_ilosc_metrow_uzytkownik/45;
                                            $temp_ilosc_sztuk_uzytkownik += $temp_ilosc_metrow_uzytkownik;
                                        }
                                        
                                        //$temp_ilosc_sztuk_uzytkownik = (int)$temp_ilosc_sztuk_uzytkownik;
                                                        if($temp_ilosc_sztuk_uzytkownik < 1)
                                                        {
                                                            $opis_sztuki = "sztuk";                                                           
                                                        }
                                                        if($temp_ilosc_sztuk_uzytkownik >= 1)
                                                        {
                                                            $opis_sztuki = "sztuka";                                                           
                                                        }
                                                        if($temp_ilosc_sztuk_uzytkownik >= 2 && $temp_ilosc_sztuk_uzytkownik < 5)
                                                        {
                                                            $opis_sztuki = "sztuki";                              
                                                        }
                                                        if($temp_ilosc_sztuk_uzytkownik > 5)
                                                        {
                                                            $opis_sztuki = "sztuk";
                                                        }
                                                        if($status_metrow != "sztuk" && $ilosc != 0 && $temp_ilosc_sztuk_uzytkownik == 0)
                                                        {
                                                            $opis_sztuki = $status_metrow;
                                                        }
                                                        
                                                if($temp_odbiorca_suma != $odbiorca_zamowienia)
                                                {
                                                        $temp_ilosc_metrow_odbiorca = $temp_ilosc_metrow_odbiorca/45;
                                                        $temp_ilosc_sztuk_odbiorca += $temp_ilosc_metrow_odbiorca;
                                                        
                                                        if($temp_ilosc_sztuk_odbiorca == 0)
                                                        {
                                                            $opis_sztuki_odbiorca = "sztuk";
                                                        }
                                                        if($temp_ilosc_sztuk_odbiorca > 0)
                                                        {
                                                            $opis_sztuki_odbiorca = "sztuka";
                                                        }
                                                        if($temp_ilosc_sztuk_odbiorca >= 2 && $temp_ilosc_sztuk_odbiorca < 5)
                                                        {
                                                            $opis_sztuki_odbiorca = "sztuki";
                                                        }
                                                        if($temp_ilosc_sztuk_odbiorca > 5)
                                                        {
                                                            $opis_sztuki_odbiorca = "sztuk";
                                                        }
                                                        $kolor = '#FFFACD';
                                                      //print"<TR><TD id='td_kolor' bgcolor=$kolor><B><font style= 'size:4; color:blue;'>$odbiorca_zamowienia</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>\n";
                                                      print"<TR><TD id='td_kolor' bgcolor=$kolor align=right></TD><TD id='td_kolor' bgcolor=$kolor align=center><B><font size='4' color='#708090'>Suma:  "; echo (int)"$temp_ilosc_sztuk_odbiorca"; print"  $opis_sztuki_odbiorca</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>\n";
                                                        
                                                      
                                                      $temp_odbiorca_suma = $odbiorca_zamowienia;

                                                }
                                                $kolor = '#F3E5F5';
                                                //print"<TR><TD id='td_kolor' bgcolor=$kolor align=right><B><font size='4' color='black'>Razem:</font></B></TD><TD id='td_kolor' bgcolor=$kolor align=center><B><font size='4' color='black'>"; echo (int)"$temp_ilosc_sztuk_uzytkownik"; print"</font></B></TD><TD id='td_kolor' bgcolor=$kolor>sztuk</TD></TR>\n";
                                                print"<TR><TD id='td_kolor' bgcolor=$kolor align=right></TD><TD id='td_kolor' bgcolor=$kolor align=center><B><font size='4' color='black'>Razem:  "; echo (int)"$temp_ilosc_sztuk_uzytkownik"; print"  $opis_sztuki</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>\n";
                                                               

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
print '<DIV class="dolny_do_tabeli" id="niedrukuj">';
                            print '<DIV class="mniejszy_panel">';

                                $ilosc_metrow = $ilosc_metrow/45;
                                $ilosc_sztuk += $ilosc_metrow;

                                print "<B><font class='opis_paneli'>Do druku :  "; echo (int)"$ilosc_sztuk"; print"   sztuk</font></B><br>";
                                /*
                                print'<FORM ACTION="wykres_ile_do_druku.php" METHOD=POST>';
                                print'<INPUT TYPE="submit" VALUE="Wykres" CLASS="btn">';
                                print'</FORM>'; 
                                 * 
                                 */                         
                            print "</DIV>";
print"</DIV>";


print "<B><font class='opis_raport'>Do druku :  "; echo (int)"$ilosc_sztuk"; print"   sztuk</font></B><br><br>";



?>


</body>
</html>
