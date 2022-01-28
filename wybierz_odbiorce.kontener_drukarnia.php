<?php

session_start();
print"<TABLE cellpadding = '0'  cellspacing = '0' border = '0' style='width: 100%; height: 100%;'>";
    print"<tr>";
        print"<td align=left>";
            print"<TABLE cellpadding = '0'  cellspacing = '0' border = '0' width=50% height=100%>";
                print"<tr>";
                    print"<td height = 30>";
                        print "<B><font class='opis_paneli'>DRUKARNIA</font></B>";
                    print"</td>";
                print"</tr>";
            print"</TABLE>";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td height = 10px>";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";
                        print"<TABLE border = '0' style='width: auto; height: 100%;'>";
                            print"<tr>";
                                print"<td>";
                                    //echo'<a href=zmien_status.php onmouseover="status.src=\'grafika/zmien_status_pomarancz3.png\'" onmouseout="status.src=\'grafika/zmien_status_cz3.png\'" onclick="status.src=\'grafika/zmien_status_cz3.png\'">';
                                    //echo'<br><img src="grafika/zmien_status_cz3.png" name="status" width=121px height=35px>';
                                    echo'<a href="zmien_status.php" class="button">Zmień status';
                                    echo'</a>';
                                print"</td>";
                                print"<td>";
                                    //echo'<a href=formularz_nowy_odbiorca.php onmouseover="gfx.src=\'grafika/nowy_odbiorca_bialy3.png\'" onmouseout="gfx.src=\'grafika/nowy_odbiorca_zielony3.png\'" onclick="gfx.src=\'grafika/nowy_odbiorca_zielony3.png\'">'; 
                                    //echo'<br><img src="grafika/nowy_odbiorca_zielony3.png" name="gfx" width=121px height=35px>';
                                    echo'<a href="formularz_nowy_odbiorca.php" class="button">Nowy odbiorca';
                                    echo'</a>';
                                print"</td>";
                                print"<td>";
                                    //echo'<a href=zamowienie_z_dnia.php onmouseover="zamow.src=\'grafika/zamowienie_z_dnia_bialy3.png\'" onmouseout="zamow.src=\'grafika/zamowienie_z_dnia_zielony3.png\'" onclick="zamow.src=\'grafika/zamowienie_z_dnia_zielony3.png\'">';
                                    //echo'<br><img src="grafika/zamowienie_z_dnia_zielony3.png" name="zamow" width=121px height=35px>';
                                    echo'<a href="zamowienie_z_dnia.php" class="button">Zam. z dnia';
                                    echo'</a>';
                                print"</td>";
                            print"</tr>";
                            print"<tr>";
                                print"<td>"; 
                                    //echo'<a href=do_druku.php onmouseover="dodruk.src=\'grafika/do_druku_bialy3.png\'" onmouseout="dodruk.src=\'grafika/do_druku_zielony3.png\'" onclick="dodruk.src=\'grafika/do_druku_zielony3.png\'">'; 
                                    //echo'<img src="grafika/do_druku_zielony3.png" name="dodruk" width=121px height=35px>';
                                    echo'<a href="do_druku.php" class="button">Do druku';
                                    echo'</a>';
                                print"</td>";
                                print"<td>";
                                    //echo'<a href=wzor_ktory_klient.php onmouseover="wzor_klient.src=\'grafika/wzory_klient_bialy3.png\'" onmouseout="wzor_klient.src=\'grafika/wzory_klient_zielony3.png\'" onclick="wzor_klient.src=\'grafika/wzory_klient_zielony3.png\'">'; 
                                    //echo'<img src="grafika/wzory_klient_zielony3.png" name="wzor_klient" width=121px height=35px>';
                                    echo'<a href="regaly.php" class="button">Regały';
                                    echo'</a>';
                                print"</td>";
                                print"<td>"; 
                                    //echo'<a href=magazyn_damaz.php onmouseover="magazyn_damaz.src=\'grafika/magazyn_data_bialy3.png\'" onmouseout="magazyn_damaz.src=\'grafika/magazyn_data_zielony3.png\'" onclick="magazyn_damaz.src=\'grafika/magazyn_data_zielony3.png\'">';
                                    //echo'<img src="grafika/magazyn_data_zielony3.png" name="magazyn_damaz" width=121px height=35px>';
                                    echo'<a href="magazyn_damaz.php" class="button">Magazyn-data';
                                    echo'</a>';
                                print"</td>";
                            print"</tr>";
                        print"</TABLE>";
                     

///////////////////koniec kontener przyciski drukarnia////////////////////////////////////////
        print"</td>";
    print"</tr>";  
print"</TABLE>";
 
 
 

?>
