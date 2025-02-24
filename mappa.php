<?php 
    require_once "templates/head.php";
    $imagen = $_GET['id'];

    $consulta_imagen = 
    "SELECT 
        cartones.imageUrl as imagen_carton,
        cartones.material as material_carton,
        cartones.title as titulo_carton,
        cartones.ano as ano_carton,
        
        authCartones.name as nombre_autor,
        authCartones.birthYear,
        authCartones.deathYear,
        authCartones.birthPlace,
        authCartones.deathPlace,

        authPinturas.name as autor_pintura,

        pinturas.title as titulo_pintura,
        pinturas.tecnica as material_pintura,
        pinturas.previewUrl as imagen_pintura,
        pinturas.ano  as ano_pintura,
        pinturas.europeMapX  as x_pintura,
        pinturas.europeMapY  as y_pintura,
        pinturas.museo  as museo_pintura,
        pinturas.ciudad  as ciudad_pintura
    FROM 
        cartones 
    JOIN 
        author authCartones
        ON cartones.author_id = authCartones.id 
        JOIN 
            pinturas
            ON pinturas.id_pintura = cartones.pintura_rel
        JOIN
            author authPinturas
        ON pinturas.autor_id = authPinturas.id
    WHERE cartones.id = :carton";

    $exec_imagen = $conn->prepare($consulta_imagen);
    $exec_imagen->bindParam(':carton',$imagen);
    $exec_imagen->execute();
    $resultado = $exec_imagen -> fetch(PDO::FETCH_ASSOC);
    $img_cartone = $resultado['imagen_carton'];
    $img_pintura = $resultado['imagen_pintura'];
    $material = $resultado['material_carton'];
    $title = $resultado['titulo_carton'];
    $ano = $resultado['ano_carton'];

    $nombre_autor = $resultado['nombre_autor'];
    $birthYear_autor = $resultado['birthYear'];
    $deathYear_autor = $resultado['deathYear'];
    $birthPlace_autor = $resultado['birthPlace'];
    $deathPlace_autor = $resultado['deathPlace'];

    $x_pintura = $resultado['x_pintura'];
    $y_pintura = $resultado['y_pintura'];
    $autor_pintura = $resultado['autor_pintura'];
    $ciudad_pintura = $resultado['ciudad_pintura'];
    $museo_pintura = $resultado['museo_pintura'];
?>
<body>

<div class="background">
 
 <?php 
    require_once "templates/navbar.php";
 ?>
   
    <div class="breadcrumbs">
    <p class="playfair"><a href="immagine.php?id=<?=$imagen?>"><?=$title?></a>/ <span class="bread2">esplora la mappa</span></p>
        <a class="close_breadcrumbs" href="immagine.php?id=<?=$imagen?>"><img src="img/cross.png" alt="cross"></a>
    </div>

    <section class="contents">

        <div class="instrucciones activo">
            <div class="instrucciones_content">
                <div class="instrucciones_icon">
                    <img src="img/infoicon.png">
                </div>
                <div class="instrucciones_texto">
                    <p class="instrucciones_titl">esplora la mappa</p>
                    <p class="instrucciones_content">scopri dove è stato riprodotto il cartone e confronta i disegni</p>
                </div>
                <div class="instrucciones_boton">
                OK
                </div>
            </div>
        </div>


        <div class="box1">
            <p class="box-titl">Scheda tecnica del cartone</p>
            <div class="minicartone">
                <div class="boximg">
                    <img src="pinturas/<?=$img_cartone?>">
                </div>
                <div class="txtscheda">
                    <h4><?=$title?></h4>
                    <p class="txtscheda-autor" class="bold"><?=$ano?></p>
                    <p class="txtscheda-autor" class="bold"><?=$nombre_autor?></p>
                    <p class="txtscheda-describe">(<?=$birthPlace_autor?> <?=$birthYear_autor?>, <?=$deathPlace_autor?> <?=$deathYear_autor?>)</p>
                    <p class="txtscheda-describe"><?=$material?></p>
                </div>        
            </div>
        </div>

        <div class="box2">
            <p class="box-titl2">Mappa delle riproduzioni collocate in Europa</p>
            <div id="mapframe">
                <div class="region">
                    <img src="img/mappa.png" alt="europe map">
                </div>
                <div class="spot" style="left:<?=$x_pintura?>px;top:<?=$y_pintura?>px">
                    <img src="img/infopoint.svg" alt="location tag">      
                </div>
                <div class="whitebox display-onclick">
                    <div class="compared-img-box">
                        <div class="img1-overwhite">   
                          <img src="pinturas/<?=$img_cartone?>">  
                        </div>
                        <div class="img1-overwhite">
                          <img src="pinturas/<?=$img_pintura?>">
                        </div>
                    </div>
                    <div class="txtwhite">
                        <h5><?=$title?></h5>
                        <p><span class="bold"><?=$museo_pintura?>,<?=$ciudad_pintura?><br><?=$autor_pintura?></span><br>
                        (<?=$birthPlace_autor?> <?=$birthYear_autor?>, <?=$deathPlace_autor?> <?=$deathYear_autor?>)<br>
                        <?=$material?></p>
                    </div>
                    <div class="blackx">
                        <img src="img/crossblack.png" alt="chiudi">
                    </div>
                </div>
            </div>
        </div>

        <div class="iconsrow">
            <a href="mappa.php?id=<?=$imagen?>">
                <div class="fondo-icona activo">
                    <img id="mapa" src="img/mapicon.png" alt="mapa">
                </div>
            </a>
            <a href="detagli.php?id=<?=$imagen?>">
                <div class="fondo-icona">
                    <img id="detalle" src="img/brighticon.png" alt="detalle">
                </div>
            </a>
            <a href="tags.php?id=<?=$imagen?>">
                <div class="fondo-icona">
                    <img id="tags" src="img/infoicon.png" alt="tags">
                </div>
            </a>
        </div>
    </section>

    <div class="footer">
        <div class="handicap open_handicap">
            <img id="chair" src="img/handic.png" alt="handicap">
        </div>
        <div id="add-div" class="hiding">
            <div class="handicap_shortcuts">
                <div class="instrucciones_ok activo">
                    <div class="instrucciones_boton2">OK</div>
                </div>
                <div class="correspondencia_mapa">
                    <div class="handicap_pin hidden-tag"><img src="img/infopoint_line.svg" alt="location"></div>
                </div>
            </div>
            <div class="down-cross">
                <img id="video" class="down-video open_video" src="img/videoicon.png">
                <a href="immagine.php?id=<?=$imagen?>">
                    <img class="down-cross-size" src="img/cross.png" alt="cross">
                </a>
            </div>
        </div>
    </div>


</div>
<script src="scripts/principal.js"></script>
<script>


$(".spot").click(function(){

$(".whitebox").toggleClass("display-onclick");
})

$(".blackx").click(function(){
    $(".whitebox").toggleClass("display-onclick");
})

/***************/
/* Minusvàlids */
/***************/

// Abrir handicap
$(document).on('click','.handicap',function(){
    $('#add-div').toggleClass('hiding');     
});

//Abrir y cerrar el pin en el mapa
$('.handicap_pin').on('click',function(){
    console.log("Pin mapa");
    $(".whitebox").toggleClass("display-onclick");
})

//Minusvàlids -> Obrim el tag corresponent al numero
$('.handicap_tag').on('click',function(){
    /*var tag_corr = $(this).data('tag');
    markers[tag_corr].openPopup();*/
});

//Al principio esta activo el boton de Ok para que cierren instrucciones
$('.instrucciones_boton').on('click',function(){
    $('.instrucciones_ok').removeClass('activo');
    $('.correspondencia_mapa').addClass('activo');
    $('.handicap_pin').removeClass('hidden-tag');
})
$('.instrucciones_boton2').on('click',function(){
    $('.instrucciones_ok').removeClass('activo');
    $('.correspondencia_mapa').addClass('activo');
    $('.handicap_pin').removeClass('hidden-tag');
})



</script>

</body>
</html>