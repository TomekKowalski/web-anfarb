

<?php

print'<DIV>';
print"<TABLE cellpadding = '0'  cellspacing = '0' border = '0' style='width: 100%; height: 100%;'>";
    print"<tr>";
        print"<td align=center>"; 
            /////////wyswietlanie po wybraniu/////////////
            if($_POST['co']=='opcja')
            {
                ////////////////wyszukiwanie z danego dnia /////////////////////////////
                $data=$_POST['data_data'];
                $data_miesiac = substr($data,5, 2);
                $data_dzien = substr($data,8, 2);
                $data_rok = substr($data,0, 4);
                $data_razem = $data_miesiac."/".$data_dzien."/".$data_rok;
                              
                $data_wyswietl = $data;
                print"<B><font size=3 color=#00004d>$data_wyswietl</font></B><br/>";
                $polocz->open();
                $wynik = mysql_query("SELECT * FROM ZAMOWIENIA_TAB, MAGAZYN_DAMAZ_TAB WHERE MAGAZYN_DAMAZ_TAB.Data_magazynowania LIKE '$data_razem' AND ZAMOWIENIA_TAB.Nr_wiersza = MAGAZYN_DAMAZ_TAB.Nr_wiersza ORDER BY Odbiorca_zamowienia;") or die ("zle pytanie");
                $polocz->close();
                print"<TABLE style='width: 100%; height: 100%;'>";
                    print"<TR bgcolor = #6666ff><TD id='td_kolor' width=2%><B>ARTYKUŁ</B></TD><TD id='td_kolor' width=2%><B>ILOŚĆ</B></TD><TD id='td_kolor' width=5%><B> M./SZT. </B></TD><TD id='td_kolor' width=5%><B>NR PARTI</B></TD><TD id='td_kolor' style='width: auto;'><B>WZÓR</B></TD><TD id='td_kolor' width=2%><B>UWAGI</B></TD><TD id='td_kolor' width=2%><B>STATUS</B></TD><TD id='td_kolor' width=2%><B>PLANOWANA DATA ODBIORU</B></TD></TR>";
                        $temp_zamowienie = 0;
                        $temp_odbiorca = "";
                        $ktory_wiersz = 0;
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
  
                    print"<TR><TD id='td_kolor' bgcolor=$kolor>$artykul_zamowienia</TD><TD id='td_kolor' align='right' bgcolor=$kolor>$ilosc</TD><TD id='td_kolor' align = 'center' bgcolor=$kolor>$status_metrow</TD><TD id='td_kolor' bgcolor=$kolor>$nr_parti</TD><TD class='td_kolor_class' bgcolor=$kolor><a href='../WZORY_JPG_WSZYSTKIE/$wzor.jpg' data-lightbox='$wzor.jpg' data-title='$wzor'><div id='td_wzor".$ktory_wiersz."' class=''>$wzor</div></a></TD><TD id='td_kolor' bgcolor=$kolor>$uwagi</TD><TD id='td_kolor' bgcolor=$kolor>$status</TD><TD id='td_kolor' align=center bgcolor=$kolor>$planowana_data_odbioru</TD></TR>";
                    
                        $ktory_wiersz++;
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

<figure id="miniatura_zdjecia"></figure>
