<?php
    use yii\helpers\Url;
    $this->title = 'Huellitas CR';
?>
<section class="section__carousel">
     <section class="carousel__container">
        <input type="radio" id="1" name="image-slide" hidden/>
        <input type="radio" id="2" name="image-slide" hidden/>
        <input type="radio" id="3" name="image-slide" hidden/>      

        <section class="carousel__slide">
            <div class="slide__item">
                <img src="fotosMascotas/carousel1.jpg">
            </div>
            <div class="slide__item">
                <img src="fotosMascotas/carousel2.jpg">
            </div>
            <div class="slide__item">
                <img src="fotosMascotas/carousel8.jpg">
            </div>            
        </section>
        <section class="carousel__pagination">           
            <label class="pagination__item" for="1">
                <img src="fotosMascotas/carousel1.jpg">
            </label>            
            <label class="pagination__item" for="2">
                <img src="fotosMascotas/carousel2.jpg">
            </label>            
            <label class="pagination__item" for="3">
                <img src="fotosMascotas/carousel8.jpg">
            </label>                     
        </section>        
    </section>   
</section>
<section class="section__article">    
    <article>
        <p class="article__parrafo">
            <b>¿Quienes somos?</b><br><br>
            Nos dedicamos al rescate, recuperación, vacunación y castración de perros y gatos en estado de abandono o maltrato.
            Nuestro objetivo es crear conciencia en la población en general sobre el respeto, amor y cuidado a los animales.
        </p>
        <a class="btn btn-primary" href="<?= Url::toRoute("site/about") ?>">Ver mas...</a><br>
    </article>    
</section>
<section class="section__article--second">
    <article>
        <p class="article__parrafo">
            <b>¿Porque lo hacemos?</b><br><br>
            Nace a partir de la inquietud de tres mujeres por ayudar a los animales abandonados de su comunidad, 
            con la ayuda de muchas manos solidarias que al igual que nosotras tienen deseos de crear un mundo mejor.
        </p>
        <a class="btn btn-primary" href="<?= Url::toRoute("site/about") ?>">Ver mas...</a><br>
    </article>  
</section>
<section class="section__article">
    <article>
        <p class="article__parrafo">
            <b>Agradecimientos</b><br><br>
            Todo nuestro esfuerzo y gratitud están dirigidos a las personas y empresas de nuestra comunidad, 
            que día a día nos brindan su apoyo desinteresado para cumplir con esta laboral de amor.
        </p>
        <a class="btn btn-primary" href="<?= Url::toRoute("site/donation") ?>">Ver mas...</a><br>
    </article>  
</section>