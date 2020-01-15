<footer id="footer" class="footer no-print fixed-bottom">
  <div id="rodape">
    <div class="container-fluid pl-0 pr-0">
      <div class="row align-items-center mr-0 ml-0">

        <div id="autoria" class="col-12 col-lg-8 mt-1 mb-1 text-center text-lg-left">
          <?php echo $nomeSite; ?>
        </div> 

        <div class="col-12 col-lg-4 d-flex" id="versao">
          <img src="img/rodape-direito.png" />

          <div class="align-self-center mt-1 mb-1 text-center">
            <a href="<?php echo $https <> '' ? $https.$enderecoSite : $http.$enderecoSite ; ?>" target="_blank">
              <?php echo $enderecoSite; ?>
            </a>
          </div>
        </div> 

      </div>
    </div>
  </div>
</footer>