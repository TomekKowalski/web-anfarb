

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
    }catch(e){}
    
    //////////////////////////////////////////////////////////////////////////
       
    
};



        