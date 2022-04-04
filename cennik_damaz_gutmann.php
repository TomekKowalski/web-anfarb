<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany_gutmann']))
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

      

print"<DIV class='panel_glowny'>";

    print"<TABLE  cellpadding = '0'  cellspacing = '0' border = '0' style='width: 100%; height: 100%;'>";
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
        
                /////////przycisk i nazwa odbiorcy/////////////////////

                            
   
                                    /////////////wybieranie parti////////////////////////
                                  
                            print"<div class='panel_1ogowanie'>";
                            print"<div align=center>";
                                     ////////////textbox do wpisywania nr parti i przycisk /////////////////////////// 
                                print"<TABLE id=niedrukuj CELLPADDING=0 CELLSPACING=0 BORDER=0 style='width: 80%; height: 100%;'>";
                                    print"<TR>";    
                                        print"<TD valign=bottom style='width: 45%; text-align: left;'>";
                                            print'<B><font class="opis_texbox">NO. ARTICLE</font></B><br/>';   
                                            print'<FORM ACTION="cennik_damaz_gutmann.php" METHOD=POST>';
                                            print '<INPUT TYPE="hidden" NAME="co" VALUE="wybor_artykulu">';

                                            if($_POST['nr_artykulu'])
                                            {                      
                                                     $wybrany_nr_artykulu = $_POST['nr_artykulu'];
                                            }
                                            print ("<INPUT class='text_box' style='width: 95%;' TYPE='text' NAME='nr_artykulu' VALUE=".$wybrany_nr_artykulu.">");
  
                                     print"</TD>";                                        
                                     print"<TD valign=bottom style='width: 45%; text-align: left;'>"; 
   
                                            print'<B><font class="opis_texbox">NAME ARTICLE</font></B><br/>';
                                            if($_POST['nazwa_artykulu'])
                                            {                      
                                                     $wybrana_nazwa_artykulu = $_POST['nazwa_artykulu'];
                                            }
                                            print"  ";
                                            print ("<INPUT class='text_box' style='width: 95%;' TYPE='text' NAME='nazwa_artykulu' VALUE=".$wybrana_nazwa_artykulu.">");
                                   
                                     print"</TD>";                                       
                                     print"<TD valign=bottom style='width: 10%; text-align: left;'>"; 
                                        print "";
                                        print'<INPUT style="width: 100%;" TYPE="submit" VALUE="Select" CLASS="btn">';
                                  print'</FORM>';
                                     print"</TD>";               
                                  print"</TR>";
                                print"</TABLE>";
                                print "<br><B><font class='opis_paneli'>Price list DAMAZ</font></B><br><br>"; 
                            print"</div>"; 
                            print"</div>";
                        print"</td>";
                    print"</tr>";                   
                    print"<tr>";
                        print"<td>";
                           // print"</DIV>";

 
//print_r( $_POST );

////////////////wyszukiwanie nr parti /////////////////////////////

                if(($_POST['co']=='wybor_artykulu'))
                {
    
                                //print_r( $_POST['co'] );

                                $wybrany_nr_artykulu =$_POST['nr_artykulu'];
                                $wybrana_nazwa_artykulu = $_POST['nazwa_artykulu'];


                                //var_dump($wybrany_nr_artykulu);
                                //print"<br>";
                                //var_dump($wybrana_nazwa_artykulu);
                                //print_r($_SESSION);

                                $polocz->open(); 
                                mysql_select_db("DZIEWIARNIA_CENY") or die ("nie ma DZIEWIARNIA_CENY");


                                $wynik = mysql_query("SELECT `ID_dane_artykulu`, `Nr_artykulu`, `Nazwa_artykulu`, `Nazwa_grupa_cenowa`, `Cena_netto_kg_zl`, `Cena_netto_mb_zl`, `Cena_EUR_za_kg`, `Data_ostatniej_zmiany`, `Uwagi_ceny`, `sklad_dzianiny`, `szerokosc`, `gramatura`, `wydajnosc`, `dlugosc_raportu`, `kurs_euro` FROM `view_cennik_na_strone_i_dane_do_programu` WHERE `Nr_artykulu` LIKE '%$wybrany_nr_artykulu%' AND `Nazwa_artykulu` LIKE '%$wybrana_nazwa_artykulu%' AND `Nr_artykulu` NOT LIKE '%usuniete%' AND `Ukryj_artykul` = '0' ORDER BY `Nazwa_grupa_cenowa`, `Nr_artykulu`;") or die ("zle pytanie wybor cennika");


                                $polocz->close();

                                $ilosc_wierszy_cennik = 0;


                        print"<TABLE style='width: 100%; height: 100%;' border = '0'>";

                            print"<TR bgcolor = #6666ff><TD id='td_kolor' width=2%><B>No.</B></TD><TD id='td_kolor' width=15%><B>No. article </B></TD><TD id='td_kolor' width=15%><B>Name article</B></TD><TD id='td_kolor' width=5%><B>Price EUR  per kg</B></TD><TD id='td_kolor' width=5%><B>Price EUR per m.</B></TD><TD id='td_kolor' width=5%><B>Price EUR per kg + 7%</B></TD><TD id='td_kolor' width=5%><B>Price EUR per m. + 7%</B></TD><TD id='td_kolor' width=10%><B>Fiber</B></TD><TD id='td_kolor' width=5%><B>Width</B></TD><TD id='td_kolor' width=5%><B>Weight</B></TD><TD id='td_kolor' width=5%><B>Efficiency</B></TD><TD id='td_kolor' width=5%><B>Report</B></TD></TR>";

                                while($rekord_3 = mysql_fetch_assoc($wynik)){
                                    $ilosc_wierszy_cennik ++;
                                    $nr_artykulu = $rekord_3['Nr_artykulu'];
                                    $nazwa_artykulu = $rekord_3['Nazwa_artykulu'];
                                    $grupa_cenowa = $rekord_3['Nazwa_grupa_cenowa'];

                                    $cena_netto_zl_za_kg_temp = $rekord_3['Cena_netto_kg_zl'];
                                    $cena_netto_zl_za_kg = number_format($cena_netto_zl_za_kg_temp, 2);
                                    $wydajnosc = $rekord_3['wydajnosc'];
                                    $wydajnosc_float = str_replace(",", ".", $wydajnosc);
                                    $cena_netto_zl_za_mb_temp = $rekord_3['Cena_netto_mb_zl'];
                                    $cena_netto_zl_za_mb = round($cena_netto_zl_za_mb_temp, 2);
                                    $cena_netto_zl_za_mb = number_format($cena_netto_zl_za_mb, 2);
                                    if($cena_netto_zl_za_kg != 0)
                                    {        
                                        $cena_netto_zl_za_mb_temp = $cena_netto_zl_za_kg / $wydajnosc_float;
                                        $cena_netto_zl_za_mb = round($cena_netto_zl_za_mb_temp, 2);
                                        $cena_netto_zl_za_mb = number_format($cena_netto_zl_za_mb, 2);

                                        /*
                                        print"<br>wydajnosc : ";
                                        print_r($wydajnosc);
                                        print"<br>cena za kg : ";
                                        print_r($cena_netto_zl_za_kg);
                                        print"<br>wydajnosc float : ";
                                        print_r($wydajnosc_float);

                                         */
                                    }



                                    $kurs_EUR = $rekord_3['kurs_euro'];
                                   // print"<br>kurs EURO : ";
                                    //    print_r($kurs_EUR);
                                    $cena_EUR_za_kg_temp = $cena_netto_zl_za_kg / $kurs_EUR;
                                    $cena_EUR_za_kg = round($cena_EUR_za_kg_temp, 1);
                                    $cena_EUR_za_kg = number_format($cena_EUR_za_kg, 2);


                                    $siedem_procent_temp = $cena_EUR_za_kg * 0.07;
                                    $cena_EUR_za_kg_temp = $cena_EUR_za_kg + $siedem_procent_temp;
                                    $cena_EUR_za_kg_plus_siedem_procent = round($cena_EUR_za_kg_temp, 1);
                                    $cena_EUR_za_kg_plus_siedem_procent = number_format($cena_EUR_za_kg_plus_siedem_procent, 2);
                                   // print"<br>cena_EUR_za_kg_plus_siedem_procent : ";
                                    //    print_r($cena_EUR_za_kg_plus_siedem_procent);


                                    $cena_EUR_za_mb_temp = $cena_netto_zl_za_mb / $kurs_EUR;
                                    $cena_EUR_za_mb = round($cena_EUR_za_mb_temp, 1);
                                    $cena_EUR_za_mb = number_format($cena_EUR_za_mb, 2);

                                    $siedem_procent_temp = $cena_EUR_za_mb * 0.07;
                                    $cena_EUR_za_mb_temp = $cena_EUR_za_mb + $siedem_procent_temp;
                                    $cena_EUR_za_mb_plus_siedem_procent = round($cena_EUR_za_mb_temp, 1);
                                    $cena_EUR_za_mb_plus_siedem_procent = number_format($cena_EUR_za_mb_plus_siedem_procent, 2);
                                   // print"<br>cena_EUR_za_mb_plus_siedem_procent : ";
                                    //    print_r($cena_EUR_za_mb_plus_siedem_procent);

                                    $data_modyfikacji = $rekord_3['Data_ostatniej_zmiany'];
                                    $uwagi = $rekord_3['Uwagi_ceny'];
                                    $sklad_dzianiny = $rekord_3['sklad_dzianiny'];
                                    $szerokosc = $rekord_3['szerokosc'];
                                    $gramatura = $rekord_3['gramatura'];

                                    $raport = $rekord_3['dlugosc_raportu'];




                                    $kolor = '#f2f2f2';

                              if($k%2)
                              {
                                 $kolor = '#e6ffff';
                              }


                                            print"<TR bgcolor = $kolor><TD align='center' id='td_kolor' width=2%>$ilosc_wierszy_cennik</TD><TD align='left' id='td_kolor' width=15%>$nr_artykulu</TD><TD align='left' id='td_kolor' width=15%>$nazwa_artykulu</TD><TD align='center' id='td_kolor' width=5%>$cena_EUR_za_kg</TD><TD align='center' id='td_kolor' width=5%>$cena_EUR_za_mb</TD><TD align='center' id='td_kolor' width=5%>$cena_EUR_za_kg_plus_siedem_procent</TD><TD align='center' id='td_kolor' width=5%>$cena_EUR_za_mb_plus_siedem_procent</TD><TD align='left' id='td_kolor' width=15%>$sklad_dzianiny</TD><TD align='center' id='td_kolor' width=5%>$szerokosc</TD><TD align='center' id='td_kolor' width=5%>$gramatura</TD><TD align='center' id='td_kolor' width=5%>$wydajnosc</TD><TD align='center' id='td_kolor' width=5%>$raport</TD></TR>";

                                            print"</TD>";

                                            print"</TR>";

                                            $k++;

                            }

                                print"</TD>";
                            print"</TR>";
                        print"</TABLE>";



                }
                
                        print"</td>";
                    print"</tr>";
                    //print"</td></tr>";  
                print"</TABLE>";

   

        print"</td>";
    print"</tr>";   
print"</TABLE>";

print"</DIV>";


?>



</body>
</html>
