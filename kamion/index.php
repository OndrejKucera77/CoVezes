<!DOCTYPE html>
<html lang='cs'>
  <head>
    <title>Co veze kamion?</title>
    <meta charset='utf-8'>
    <style>
        body {
            font-family: sans-serif;
            
            background-image: url("cesta.png");
            background-repeat: repeat-x;
            background-position: 0 507px;
            background-size: 36px;
        }
        main {
            width: 900px;
            margin: auto;
            padding-top: 60px;
        }
        h1 {
            margin-top: 0;
            margin-bottom: 40px;
            text-align: center;
        }
        #kamion {
            height: 370px;
            margin-bottom: 85px;
            position: relative;
            
            background-image: url("kamion.png");
            background-size: 100%;
            background-repeat: no-repeat;
        }
        #kody {
            width: 208px;
            
            background-color: orange;
            border: 6px solid black;
            
            position: absolute;
            top: 48px;
            left: 280px;
        }
        #kemler_kod {
            height: 78px;
            border: none;
            border-bottom: 6px solid black;
        }
        #un_kod {
            height: 78px;
        }                                  
        #kody input {
            border: none;
            background-color: transparent;
            
            width: 204px;
            height: 75px;
            
            font-size: 70px;
            text-align: center;
        }
        #kody input:hover {
            outline: 1px solid #eee;
        }
        #vypis {
            position: absolute;
            top: 55px;
            left: 511px;
            
            font-size: 16px;
        }
        #vypis p {
            height: 75px;
            margin-bottom: 10px;
            margin-top: 0;
            
            width: 364px; 
        }
        form {
            position: absolute;
            top: 142px;
            left: 511px;

            visibility: hidden;
        }
        form div {
            margin-bottom: 10px;
            font-size: 14px;
        }
        form input[type=text] {
            width: 240px;
        }
        #popis strong {
            display: block;
            margin-bottom: 8px;
        }
        #popis b {
            font-size: 14px;
        }
        #popis p {
            font-size: 13px;
        }
    </style>
  </head>
  <body>
    <main>
        <h1>Co veze kamion?</h1>
        <div id="kamion">
            <div id="kody">
                <div id="kemler_kod">
                    <input type="text" maxlength="4" onKeyUp="vypis(1, this.value)">                    
                </div>                                                             
                <div id="un_kod">
                    <input type="text" maxlength="4" onKeyUp="vypis(2, this.value)">
                </div>                                                               
            </div>
            <div id="vypis">
                <p id="vystup1"></p>
                <p id="vystup2"></p>
            </div>
            <form id="UNform" method="POST">
                <div>
                Nena??li jsme ????dnou l??tku odpov??daj??c?? UN k??du <span id="cislo"></span>.
                <br>
                Pro tento k??d v??ak nyn?? m????ete napsat n??zev l??tky:
                </div>
                <input type="text" name="novynazev" required>
                <input type="hidden" id="hidden_input" name="hodnota" required>
                <input type="submit" value="P??idat">
            </form>
            <?php
            if (isset($_POST["novynazev"])&&!empty($_POST["novynazev"])&&isset($_POST["hodnota"])&&!empty($_POST["hodnota"])) {
                $nazvy=file_get_contents("pridane_nazvy.json");
                $json=json_decode($nazvy, true);
                                        
                $json[$_POST["hodnota"]]=$_POST["novynazev"];
                
                $nazvy=json_encode($json, JSON_UNESCAPED_UNICODE);
                
                $soubor=fopen("pridane_nazvy.json", "w");
                fwrite($soubor, $nazvy);
                fclose($soubor);                
            }
            ?>
        </div>
        <div id="popis">
            <strong>Z Wikipedie:</strong>
            <b>Kemler??v k??d</b>
            <p>
            Kemler??v k??d je k??d zna????c?? nebezpe??nost nebezpe??n?? l??tky pro pot??eby p??epravy podle dohod ADR a RID. Umis??uje se na v??stra??nou tabulku o rozm??ru 300??400 mm na vozidlo p??epravuj??c?? p??edm??ty podle t??chto dohod. Kemler??v k??d slou???? pro rychl?? zji??t??n?? p??ibli??n??ch vlastnost?? (chov??n??) l??tky a je um??st??n v horn?? polovin?? tabulky. Doln?? polovina tabulky obsahuje podrobn??j???? k??d, ur??uj??c?? p??esn?? p??epravovanou l??tku.
            </p>
            <p>
            2 ??? Plynn?? l??tka (uvol??ov??n?? plyn?? pod tlakem); 3 ??? Ho??lav?? kapalina (ho??lavost par kapalin a plyn??); 4 ??? Ho??lav?? pevn?? l??tka; 5 ??? L??tka podporuj??c?? ho??en?? (oxida??n?? ????inky); 6 ??? Jedovat?? l??tka (toxicita); 7 ??? Radioaktivn?? l??tka; 8 ??? ????rav?? l??tka (leptav?? ????inky); 9 ??? Samovoln?? reakce (nebezpe???? prudk??, bou??liv?? reakce); 0 ??? Bez v??znamu
            </p>
            <b>UN k??d</b>
            <p>
            UN k??d je charakteristick?? ??ty??????sl??, p??i??azen?? dnes asi 3000 l??tk??m a jejich sm??s??m, kter?? l??tku nebo sm??s jednozna??n?? identifikuje. Je um??st??n v doln?? polovin?? tabulky. Mus?? b??t spole??n?? s Kemlerov??m k??dem uveden na ka??d??m vozidle pou????van??m p??i p??eprav?? l??tek, kter?? spadaj?? do seznamu l??tek, jejich?? p??eprava se ????d?? dle ADR ??i RID. L??tky identifikuje v??dy ??ty??m??stn?? k??d (v p????pad?? pot??eby se dopl??uje k??d ????slem 0).
            </p>
        </div>
        <script>
            function vypis(verze, hodnota) {
                if (hodnota=="") {
                    document.getElementById("vystup"+verze).innerHTML = "";
                    if (verze==2) {
                        document.getElementById("UNform").style.visibility = "hidden";
                    }                
                }
                else {
                    const xmlhttp = new XMLHttpRequest();
                    xmlhttp.onload = function() {
                        document.getElementById("vystup"+verze).innerHTML = this.responseText;

                        if (verze==2) {
                            if (this.responseText == "") {
                                document.getElementById("UNform").style.visibility = "visible";
                                document.getElementById("cislo").innerHTML = hodnota;
                                document.getElementById("hidden_input").value = hodnota;
                            }
                            else {
                                document.getElementById("UNform").style.visibility = "hidden";
                            }
                        }                      
                    }
                    xmlhttp.open("GET", "kody.php?verze="+verze+"&&hodnota="+hodnota);
                    xmlhttp.send();                
                }                
            }
        </script>
    </main>
  </body>
</html>