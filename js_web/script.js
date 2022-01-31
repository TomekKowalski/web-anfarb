var yScrollAxis02 = 0;

window.onload = function()
{  
    
    try{
        //var test = document.getElementById("test");
        var checkZaznaczWszystko = document.getElementById("zaznacz_wszystko");
        var checkBoxs = [];
        var n = 1;
        while(document.getElementById("checkNr"+n+""))
        {
            checkBoxs.push(document.getElementById("checkNr"+n+""));
            n++;
        }
        /////////////zaznaczanie odznaczanie checkBox ///////////////////

    
        checkZaznaczWszystko.onclick = function()
        {
            if(document.getElementById("zaznacz_wszystko").checked === true)
            {           
                for(var i=0; i<checkBoxs.length; i++)
                {
                    document.getElementById(checkBoxs[i].id).checked = true;
                }
            }
            if(document.getElementById("zaznacz_wszystko").checked === false)
            {
                for(var i=0; i<checkBoxs.length; i++)
                {
                    document.getElementById(checkBoxs[i].id).checked = false;
                }
            }
        };    
    
        ///////////////////////////////////////////////////////////////////

        ///////////////////podliczanie metrow ////////////////////////////


        var przyciskSumaMetry = document.getElementById("buttonSumaMetrow");

        przyciskSumaMetry.onclick = function(e)
        {            
            //var test = document.getElementById("test");
            var tekst_suma_metrow = document.getElementById("sumaMetrow");
            var suma_metrow = 0;
            e.preventDefault();
            //test.innerHTML += "przyciskSumaMetry.name<br>";

            for(var i=0; i<checkBoxs.length; i++)
            {
                   if(document.getElementById(checkBoxs[i].id).checked === true)
                   {
                       suma_metrow += parseInt(document.getElementById(checkBoxs[i].id).value);
                       //test.innerHTML += "<br>" + document.getElementById(checkBoxs[i].id).value;

                   }
            }
            //test.innerHTML += "<br>Suma: " + suma_metrow;
            tekst_suma_metrow.innerHTML = suma_metrow + " m";        
        };
        
        
        ///////////wyswietlanie miniatur  ////////////////////////
        
        var tdNazwyWzorow = [];

        var n = 0;
        while(document.getElementById("td_wzor"+n+""))
        {
            tdNazwyWzorow.push(document.getElementById("td_wzor"+n+""));  ///pobranie kolejnych okienek tabliczki
            n++;
        }
        for(var i=0; i<tdNazwyWzorow.length; i++)
        {
            tdNazwyWzorow[i].addEventListener("mouseout", zmienKolor);
            tdNazwyWzorow[i].addEventListener("mouseover", wrocKolor);  
            tdNazwyWzorow[i].addEventListener("mousemove", wyswietl_miniature_wzoru);

        }
        window.onscroll = function()
        {       
            yScrollAxis02 = window.pageYOffset;
        };
        
        
    }catch(e){}
    
    //////////////////////////////////////////////////////////////////////////
       
    
};

function zmienKolor()
{
    this.className = "";    
    var miniatura_zdjecia = document.getElementById("miniatura_zdjecia");
    
    miniatura_zdjecia.style.display = "none";
}

function wrocKolor()
{       
    this.className = "divNowyColor";      
}

function wyswietl_miniature_wzoru(event)
{
    var e = event || window.event;
    this.className = "divNowyColor";
    //var pozycjaScroll = e.pageYOffset;
    
      
    var miniatura_zdjecia = document.getElementById("miniatura_zdjecia");
    
    miniatura_zdjecia.style.display = "block";
    miniatura_zdjecia.style.left = e.clientX + 5 + "px";
    miniatura_zdjecia.style.top = e.clientY + 5 + yScrollAxis02 + "px";
    miniatura_zdjecia.innerHTML = "<img src='../WZORY_JPG_WSZYSTKIE/" + this.innerHTML + ".jpg' alt='Loading...' class='wielkosc_miniatura'/>\n\
                                <br /><figcaption>"+this.innerHTML+"</figcaption>";
       
}



        