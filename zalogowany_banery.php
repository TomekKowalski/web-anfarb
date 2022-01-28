
<?php

	session_start();
	
        
	
	/////////////////////tabela logowanie i banery////////////////////////////////////////////
print"<TABLE style='width: 100%; height: 100%;'>";
    print"<tr>";
        //print"<td id=niedrukuj width=57px align=center>";
        print"<td id=niedrukuj align=center>";
            echo'<a href=zmiana_hasla.php onmouseover="ustawienia.src=\'../grafika/ustawienia_2.png\'" onmouseout="ustawienia.src=\'../grafika/ustawienia_1.png\'" onclick="ustawienia.src=\'../grafika/ustawienia_1.png\'">';
            echo'<br><img src="../grafika/ustawienia_1.png" name="ustawienia" width=40px height=40px>';
            echo'</a>';
   	print"</td>";
        print"<td  id=niedrukuj align=left>";
            $zalogowany = $_SESSION['imie_nazwisko'];
            print("<font size='2' face='verdana' color='#D9D919'>Użytkownik: $zalogowany</font><br />");
            print'<a href = wyloguj.php><font size=2 face="verdana" color=#D9D919>Wyloguj</font></a>';
        print"</td>";
            /////////////////////////////////////
        print"<td align=right> <img id=niedrukuj src='../grafika\baner_an_farb_02.png' alt='Smiley face' height=47 width=183> <img src='../grafika\baner_damaz_02.png' alt='Smiley face' height=47 width=183>";
        print"</td>";
    print"</tr>";
print"</TABLE>";
///////////////////koniec tabaela logowanie i banery///////////////////////////////
      

	
?>
