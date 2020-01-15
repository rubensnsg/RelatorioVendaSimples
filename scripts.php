<!-- jQuery library -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS  -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


<script src="https://cdn.jsdelivr.net/gh/moment/moment@develop/min/moment-with-locales.min.js"></script>

<script src="https://cdn.jsdelivr.net/gh/djibe/bootstrap-material-datetimepicker@83a10c38ee94dd27fd946ea137af6667c65a738f/js/bootstrap-material-datetimepicker-bs4.min.js"></script>

<script type="text/javascript">
  var $now = moment("2019-12-30", "YYYY-MM-DD");
  var $inicio = moment("<?php echo $dataInicio; ?>", "YYYY-MM-DD");
  var $menordata = moment("2019-11-24", "YYYY-MM-DD");

  $(document).ready(function(){
    chamaDatePicker();
  })


  function chamaDatePicker(){
    /* DATEPICKER --------------------- */

    $("#dataAte").bootstrapMaterialDatePicker({
      format: 'DD/MM/YYYY',
      shortTime: false,
      maxDate: $now,
      minDate: $inicio,
      date: true,
      time: false,
      monthPicker: false,
      year: true,
      clearButton: false,
      switchOnClick: true,
      cancelText: 'Cancelar',
    })

    $("#dataDe").bootstrapMaterialDatePicker({
      format: 'DD/MM/YYYY',
      shortTime: false,
      maxDate: $now,
      minDate: $menordata,
      date: true,
      time: false,
      monthPicker: false,
      year: true,
      clearButton: false,
      switchOnClick: true,
      cancelText: 'Cancelar',
    }).on('change', function(e, date){
      $('#dataAte').bootstrapMaterialDatePicker('setMinDate', date);
      //console.log(date);
    });
  }


  function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();
    document.body.innerHTML = originalContents;
    
    chamaDatePicker();
  }
</script>
